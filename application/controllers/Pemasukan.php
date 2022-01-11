<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Pemasukan extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_operasional");
        $this->load->model("Model_master");

    }

    public function index() {
        $data['pemasukan']      = $this->Model_operasional->get_pemasukan();
        $data['kategori']   = $this->Model_master->getMasterOneTable("*", "tbl_kategori_operasional", "nama_kategori", "asc", "");
    	$this->template->load("template", "pemasukan/data-pemasukan", $data);

    }

    public function tambah(){
        $id_operasional      = $this->input->post("id_operasional");
        $satuan_pemasukan    = $this->input->post("satuan_pemasukan");
        $total_pemasukan     = $this->input->post("total_pemasukan");
        $keterangan          = $this->input->post("keterangan");
        $created_date        = date("Y-m-d H:i:s");

    	$data = array(
            "id_operasional"    => $id_operasional,
            "keterangan"        => $keterangan,
            "total_pemasukan"   => $total_pemasukan,
            "satuan_pemasukan"  => $satuan_pemasukan,
            "created_date"      => $created_date
    	);
        echo "<pre>", print_r($data, 1), "</pre>";
        $action = $this->Model_master->tambahMaster("tbl_pemasukan", $data);
        if ($action) {
            $this->session->set_flashdata("success", "Berhasil menambahkan pemasukan");
        } else {
            $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan pemasukan");
        }
        redirect('pemasukan');

    }

    public function edit(){
        $id_pemasukan        = $this->input->post("id_pemasukan");
        $id_operasional      = $this->input->post("id_operasional");
        $satuan_pemasukan    = $this->input->post("satuan_pemasukan");
        $total_pemasukan     = $this->input->post("total_pemasukan");
        $keterangan          = $this->input->post("keterangan");

        $data = array(
            "id_operasional"    => $id_operasional,
            "keterangan"        => $keterangan,
            "total_pemasukan"   => $total_pemasukan,
            "satuan_pemasukan"  => $satuan_pemasukan
        );

        $action = $this->Model_master->editMaster(array('id_pemasukan' => $id_pemasukan), "tbl_pemasukan", $data);
        if ($action) {
           $this->session->set_flashdata("success", "Berhasil Mengubah pemasukan");
        }  else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah pemasukan");
        }

        redirect("pemasukan");
    }

    public function delete_pemasukan(){
        $id_pemasukan = $this->input->post("id_pemasukan");
        $delete         = $this->Model_master->deleteMaster($id_pemasukan, "id_pemasukan", "tbl_pemasukan");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_pemasukan, "message"  => "Berhasil menghapus pemasukan"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus pemasukan"));
         }
    }
}