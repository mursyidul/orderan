<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tampilan extends CI_Controller {

    public function __construct(){
		parent::__construct();
		checkSessionUser();
        $this->load->model("Model_master");
        $this->load->model("Model_setting");
        $this->load->model("Model_dashboard");
    }

    public function index(){
        $this->load->view("tampilan/data_tampilan");
    }
    
}
?>