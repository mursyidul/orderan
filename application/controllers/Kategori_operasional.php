<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Kategori_operasional extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");

    }

    public function index() {
        // $data['bahan']      = $this->Model_master->get_bahan();
        $data['operasional']      = $this->Model_master->getMasterOneTable("*", "tbl_kategori_operasional", "nama_kategori", "asc", "");
    	$this->template->load("template", "kategori operasional/data-kategori_operasional", $data);

    }

    public function tambah(){
        $nama_kategori  = $this->input->post("nama_kategori");

    	$data = array(
            "nama_kategori"  => $nama_kategori
    	);

        $jenis_sama = $this->Model_master->check_existing_name_master("id_operasional", "tbl_kategori_operasional", "nama_kategori", $nama_kategori);
        if ($jenis_sama) {
            $this->session->set_flashdata("error", "Kategori Operasional sudah ada, mohon gunakan lain");
        } else {
            $action = $this->Model_master->tambahMaster("tbl_kategori_operasional", $data);
            if ($action) {
                $this->session->set_flashdata("success", "Berhasil menambahkan kategori operasional");
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan kategori operasional");
            }
        }
        redirect('kategori_operasional');

    }

    public function edit(){
        $id_operasional       = $this->input->post("id_operasional");
        $nama_kategori    = $this->input->post("nama_kategori");
        
        $data_operasional     = array(
            "nama_kategori"   => $nama_kategori,
            "id_operasional !="   => $id_operasional
        ); 
        $bahan_exist = $this->Model_master->check_data_exist("tbl_kategori_operasional", $data_operasional);
        $data = array(
            "nama_kategori"  => $nama_kategori 
        );
        if ($bahan_exist) {
            $this->session->set_flashdata("error", "Kategori operasional sudah ada, mohon gunakan lain");
        } else {
            $action = $this->Model_master->editMaster(array('id_operasional' => $id_operasional), "tbl_kategori_operasional", $data);
            if ($action) {
               $this->session->set_flashdata("success", "Berhasil Mengubah kategori operasional");
            }  else {
                $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah kategori operasional");
            }
        }

        redirect("kategori_operasional");
    }

    public function delete_operasional(){
        $id_operasional = $this->input->post("id_operasional");
        $delete         = $this->Model_master->deleteMaster($id_operasional, "id_operasional", "tbl_kategori_operasional");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_operasional, "message"  => "Berhasil menghapus kategori operasional"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus kategori operasional"));
         }
    }
}