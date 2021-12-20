<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistic extends MY_Controller
{
	function company() {
		$sdt = $this->input->post('start');
		$edt = $this->input->post('end');

		$company_id = $this->session->userdata('consultant_id');

		$result = [];

		$employees = $this->Employees_model->find([
			'consultant_id' => $company_id
		]);

		$cnt = 0;
		foreach ($employees as $employee) :
			$i = intval($cnt / 8);

			$result[$i]['label'][] = $employee->employee_name;

			$where = [
				'process_owner' => $employee->employee_id,
				'by_when_date >= ' => $sdt,
				'by_when_date <= ' => $edt
			];

			$result[$i]['total'][] = $this->Corrective_action_data_model->count($where);
			$where['process_status'] = 'Open';
			$result[$i]['open'][] = $this->Corrective_action_data_model->count($where);
			$where['process_status'] = 'Close';
			$result[$i]['close'][] = $this->Corrective_action_data_model->count($where);
			$where = [
				'process_owner' => $employee->employee_id,
				'by_when_date <= ' => $edt,
			];
			$result[$i]['past'][] = $this->Corrective_action_data_model->count($where);

			$cnt ++;
		endforeach;

		$this->json($result);
	}
}