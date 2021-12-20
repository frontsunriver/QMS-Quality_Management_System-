<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

$header_align = '';

class Pdf extends TCPDF
{
	function __construct()
	{
		parent::__construct();
	}
}