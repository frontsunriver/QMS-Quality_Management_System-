<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qualitycheck extends MY_Controller {
	public $mLayout = 'porto/';

	function __construct() {
		parent::__construct();

		if ($this->mUser->type != 'monitor') {
			$this->redirect('manufacture');
			die;
		}

		$this->mHeader['menu_id'] = 'manufacturing_system';
		$this->load->model(['Frequency_model', 'Ims_product_attr_model', 'Ims_operation_type_model', 'Ims_quality_check_model']);
	}

	function index() {
		$this->mHeader['title'] = 'Quality Check';
		$this->render('manufacture/qualitycheck/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id,
			'A.title LIKE' => "%{$param['sSearch']}%"
		];

		$data['iTotalRecords'] = $this->Ims_quality_check_model->count($filter);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
		}

		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);

		$this->db->join("{$this->Ims_product_model->_table} B", 'A.product_id = B.id', 'LEFT');
		$this->db->join("{$this->Ims_operation_type_model->_table} C", 'A.operation_id = C.id', 'LEFT');
		$this->db->join("{$this->Ims_workcenter_model->_table} D", 'A.workcenter_id = D.id', 'LEFT');
		$this->db->join("{$this->Employees_model->_table} E", 'A.responsible_id = E.employee_id', 'LEFT');
		$data['qualitycheck'] = $this->Ims_quality_check_model->find($filter, $orders, [
			'A.*', 'B.name product_name', 'C.name operation_name', 'D.name workcenter_name', 'E.employee_name responsible_name'
		]);

		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function create($id = -1) {
		$param = $this->input->post('create');

		if (!$param) {
			$this->mHeader['title'] = 'Create Quality Check';

			$this->mContent['products'] = $this->Ims_product_model->find(['consultant_id' => $this->mUser->consultant_id], ['name' => 'asc']);
			$this->mContent['operations'] = $this->Ims_operation_type_model->find(['consultant_id' => $this->mUser->consultant_id], ['id' => 'asc']);
			$this->mContent['workcenters'] = $this->Ims_workcenter_model->find(['consultant_id' => $this->mUser->consultant_id], ['id' => 'asc']);
			$this->mContent['frequencies'] = $this->Frequency_model->find(['company_id' => $this->mUser->consultant_id], ['days' => 'asc']);
			$this->mContent['responsibles'] = $this->Employees_model->find(['consultant_id' => $this->mUser->consultant_id], ['employee_name' => 'asc']);
			$this->mContent['qualitycheck'] = $this->Ims_quality_check_model->one(['id' => $id]);

			$product_id = $this->mContent['qualitycheck'] ? $this->mContent['qualitycheck']->product_id : $this->mContent['products'][0]->id;

			$this->mVariants = [];

			$attrs = $this->Ims_product_attr_model->find(['product_id' => $product_id], ['id' => 'asc']);

			if (!empty($attrs)) {
				$variants = [];
				foreach ($attrs as $attr) :
					$variants[] = explode(',', $attr->value);
				endforeach;

				for ($i = 0; $i < count($variants[0]); $i ++)
					$this->getVariants($variants, 0, $i, '');
			}

			$this->mContent['variants'] = $this->mVariants;

			$this->render('manufacture/qualitycheck/create', $this->mLayout);
		} else {
			$param['consultant_id'] = $this->mUser->consultant_id;
			$param['employee_id'] = $this->mUser->employee_id;

			if ($id == -1) {
				$param['create_at'] = date('Y-m-d H:i:s');
				$inserted_id = $this->Ims_quality_check_model->insert($param);

				$this->session->set_flashdata('flash', [
					'success' => true,
					'msg' => 'Successfully created.'
				]);
			} else {
				$param['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_quality_check_model->update(['id' => $id], $param);

				$this->session->set_flashdata('flash', [
					'success' => true,
					'msg' => 'Successfully updated.'
				]);
			}

			$this->redirect('manufacture/qualitycheck');
		}
	}

	function get($id = -1) {
		if ($id == -1) {
			$workorder_id = $this->input->post('workorder_id');
			$workorder = $this->Ims_manuorder_work_order_model->one(['id' => $workorder_id]);
			$routing_operation = $this->Ims_routing_operation_model->one(['id' => $workorder->routing_operation_id]);
			$manuorder = $this->Ims_manuorder_model->one(['id' => $workorder->manuorder_id]);

			$qualitycheck = $this->Ims_quality_check_model->one(['product_id' => $manuorder->product_id, 'variant' => $manuorder->variant, 'workcenter_id' => $routing_operation->workcenter_id]);

			$this->json($qualitycheck ? $qualitycheck : []);
		}
	}

	function delete($id) {
		$this->Ims_quality_check_model->delete(['id' => $id]);
		$this->success();
	}

	function variants($product_id) {
		$this->mVariants = [];

		$attrs = $this->Ims_product_attr_model->find(['product_id' => $product_id], ['id' => 'asc']);

		if (!empty($attrs)) {
			$variants = [];
			foreach ($attrs as $attr) :
				$variants[] = explode(',', $attr->value);
			endforeach;

			for ($i = 0; $i < count($variants[0]); $i ++)
				$this->getVariants($variants, 0, $i, '');
		}

		$this->json($this->mVariants);
	}
}