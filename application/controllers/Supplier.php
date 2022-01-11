<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Supplier extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");
        $this->load->model("Model_setting");

    }

    public function index() {
        // $data['bahan']      = $this->Model_master->get_bahan();
        $data['supplier']      = $this->Model_master->getMasterOneTable("*", "tbl_supplier", "id_supplier", "desc", "");
    	$this->template->load("template", "supplier/data-supplier", $data);

    }

    public function tambah(){
        $nama_supplier      = $this->input->post("nama_supplier");
        $alamat_supplier    = $this->input->post("alamat_supplier");
        $no_hp_supplier     = $this->input->post("no_hp_supplier");
        $created_date       = date("Y-m-d H:i:s");

    	$data = array(
            "nama_supplier"     => $nama_supplier,
            "alamat_supplier"   => $alamat_supplier,
            "no_hp_supplier"    => $no_hp_supplier,
            "created_date"      => $created_date 
    	);

        $nama_sama = $this->Model_master->check_existing_name_master("id_supplier", "tbl_supplier", "nama_supplier", $nama_supplier);
        if ($nama_sama) {
            $this->session->set_flashdata("error", "Nama supplier sudah ada, mohon gunakan yang lain");
        } else {
            $action = $this->Model_master->tambahMaster("tbl_supplier", $data);
            if ($action) {
                $this->session->set_flashdata("success", "Berhasil menambahkan supplier");
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan supplier");
            }
        }
        redirect('supplier');

    }

    public function edit(){
        $id_supplier       = $this->input->post("id_supplier");
        $nama_supplier    = $this->input->post("nama_supplier");
        $alamat_supplier   = $this->input->post("alamat_supplier");
        $no_hp_supplier    = $this->input->post("no_hp_supplier");

        $data_supplier     = array(
            "nama_supplier"    => $nama_supplier,
            "id_supplier !="   => $id_supplier
        ); 
        $bahan_exist = $this->Model_master->check_data_exist("tbl_supplier", $data_supplier);
        $data = array(
            "nama_supplier"   => $nama_supplier,
            "alamat_supplier" => $alamat_supplier, 
            "no_hp_supplier"  => $no_hp_supplier  
        );
        if ($bahan_exist) {
            $this->session->set_flashdata("error", "Nama supplier sudah ada, mohon gunakan yang lain");
        } else {
            $action = $this->Model_master->editMaster(array('id_supplier' => $id_supplier), "tbl_supplier", $data);
            if ($action) {
               $this->session->set_flashdata("success", "Berhasil Mengubah supplier");
            }  else {
                $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah supplier");
            }
        }

        redirect("supplier");
    }

    public function delete_supplier(){
        $id_supplier = $this->input->post("id_supplier");
        $delete         = $this->Model_master->deleteMaster($id_supplier, "id_supplier", "tbl_supplier");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_supplier, "message"  => "Berhasil menghapus supplier"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus supplier"));
         }
    }
}