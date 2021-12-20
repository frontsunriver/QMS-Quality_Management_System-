<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends MY_Controller {
	public $mLayout = 'porto/';

	function index() {
		$this->mHeader['title'] = 'Supplier Management';
		$this->mHeader['menu_id'] = 'supplier';
		$this->render('procurement/supplier/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id
		];

		$data['iTotalRecords'] = $this->Ims_supplier_model->count($filter);

		$filter['A.name LIKE'] = "%{$param['sSearch']}%";

		$data['iTotalDisplayRecords'] = $this->Ims_supplier_model->count($filter);

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			$orders['A.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
		}

		foreach ($orders as $key => $val)
			$this->db->order_by($key, $val);

		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$data['supplier'] = $this->Ims_supplier_model->find($filter);
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function add() {
		$param = $this->input->post('add');
		$id = $this->input->post('id');

		if (!$param) {
			$data['supplier'] = $this->Ims_supplier_model->one(['id' => $id]);

			$this->load->view('procurement/supplier/add', $data);
		} else {
			if ($id == -1) {
				$param['consultant_id'] = $this->mUser->consultant_id;
				$param['employee_id'] = $this->mUser->employee_id;
				$param['create_at'] = date('Y-m-d H:i:s');
				$this->Ims_supplier_model->insert($param);
			} else {
				$param['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_supplier_model->update(['id' => $id], $param);
			}

			$this->success();
		}
	}

	function delete($id) {
		$this->Ims_supplier_model->delete(['id' => $id]);
		$this->success();
	}
}