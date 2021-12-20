<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends MY_Controller {
	public $mLayout = 'porto/';

	function __construct() {
		parent::__construct();

		$this->load->model(['Ims_product_attr_model']);
	}

	function index() {
		$type = $this->input->get('type');
		$view = $this->input->get('view');
		$view = !$view ? 'frequency' : $view;

		if ($type == 'product')
			$this->mHeader['title'] = 'Product Planing Management';
		else if ($type == 'material')
			$this->mHeader['title'] = 'Material Planing Management';

		$this->mHeader['menu_id'] = 'planing';
		$this->mContent['type'] = $type;

		if ($type == 'product') {
			$this->mContent['products'] = $this->Ims_product_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$plans = $this->Ims_plan_product_model->find(['employee_id' => $this->mUser->employee_id]);

			$items = [];
			foreach ($plans as $plan) :
				$items[substr($plan->order_date, 0, 7)][] = $plan;
			endforeach;
		} else if ($type == 'material') {
			$this->mContent['materials'] = $this->Ims_material_model->find(['consultant_id' => $this->mUser->consultant_id]);

			$plans = $this->Ims_plan_material_model->find(['employee_id' => $this->mUser->employee_id]);
			$items = [];
			foreach ($plans as $plan) :
				$items[substr($plan->order_date, 0, 7)][] = $plan;
			endforeach;
		}

		$this->mContent['view'] = $view;
		$this->mContent['plans'] = $items;

		$this->render('manufacture/plan/list_' . $type, $this->mLayout);
	}

	function read($type = 'product') {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.employee_id' => $this->mUser->employee_id,
			'B.name LIKE' => "%{$param['sSearch']}%"
		];
				
		if ($type == 'product') {
			$this->db->join("{$this->Ims_product_model->_table} B", 'A.product_id = B.id', 'LEFT');
			$data['iTotalRecords'] = $this->{'Ims_plan_' . $type . '_model'}->count($filter);

			$orders = [];
			for ($i = 0; $i < $param['iSortingCols']; $i ++) {
				$sortCol = $param["iSortCol_{$i}"];
				if ($param["mDataProp_{$sortCol}"] == 'product_name')
					$orders['B.name'] = $param["sSortDir_{$i}"];
				else if ($param["mDataProp_{$sortCol}"] == 'workcenter_name')
					$orders['C.name'] = $param["sSortDir_{$i}"];
				else if ($param["mDataProp_{$sortCol}"] == 'responsible_name')
					$orders['D.employee_name'] = $param["sSortDir_{$i}"];
				else
					$orders['A.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
			}

			$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
			$this->db->join("{$this->Ims_product_model->_table} B", 'A.product_id = B.id', 'LEFT');
			$this->db->join("{$this->Ims_workcenter_model->_table} C", 'A.workcenter_id = C.id', 'LEFT');
			$this->db->join("{$this->Employees_model->_table} D", 'A.responsible_id = D.employee_id', 'LEFT');

			$products = $this->Ims_plan_product_model->find($filter, $orders, [
				'A.id', 'A.variant', 'A.frequency', 'A.order_date', 'A.active', 'B.name product_name', 'C.name workcenter_name', 'D.employee_name responsible_name'
			]);

			foreach ($products as $product) :
				$interval = date_diff(date_create(date('Y-m-d')), date_create($product->order_date));
				$product->state = $interval->invert == 1 ? 0 - $interval->days :$interval->days;
				$manuorder = $this->Ims_manuorder_model->one(['employee_id' => $this->mUser->employee_id, 'plan_id' => $product->id, 'state <' => 4 ]);
				if ($manuorder) {
					$fail_cnt = $this->Ims_manuorder_work_order_model->count(['manuorder_id' => $manuorder->id, 'state' => -2]);
					if ($fail_cnt > 0)
						$product->quality_check = -2;
					else {
						$checking_cnt = $this->Ims_manuorder_work_order_model->count(['manuorder_id' => $manuorder->id, 'state <>' => -2, 'state <' => 2]);
						if ($checking_cnt > 0)
							$product->quality_check = 1;
						else
							$product->quality_check = 0;
					}

					$product->start_date = $manuorder->create_at;
				} else {
					$product->quality_check = -1;
					$product->start_date = null;
				}
			endforeach;

			$data['product'] = $products;
		} else if ($type == 'material') {
			$this->db->join("{$this->Ims_material_model->_table} B", 'A.material_id = B.id', 'LEFT');
			$data['iTotalRecords'] = $this->{'Ims_plan_' . $type . '_model'}->count($filter);

			$orders = [];
			for ($i = 0; $i < $param['iSortingCols']; $i ++) {
				$sortCol = $param["iSortCol_{$i}"];
				if ($param["mDataProp_{$sortCol}"] == 'material_name')
					$orders['B.name'] = $param["sSortDir_{$i}"];
				else if ($param["mDataProp_{$sortCol}"] == 'warehouse_name')
					$orders['C.name'] = $param["sSortDir_{$i}"];
				else
					$orders['A.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
			}

			$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
			$this->db->join("{$this->Ims_material_model->_table} B", 'A.material_id = B.id', 'LEFT');
			$this->db->join("{$this->Ims_warehouse_model->_table} C", 'A.warehouse_id = C.id', 'LEFT');

			$materials = $this->Ims_plan_material_model->find($filter, $orders, [
				'A.id', 'A.material_id', 'A.warehouse_id', 'A.demand_quantity', 'A.frequency', 'A.order_date', 'B.name material_name', 'C.name warehouse_name'
			]);

			foreach ($materials as $material) :
				$interval = date_diff(date_create(date('Y-m-d')), date_create($material->order_date));
				$material->state = $interval->invert == 1 ? 0 - $interval->days :$interval->days;
				$material->remain_quantity = $this->Ims_warehouse_material_model->count(['warehouse_id' => $material->warehouse_id, 'material_id' => $material->material_id]);
			endforeach;

			$data['material'] = $materials;
		}
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function add($id = -1) {
		$param = $this->input->post('plan');
		$type = $this->input->post('type');

		$data = [];
		if (!$param) {
			if ($type == 'product') {
				$products = $this->Ims_product_model->find(['consultant_id' => $this->mUser->consultant_id]);

				foreach ($products as $item) :
					$attrs = $this->Ims_product_attr_model->find(['product_id' => $item->id], ['id' => 'asc']);
					if (!empty($attrs)) :
						$variants = [];
						foreach ($attrs as $attr) :
							$variants[] = explode(',', $attr->value);
						endforeach;

						$this->mVariants = [];
						for ($i = 0; $i < count($variants[0]); $i ++)
							$this->getVariants($variants, 0, $i, '');

						$item->variants = $this->mVariants;
					endif;
				endforeach;

				$data['products'] = $products;
				$data['workcenters'] = $this->Ims_workcenter_model->find(['employee_id' => $this->mUser->employee_id]);
				$data['employees'] = $this->Employees_model->find(['consultant_id' => $this->mUser->consultant_id]);
			} else if ($type == 'material') {
				$data['materials'] = $this->Ims_material_model->find(['consultant_id' => $this->mUser->consultant_id]);
				$data['warehouses'] = $this->Ims_warehouse_model->find(['consultant_id' => $this->mUser->consultant_id]);
			}

			$this->load->view("manufacture/plan/add_{$type}", $data);
		} else {
			$param['consultant_id'] = $this->mUser->consultant_id;
			$param['employee_id'] = $this->mUser->employee_id;

			if ($type == 'product') {
				$arr = explode('@', $param['product_id']);
				$param['product_id'] = $arr[0];
				$param['variant'] = isset($arr[1]) ? $arr[1] : null;
			}

			if ($id == -1) {
				$param['created_at'] = date('Y-m-d H:i:s');

				$this->{'Ims_plan_' . $type . '_model'}->insert($param);

				$this->session->set_flashdata('flash', [
					'success' => true,
					'msg' => "Successfully created $type."
				]);
			}

			$this->redirect("manufacture/plan?type=$type");
		}
	}

	function close($id) {
		$type = $this->input->post('type');
		$this->{'Ims_plan_' . $type . '_model'}->delete(['id' => $id]);
		$this->success();
	}
}