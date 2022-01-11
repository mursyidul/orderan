<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Opsi_pembayaran extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");

    }

    public function index() {
        $data['opsi_pembayaran']      = $this->Model_master->getMasterOneTable("*", "tbl_opsi_pembayaran", "id_opsi_pembayaran", "asc", "");
    	$this->template->load("template", "opsi pembayaran/data-opsi_pembayaran", $data);

    }

    public function tambah(){
        $jenis_pembayaran   = $this->input->post("jenis_pembayaran");
        $nomor_rekening     = $this->input->post("nomor_rekening");
        $atas_nama          = $this->input->post("atas_nama");
        $created_date       = date("Y-m-d H:i:s");

    	$data = array(
            "jenis_pembayaran"   => $jenis_pembayaran,
            "nomor_rekening"     => $nomor_rekening,
            "atas_nama"          => $atas_nama,
            "created_date"       => $created_date 
    	);

        $shift_sama = $this->Model_master->check_existing_name_master("id_opsi_pembayaran", "tbl_opsi_pembayaran", "jenis_pembayaran", $jenis_pembayaran);
        if ($shift_sama) {
            $this->session->set_flashdata("error", "Opsi pembayaran sudah ada, mohon gunakan yang lain");
        } else {
            $action = $this->Model_master->tambahMaster("tbl_opsi_pembayaran", $data);
            if ($action) {
                $this->session->set_flashdata("success", "Berhasil menambahkan opsi pembayaran");
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan opsi pembayaran");
            }
        }
        redirect('opsi_pembayaran');

    }

    public function edit(){
        $id_opsi_pembayaran   = $this->input->post("id_opsi_pembayaran");
        $jenis_pembayaran     = $this->input->post("jenis_pembayaran");
        $nomor_rekening       = $this->input->post("nomor_rekening");
        $atas_nama            = $this->input->post("atas_nama");

        $data_bahan     = array(
            "jenis_pembayaran"        => $jenis_pembayaran,
            "id_opsi_pembayaran !="   => $id_opsi_pembayaran
        ); 
        $bahan_exist = $this->Model_master->check_data_exist("tbl_opsi_pembayaran", $data_bahan);
        $data = array(
            "jenis_pembayaran"   => $jenis_pembayaran,
            "nomor_rekening"     => $nomor_rekening,
            "atas_nama"          => $atas_nama
        );
        if ($bahan_exist) {
            $this->session->set_flashdata("error", "Opsi pembayaran sudah ada, mohon gunakan yang lain");
        } else {
            $action = $this->Model_master->editMaster(array('id_opsi_pembayaran' => $id_opsi_pembayaran), "tbl_opsi_pembayaran", $data);
            if ($action) {
               $this->session->set_flashdata("success", "Berhasil Mengubah opsi pembayaran");
            }  else {
                $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah opsi pembayaran");
            }
        }

        redirect("opsi_pembayaran");
    }

    public function delete_opsi(){
        $id_opsi_pembayaran = $this->input->post("id_opsi_pembayaran");
        $delete   = $this->Model_master->deleteMaster($id_opsi_pembayaran, "id_opsi_pembayaran", "tbl_opsi_pembayaran");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_opsi_pembayaran, "message"  => "Berhasil menghapus opsi pembayaran"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus opsi pembayaran"));
         }
    }
}