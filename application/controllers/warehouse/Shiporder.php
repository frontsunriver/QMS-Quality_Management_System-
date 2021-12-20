<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shiporder extends MY_Controller {
	public $mLayout = 'porto/';

	public $prefix_num = 'WH/OUT/';
	public $num_length = 6;

	function __construct() {
		parent::__construct();

		$this->load->model(['Ims_shiporder_model', 'Ims_salesorder_model', 'Ims_salesorder_product_model', 'Ims_operation_type_model', 'Ims_warehouse_product_model']);
	}

	function index() {
		$this->mHeader['title'] = 'Ship Orders';
        $this->mHeader['menu_id'] = 'ship_orders';

        $this->render('warehouse/shiporder/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id,
			'A.reference LIKE' => "%{$param['sSearch']}%"
		];

		$data['iTotalRecords'] = $this->Ims_shiporder_model->count($filter);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			if ($param["mDataProp_{$sortCol}"] != 'src_doc') {
				if ($param["mDataProp_{$sortCol}"] == 'warehouse_name')
					$orders['B.name'] = $param["sSortDir_{$i}"];
				else if ($param["mDataProp_{$sortCol}"] == 'customer_name')
					$orders['C.name'] = $param["sSortDir_{$i}"];
			}
		}

		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);

		$this->db->join("{$this->Ims_warehouse_model->_table} B", "A.des_location = B.id", 'right');
		$this->db->join("{$this->Ims_customer_model->_table} C", "A.customer_id = C.id", 'right');
		$shiporders = $this->Ims_shiporder_model->find($filter, $orders, [
			'A.*', 'B.name warehouse_name', 'C.name customer_name', '" " src_doc'
		]);

		$data['shiporder'] = $shiporders;

		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function create($id = -1) {
		$param = $this->input->post('shiporder');

		if (!$param) {
			$reference = $this->Ims_shiporder_model->select_max('reference');
			$reference = intval(str_replace($this->prefix_num, '', $reference)) + 1;
			$reference = $this->prefix_num . str_repeat('0', $this->num_length - strlen($reference)) . $reference;

			$this->mHeader['title'] = 'Ship Orders';
			$this->mHeader['menu_id'] = 'shiporder';
			$this->mContent['reference'] = $reference;

			$this->mContent['customers'] = $this->Ims_customer_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['warehouses'] = $this->Ims_warehouse_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['opts'] = $this->Ims_operation_type_model->find(['consultant_id' => $this->mUser->consultant_id]);
			// $this->mContent['employees'] = $this->Employees_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['products'] = $this->Ims_product_model->find(['consultant_id' => $this->mUser->consultant_id]);

			$shiporder = $this->Ims_shiporder_model->one(['id' => $id]);

			if ($shiporder) :
				$this->db->join("{$this->Ims_product_model->_table} B", 'A.product_id = B.id', 'right');
				$shiporder->product = $this->Ims_salesorder_product_model->find(['A.salesorder_id' => $shiporder->salesorder_id], [], ['B.name product_name', 'A.ordered_qty', 'A.variant']);
			endif;

			$this->mContent['shiporder'] = $shiporder;

			$this->render('warehouse/shiporder/create', $this->mLayout);
		} else {
			if ($id == -1) {
				$param['consultant_id'] = $this->mUser->consultant_id;
				$param['employee_id'] = $this->mUser->employee_id;
				$param['create_at'] = date('Y-m-d H:i:s');
				$this->Ims_shiporder_model->insert($param);

				$this->Ims_salesorder_model->update(['id' => $param['salesorder_id']], ['state' => 1]);

				$this->session->set_flashdata('flash', [
					'success' => true,
					'msg' => 'Successfully created.'
				]);
			} else {
				
			}

			$this->redirect('warehouse/shiporder');
		}
	}

	function confirm($id) {
		$shiporder = $this->Ims_shiporder_model->one(['id' => $id]);
		$salesorder = $this->Ims_salesorder_model->one(['id' => $shiporder->salesorder_id]);

		$this->Ims_shiporder_model->update(['id' => $id], ['state' => 1, 'confirm_at' => date('Y-m-d H:i:s')]);
		$this->Ims_salesorder_model->update(['id' => $shiporder->salesorder_id], ['state' => 2]);

		$products = $this->Ims_salesorder_product_model->find(['salesorder_id' => $shiporder->salesorder_id]);
		foreach ($products as $item) :
			$wProduct = $this->Ims_warehouse_product_model->one(['warehouse_id' => $salesorder->warehouse_id, 'product_id' => $item->product_id]);
			if ($wProduct) :
				$remainQty = $wProduct->quantity - $item->ordered_qty;

				// if ($remainQty == 0)
					// $this->Ims_warehouse_product_model->delete(['warehouse_id' => $salesorder->warehouse_id, 'product_id' => $item->product_id]);
				// else
					$this->Ims_warehouse_product_model->update(['warehouse_id' => $salesorder->warehouse_id, 'product_id' => $item->product_id], ['quantity' => $remainQty]);
			endif;
		endforeach;

		$this->session->set_flashdata('flash', [
			'success' => true,
			'msg' => 'Successfully sailed.'
		]);

		$this->success();
	}
}