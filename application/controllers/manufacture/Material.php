<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends MY_Controller {
	public $mLayout = 'porto/';

	function index() {
		$this->mHeader['title'] = 'Material Management';
		$this->mHeader['menu_id'] = 'material';
		$this->render('manufacture/material/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id
		];

		$data['iTotalRecords'] = $this->Ims_material_model->count($filter);

		$filter["A.name LIKE"] = "%{$param['sSearch']}%";

		$data['iTotalDisplayRecords'] = $this->Ims_material_model->count($filter);

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			if ($param["mDataProp_{$sortCol}"] == 'supplier_name')
				$orders["B.name"] = $param["sSortDir_{$i}"];
			else
				$orders["A.{$param["mDataProp_{$sortCol}"]}"] = $param["sSortDir_{$i}"];
		}

		$this->db->join("{$this->Ims_supplier_model->_table} B", 'A.supplier_id = B.id', 'LEFT');

		foreach ($orders as $key => $val)
			$this->db->order_by($key, $val);

		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$data['material'] = $this->Ims_material_model->find($filter, [], [
			'A.*', 'B.name supplier_name'
		]);
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function add() {
		$param = $this->input->post('add');
		$id = $this->input->post('id');

		if (!$param) {
			$data['material'] = $this->Ims_material_model->one(['A.id' => !$id ? -1 : $id]);
			$data['suppliers'] = $this->Ims_supplier_model->find(['A.consultant_id' => $this->mUser->consultant_id]);

			$this->load->view('procurement/material/add', $data);
		} else {
			if ($id == -1) {
				$param['consultant_id'] = $this->mUser->consultant_id;
				$param['employee_id'] = $this->mUser->employee_id;
				$param['create_at'] = date('Y-m-d H:i:s');
				$this->Ims_material_model->insert($param);
			} else {
				$param['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_material_model->update(['id' => $id], $param);
			}

			$this->success();
		}
	}

	function delete($id) {
		$this->Ims_material_model->delete(['id' => $id]);
		$this->success();
	}
}