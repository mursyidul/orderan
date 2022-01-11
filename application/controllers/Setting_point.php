<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Setting_point extends CI_Controller {



    public function __construct(){

		parent::__construct();

        checkSessionUser();

        // $loginstatus = $this->session->userdata('role_name');

        //  if($loginstatus!="SUPERADMIN" && $loginstatus!="HRD" && $loginstatus!="OWNER"){

        //     redirect('my404');

        // }

        // $this->load->library('pdf');

        $this->load->model("Model_setting");

    }



    public function index() {

    	$this->template->load("template", "setting/data-setting-point");

    }



    public function get_data_setting($id_setting = null){

        $data = $this->Model_setting->get_setting($id_setting);

        echo json_encode(array("status" => "success", "data" => $data));

    }



    public function add_setting(){

        $harga_setting = $this->input->post("harga_setting");
        $jumlah_setting = $this->input->post("jumlah_setting");

        $data = array(
            "harga_setting"  => $harga_setting,
            "jumlah_setting" => $jumlah_setting
        );

            $query = $this->Model_setting->add_setting($data);
            if($query){
                echo json_encode(array("status" => "success", "message" => "Setting berhasil ditambahkan", "data" => $data));

            } else {
                echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menyimpan setting.!!"));

            }

    }



    public function edit_setting(){
        $id_setting     = $this->input->post("id_setting");
        $harga_setting  = $this->input->post("harga_setting");
        $jumlah_setting = $this->input->post("jumlah_setting");

        $data = array(
            "harga_setting"  => $harga_setting,
            "jumlah_setting" => $jumlah_setting
        );

        $query = $this->Model_setting->edit_setting($data, $id_setting);

        if($query) {
            echo json_encode(array("status" => "success", "message" => "Berhasil mengubah setting point", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menyimpan setting point.!!"));
        }
    }

    public function delete_setting(){
        $id_setting = $this->input->post("id_setting");
        $delete = $this->Model_master->deleteMaster($id_setting, "id_setting","tbl_setting");
        if($delete){
            echo json_encode(array("status" => "success", "data" => $id_setting, "message" => "Setting point berhasil dihapus"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus setting point.!!"));
        }
    }

}