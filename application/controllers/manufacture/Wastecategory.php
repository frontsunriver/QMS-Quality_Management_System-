<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wastecategory extends MY_Controller {
	public $mLayout = 'porto/';

	function __construct() {
		parent::__construct();
		
		$this->load->model('Ims_waste_category_model');
	}

	function index() {
		$this->mHeader['title'] = 'Waste Category Management';
		$this->mHeader['menu_id'] = 'master_data';
		$this->render('manufacture/wastecategory/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id,
			'A.name LIKE' => "%{$param['sSearch']}%"
		];

		$data['iTotalRecords'] = $this->Ims_waste_category_model->count($filter);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			$orders['A.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
		}

		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$data['wastecategory'] = $this->Ims_waste_category_model->find($filter, $orders);
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function add() {
		$param = $this->input->post('add');
		$id = $this->input->post('id');
		

		if (!$param) {
			$data['wastecategory'] = $this->Ims_waste_category_model->one(['A.id' => $id]);

			$this->load->view('manufacture/wastecategory/add', $data);
		} else {
			if ($id == -1) {
				$param['consultant_id'] = $this->mUser->consultant_id;
				$param['employee_id'] = $this->mUser->employee_id;
				$param['create_at'] = date('Y-m-d H:i:s');
				$this->Ims_waste_category_model->insert($param);
			} else {
				$param['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_waste_category_model->update(['id' => $id], $param);
			}

			$this->success();
		}
	}

	function delete($id) {
		$this->Ims_waste_category_model->delete(['id' => $id]);
		$this->success();
	}
}