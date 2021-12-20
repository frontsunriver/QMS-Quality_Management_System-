<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manuorderreport extends MY_Controller {
	public $mLayout = 'porto/';

	function __construct() {
		parent::__construct();
	}

	function index() {
		$type = $this->input->get('type');

		if (is_null($type))
			$type = -1;

		$this->mHeader['title'] = 'Manufacturing Orders Report';
		$this->mHeader['menu_id'] = 'report';

		$this->mContent['type'] = $type;

		$filter = ['consultant_id' => $this->mUser->consultant_id];
		if ($type != -1)
			$filter['state'] = $type;

		$this->db->group_by('state');
		$results = $this->Ims_manuorder_model->find($filter, [], [
			'state', 'COUNT(*) cnt'
		]);

		$types = [0 => 'NEW', 1 => 'AWAITING RAW MATERIALS', 2 => 'READY TO PRODUCE', 3 => 'PRODUCTION STARTED', 4 => 'DONE', 5 => 'TRANSFER'];

		$items = [];
		foreach ($results as $item) :
			$items[] = [$types[$item->state], $item->cnt];
		endforeach;

		$report = json_encode($items);
		$report = str_replace('},{', '],[', $report);
		$report = str_replace('[{', '[[', $report);
		$report = str_replace('}]', ']]', $report);

		$this->mContent['report'] = $report;

		$this->render('manufacture/report/manuorder', $this->mLayout);
	}
}