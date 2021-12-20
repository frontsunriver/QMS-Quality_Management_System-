<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesorderreport extends MY_Controller {
	public $mLayout = 'porto/';

	function __construct() {
		parent::__construct();

		$this->load->model(['Ims_salesorder_model']);
	}

	function index() {
		$type = $this->input->get('type');

		if (is_null($type))
			$type = -1;

		$this->mHeader['title'] = 'Sales Orders Report';
		$this->mHeader['menu_id'] = 'sales_report';

		$this->mContent['type'] = $type;

		$this->db->group_by('state');

		$filter = ['consultant_id' => $this->mUser->consultant_id];
		if ($type != -1)
			$filter['state'] = $type;
		else
			$filter['state < '] = 2;

		$results = $this->Ims_salesorder_model->find($filter, [], [
			'state', 'COUNT(*) cnt'
		]);

		$types = [0 => 'SALES ORDER', 1 => 'SALES DONE'];

		$items = [];
		foreach ($results as $item) :
			$items[] = [$types[$item->state], $item->cnt];
		endforeach;

		$report = json_encode($items);
		$report = str_replace('},{', '],[', $report);
		$report = str_replace('[{', '[[', $report);
		$report = str_replace('}]', ']]', $report);

		$this->mContent['report'] = $report;

		$this->render('sales/salesorderreport', $this->mLayout);
	}
}