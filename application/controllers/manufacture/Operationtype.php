<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operationtype extends MY_Controller {
	public $mLayout = 'porto/';

	function __construct() {
		parent::__construct();

		$this->load->model(['Ims_operation_type_model']);
	}

	function index() {
		$this->mHeader['title'] = 'Operation Type';
		$this->mHeader['menu_id'] = 'master_data';
		$this->render('manufacture/operationtype/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id,
			'A.name LIKE' =>"%{$param['sSearch']}%"
		];

		$data['iTotalRecords'] = $this->Ims_operation_type_model->count($filter);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			$orders['A.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
		}

		foreach ($orders as $key => $val)
			$this->db->order_by($key, $val);

		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$data['operationtype'] = $this->Ims_operation_type_model->find($filter);
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function add() {
		$param = $this->input->post('add');
		$id = $this->input->post('id');
		

		if (!$param) {
			$data['operationtype'] = $this->Ims_operation_type_model->one(['A.id' => $id]);

			$this->load->view('manufacture/operationtype/add', $data);
		} else {
			if ($id == -1) {
				$param['consultant_id'] = $this->mUser->consultant_id;
				$param['employee_id'] = $this->mUser->employee_id;
				$param['create_at'] = date('Y-m-d H:i:s');
				$this->Ims_operation_type_model->insert($param);
			} else {
				$param['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_operation_type_model->update(['id' => $id], $param);
			}

			$this->success();
		}
	}

	function delete($id) {
		$this->Ims_operation_type_model->delete(['id' => $id]);
		$this->success();
	}
}