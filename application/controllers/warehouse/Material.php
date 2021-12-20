<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends MY_Controller {
	public $mLayout = 'porto/';

	function __construct() {
		parent::__construct();

		$this->load->model(['Ims_waste_category_model', 'Ims_waste_model']);
	}

	function index() {
		$this->mHeader['title'] = 'Material Management';
		$this->mHeader['menu_id'] = 'material';
		$this->mContent['waste_categories'] = $this->Ims_waste_category_model->find(['consultant_id' => $this->mUser->consultant_id]);

		$this->render('warehouse/material/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'B.consultant_id' => $this->mUser->consultant_id,
			'C.name LIKE' => "%{$param['sSearch']}%"
		];

		$this->db->join("{$this->Ims_warehouse_model->_table} B", "A.warehouse_id = B.id", 'right');
		$this->db->join("{$this->Ims_material_model->_table} C", "A.material_id = C.id", 'right');
		$data['iTotalRecords'] = $this->Ims_warehouse_material_model->count($filter);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			if ($param["mDataProp_{$sortCol}"] == 'name')
				$orders["C.name"] = $param["sSortDir_{$i}"];
			else if ($param["mDataProp_{$sortCol}"] == 'warehouse_name')
				$orders["B.name"] = $param["sSortDir_{$i}"];
			else if ($param["mDataProp_{$sortCol}"] == 'supplier_name')
				$orders["D.name"] = $param["sSortDir_{$i}"];
			else if ($param["mDataProp_{$sortCol}"] == 'upc')
				$orders["C.upc"] = $param["sSortDir_{$i}"];
			else if ($param["mDataProp_{$sortCol}"] == 'barcode')
				$orders["C.barcode"] = $param["sSortDir_{$i}"];
			else
				$orders["A.{$param["mDataProp_{$sortCol}"]}"] = $param["sSortDir_{$i}"];
		}

		foreach ($orders as $key => $val)
			$this->db->order_by($key, $val);

		$this->db->join("{$this->Ims_warehouse_model->_table} B", 'A.warehouse_id = B.id', 'LEFT');
		$this->db->join("{$this->Ims_material_model->_table} C", 'A.material_id = C.id', 'LEFT');
		$this->db->join("{$this->Ims_supplier_model->_table} D", 'C.supplier_id = D.id', 'LEFT');
		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$data['material'] = $this->Ims_warehouse_material_model->find($filter, [], [
			'A.*', 'B.name warehouse_name', 'C.name', 'C.upc', 'C.barcode', 'D.name supplier_name'
		]);
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function add() {
		$param = $this->input->post('add');
		$id = $this->input->post('id');

		if (!$param) {
			$this->db->join("{$this->Ims_warehouse_model->_table} B", 'A.warehouse_id = B.id', 'LEFT');
			$this->db->join("{$this->Ims_material_model->_table} C", 'A.material_id = C.id', 'LEFT');
			$this->db->join("{$this->Ims_supplier_model->_table} D", 'C.supplier_id = D.id', 'LEFT');

			$data['material'] = $this->Ims_warehouse_material_model->one([ 'A.id' => !$id ? -1 : $id ], [
				'A.*', 'B.name warehouse_name', 'C.name', 'C.upc', 'C.barcode', 'D.id supplier_id'
			]);

			$data['suppliers'] = $this->Ims_supplier_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$data['warehouses'] = $this->Ims_warehouse_model->find(['consultant_id' => $this->mUser->consultant_id]);

			$this->load->view('warehouse/material/add', $data);
		} else {
			if ($id == -1)
				$this->Ims_warehouse_material_model->insert($param);
			else
				$this->Ims_warehouse_material_model->update(['id' => $id], ['quantity' => $param['quantity']]);

			$this->success();
		}
	}

	function waste() {
		$param = $this->input->post('waste');

		$item = $this->Ims_warehouse_material_model->one(['id' => $param['id']]);

		if (intval($item->quantity) - intval($param['quantity']) == 0)
			$this->Ims_warehouse_material_model->delete(['id' => $param['id']]);
		else
			$this->Ims_warehouse_material_model->update(['id' => $param['id']], [
				'quantity' => intval($item->quantity) - intval($param['quantity'])
			]);

		$data = [
			'consultant_id' => $this->mUser->consultant_id,
			'employee_id' => $this->mUser->employee_id,
			'good_id' => $item->material_id,
			'waste_category_id' => $param['waste_category_id'],
			'quantity' => $param['quantity'],
			'expired_date' => $item->expired_date,
			'waste_date' => date('Y-m-d H:i:s'),
			'waste_type' => 'material'
		];

		$this->Ims_waste_model->insert($data);

		$this->success();
	}

	function delete($id) {
		$this->Ims_warehouse_material_model->delete(['id' => $id]);
		$this->success();
	}
}