<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Bahan extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");
        $this->load->model("Model_setting");

    }

    public function index() {
        // $data['bahan']      = $this->Model_master->get_bahan();
        $data['bahan']      = $this->Model_master->getMasterOneTable("*", "tbl_bahan", "id_bahan", "asc", "");
    	$this->template->load("template", "bahan/data-bahan", $data);

    }

    public function tambah(){
        $jenis_bahan  = $this->input->post("jenis_bahan");
        $harga_kertas = $this->input->post("harga_kertas");
        $harga_cetak  = $this->input->post("harga_cetak");
        $created_date = date("Y-m-d H:i:s");

    	$data = array(
            "jenis_bahan"  => $jenis_bahan,
            "harga_kertas" => $harga_kertas,
            "harga_cetak"  => $harga_cetak,
            "created_date" => $created_date 
    	);

        $jenis_sama = $this->Model_master->check_existing_name_master("id_bahan", "tbl_bahan", "jenis_bahan", $jenis_bahan);
        if ($jenis_sama) {
            $this->session->set_flashdata("error", "Jenis bahan sudah ada, mohon gunakan jenis bahan lain");
        } else {
            $action = $this->Model_master->add_bahan($data);
            if ($action) {
                $this->session->set_flashdata("success", "Berhasil menambahkan bahan");
                $tambah_stock = array(
                        'id_bahan'   => $action,
                        'jumlah_stock'  => "0"
                );

                $this->db->insert('tbl_stock', $tambah_stock);
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan bahan");
            }
        }
        redirect('bahan');

    }

    public function edit(){
        $id_bahan       = $this->input->post("id_bahan");
        $jenis_bahan    = $this->input->post("jenis_bahan");
        $harga_kertas   = $this->input->post("harga_kertas");
        $harga_cetak    = $this->input->post("harga_cetak");

        $data_bahan     = array(
            "jenis_bahan"   => $jenis_bahan,
            "id_bahan !="   => $id_bahan
        ); 
        $bahan_exist = $this->Model_master->check_data_exist("tbl_bahan", $data_bahan);
        $data = array(
            "jenis_bahan"  => $jenis_bahan,
            "harga_kertas" => $harga_kertas, 
            "harga_cetak"  => $harga_cetak  
        );
        if ($bahan_exist) {
            $this->session->set_flashdata("error", "Jenis bahan sudah ada, mohon gunakan jenis bahan lain");
        } else {
            $action = $this->Model_master->editMaster(array('id_bahan' => $id_bahan), "tbl_bahan", $data);
            if ($action) {
               $this->session->set_flashdata("success", "Berhasil Mengubah bahan");
            }  else {
                $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah bahan");
            }
        }

        redirect("bahan");
    }

    public function delete_bahan(){
        $id_bahan = $this->input->post("id_bahan");
        $delete         = $this->Model_master->deleteMaster($id_bahan, "id_bahan", "tbl_bahan");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_bahan, "message"  => "Berhasil menghapus bahan"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus bahan"));
         }
    }
}