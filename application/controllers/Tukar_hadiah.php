<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Tukar_hadiah extends CI_Controller {



    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");
        $this->load->model("Model_point");

    }

    public function index() {
        $data['point'] = $this->Model_point->get_point_username($this->session->userdata('username'));
        $data['tukar'] = $this->Model_point->get_tukar_hadiah();
    	$this->template->load("template", "tukar hadiah/data-tukar_hadiah", $data);

    }

    public function approve_hadiah(){
        $username       = $this->input->post("username");
        $tukar_point    = $this->input->post("tukar_point");
        $barang_point   = $this->input->post("barang_point");
        $keterangan     = $this->input->post("keterangan");

        $data = array(
            "username"      => $username,
            "tukar_point"   => $tukar_point,
            "barang_point"  => $barang_point,
            "keterangan"    => $keterangan
        );

        $action = $this->Model_master->tambahMaster("tbl_hadiah", $data);
        if ($action) {
            echo json_encode(array("status" => "success", "message" => "Berhasil menukarkan hadiah", "data" => $data));
            // $setting      = $this->db->get_where('tbl_setting', ['id_setting' => 1])->row();
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menyimpan hadiah.!!"));
        }
    }

}