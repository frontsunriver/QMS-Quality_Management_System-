<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesorder extends MY_Controller {
	public $mLayout = 'porto/';

	public $prefix_num = 'SO/';
	public $num_length = 6;

	function __construct() {
		parent::__construct();

		$this->load->model(['Ims_salesorder_model', 'Ims_salesorder_product_model', 'Ims_shiporder_model', 'Ims_warehouse_product_model', 'Ims_product_attr_model']);
	}

	function index() {
		$this->mHeader['title'] = 'Sales Orders';
        $this->mHeader['menu_id'] = 'sales_orders';

        $this->render('sales/salesorder/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id,
			'A.salesorder_num LIKE' => "%{$param['sSearch']}%"
		];

		$data['iTotalRecords'] = $this->Ims_salesorder_model->count($filter);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			if ($param["mDataProp_{$sortCol}"] == 'customer_name')
				$orders['B.name'] = $param["sSortDir_{$i}"];
			else if ($param["mDataProp_{$sortCol}"] == 'salesperson_email')
				$orders['C.employee_email'] = $param["sSortDir_{$i}"];
			else
				$orders['A.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
		}

		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);

		$this->db->join("{$this->Ims_customer_model->_table} B", 'A.customer_id = B.id', 'LEFT');
		$this->db->join("{$this->Employees_model->_table} C", 'A.salesperson_id = C.employee_id', 'LEFT');
		$salesorders = $this->Ims_salesorder_model->find($filter, $orders, [
			'A.*', 'B.name customer_name', 'C.employee_email salesperson_email'
		]);
		$data['salesorder'] = $salesorders;

		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function create($id = -1) {
		$param = $this->input->post('salesorder');

		if (!$param) {
			$salesorder_num = $this->Ims_salesorder_model->select_max('salesorder_num');
			$salesorder_num = intval(str_replace($this->prefix_num, '', $salesorder_num)) + 1;
			$salesorder_num = $this->prefix_num . str_repeat('0', $this->num_length - strlen($salesorder_num)) . $salesorder_num;

			$this->mHeader['title'] = 'Sales Orders';
			$this->mHeader['menu_id'] = 'sales_orders';
			$this->mContent['salesorder_num'] = $salesorder_num;
			$this->mContent['customers'] = $this->Ims_customer_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['warehouses'] = $this->Ims_warehouse_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['employees'] = $this->Employees_model->find(['consultant_id' => $this->mUser->consultant_id]);

			$products = $this->Ims_product_model->find(['consultant_id' => $this->mUser->consultant_id]);

			foreach ($products as $item) :
				$attrs = $this->Ims_product_attr_model->find(['product_id' => $item->id], ['id' => 'asc']);
				if (!empty($attrs)) :
					$variants = [];
					foreach ($attrs as $attr) :
						$variants[] = explode(',', $attr->value);
					endforeach;

					$this->mVariants = [];
					for ($i = 0; $i < count($variants[0]); $i ++)
						$this->getVariants($variants, 0, $i, '');

					$item->variants = $this->mVariants;
				endif;
			endforeach;

			$this->mContent['products'] = $products;

			$salesorder = $this->Ims_salesorder_model->one(['id' => $id]);
			if ($salesorder)
				$salesorder->products = $this->Ims_salesorder_product_model->find(['salesorder_id' => $id]);

			$this->mContent['salesorder'] = $salesorder;

			$this->render('sales/salesorder/create', $this->mLayout);
		} else {
			if ($id == -1) {
				$param['consultant_id'] = $this->mUser->consultant_id;
				$param['employee_id'] = $this->mUser->employee_id;
				$param['create_at'] = date('Y-m-d H:i:s');

				$id = $this->Ims_salesorder_model->insert($param);

				$this->session->set_flashdata('flash', [
					'success' => true,
					'msg' => 'Successfully created.'
				]);
			} else {
				$param['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_salesorder_model->update(['id' => $id], $param);
				$this->Ims_salesorder_product_model->delete(['salesorder_id' => $id]);

				$this->session->set_flashdata('flash', [
					'success' => true,
					'msg' => 'Successfully updated.'
				]);
			}

			$products = $this->input->post('product');
			foreach ($products as $item) :
				$item['salesorder_id'] = $id;
				$arr = explode('@', $item['product_id']);
				$item['product_id'] = $arr[0];
				// $item['lot_code'] = $arr[1];
				$item['variant'] = isset($arr[1]) ? $arr[1] : '';
				$this->Ims_salesorder_product_model->insert($item);
			endforeach;

			$this->redirect('sales/salesorder');
		}
	}

	function delete($id) {
		$this->Ims_salesorder_model->delete(['id' => $id]);
		$this->Ims_salesorder_product_model->delete(['salesorder_id' => $id]);
		$this->Ims_shiporder_model->delete(['salesorder_id' => $id]);

		$this->success();
	}

	function delivery($id) {
		$salesorder = $this->Ims_salesorder_model->one(['id' => $id]);
		$products = $this->Ims_salesorder_product_model->find(['salesorder_id' => $id]);
		foreach ($products as $item) :
			$result = $this->Ims_warehouse_product_model->one(['warehouse_id' => $salesorder->warehouse_id, 'product_id' => $item->product_id, 'variant' => $item->variant]);
			if (!$result || $result->quantity < $item->ordered_qty) {
				$product = $this->Ims_product_model->one(['id' => $item->product_id]);
				$this->error("{$product->name}({$item->variant}) is not enough.");
				return;
			}
		endforeach;

		foreach ($products as $item) :
			$result = $this->Ims_warehouse_product_model->one(['warehouse_id' => $salesorder->warehouse_id, 'product_id' => $item->product_id, 'variant' => $item->variant]);			
			$this->Ims_salesorder_product_model->update(['salesorder_id' => $id, 'product_id' => $item->product_id, 'variant' => $item->variant], ['lot_code' => $result->lot_code]);
		endforeach;

		$this->success();
	}

	function product() {
		$warehouse_id = $this->input->post('warehouse_id');

		$this->db->group_by('product_id');
		$this->db->join("{$this->Ims_product_model->_table} B", 'A.product_id = B.id', 'right');
		$products = $this->Ims_warehouse_product_model->find(['warehouse_id' => $warehouse_id], ['stocked_date' => 'asc'], ['A.*', 'B.name']);

		foreach ($products as $item) :
			$variants = $this->Ims_product_attr_model->find(['product_id' => $item->product_id]);
			if (empty($variants))
				$item->variants = [];
			else
				$item->variants = $this->Ims_warehouse_product_model->find(['warehouse_id' => $warehouse_id, 'product_id' => $item->product_id], ['stocked_date' => 'asc']);
		endforeach;

		$this->json($products);
	}

	function quantity() {
		$param = $this->input->post();
		$result = $this->Ims_warehouse_product_model->one($param);

		if ($result)
			$this->json($result->quantity);
		else
			$this->json(0);
	}
}