<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Workcenter extends MY_Controller {
	public $mLayout = 'porto/';

	function index() {
		$this->mHeader['title'] = 'Work Center';
		$this->mHeader['menu_id'] = 'master_data';
		$this->render('manufacture/workcenter/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();
		
		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id,
			'A.name LIKE' => "%{$param['sSearch']}%"
		];

		$data['iTotalRecords'] = $this->Ims_workcenter_model->count($filter);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			$orders['A.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
		}

		foreach ($orders as $key => $val)
			$this->db->order_by($key, $val);

		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$data['workcenter'] = $this->Ims_workcenter_model->find($filter);
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function create($id = -1) {
		$param = $this->input->post('create');

		if (!$param) {
			$this->mHeader['title'] = 'Work Center';
			$this->mHeader['menu_id'] = 'master_data';

			$this->mContent['workcenter'] = $this->Ims_workcenter_model->one(['A.id' => $id]);

			$this->render('manufacture/workcenter/create', $this->mLayout);
		} else {
			$param['bom_type'] = !isset($param['bom_type']) ? 0 : 1;

			if ($id == -1) {
				$param['consultant_id'] = $this->mUser->consultant_id;
				$param['employee_id'] = $this->mUser->employee_id;
				$param['create_at'] = date('Y-m-d H:i:s');
				$this->Ims_workcenter_model->insert($param);

				$msg = 'Successfully created.';
			} else {
				$param['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_workcenter_model->update(['id' => $id], $param);

				$msg = 'Successfully updated.';
			}

			$this->session->set_flashdata('flash', [
				'success' => true,
				'msg' => $msg
			]);

			$this->redirect('manufacture/workcenter');
		}
	}

	function delete($id) {
		$this->Ims_workcenter_model->delete(['id' => $id]);
		$this->success();
	}
}