<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Biaya_operasional extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_operasional");
        $this->load->model("Model_master");

    }

    public function index() {
        if(isset($_GET['startdate']) && ! empty($_GET['startdate']) && isset($_GET['enddate']) && ! empty($_GET['enddate'])){ 
                $startdate =  date('Y-m-d',strtotime($_GET['startdate']));
                $enddate = date('Y-m-d',strtotime($_GET['enddate']));
        }else{
            $startdate = date('Y-m-d',strtotime('-0 Day'));
            $enddate = date('Y-m-d');
        }
        $data['biaya']      = $this->Model_operasional->get_biaya($startdate, $enddate);
        $data['kategori']   = $this->Model_master->getMasterOneTable("*", "tbl_kategori_operasional", "nama_kategori", "asc", "");
    	$this->template->load("template", "biaya operasional/data-biaya_operasional", $data);

    }

    public function tambah(){
        $id_operasional  = $this->input->post("id_operasional");
        $satuan_biaya    = $this->input->post("satuan_biaya");
        $total_biaya     = $this->input->post("total_biaya");
        $keterangan      = $this->input->post("keterangan");
        $tanggal         = $this->input->post("tanggal");
        $created_date    = date("Y-m-d H:i:s");

    	$data = array(
            "id_operasional"    => $id_operasional,
            "keterangan"        => $keterangan,
            "total_biaya"       => $total_biaya,
            "satuan_biaya"      => $satuan_biaya,
            "satuan_biaya"      => $satuan_biaya,
            "tanggal"           => date("Y-m-d", strtotime(str_replace("/", "-", $tanggal))),
            "created_date"      => $created_date
    	);

        $action = $this->Model_master->tambahMaster("tbl_biaya_operasional", $data);
        if ($action) {
            $this->session->set_flashdata("success", "Berhasil menambahkan biaya operasional");
        } else {
            $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan biaya operasional");
        }
        redirect('biaya_operasional');

    }

    public function edit(){
        $id_biaya        = $this->input->post("id_biaya");
        $id_operasional  = $this->input->post("id_operasional");
        $satuan_biaya    = $this->input->post("satuan_biaya");
        $total_biaya     = $this->input->post("total_biaya");
        $keterangan      = $this->input->post("keterangan");
        $tanggal         = $this->input->post("tanggal");

        $data = array(
            "id_operasional"    => $id_operasional,
            "keterangan"        => $keterangan,
            "total_biaya"       => $total_biaya,
            "tanggal"           => date("Y-m-d", strtotime(str_replace("/", "-", $tanggal))),
            "satuan_biaya"      => $satuan_biaya,
        );

        $action = $this->Model_master->editMaster(array('id_biaya' => $id_biaya), "tbl_biaya_operasional", $data);
        if ($action) {
           $this->session->set_flashdata("success", "Berhasil Mengubah biaya operasional");
        }  else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah biaya operasional");
        }

        redirect("biaya_operasional");
    }

    public function delete_biaya(){
        $id_biaya = $this->input->post("id_biaya");
        $delete         = $this->Model_master->deleteMaster($id_biaya, "id_biaya", "tbl_biaya_operasional");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_biaya, "message"  => "Berhasil menghapus biaya operasional"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus biaya operasional"));
         }
    }
}