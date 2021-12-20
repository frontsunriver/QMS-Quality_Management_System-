<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/fpdf/fpdf.php';
require_once dirname(__FILE__) . '/FPDI/fpdi.php';

class PDF_Rotate extends FPDI {

    var $angle = 0;

    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle*=M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    function _endpage() {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

}

$fullPathToFile = "";
$fullPathToImage = "";
$header_text = "";
$header_align = "";
$footer_text = "";
$footer_align = "";

class WatermarkPDF extends PDF_Rotate {

    var $_tplIdx;

    function Header() {
        global $fullPathToFile;
        global $fullPathToImage;
        global $header_text;
        global $header_align;

        if ($header_align != "H") {
            // Go to 1.5 cm from bottom
            $this->SetY(10);
            // Print centered page number
            $this->Cell(0,10,$header_text,0,0,$header_align);
        }  
        
        if (file_exists($fullPathToImage)) {
            //Put the watermark
            $this->SetAlpha(0.5);
            $this->Image($fullPathToImage, 55, 80, 100, 100, '');
            $this->SetAlpha(1);
        }        
        
        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            $this->numPages = $this->setSourceFile($fullPathToFile);
            $this->_tplIdx = $this->importPage(1);
        }
        $this->useTemplate($this->_tplIdx, 0, 0, 200);  
    }

    // Page footer
    public function Footer() {
        global $footer_text;
        global $footer_align;
        if ($footer_align != "H") {
            // Go to 1.5 cm from bottom
            $this->SetY(-15);
            // Print centered page number
            $this->Cell(0,10,$footer_text,0,0,$footer_align);
        }        
    }

}
?>