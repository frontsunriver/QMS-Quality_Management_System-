<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {
	function all() {
		$products = $this->Ims_product_model->find(['consultant_id' => $this->mUser->consultant_id], ['name' => 'asc']);
		$this->json($products);
	}
}