<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wastereport extends MY_Controller {
	public $mLayout = 'porto/';

	function __construct() {
		parent::__construct();

		$this->load->model('Ims_waste_model');
		$this->load->model('Ims_waste_category_model');
	}

	function index() {
		$type = $this->input->get('type');
		$category = $this->input->get('category');
		$daterange = $this->input->get('daterange');

		if (!$type)
			$type = 'material';

		if (!$category)
			$category = -1;

		if (!$daterange) {
			$dt = date('Y/m/d');
			$order_date = new DateTime($dt);
			$order_date->sub(new DateInterval("P7D"));
			$daterange = $order_date->format('Y/m/d') . ' - ' . $dt;
		}

		$this->mHeader['title'] = 'Waste Report';
		$this->mHeader['menu_id'] = 'report';

		$this->mContent['waste_categories'] = $this->Ims_waste_category_model->find(['employee_id' => $this->mUser->employee_id]);
		$this->mContent['type'] = $type;
		$this->mContent['category'] = $category;
		$this->mContent['daterange'] = $daterange;

		$daterange = str_replace('/', '-', $daterange);
		$arr = explode(' - ', $daterange);

		$this->db->group_by('good_id');

		if ($type == 'material')
			$this->db->join("{$this->Ims_material_model->_table} B", "A.good_id = B.id", 'right');
		else if ($type == 'product')
			$this->db->join("{$this->Ims_product_model->_table} B", "A.good_id = B.id", 'right');

		if ($category != -1)
			$this->db->where('waste_category_id', $category);

		$this->db->where("A.waste_date BETWEEN '{$arr[0]}' AND '{$arr[1]}'");
		$results = $this->Ims_waste_model->find([
			'A.consultant_id' => $this->mUser->consultant_id,
			'A.waste_type' => $type
		], [], [
			'B.name name', 'SUM(A.quantity) qty'
		]);

		$items = [];
		foreach ($results as $item) :
			$items[] = [$item->name, $item->qty];
		endforeach;

		$report = json_encode($items);
		$report = str_replace('},{', '],[', $report);
		$report = str_replace('[{', '[[', $report);
		$report = str_replace('}]', ']]', $report);

		$this->mContent['report'] = $report;

		$this->render('manufacture/report/waste', $this->mLayout);
	}
}