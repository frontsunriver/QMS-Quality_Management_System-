<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {
	public $mLayout = 'porto/';

	function index() {
		$this->mHeader['title'] = 'Product Wise Stock';
		$this->mHeader['menu_id'] = 'product';
		$this->render('procurement/product/list', $this->mLayout);
	}
}