<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse extends MY_Controller {
	public $mLayout = 'porto/';

	function index() {
		$this->mHeader['title'] = 'Warehouse Management';
		$this->mHeader['menu_id'] = 'master_data';
		$this->render('manufacture/warehouse/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'consultant_id' => $this->mUser->consultant_id,
			'name LIKE' => "%{$param['sSearch']}%"
		];

		$data['iTotalRecords'] = $this->Ims_warehouse_model->count($filter);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			$orders[$param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
		}

		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$data['warehouse'] = $this->Ims_warehouse_model->find($filter, $orders);
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function add() {
		$param = $this->input->post('add');
		$id = $this->input->post('id');
		

		if (!$param) {
			$data['warehouse'] = $this->Ims_warehouse_model->one(['id' => $id]);

			$this->load->view('manufacture/warehouse/add', $data);
		} else {
			if ($id == -1) {
				$param['consultant_id'] = $this->mUser->consultant_id;
				$param['employee_id'] = $this->mUser->employee_id;
				$param['create_at'] = date('Y-m-d H:i:s');
				$this->Ims_warehouse_model->insert($param);
			} else {
				$param['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_warehouse_model->update(['id' => $id], $param);
			}

			$this->success();
		}
	}

	function delete($id) {
		$this->Ims_warehouse_model->delete(['id' => $id]);
		$this->success();
	}
}