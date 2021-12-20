<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends MY_Controller {
	function all() {
		$materials = $this->Ims_material_model->find(['consultant_id' => $this->mUser->consultant_id], ['name' => 'asc']);
		$this->json($materials);
	}
}