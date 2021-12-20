<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frequency extends MY_Controller {
	function __construct() {
		parent::__construct();

		$this->load->model(['Frequency_model']);
	}

	function get() {
		$frequencies = $this->Frequency_model->find(['company_id' => $this->mUser->consultant_id]);

		$this->json($frequencies);
	}

	function add() {
		$param = $this->input->post();
		$param['company_id'] = $this->mUser->consultant_id;

		$this->Frequency_model->insert($param);

		$this->success();
	}

	function delete($id) {
		$this->Frequency_model->delete(['frequency_id' => $id]);

		$this->success();
	}
}