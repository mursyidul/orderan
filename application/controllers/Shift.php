<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Shift extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");

    }

    public function index() {
        // $data['bahan']      = $this->Model_master->get_bahan();
        $data['shift']      = $this->Model_master->getMasterOneTable("*", "tbl_shift", "id_shift", "asc", "");
    	$this->template->load("template", "shift/data-shift", $data);

    }

    public function tambah(){
        $nama_shift   = $this->input->post("nama_shift");
        $jam_masuk    = $this->input->post("jam_masuk");
        $jam_keluar   = $this->input->post("jam_keluar");
        $created_date = date("Y-m-d H:i:s");

    	$data = array(
            "nama_shift"   => $nama_shift,
            "jam_masuk"    => $jam_masuk,
            "jam_keluar"   => $jam_keluar,
            "created_date" => $created_date 
    	);

        $shift_sama = $this->Model_master->check_existing_name_master("id_shift", "tbl_shift", "nama_shift", $nama_shift);
        if ($shift_sama) {
            $this->session->set_flashdata("error", "Shift sudah ada, mohon gunakan shift yang lain");
        } else {
            $action = $this->Model_master->tambahMaster("tbl_shift", $data);
            if ($action) {
                $this->session->set_flashdata("success", "Berhasil menambahkan shift");
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan shift");
            }
        }
        redirect('shift');

    }

    public function edit(){
        $id_shift       = $this->input->post("id_shift");
        $nama_shift     = $this->input->post("nama_shift");
        $jam_masuk      = $this->input->post("jam_masuk");
        $jam_keluar     = $this->input->post("jam_keluar");

        $data_bahan     = array(
            "nama_shift"    => $nama_shift,
            "id_shift !="   => $id_shift
        ); 
        $bahan_exist = $this->Model_master->check_data_exist("tbl_shift", $data_bahan);
        $data = array(
            "nama_shift"   => $nama_shift,
            "jam_masuk"    => $jam_masuk,
            "jam_keluar"   => $jam_keluar
        );
        if ($bahan_exist) {
            $this->session->set_flashdata("error", "Shift sudah ada, mohon gunakan shift yang lain");
        } else {
            $action = $this->Model_master->editMaster(array('id_shift' => $id_shift), "tbl_shift", $data);
            if ($action) {
               $this->session->set_flashdata("success", "Berhasil Mengubah shift");
            }  else {
                $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah shift");
            }
        }

        redirect("shift");
    }

    public function delete_shift(){
        $id_shift = $this->input->post("id_shift");
        $delete   = $this->Model_master->deleteMaster($id_shift, "id_shift", "tbl_shift");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_shift, "message"  => "Berhasil menghapus shift"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus shift"));
         }
    }
}