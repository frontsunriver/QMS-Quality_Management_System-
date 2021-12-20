<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends MY_Controller {
	public $mLayout = 'porto/';
	
	function index() {
		$this->mHeader['title'] = 'Transfer';
		$this->mHeader['menu_id'] = 'transfer';
		$this->render('warehouse/transfer/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id,
			'A.purchase_num LIKE' => "%{$param['sSearch']}%",
			'A.state >' => 0
		];

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

		foreach ($orders as $key => $val)
			$this->db->order_by($key, $val);

		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);
		$data['transfer'] = $this->Ims_purchase_order_model->find($filter, [], [
			'A.*', 'B.name warehouse_name'
		]);
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function view($id) {
		$this->mHeader['title'] = 'View Transfer';
		$this->mHeader['menu_id'] = 'transfer';

		$this->db->join("{$this->Ims_warehouse_model->_table} B", 'A.warehouse_id = B.id', 'LEFT');
		$this->mContent['transfer'] = $this->Ims_purchase_order_model->one(['A.id' => $id], [
			'A.*', 'B.name warehouse_name'
		]);

		$this->db->join("{$this->Ims_material_model->_table} B", 'A.material_id = B.id', 'LEFT');
		$this->mContent['transfer_materials'] = $this->Ims_purchase_order_material_model->find(['A.purchase_order_id' => $id], [], [
			'A.*', 'B.name material_name'
		]);

		$this->render('warehouse/transfer/view', $this->mLayout);
	}

	function pdf($id) {
		$this->db->join("{$this->Ims_warehouse_model->_table} B", 'A.warehouse_id = B.id', 'LEFT');
		$data['transfer'] = $this->Ims_purchase_order_model->one(['A.id' => $id], [
			'A.*', 'B.name warehouse_name'
		]);

		$this->db->join("{$this->Ims_material_model->_table} B", 'A.material_id = B.id', 'LEFT');
		$data['transfer_materials'] = $this->Ims_purchase_order_material_model->find(['A.purchase_order_id' => $id], [], [
			'A.*', 'B.name material_name'
		]);

		$content = $this->load->view('warehouse/transfer/pdf', $data, true);

		$this->load->library('html2pdf');
		$this->html2pdf->folder(UPLOAD_URL . 'ims/warehouse/transfer');
		$this->html2pdf->filename("transfer_{$data['transfer']->purchase_num}.pdf");
		$this->html2pdf->paper('a4', 'landscape');
		$this->html2pdf->html($content);
		if($this->html2pdf->create('download'))
			echo 'PDF saved';
	}

	function done($id) {
		$expireds = $this->input->post('expireds');
		
		$this->db->join("{$this->Ims_purchase_order_model->_table} B", 'A.purchase_order_id = B.id', 'LEFT');
		$materials = $this->Ims_purchase_order_material_model->find(['A.purchase_order_id' => $id], [], [
			'A.*', 'B.warehouse_id'
		]);

		foreach ($materials as $material) :
			$expired_date = $expireds[$material->material_id];
			$qty = $this->Ims_warehouse_material_model->count(['warehouse_id' => $material->warehouse_id, 'material_id' => $material->material_id, 'expired_date' => $expired_date]);
			if ($qty == 0)
				$this->Ims_warehouse_material_model->insert([
					'warehouse_id' => $material->warehouse_id,
					'material_id' => $material->material_id,
					'quantity' => $material->quantity,
					'trace_code' => $material->trace_code,
					'stocked_date' => date('Y-m-d'),
					'expired_date' => $expired_date
				]);
			else
				$this->Ims_warehouse_material_model->update(['warehouse_id' => $material->warehouse_id, 'material_id' => $material->material_id], [
					'quantity' => intval($material->quantity) + intval($qty),
					'trace_code' => $material->trace_code,
					'stocked_date' => date('Y-m-d')
				]);
		endforeach;

		$this->Ims_purchase_order_model->update(['id' => $id], ['state' => 2]);

		$this->session->set_flashdata('flash', [
			'success' => true,
			'msg' => 'Successfully transfered.'
		]);

		$this->success('warehouse/transfer');
	}
}