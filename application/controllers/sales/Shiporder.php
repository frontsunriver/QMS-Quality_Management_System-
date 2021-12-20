<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shiporder extends MY_Controller {
	public $mLayout = 'porto/';

	public $prefix_num = 'WH/OUT/';
	public $num_length = 6;

	function __construct() {
		parent::__construct();

		$this->load->model(['Ims_shiporder_model', 'Ims_salesorder_model', 'Ims_salesorder_product_model', 'Ims_operation_type_model']);
	}

	function index() {
		$this->mHeader['title'] = 'Ship Orders';
        $this->mHeader['menu_id'] = 'ship_orders';

        $this->render('sales/shiporder/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id
		];

		$data['iTotalRecords'] = $this->Ims_shiporder_model->count($filter);

		$filter['A.reference LIKE'] = "%{$param['sSearch']}%";

		$data['iTotalDisplayRecords'] = $this->Ims_shiporder_model->count($filter);

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

		$this->db->join("{$this->Ims_warehouse_model->_table} B", "A.des_location = B.id", 'LEFT');
		$this->db->join("{$this->Ims_customer_model->_table} C", "A.customer_id = C.id", 'LEFT');
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
			$this->mHeader['menu_id'] = 'ship_orders';
			$this->mContent['reference'] = $reference;

			$this->mContent['customers'] = $this->Ims_customer_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['warehouses'] = $this->Ims_warehouse_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['opts'] = $this->Ims_operation_type_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['products'] = $this->Ims_product_model->find(['consultant_id' => $this->mUser->consultant_id]);

			$salesorder_id = $this->input->get('salesorder_id');

			if ($salesorder_id != -1) {
				$salesorder = $this->Ims_salesorder_model->one(['id' => $salesorder_id]);

				$shiporder = new stdClass();
				$shiporder->id = -1;
				$shiporder->salesorder_id = $salesorder_id;
				$shiporder->reference = $reference;
				$shiporder->customer_id = $salesorder->customer_id;
				$shiporder->src_location = $this->mContent['warehouses'][0]->id;
				$shiporder->des_location = $salesorder->warehouse_id;

				$this->db->join("{$this->Ims_product_model->_table} B", 'A.product_id = B.id', 'LEFT');
				$shiporder->product = $this->Ims_salesorder_product_model->find(['A.salesorder_id' => $salesorder_id], [], ['B.name product_name', 'A.ordered_qty', 'A.variant']);

				$this->mContent['shiporder'] = $shiporder;
			} else {
				$shiporder = $this->Ims_shiporder_model->one(['id' => $id]);
			}

			$this->render('sales/shiporder/create', $this->mLayout);
		} else {
			$param['consultant_id'] = $this->mUser->consultant_id;
			$param['employee_id'] = $this->mUser->employee_id;
			$param['create_at'] = date('Y-m-d H:i:s');
			$this->Ims_shiporder_model->insert($param);

			$this->Ims_salesorder_model->update(['id' => $param['salesorder_id']], ['state' => 1]);

			$this->session->set_flashdata('flash', [
				'success' => true,
				'msg' => 'Successfully deliveried.'
			]);

			$this->redirect('sales/salesorder');
		}
	}
}