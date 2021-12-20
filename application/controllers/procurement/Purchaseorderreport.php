<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchaseorderreport extends MY_Controller {
	public $mLayout = 'porto/';

	function index() {
		$type = $this->input->get('type');

		if (is_null($type))
			$type = -1;

		$this->mHeader['title'] = 'Purchase Orders Report';
		$this->mHeader['menu_id'] = 'purchaseorderreport';

		$this->mContent['type'] = $type;

		$filter = ['consultant_id' => $this->mUser->consultant_id];
		if ($type != -1)
			$filter['state'] = $type;

		$this->db->group_by('state');
		$results = $this->Ims_purchase_order_model->find($filter, [], [
			'state', 'COUNT(*) cnt'
		]);

		$types = [0 => 'PURCHASE', 1 => 'DONE', 2 => 'TRANSFERED'];

		$items = [];
		foreach ($results as $item) :
			$items[] = [$types[$item->state], $item->cnt];
		endforeach;

		$report = json_encode($items);
		$report = str_replace('},{', '],[', $report);
		$report = str_replace('[{', '[[', $report);
		$report = str_replace('}]', ']]', $report);

		$this->mContent['report'] = $report;

		$this->render('procurement/purchaseorderreport', $this->mLayout);
	}
}