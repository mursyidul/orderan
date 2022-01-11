<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Point extends CI_Controller {



    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");
        $this->load->model("Model_point");

    }

    public function index() {
        $data['point'] = $this->Model_point->get_point();
    	$this->template->load("template", "point/data-point", $data);

    }

    public function detail($username){
    	$data['detail_point'] = $this->Model_point->get_detail_point($username);
    	$data['point']		  = $this->db->get_where("tbl_point", ['username' => $username])->row();
    	$this->template->load("template", "point/data-detail-point", $data);
    }

}