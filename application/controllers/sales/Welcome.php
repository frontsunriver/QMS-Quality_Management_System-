<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {
	function index() {
		$this->redirect('sales/salesorder');
	}
}