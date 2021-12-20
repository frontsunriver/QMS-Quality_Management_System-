<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manuorder extends MY_Controller {
	public $mLayout = 'porto/';
	public $mVariants;

	function __construct() {
		parent::__construct();

		$this->load->model(['Ims_waste_category_model', 'Ims_waste_model', 'Ims_warehouse_product_model', 'Ims_product_attr_model']);
	}

	function index() {
		$this->mHeader['title'] = 'Manufacturing Orders';
		$this->mHeader['menu_id'] = 'manufacturing_orders';

		$this->render('manufacture/manuorder/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id,
			'A.manuorder_num LIKE' => "%{$param['sSearch']}%"
		];

		$data['iTotalRecords'] = $this->Ims_manuorder_model->count($filter);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			if ($param["mDataProp_{$sortCol}"] == 'product_name')
				$orders['B.name'] = $param["sSortDir_{$i}"];
			else if ($param["mDataProp_{$sortCol}"] == 'routing_name')
				$orders['C.name'] = $param["sSortDir_{$i}"];
			else
				$orders['A.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
		}

		$this->db->join("{$this->Ims_product_model->_table} B", 'A.product_id = B.id', 'LEFT');
		$this->db->join("{$this->Ims_routing_model->_table} C", 'A.routing_id = C.id', 'LEFT');
		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$manuorders = $this->Ims_manuorder_model->find($filter, $orders, [
			'A.*', 'B.name product_name', 'C.name routing_name'
		]);

		foreach ($manuorders as $manuorder) :
			$operations = $this->Ims_routing_operation_model->find(['routing_id' => $manuorder->routing_id]);
			$manuorder->total_hours = 0;
			$manuorder->total_cycles = 0;
			
			foreach ($operations as $operation) :
				$manuorder->total_hours += minutes($operation->number_of_hours);
				$manuorder->total_cycles += $operation->number_of_cycles;
			endforeach;
		endforeach;
		$data['manuorder'] = $manuorders;

		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function create($id = -1) {
		$param = $this->input->post('manuorder');

		if (!$param) {
			$manuorder_num = $this->Ims_manuorder_model->select_max('manuorder_num');
			$manuorder_num = intval(str_replace('MO/', '', $manuorder_num)) + 1;
			$manuorder_num = 'MO/' . str_repeat('0', 6 - strlen($manuorder_num)) . $manuorder_num;

			$lot_code = $this->Ims_manuorder_model->select_max('lot_code');
			$lot_code = intval($lot_code) + 1;
			$lot_code = str_repeat('0', 7 - strlen($lot_code)) . $lot_code;

			$this->mHeader['title'] = 'Manufacturing Orders';
			$this->mHeader['menu_id'] = 'manufacturing_orders';
			$this->mContent['manuorder_num'] = $manuorder_num;
			$this->mContent['lot_code'] = $lot_code;
			$this->mContent['user'] = $this->mUser;
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

			$this->mContent['products'] = $products;

			$this->db->group_by('product_id');
			$this->db->join("{$this->Ims_product_model->_table} B", 'A.product_id = B.id', 'LEFT');
			$bills = $this->Ims_bill_model->find(['A.consultant_id' => $this->mUser->consultant_id], [], [
				'A.id', 'A.product_id', 'B.name'
			]);

			foreach ($bills as $item) :
				$item->variants = $this->Ims_bill_model->find(['consultant_id' => $this->mUser->consultant_id, 'product_id' => $item->product_id], ['variant' => 'asc'], ['id', 'variant']);
			endforeach;

			$this->mContent['bills'] = $bills;

			$this->mContent['routings'] = $this->Ims_routing_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['employees'] = $this->Employees_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['waste_categories'] = $this->Ims_waste_category_model->find(['consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['warehouses'] = $this->Ims_warehouse_model->find(['consultant_id' => $this->mUser->consultant_id]);

			// $this->db->join("{$this->Ims_warehouse_model->_table} B", 'A.warehouse_id = B.id', 'LEFT');
			// $this->db->join("{$this->Ims_material_model->_table} C", 'A.material_id = C.id', 'LEFT');
			$this->mContent['materials'] = $this->Ims_material_model->find(['consultant_id' => $this->mUser->consultant_id]);

			$plan_id = $this->input->get('plan_id');
			if ($plan_id) {
				$plan = $this->Ims_plan_product_model->one(['id' => $plan_id]);

				if ($plan) {
					$manuorder = new stdClass();
					$manuorder->id = -1;
					$manuorder->manuorder_num = $manuorder_num;
					$manuorder->lot_code = $lot_code;
					$manuorder->product_id = $plan->product_id;
					$manuorder->variant = $plan->variant;
					$manuorder->quantity = 1;
					$manuorder->scheduled_date = date('Y-m-d H:i:s');
					$manuorder->bill_id = null;
					$manuorder->routing_id = $this->mContent['routings'][0]->id;
					$manuorder->responsible_id = $this->mContent['employees'][0]->employee_id;
					$manuorder->state = 0;
					$manuorder->src_doc = '';
					$manuorder->note = '';
					$manuorder->plan_id = $plan_id;

					$this->mContent['plan_id'] = $plan_id;
				}

				$this->mContent['manuorder'] = $manuorder;
				$this->mContent['material_to_consumes'] = [];
				$this->mContent['consumed_materials'] = [];
				$this->mContent['work_orders'] = [];
			} else {
				$this->mContent['manuorder'] = $this->Ims_manuorder_model->one(['id' => $id]);

				$this->mContent['material_to_consumes'] = $this->Ims_manuorder_consume_material_model->find([
					'manuorder_id' => $id,
					'consumed' => 0
				]);

				$this->db->join("{$this->Ims_material_model->_table} B", 'A.material_id = B.id', 'LEFT');
				$this->mContent['consumed_materials'] = $this->Ims_manuorder_consume_material_model->find([
					'A.manuorder_id' => $id,
					'A.consumed' => 1
				], [], [
					'A.quantity', 'B.id', 'B.name', 'B.upc'
				]);

				$this->db->join("{$this->Ims_routing_operation_model->_table} B", 'A.routing_operation_id = B.id', 'LEFT');
				$this->db->join("{$this->Ims_workcenter_model->_table} C", 'B.workcenter_id = C.id', 'LEFT');
				$this->mContent['work_orders'] = $this->Ims_manuorder_work_order_model->find(['A.manuorder_id' => $id], ['B.sequence' => 'asc'], [
					'A.id work_order_id', 'A.state work_order_state', 'A.src_doc', 'A.finished_at', 'B.*', 'C.name workcenter_name'
				]);

				if ($this->mContent['manuorder'] && $this->mContent['manuorder']->state >= 4) {
					$this->db->join("{$this->Ims_product_model->_table} B", 'A.product_id = B.id', 'LEFT');
					$this->db->join("{$this->Employees_model->_table} C", 'A.responsible_id = C.employee_id', 'LEFT');
					$this->mContent['finished_product'] = $this->Ims_manuorder_model->one(['A.id' => $id], [
						'A.quantity', 'B.name product_name', 'C.employee_name responsible_name'
					]);
					$cnt = count($this->mContent['work_orders']);
					$this->mContent['finished_product']->workorder_count = $cnt;
					$this->mContent['finished_product']->manufactured_date = $this->mContent['work_orders'][$cnt - 1]->finished_at;
				}
			}

			$this->render('manufacture/manuorder/create', $this->mLayout);
		} else {
			if (!empty($_FILES['userfile']['name'])) {
				$config = [];
				$config['upload_path'] = './uploads/src_doc/';
				if (!file_exists($config['upload_path']))
					mkdir($config['upload_path']);

				$ext = strtolower(substr(strrchr($_FILES['userfile']['name'], '.'), 1));

				$config['file_name'] = substr(sha1(rand(1, 100)), 0, 20) . ".{$ext}";
				$config['allowed_types'] = 'pdf';
				$config['max_size'] = '2048000';

				$this->upload->initialize($config);

				if ($this->upload->do_upload())
					$param['src_doc'] = $config['file_name'];
				else
					show_error($this->upload->display_errors());
			}

			$arr = explode('@', $param['product_id']);
			$param['product_id'] = $arr[0];
			$param['variant'] = isset($arr[1]) ? $arr[1] : null;

			$materials = $this->input->post('material');

			if ($id == -1) {
				$plan_id = $this->input->post('plan_id');

				$param['consultant_id'] = $this->mUser->consultant_id;
				$param['employee_id'] = $this->mUser->employee_id;
				$param['plan_id'] = $plan_id;
				$param['create_at'] = date('Y-m-d H:i:s');
				$inserted_id = $this->Ims_manuorder_model->insert($param);

				foreach ($materials as $material) :
					$material['manuorder_id'] = $inserted_id;
					$this->Ims_manuorder_consume_material_model->insert($material);
				endforeach;

				$msg = 'Successfully created.';

				if ($plan_id) {
					$plan = $this->Ims_plan_product_model->one(['id' => $plan_id]);

					if ($plan->frequency == 'Onetime')
						$this->Ims_plan_product_model->delete(['id' => $plan_id]);
					else {
						$frequencies = ['Yearly' => 365, 'Monthly' => 30, 'Weekly' => 7, 'Daily' => 1];
						$interval = new DateInterval("P{$frequencies[$plan->frequency]}D");

						$order_date = new DateTime($plan->order_date);
						$order_date->add($interval);

						$this->Ims_plan_product_model->update(['id' => $plan_id], [
							'active' => 0,
							'order_date' => $order_date->format('Y-m-d'),
							'created_at' => date('Y-m-d H:i:s')
						]);
					}
				}
			} else {
				$param['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_manuorder_model->update(['id' => $id], $param);
				$this->Ims_manuorder_consume_material_model->delete(['manuorder_id' => $id, 'consumed' => 0]);

				foreach ($materials as $material) :
					$material['manuorder_id'] = $id;
					$this->Ims_manuorder_consume_material_model->insert($material);
				endforeach;

				$msg = 'Successfully updated.';
			}

			$this->session->set_flashdata('flash', [
				'success' => true,
				'msg' => $msg
			]);

			$this->redirect('manufacture/manuorder');
		}
	}

	function delete($id) {
		$this->Ims_manuorder_model->delete(['id' => $id]);
		$consume_materials = $this->Ims_manuorder_consume_material_model->find(['manuorder_id' => $id]);
		foreach ($consume_materials as $item) :
			$this->db->join("{$this->Ims_warehouse_model->_table} B", 'A.warehouse_id = B.id', 'LEFT');
			$material = $this->Ims_warehouse_material_model->one([
				'A.material_id' => $item->material_id
				, 'B.consultant_id' => $this->mUser->consultant_id
			], ['A.id', 'A.quantity']);
			$this->Ims_warehouse_material_model->update(['id' => $material->id], ['quantity' => intval($item->quantity) + intval($material->quantity)]);
		endforeach;
		$this->Ims_manuorder_consume_material_model->delete(['manuorder_id' => $id]);
		$this->success();
	}

	function confirm($id) {
		$this->Ims_manuorder_model->update(['id' => $id], ['state' => 1]);
		$this->session->set_flashdata('flash', [
			'success' => true,
			'msg' => 'Successfully confirmed.'
		]);

		$this->redirect("manufacture/manuorder/create/{$id}");
	}

	function check_availability($id) {
		$consume_materials = $this->Ims_manuorder_consume_material_model->find(['manuorder_id' => $id]);

		$ids = []; $codes = [];

		$check = 1;
		foreach ($consume_materials as $item) :
			$this->db->join("{$this->Ims_warehouse_model->_table} B", 'A.warehouse_id = B.id', 'LEFT');
			$this->db->join("{$this->Ims_material_model->_table} C", 'A.material_id = C.id', 'LEFT');
			$material = $this->Ims_warehouse_material_model->one([
				'A.material_id' => $item->material_id
				, 'B.consultant_id' => $this->mUser->consultant_id
			], [
				'A.id', 'A.quantity', 'A.material_id', 'A.trace_code', 'C.name'
			]);

			if (!$material || ($item->quantity > $material->quantity)) {
				if (!$material)
					$material = $this->Ims_material_model->one(['id' => $item->material_id]);

				$check = 0;
				$this->error("{$material->name} is not enough.\nPlease purchase {$material->name}.");
				break;
			} else {
				$ids[$material->id] = intval($material->quantity) - intval($item->quantity);
				$codes[$material->material_id] = $material->trace_code;
			}
		endforeach;

		if ($check == 1) {
			foreach ($ids as $key => $value) :
				// if ($value == 0)
					// $this->Ims_warehouse_material_model->delete(['id' => $key]);
				// else
					$this->Ims_warehouse_material_model->update(['id' => $key], ['quantity' => $value]);
			endforeach;

			foreach ($codes as $key => $value) :
				$this->Ims_manuorder_consume_material_model->update(['manuorder_id' => $id, 'material_id' => $key], ['trace_code' => $value]);
			endforeach;
			
			$this->Ims_manuorder_model->update(['id' => $id], ['state' => 2]);
			$this->Ims_manuorder_consume_material_model->update(['manuorder_id' => $id], ['consumed' => 1]);

			$this->session->set_flashdata('flash', [
				'success' => true,
				'msg' => 'Successfully checked availability.'
			]);
			$this->success();
		}
	}

	function produce($id) {
		$manuorder = $this->Ims_manuorder_model->one(['id' => $id]);
		$routing_operations = $this->Ims_routing_operation_model->find(['routing_id' => $manuorder->routing_id]);
		foreach ($routing_operations as $item) :
			$this->Ims_manuorder_work_order_model->insert([
				'manuorder_id' => $id
				, 'routing_operation_id' => $item->id
				, 'created_at' => date('Y-m-d H:i:s')
			]);
		endforeach;
		$this->Ims_manuorder_model->update(['id' => $id], ['state' => 3]);

		$this->session->set_flashdata('flash', [
			'success' => true,
			'msg' => 'Successfully production started.'
		]);
		$this->success();
	}

	function transfer($manuorder_id) {
		$param = $this->input->post('transfer');

		$param['stocked_date'] = date('Y-m-d');

		$item = $this->Ims_warehouse_product_model->one([
			'warehouse_id' => $param['warehouse_id'],
			'product_id' => $param['product_id'],
			'expired_date' => $param['expired_date'],
			'variant' => $param['variant'],
			'lot_code' => $param['lot_code']
		]);

		if ( !$item )
			$this->Ims_warehouse_product_model->insert($param);
		else
			$this->Ims_warehouse_product_model->update(['id' => $item->id], [
				'quantity' => intval($item->quantity) + intval($param['quantity']),
				'stocked_date' => $param['stocked_date']
			]);

		$this->Ims_manuorder_model->update(['id' => $manuorder_id], [
			'state' => 5,
			'warehouse_id' => $param['warehouse_id'],
			'transfer_at' => date('Y-m-d H:i:s')
		]);

		$this->session->set_flashdata('flash', [
			'success' => true,
			'msg' => 'Successfully production transfered.'
		]);

		$this->redirect('manufacture/manuorder');
	}

	function waste($manuorder_id) {
		$param = $this->input->post('waste');

		$item = $this->Ims_manuorder_consume_material_model->one(['manuorder_id' => $manuorder_id, 'material_id' => $param['good_id'], 'consumed' => 1]);

		if (intval($item->quantity) - intval($param['quantity']) == 0)
			$this->Ims_manuorder_consume_material_model->delete(['id' => $item->id]);
		else
			$this->Ims_manuorder_consume_material_model->update(['id' => $item->id], ['quantity' => intval($item->quantity) - intval($param['quantity'])]);

		$data = [
			'consultant_id' => $this->mUser->consultant_id,
			'employee_id' => $this->mUser->employee_id,
			'good_id' => $param['good_id'],
			'waste_category_id' => $param['waste_category_id'],
			'quantity' => $param['quantity'],
			'waste_date' => date('Y-m-d H:i:s'),
			'waste_type' => 'material'
		];

		$this->Ims_waste_model->insert($data);

		$this->session->set_flashdata('flash', [
			'success' => true,
			'msg' => 'Successfully wasted.'
		]);

		$this->success();
	}

	function variants($product_id) {
		$variants = $this->Ims_product_attr_model->find(['product_id' => $product_id], ['id' => 'asc']);
		$this->json($variants);
	}
}