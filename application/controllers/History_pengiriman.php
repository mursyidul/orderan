<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class History_pengiriman extends CI_Controller {



    public function __construct(){

		parent::__construct();

        checkSessionUser();

        // $loginstatus = $this->session->userdata('role_name');

        //  if($loginstatus!="SUPERADMIN" && $loginstatus!="HRD" && $loginstatus!="OWNER"){

        //     redirect('my404');

        // }

        // $this->load->library('pdf');

        $this->load->model("Model_master");
        $this->load->model("Model_setting");

    }

    public function index() {
        $data["history"] = $this->Model_setting->get_history_pengiriman();
    	$this->template->load("template", "history/data-history-pengiriman", $data);
    }
}