<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Variasi extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_variasi");
        $this->load->model("Model_master");

    }

    public function index() {
        $data['variasi']      = $this->Model_variasi->get_variasi();
        $data['produk']   = $this->Model_master->getMasterOneTable("*", "tbl_product", "deskripsi", "asc", "");
    	$this->template->load("template", "variasi/data-variasi", $data);

    }

    public function tambah(){
        $id_product          = $this->input->post("id_product");
        $nomor_sku           = $this->input->post("nomor_sku");
        $nama_variasi        = $this->input->post("nama_variasi");
        $harga_variasi       = $this->input->post("harga_variasi");
        $keterangan_variasi  = $this->input->post("keterangan_variasi");
        $created_date        = date("Y-m-d H:i:s");

    	$data = array(
            "id_produk"         => $id_product,
            "keterangan_variasi"=> $keterangan_variasi,
            "harga_variasi"     => $harga_variasi,
            "nomor_sku"         => $nomor_sku,
            "nama_variasi"      => $nama_variasi,
            "created_date"      => $created_date
    	);

        $sama_variasi = $this->Model_master->check_existing_name_master("id_variasi", "tbl_variasi", "nama_variasi", $nama_variasi);
        if ($sama_variasi) {
            $this->session->set_flashdata("error", "Variasi sudah ada, mohon gunakan yang lain");
        } else {
            $action = $this->Model_master->tambahMaster("tbl_variasi", $data);
            if ($action) {
                $this->session->set_flashdata("success", "Berhasil menambahkan variasi");
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan variasi");
            }
        }
        redirect('variasi');

    }

    public function edit(){
        $id_variasi          = $this->input->post("id_variasi");
        $id_product          = $this->input->post("id_product");
        $nomor_sku           = $this->input->post("nomor_sku");
        $nama_variasi        = $this->input->post("nama_variasi");
        $harga_variasi       = $this->input->post("harga_variasi");
        $keterangan_variasi  = $this->input->post("keterangan_variasi");

        $data_variasi     = array(
            "nama_variasi"    => $nama_variasi,
            "id_variasi !="   => $id_variasi
        ); 
        $variasi_exist = $this->Model_master->check_data_exist("tbl_variasi", $data_variasi);
        $data = array(
            "id_produk"        => $id_product,
            "keterangan_variasi"=> $keterangan_variasi,
            "harga_variasi"     => $harga_variasi,
            "nomor_sku"         => $nomor_sku,
            "nama_variasi"      => $nama_variasi
        );
        if ($variasi_exist) {
            $this->session->set_flashdata("error", "Variasi sudah ada, mohon gunakan yang lain");
        } else {
            $action = $this->Model_master->editMaster(array('id_variasi' => $id_variasi), "tbl_variasi", $data);
            if ($action) {
               $this->session->set_flashdata("success", "Berhasil Mengubah variasi");
            }  else {
                $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah variasi");
            }
        }
        redirect("variasi");
    }

    public function delete_variasi(){
        $id_variasi = $this->input->post("id_variasi");
        $delete     = $this->Model_master->deleteMaster($id_variasi, "id_variasi", "tbl_variasi");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_variasi, "message"  => "Berhasil menghapus variasi"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus variasi"));
         }
    }
}