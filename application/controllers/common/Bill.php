<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bill extends MY_Controller {
	function get($id) {
		$bill = $this->Ims_bill_model->one(['id' => $id]);

		$this->db->join("{$this->Ims_material_model->_table} B", 'A.material_id = B.id', 'right');
		$materials = $this->Ims_bill_material_model->find(['A.bill_id' => $id], [], [
			'A.material_id', 'A.apply_on_variants qty', 'B.name'
		]);
		$bill->materials = $materials;

		$this->json($bill);
	}
}