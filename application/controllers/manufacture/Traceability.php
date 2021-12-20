<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Traceability extends MY_Controller {
	public $mLayout = 'porto/';

	function __construct() {
		parent::__construct();

		$this->load->model(['Ims_warehouse_product_model', 'Ims_salesorder_model', 'Ims_salesorder_product_model', 'Ims_shiporder_model']);
	}

	function index() {
		$this->mHeader['title'] = 'Traceability';
		$this->mHeader['menu_id'] = 'report';

		$traces = [];

		$this->db->join("{$this->Ims_shiporder_model->_table} B", 'A.id = B.salesorder_id');
		$this->db->join("{$this->Ims_customer_model->_table} C", 'A.customer_id = C.id');
		$salesorders = $this->Ims_salesorder_model->find(['A.consultant_id' => $this->mUser->consultant_id, 'A.state' => 2], ['A.create_at' => 'asc'], [
			'A.*', 'B.confirm_at', 'C.name customer'
		]);
		foreach ($salesorders as $salesorder) :
			$this->db->join("{$this->Ims_product_model->_table} B", 'A.product_id = B.id');
			$this->db->join("{$this->Ims_warehouse_product_model->_table} C", 'A.lot_code = C.lot_code');
			$this->db->join("{$this->Ims_warehouse_model->_table} D", 'C.warehouse_id = D.id');
			$products = $this->Ims_salesorder_product_model->find(['A.salesorder_id' => $salesorder->id], ['A.product_id' => 'asc'], [
				'A.product_id', 'A.ordered_qty', 'A.variant', 'A.lot_code', 'B.name', 'C.stocked_date', 'D.name warehouse_name'
			]);
			foreach ($products as $product) :
				$manuorder = $this->Ims_manuorder_model->one(['A.lot_code' => $product->lot_code]);
				$this->db->join("{$this->Ims_material_model->_table} B", 'A.material_id = B.id');
				$this->db->join("{$this->Ims_purchase_order_material_model->_table} C", 'A.trace_code = C.trace_code');
				$this->db->join("{$this->Ims_purchase_order_model->_table} D", 'C.purchase_order_id = D.id');
				$this->db->join("{$this->Ims_supplier_model->_table} E", 'B.supplier_id = E.id');
				$this->db->join("{$this->Ims_warehouse_model->_table} G", 'D.warehouse_id = G.id');
				$this->db->join("{$this->Ims_warehouse_material_model->_table} H", 'A.trace_code = H.trace_code');
				$manuorder->materials = $this->Ims_manuorder_consume_material_model->find(['A.manuorder_id' => $manuorder->id], ['A.material_id' => 'asc'], [
					'B.name', 'A.quantity', 'A.trace_code', 'D.reference', 'H.stocked_date', 'G.name warehouse_name', 'E.name supplier_name'
				]);

				$traces[] = [
					'name' => $product->name,
					'variant' => $product->variant,
					'lot_code' => $product->lot_code,
					'create_at' => $product->stocked_date,
					'quantity' => $product->ordered_qty,
					'warehouse' => $product->warehouse_name,
					'manuorder' => $manuorder,
					'salesorder' => $salesorder
				];
			endforeach;
		endforeach;
		
		$this->mContent['products'] = $traces;

		$this->render('manufacture/report/traceability', $this->mLayout);
	}
}