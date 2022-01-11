<?php
class pdf {
    function __construct() {
    	include_once APPPATH . '/third_party/TCPDF-6.3.5/tcpdf.php';
        // include_once APPPATH . '/third_party/fpdf/fpdf.php';
        // include_once APPPATH . '/third_party/fpdf/html2pdf.php';
    }
}
?>