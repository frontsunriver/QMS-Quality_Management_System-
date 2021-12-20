<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller {
	public $mLayout = 'porto/';

	function index() {
		$this->mHeader['title'] = 'Customer Management';
		$this->mHeader['menu_id'] = 'customer';
		$this->render('sales/customer/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id,
			'A.name LIKE' => "%{$param['sSearch']}%"
		];

		$data['iTotalRecords'] = $this->Ims_customer_model->count($filter);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			$orders['A.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
		}

		foreach ($orders as $key => $val)
			$this->db->order_by($key, $val);

		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$data['customer'] = $this->Ims_customer_model->find($filter);
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function add() {
		$param = $this->input->post('add');
		$id = $this->input->post('id');

		if (!$param) {
			$data['customer'] = $this->Ims_customer_model->one(['A.id' => $id]);

			$this->load->view('sales/customer/add', $data);
		} else {
			if ($id == -1) {
				$param['consultant_id'] = $this->mUser->consultant_id;
				$param['employee_id'] = $this->mUser->employee_id;
				$param['create_at'] = date('Y-m-d H:i:s');
				$this->Ims_customer_model->insert($param);
			} else {
				$param['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_customer_model->update(['id' => $id], $param);
			}

			$this->success();
		}
	}

	function delete($id) {
		$this->Ims_customer_model->delete(['id' => $id]);
		$this->success();
	}
}