<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Routing extends MY_Controller {
	public $mLayout = 'porto/';

	function index() {
		$this->mHeader['title'] = 'Routing Management';
		$this->mHeader['menu_id'] = 'master_data';
		$this->render('manufacture/routing/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id,
			'A.name LIKE' => "%{$param['sSearch']}%"
		];

		$data['iTotalRecords'] = $this->Ims_routing_model->count($filter);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			if ($param["mDataProp_{$sortCol}"] == 'warehouse_name')
				$orders['B.name'] = $param["sSortDir_{$i}"];
			else
				$orders['A.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
		}

		$this->db->join("{$this->Ims_warehouse_model->_table} B", 'A.warehouse_id = B.id', 'LEFT');
		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$data['routing'] = $this->Ims_routing_model->find($filter, $orders, [
			'A.*', 'B.name warehouse_name'
		]);
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function add($id = -1) {
		$param = $this->input->post('routing');

		if (!$param) {
			$this->mHeader['title'] = $id == -1 ? 'Add Routing' : 'Update Routing';
			$this->mHeader['menu_id'] = 'master_data';
			$this->mContent['warehouses'] = $this->Ims_warehouse_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['workcenters'] = $this->Ims_workcenter_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['routing'] = $this->Ims_routing_model->one(['id' => $id]);

			$this->db->join("{$this->Ims_workcenter_model->_table} B", 'A.workcenter_id = B.id', 'LEFT');
			$this->mContent['operations'] = $this->Ims_routing_operation_model->find(['routing_id' => $id], [], [
				'A.*', 'B.name workcenter_name'
			]);

			$this->render('manufacture/routing/add', $this->mLayout);
		} else {
			$param['active'] = !isset($param['active']) ? 0 : 1;

			$operations = $this->input->post('operation');

			if ($id == -1) {
				$param['consultant_id'] = $this->mUser->consultant_id;
				$param['employee_id'] = $this->mUser->employee_id;
				$param['create_at'] = date('Y-m-d H:i:s');
				$inserted_id = $this->Ims_routing_model->insert($param);

				foreach ($operations as $operation) {
					$operation['routing_id'] = $inserted_id;
					$this->Ims_routing_operation_model->insert($operation);
				}

				$msg = 'Successfully created.';
			} else {
				$param['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_routing_model->update(['id' => $id], $param);

				$this->Ims_routing_operation_model->delete(['routing_id' => $id]);

				foreach ($operations as $operation) {
					$operation['routing_id'] = $id;
					$this->Ims_routing_operation_model->insert($operation);
				}

				$msg = 'Successfully updated.';
			}

			$this->session->set_flashdata('flash', [
				'success' => true,
				'msg' => $msg
			]);

			$this->redirect('manufacture/routing');
		}
	}

	function delete($id) {
		$this->Ims_routing_model->delete(['id' => $id]);
		$this->Ims_routing_operation_model->delete(['routing_id' => $id]);

		$this->success();
	}
}