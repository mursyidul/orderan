<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Durasi_peruser extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_absensi");

    }

    public function index() {
        if(isset($_GET['startdate']) && ! empty($_GET['startdate']) && isset($_GET['enddate']) && ! empty($_GET['enddate'])){ 
            $startdate =  date('Y-m-d',strtotime($_GET['startdate']));
            $enddate = date('Y-m-d',strtotime($_GET['enddate']));
        }else{
            $startdate = date('Y-m-d',strtotime('-1 month'));
            $enddate = date('Y-m-d');
        }
        $user = $this->Model_absensi->get_user_array();
        $i=0;
        foreach ($user as $k) {
            $id_user = $k['id_user'];
            $durasi  = $this->Model_absensi->get_durasi_peruser($id_user, $startdate, $enddate);
            $user[$i]['durasi'] = $durasi;
        $i++; }
        $data['durasi'] = $user;
    	$this->template->load("template", "absensi/data-durasi_peruser", $data);

    }
}