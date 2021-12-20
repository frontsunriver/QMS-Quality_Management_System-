<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/BaseController.php';
class MY_Controller extends BaseController//CI_Controller
{
  protected $mHeader = array();
  protected $mContent = array();
  protected $mFooter = array();
  protected $mUser;

  protected $css = [];
  protected $js = [];

  function __construct() {
    parent::__construct();

    $user = $this->session->userdata('user');
    $this->mHeader['isLogged'] = !$user ? false : true;

    $class = $this->uri->segment(1);
    $func = $this->uri->segment(2);
    $user = $this->session->userdata('user');

    if (!$user) {
      if ($class != 'welcome' && $class != 'auth') {
        $this->redirect('welcome');
        die;
      }
    } else {
      if ($class == 'auth' && $func == 'login'){
        $this->redirect('welcome');
        die;
      } else if (($class == 'manufacture' && $user->type != 'manufacturing' && $user->type != 'monitor')
          || ($class == 'warehouse' && $user->type != 'warehousing')
          || ($class == 'procurement' && $user->type != 'procurement')) {
        $this->redirect('welcome/dashboard');
        die;
      }

      $this->mUser = $user;
    }
  }

  protected function render($view, $admin = '') {
    $flash = $this->session->flashdata('flash');
    if ($flash)
      $this->mHeader['flash'] = $flash;

    $this->load->view("layout/{$admin}header", $this->mHeader);
    $this->load->view($view, $this->mContent);
    $this->load->view("layout/{$admin}footer", $this->mFooter);
  }

  protected function getAssets($type, $assets = []) {
    $result = $this->config->item($type, 'assets');
    if (empty($assets))
      return [];

    $list = [];
    foreach ($assets as $item)
      $list[] = $result[$item];

    return $list;
  }

  protected function redirect($url) {
    redirect(base_url($url));
  }

  protected function json($data) {
    $json = json_encode($data);
    $this->output->set_content_type('application/json')->set_output($json);
  }

  protected function success($result = NULL) {
    $data['success'] = true;
    if($result)
      $data['result'] = $result;
    $this->json($data);
  }

  protected function error($result = NULL) {
    $data['success'] = false;
    if($result)
      $data['result'] = $result;
    $this->json($data);
  }

  protected function getVariants($mList, $iPos, $jPos, $mLabel) {
    if ($mLabel == '')
      $mLabel = $mList[$iPos][$jPos];
    else
      $mLabel .= '-' . $mList[$iPos][$jPos];

    if (count($mList) == $iPos + 1)
      $this->mVariants[] = $mLabel;

    if ($iPos + 1 < count($mList)) {
      for ($i = 0; $i < count($mList[$iPos + 1]); $i ++)
        $this->getVariants($mList, $iPos + 1, $i, $mLabel);
    }
  }
}
