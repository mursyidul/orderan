<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Kategori extends CI_Controller {



    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");

    }

    public function index() {
        $data['kategori'] = $this->Model_master->getMasterOneTable("*", "tbl_kategori", "id_kategori", "asc", "");
    	$this->template->load("template", "kategori/data-kategori", $data);

    }

    public function tambah(){
    	$nama_kategori   = $this->input->post("nama_kategori");
        $created_date    = date("Y-m-d H:i:s");

    	$data = array(
    		"nama_kategori"   => $nama_kategori,
            "created_date"    => $created_date 
    	);
        $kategori_sama = $this->Model_master->check_existing_name_master("id_kategori", "tbl_kategori", "nama_kategori", $nama_kategori);

        if ($kategori_sama) {
            $this->session->set_flashdata("error", "Kategori sudah ada, mohon gunakan kategori lain");
        } else {
            $action = $this->Model_master->tambahMaster("tbl_kategori", $data);
            if ($action) {
                $this->session->set_flashdata("success", "Berhasil menambahkan kategori");
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan kategori");
            }
        }

    	
    	redirect('kategori');
    }

    public function edit(){
        $id_kategori    = $this->input->post("id_kategori");
        $nama_kategori  = $this->input->post("nama_kategori");

        $data_kategori     = array(
            "nama_kategori"   => $nama_kategori,
            "id_kategori !="   => $id_kategori
        ); 
        $kategori_exist = $this->Model_master->check_data_exist("tbl_kategori", $data_kategori);

        $data = array(
            "nama_kategori"  => $nama_kategori
        );

        if ($kategori_exist) {
            $this->session->set_flashdata("error", "Kategori sudah ada, mohon gunakan kategori lain");
        } else {
            $action = $this->Model_master->editMaster(array('id_kategori' => $id_kategori), "tbl_kategori", $data);
            if ($action) {
               $this->session->set_flashdata("success", "Berhasil Mengubah kategori");
            }  else {
                $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah kategori");
            }
        }
        redirect("kategori");
    }

    public function delete_kategori(){
        $id_kategori = $this->input->post("id_kategori");
        $delete         = $this->Model_master->deleteMaster($id_kategori, "id_kategori", "tbl_kategori");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_kategori, "message"  => "Berhasil menghapus kategori"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus kategori"));
         }
    }
}