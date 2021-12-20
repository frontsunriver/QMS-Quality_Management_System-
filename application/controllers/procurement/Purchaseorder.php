<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchaseorder extends MY_Controller {
	public $mLayout = 'porto/';

	public $prefix_num = 'PO/';
	public $num_length = 6;

	function index() {
		$this->mHeader['title'] = 'Purchase Order';
		$this->mHeader['menu_id'] = 'purchaseorder';

		$this->render('procurement/purchaseorder/list', $this->mLayout);
	}

	function get($id) {
		$this->db->join("{$this->Ims_supplier_model->_table} B", 'A.supplier_id = B.id', 'LEFT');
		$material = $this->Ims_material_model->one(['A.id' => $id], [
			'A.*', 'B.name supplier_name'
		]);

		$this->json($material);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id
		];

		$data['iTotalRecords'] = $this->Ims_purchase_order_model->count($filter);

		$filter['A.purchase_num LIKE'] = "%{$param['sSearch']}%";

		$data['iTotalDisplayRecords'] = $this->Ims_purchase_order_model->count($filter);

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			if ($param["mDataProp_{$sortCol}"] == 'warehouse_name')
				$orders["B.name"] = $param["sSortDir_{$i}"];
			else
				$orders["A.{$param["mDataProp_{$sortCol}"]}"] = $param["sSortDir_{$i}"];
		}

		$this->db->join("{$this->Ims_warehouse_model->_table} B", 'A.warehouse_id = B.id', 'LEFT');

		foreach ($orders as $key => $val)
			$this->db->order_by($key, $val);

		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$data['purchase_order'] = $this->Ims_purchase_order_model->find($filter, [], [
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

			$this->mContent['warehouses'] = $this->Ims_warehouse_model->find([ 'A.consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['materials'] = $this->Ims_material_model->find([ 'A.consultant_id' => $this->mUser->consultant_id]);
			$this->mContent['suppliers'] = $this->Ims_supplier_model->find(['A.consultant_id' => $this->mUser->consultant_id]);

			$this->mContent['order'] = $this->Ims_purchase_order_model->one(['A.id' => $id]);

			if (!$this->mContent['order']) {
				$purchase_num = $this->Ims_purchase_order_model->select_max('purchase_num');
				$purchase_num = intval(str_replace($this->prefix_num, '', $purchase_num)) + 1;
				$purchase_num = $this->prefix_num . str_repeat('0', $this->num_length - strlen($purchase_num)) . $purchase_num;

				$this->mContent['purchase_num'] = $purchase_num;
			} else {
				$this->mContent['purchase_materials'] = $this->Ims_purchase_order_material_model->find(["A.purchase_order_id" => $id], [], ["A.*"]);
			}

			$this->render('procurement/purchaseorder/create', $this->mLayout);
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

			$this->redirect('procurement/purchaseorder/create/' . ($id == -1 ? $order_id : $id));
		}
	}

	function pdf($id) {
		$this->db->join("{$this->Ims_warehouse_model->_table} B", 'A.warehouse_id = B.id', 'LEFT');
		$data['order'] = $this->Ims_purchase_order_model->one(['A.id' => $id], ['A.*', 'B.name warehouse_name']);

		if ($data['order']) {
			$this->db->join("{$this->Ims_material_model->_table} B", 'A.material_id = B.id', 'LEFT');
			$this->db->join("{$this->Ims_supplier_model->_table} C", 'A.supplier_id = C.id', 'LEFT');
			$data['purchase_materials'] = $this->Ims_purchase_order_material_model->find(['A.purchase_order_id' => $id], [], [
				'A.*', 'B.name material_name', 'C.name supplier_name'
			]);
		}

		$content = $this->load->view('procurement/purchaseorder/pdf', $data, true);

		$this->load->library('html2pdf');
		$this->html2pdf->folder(UPLOAD_URL . 'ims/procurement/purchaseorder');
		$this->html2pdf->filename("{$data['order']->purchase_num}.pdf");
		$this->html2pdf->paper('a4', 'landscape');
		$this->html2pdf->html($content);
		if($this->html2pdf->create('download'))
			echo 'PDF saved';
	}

	function confirm($id) {
		$reference = $this->Ims_purchase_order_model->select_max('reference');
		$reference = intval(str_replace('WH/IN/', '', $reference)) + 1;
		$reference = 'WH/IN/' . str_repeat('0', 6 - strlen($reference)) . $reference;

		$this->Ims_purchase_order_model->update(['id' => $id], ['state' => 1, 'reference' => $reference]);
		$this->session->set_flashdata('flash', [
			'success' => true,
			'msg' => 'Successfully confirmed.'
		]);
		$this->redirect('procurement/purchaseorder');
	}

	function delete($id) {
		$this->Ims_purchase_order_model->delete(['id' => $id]);
		$this->Ims_purchase_order_material_model->delete(['purchase_order_id' => $id]);
		$this->success();
	}
}