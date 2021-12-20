<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work extends MY_Controller {
	public $mLayout = 'porto/';

	function index() {
		$this->mHeader['title'] = 'Work Center';
		$this->mHeader['menu_id'] = 'master_data';
		$this->render('manufacture/work/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();
		
		$data['iTotalRecords'] = 1;
		$data['iTotalDisplayRecords'] = 1;
		$data['work'] = [
			[
				'code' => '001',
				'name' => 'Wood Shop',
				'resource_type' => 'Material'
			], [
				'code' => '002',
				'name' => 'Press Shop',
				'resource_type' => 'Material'
			], [
				'code' => '003',
				'name' => 'Machine/Welding',
				'resource_type' => 'Material'
			]
		];
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function create($id = null) {
		$param = $this->input->post('create');

		if (!$param) {
			$data = [];
			// $data['product'] = $this->Customer_model->one([
			// 	'id' => $id
			// ]);

			$this->mHeader['title'] = 'Create Bill of Material';
			$this->mHeader['menu_id'] = 'master_data';

			$this->render('manufacture/work/create', $this->mLayout);
		} else {
			$this->redirect('manufacture/work');
		}
	}
}