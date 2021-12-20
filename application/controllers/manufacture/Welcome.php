<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {
	function index() {
		// $this->mHeader['title'] = 'Dashboard';
		// $this->mHeader['menu_id'] = 'dashboard';
		// $this->render('manufacture/dashboard', 'porto/');
		//if ($this->mUser->role == 'monitor')
		if ($this->mUser->type == 'monitor')
			$this->redirect('manufacture/qualitycheck');
		//else if ($this->mUser->role == 'manufacturing')
		else if ($this->mUser->type == 'manufacturing')
			$this->redirect('manufacture/manuorder');
	}
}