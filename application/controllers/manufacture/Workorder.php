<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Workorder extends MY_Controller {
	public $mLayout = 'porto/';

	function __construct() {
		parent::__construct();

		$this->load->model(['Ims_quality_check_model']);
	}

	function index() {
		$this->mHeader['title'] = 'Work Orders';
		$this->mHeader['menu_id'] = 'work_orders';
		$this->render('manufacture/workorder/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		// if ($this->mUser->type == 'monitor')
			$filter = [ 'B.consultant_id' => $this->mUser->consultant_id ];
		// else
			// $filter = [ 'B.employee_id' => $this->mUser->employee_id ];

		$filter['B.manuorder_num LIKE'] = "%{$param['sSearch']}%";

		$this->db->join("{$this->Ims_manuorder_model->_table} B", 'A.manuorder_id = B.id', 'LEFT');
		$data['iTotalRecords'] = $this->Ims_manuorder_work_order_model->count($filter);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			if ($param["mDataProp_{$sortCol}"] == 'manuorder_num' || $param["mDataProp_{$sortCol}"] == 'scheduled_date' || $param["mDataProp_{$sortCol}"] == 'quantity' || $param["mDataProp_{$sortCol}"] == 'variant')
				$orders['B.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
			else if ($param["mDataProp_{$sortCol}"] == 'product_name')
				$orders['F.name'] = $param["sSortDir_{$i}"];
			else if ($param["mDataProp_{$sortCol}"] == 'routing_name')
				$orders['C.name'] = $param["sSortDir_{$i}"];
			else if ($param["mDataProp_{$sortCol}"] == 'workcenter_name')
				$orders['E.name'] = $param["sSortDir_{$i}"];
			else if ($param["mDataProp_{$sortCol}"] == 'number_of_cycles' || $param["mDataProp_{$sortCol}"] == 'number_of_hours')
				$orders['D.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
			else if ($param["mDataProp_{$sortCol}"] == 'manuorder_num')
				$orders['B.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
		}
		
		$this->db->join("{$this->Ims_manuorder_model->_table} B", 'A.manuorder_id = B.id', 'LEFT');
		$this->db->join("{$this->Ims_routing_model->_table} C", 'B.routing_id = C.id', 'LEFT');
		$this->db->join("{$this->Ims_routing_operation_model->_table} D", 'A.routing_operation_id = D.id', 'LEFT');
		$this->db->join("{$this->Ims_workcenter_model->_table} E", 'D.workcenter_id = E.id', 'LEFT');
		$this->db->join("{$this->Ims_product_model->_table} F", 'B.product_id = F.id', 'LEFT');
		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$data['workorder'] = $this->Ims_manuorder_work_order_model->find($filter, $orders, [
			'A.id', 'A.state', 'B.manuorder_num', 'B.scheduled_date', 'B.quantity', 'B.variant', 'C.name routing_name',
			'D.sequence', 'D.number_of_cycles', 'D.number_of_hours', 'E.name workcenter_name',
//			'F.name product_name', "'{$this->mUser->role}' role"
			'F.name product_name', "'{$this->mUser->type}' role"
		]);
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function start($id) {
		$this->Ims_manuorder_work_order_model->update(['id' => $id], [
			'state' => 1,
			'started_at' => date('Y-m-d H:i:s')
		]);

		$this->session->set_flashdata('flash', [
			'success' => true,
			'msg' => 'Successfully started this work order.'
		]);

		$this->success();
	}

	function qualitycheck($id) {
		$param = $this->input->post();

		if ($param['test_type'] == 1) {
			$this->Ims_manuorder_work_order_model->update(['id' => $id], [
				'state' => $param['check_value'],
				'qualitychecker_id' => $this->mUser->employee_id,
				'qualitycheck_at' => date('Y-m-d H:i:s')
			]);
		} else if ($param['test_type'] == 2) {
			if ($param['tolerance_from'] <= $param['check_value'] && $param['check_value'] <= $param['tolerance_to'])
				$value = 2;
			else
				$value = -2;

			$this->Ims_manuorder_work_order_model->update(['id' => $id], [
				'state' => $value,
				'qualitycheck_value' => $param['check_value'],
				'qualitychecker_id' => $this->mUser->employee_id,
				'qualitycheck_at' => date('Y-m-d H:i:s')
			]);
		}

		$this->session->set_flashdata('flash', [
			'success' => true,
			'msg' => 'Successfully quality checked !!!'
		]);

		$this->redirect("manufacture/workorder/view/$id");
	}

	function finish($id) {
		$this->Ims_manuorder_work_order_model->update(['id' => $id], [
			'state' => 3,
			'finished_at' => date('Y-m-d H:i:s')
		]);

		$one = $this->Ims_manuorder_work_order_model->one(['id' => $id]);
		$workorders = $this->Ims_manuorder_work_order_model->find(['manuorder_id' => $one->manuorder_id]);

		$finish = true;
		foreach ($workorders as $workorder) :
			if ($workorder->state != 3) {
				$finish = false;
				break;
			}
		endforeach;

		if ($finish) {
			$this->Ims_manuorder_model->update(['id' => $one->manuorder_id], ['state' => 4]);

			$manuorder = $this->Ims_manuorder_model->one(['id' => $one->manuorder_id]);
			if ($manuorder->plan_id)
				$this->Ims_plan_product_model->update(['id' => $manuorder->plan_id], ['active' => 1, 'update_at' => date('Y-m-d H:i:s')]);
		}

		$this->session->set_flashdata('flash', [
			'success' => true,
			'msg' => 'Successfully finished this work order.'
		]);

		$this->success();
	}

	function view($id) {
		$this->mHeader['title'] = 'View Orders';
		$this->mHeader['menu_id'] = 'work_orders';

		$this->db->join("{$this->Ims_manuorder_model->_table} B", 'A.manuorder_id = B.id', 'LEFT');
		$this->db->join("{$this->Ims_routing_model->_table} C", 'B.routing_id = C.id', 'LEFT');
		$this->db->join("{$this->Ims_routing_operation_model->_table} D", 'A.routing_operation_id = D.id', 'LEFT');
		$this->db->join("{$this->Ims_workcenter_model->_table} E", 'D.workcenter_id = E.id', 'LEFT');
		$this->db->join("{$this->Ims_product_model->_table} F", 'B.product_id = F.id', 'LEFT');

		$view_order = $this->Ims_manuorder_work_order_model->one(['A.id' => $id], [
			'A.id', 'A.state', 'A.started_at', 'A.finished_at', 'A.src_doc', 'B.manuorder_num', 'B.scheduled_date', 'B.quantity', 'B.variant', 'B.employee_id', 'C.name routing_name',
			'D.sequence', 'D.number_of_cycles', 'D.number_of_hours', 'E.name workcenter_name',
			'F.name product_name'
		]);

		$mm = intval($view_order->number_of_cycles) * minutes($view_order->number_of_hours);
		$view_order->endp_date = date_add(date_create($view_order->scheduled_date), new DateInterval("PT{$mm}M"));

		if ($view_order->state == 3)
			$view_order->working_hours = date_diff(date_create($view_order->finished_at), date_create($view_order->started_at));
		else
			$view_order->working_hours = date_diff(date_create(date('Y-m-d H:i:s')), date_create($view_order->started_at));

		$this->mContent['view_order'] = $view_order;
		$this->mContent['user'] = $this->mUser;

		$this->render('manufacture/workorder/view', $this->mLayout);
	}

	function conduct($id) {
		$cnt = $this->Control_list_model->count(['workorder_id' => $id]);
		if ($cnt == 0) {
			$this->db->join("{$this->Ims_routing_operation_model->_table} B", 'A.routing_operation_id = B.id', 'LEFT');
			$this->db->join("{$this->Ims_manuorder_model->_table} C", 'A.manuorder_id = C.id', 'LEFT');
			$workorder = $this->Ims_manuorder_work_order_model->one(['A.id' => $id], ['A.id', 'B.workcenter_id', 'C.responsible_id', 'C.product_id', 'C.variant']);

			$qualitycheck = $this->Ims_quality_check_model->one([
				'A.product_id' => $workorder->product_id,
				'A.variant' => $workorder->variant,
				'A.workcenter_id' => $workorder->workcenter_id,
			]);

			$risk = $this->Risk_model->one(['company_id' => $this->mUser->consultant_id, 'risk_type' => -1]);
			if (!$risk) {
				$risk_id = $this->Risk_model->insert([
					'name' => 'The Risk For IMS',
					'description' => 'This is for ims conduct.',
					'company_id' => $this->mUser->consultant_id,
					'risk_type' => -1,
					'reg_date' => date('Y-m-d H:i:s'),
					'del_flag' => 1
				]);

				$process_id = $this->Process_model->insert([
					'risk_id' => $risk_id,
					'del_flag' => 1,
					'reg_date' => date('Y-m-d H:i:s')
				]);
			} else {
				$process = $this->Process_model->one(['risk_id' => $risk->id, 'del_flag' => 1]);
				if (!$process)
					$process_id = $this->Process_model->insert([
						'risk_id' => $risk->id,
						'del_flag' => 1,
						'reg_date' => date('Y-m-d H:i:s')
					]);
				else
					$process_id = $process->id;
			}

			$this->Control_list_model->insert([
				'process_id' => $process_id,
				'name' => "$qualitycheck->title - $workorder->id",
				'frequency' => $qualitycheck->frequency_id,
				// 'sme' => $workorder->responsible_id,
				'sme' => $this->mUser->employee_id,
				'monitor' => $this->mUser->employee_id,
				'responsible_party' => $qualitycheck->responsible_id,
				'workorder_id' => $id
			]);
		}

		$this->session->set_userdata('consultant_id', $this->mUser->consultant_id);
		$this->session->set_userdata('user_type', $this->mUser->type);
		$this->session->set_userdata('employee_id', $this->mUser->employee_id);

		$this->redirect('consultant/conduct');
	}

	function upload($id) {
		$workorder = $this->Ims_manuorder_work_order_model->one(['id' => $id]);

		$config['upload_path'] = './uploads/src_doc/';
		if (!file_exists($config['upload_path']))
			mkdir($config['upload_path']);

		$ext = strtolower(substr(strrchr($_FILES['userfile']['name'], '.'), 1));

		$config['file_name'] = substr(sha1(rand(1, 1000)), 0, 20) . ".{$ext}";
		$config['allowed_types'] = 'pdf';
		$config['max_size'] = '2048000';

		$this->upload->initialize($config);

		$src_doc = '';
		if ($this->upload->do_upload()) {
			if ($workorder->src_doc)
				unlink(realpath("uploads/src_doc/$workorder->src_doc"));

			$src_doc = $config['file_name'];
			$this->Ims_manuorder_work_order_model->update(['id' => $id], ['src_doc' => $src_doc]);

			echo $src_doc;
		} else {
			// show_error($this->upload->display_errors());
			echo 'error';
		}
	}
}