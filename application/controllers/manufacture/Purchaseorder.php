<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchaseorder extends MY_Controller {
	public $mLayout = 'porto/';

	function index() {
		$this->mHeader['title'] = 'Purchase Order';
		$this->mHeader['menu_id'] = 'purchaseorder';
		$this->render('manufacture/purchaseorder/list', $this->mLayout);
	}

	function get($id) {
		$this->db->join("{$this->Ims_supplier_model->_table} B", "A.supplier_id = B.id", 'left');
		$material = $this->Ims_material_model->one(["A.id" => $id], [
			"A.*", "B.name supplier_name"
		]);

		$this->json($material);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id,
			'A.purchase_num LIKE' => "%{$param['sSearch']}%"
		];

		$this->db->join("{$this->Employees_model->_table} C", 'A.employee_id = C.employee_id', 'LEFT');
		$data['iTotalRecords'] = $this->Ims_purchase_order_model->count($filter);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'];

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			if ($param["mDataProp_{$sortCol}"] == 'warehouse_name')
				$orders["B.name"] = $param["sSortDir_{$i}"];
			else
				$orders["A.{$param["mDataProp_{$sortCol}"]}"] = $param["sSortDir_{$i}"];
		}

		$this->db->join("{$this->Ims_warehouse_model->_table} B", 'A.warehouse_id = B.id', 'LEFT');
		$this->db->join("{$this->Employees_model->_table} C", 'A.employee_id = C.employee_id', 'LEFT');
		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$data['purchase_order'] = $this->Ims_purchase_order_model->find($filter, $orders, [
			'A.*', 'B.name warehouse_name'
		]);
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function create($id = -1) {
		$order = $this->input->post('order');

		if (!$order) {
			$this->mHeader['title'] = 'New Purchase Order';
			$this->mHeader['menu_id'] = 'purchaseorder';

			$this->mContent['warehouses'] = $this->Ims_warehouse_model->find(['A.consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['materials'] = $this->Ims_material_model->find(['A.consultant_id' => $this->mUser->consultant_id]);

			$purchase_num = $this->Ims_purchase_order_model->select_max('purchase_num');

			if ($purchase_num != '0')
				$purchase_num = 'PO' . (intval(explode('PO', $purchase_num)[1]) + 1);
			else
				$purchase_num = 'PO';

			$plan_id = $this->input->get('plan_id');
			if ($plan_id) {
				$plan = $this->Ims_plan_material_model->one(['id' => $plan_id]);
				if ($plan) {
					$this->mContent['plan_id'] = $plan_id;

					$order = new stdClass();
					$order->id = -1;
					$order->warehouse_id = $plan->warehouse_id;
					$order->purchase_num = $purchase_num;
					$order->order_date = date('Y-m-d');
					$order->purchase_representative = '';
					$order->state = 0;
					$order->description = '';
					$order->untaxes = 0;
					$order->taxes = 0;
					$order->total = 0;

					$this->mContent['order'] = $order;

					$this->db->join("{$this->Ims_supplier_model->_table} B", "A.supplier_id = B.id", 'LEFT');
					$material = $this->Ims_material_model->one(['A.id' => $plan->material_id], [
						'A.id material_id', 'B.name supplier_name'
					]);
					$material->scheduled_date = date('Y-m-d H:i:s');
					$material->quantity = $plan->demand_quantity;
					$material->unit_price = 0;
					$material->tax = 0;

					$this->mContent['purchase_materials'] = [];
					$this->mContent['purchase_materials'][] = $material;
				}
			} else {
				$this->mContent['order'] = $this->Ims_purchase_order_model->one(['A.id' => $id]);

				if (!$this->mContent['order'])
					$this->mContent['purchase_num'] = $purchase_num;
				else {
					$this->db->join("{$this->Ims_material_model->_table} B", "A.material_id = B.id", 'LEFT');
					$this->db->join("{$this->Ims_supplier_model->_table} C", "B.supplier_id = C.id", 'LEFT');
					$this->mContent['purchase_materials'] = $this->Ims_purchase_order_material_model->find([
						"A.purchase_order_id" => $id
					], [], [
						"A.*", "C.name supplier_name"
					]);
				}
			}

			$this->render('manufacture/purchaseorder/create', $this->mLayout);
		} else {
			$materials = $this->input->post('material');

			if ($id == -1) {
				$order['consultant_id'] = $this->mUser->consultant_id;
				$order['employee_id'] = $this->mUser->employee_id;
				$order['create_at'] = date('Y-m-d H:i:s');
				$order_id = $this->Ims_purchase_order_model->insert($order);

				foreach ($materials as $material) {
					$material['purchase_order_id'] = $order_id;
					$this->Ims_purchase_order_material_model->insert($material);
				}

				$msg = 'Successfully created.';

				$plan_id = $this->input->post('plan_id');
				if ($plan_id) {
					$plan = $this->Ims_plan_material_model->one(['id' => $plan_id]);
					if ($plan->frequency == 'Onetime')
						$this->Ims_plan_material_model->delete(['id' => $plan_id]);
					else {
						$frequencies = ['Yearly' => 365, 'Monthly' => 30, 'Weekly' => 7, 'Daily' => 1];
						$interval = new DateInterval("P{$frequencies[$plan->frequency]}D");

						$order_date = new DateTime($plan->order_date);
						$order_date->add($interval);

						$this->Ims_plan_material_model->update(['id' => $plan_id], [
							'order_date' => $order_date->format('Y-m-d'),
							'created_at' => date('Y-m-d H:i:s')
						]);
					}
				}
			} else {
				$order['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_purchase_order_model->update(['id' => $id], $order);
				$this->Ims_purchase_order_material_model->delete(['purchase_order_id' => $id]);

				foreach ($materials as $material) {
					$material['purchase_order_id'] = $id;
					$this->Ims_purchase_order_material_model->insert($material);
				}

				$msg = 'Successfully saved.';
			}

			$this->session->set_flashdata('flash', [
				'success' => true,
				'msg' => $msg
			]);

			$this->redirect('manufacture/purchaseorder');
		}
	}

	function pdf($id) {
		$this->db->join("{$this->Ims_warehouse_model->_table} B", 'A.warehouse_id = B.id', 'LEFT');
		$data['order'] = $this->Ims_purchase_order_model->one(['A.id' => $id], ['A.*', 'B.name warehouse_name']);

		if ($data['order']) {
			$this->db->join("{$this->Ims_material_model->_table} B", 'A.material_id = B.id', 'LEFT');
			$this->db->join("{$this->Ims_supplier_model->_table} C", 'B.supplier_id = C.id', 'LEFT');
			$data['purchase_materials'] = $this->Ims_purchase_order_material_model->find(['A.purchase_order_id' => $id], [], [
				'A.*', 'B.name material_name', 'C.name supplier_name'
			]);
		}

		$content = $this->load->view('manufacture/purchaseorder/pdf', $data, true);

		$this->load->library('html2pdf');
		$this->html2pdf->folder(UPLOAD_URL . 'ims/manufacture/purchaseorder');
		$this->html2pdf->filename("{$data['order']->purchase_num}.pdf");
		$this->html2pdf->paper('a4', 'landscape');
		$this->html2pdf->html($content);
		if($this->html2pdf->create('download'))
			echo 'PDF saved';
	}

	function confirm($id) {
		$this->Ims_purchase_order_model->update(['id' => $id], ['state' => 1]);
		$this->session->set_flashdata('flash', [
			'success' => true,
			'msg' => 'Successfully confirmed.'
		]);
		$this->redirect('manufacture/purchaseorder');
	}

	function delete($id) {
		$this->Ims_purchase_order_model->delete(['id' => $id]);
		$this->Ims_purchase_order_material_model->delete(['purchase_order_id' => $id]);
		$this->success();
	}
}