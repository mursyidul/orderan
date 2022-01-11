<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Stock extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");
        $this->load->model("Model_stock");

    }

    public function index() {
        $data['stock'] = $this->Model_stock->get_stock();
    	$this->template->load("template", "stock/data-stock", $data);

    }

    public function tambah(){
        $kraft_paper    = $this->input->post("kraft_paper");
        $art_paper      = $this->input->post("art_paper");
        $samson         = $this->input->post("samson");
        // $created_date = date("Y-m-d H:i:s");

    	$data = array(
            "kraft_paper"   => $kraft_paper,
            "art_paper"     => $art_paper,
            "samson"        => $samson
    	);

        $action = $this->Model_master->tambahMaster("tbl_stock", $data);
        if ($action) {
            $this->session->set_flashdata("success", "Berhasil menambahkan stock");
        } else {
            $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan stock");
        }
        redirect('stock');

    }

    public function edit(){
        $id_stock        = $this->input->post("id_stock");
        $kraft_paper     = $this->input->post("kraft_paper");
        $art_paper       = $this->input->post("art_paper");
        $samson          = $this->input->post("samson");

        $stock = $this->db->get_where("tbl_stock", ["id_stock" => $id_stock])->row();
        $total_kraft = $stock->kraft_paper + $kraft_paper;
        $total_art   = $stock->art_paper + $art_paper;
        $total_samson= $stock->samson + $samson;

        $data = array(
            "kraft_paper"    => $total_kraft, 
            "art_paper"      => $total_art,
            "samson"         => $total_samson
        );

        // echo "<pre>", print_r($data, 1), "</pre>";
        $action = $this->Model_master->editMaster(array('id_stock' => $id_stock), "tbl_stock", $data);
        if ($action) {
           $this->session->set_flashdata("success", "Berhasil Mengubah stock");
        }  else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah stock");
        }

        redirect("stock");
    }

    public function delete_stock(){
        $id_stock   = $this->input->post("id_stock");
        $delete         = $this->Model_master->deleteMaster($id_stock, "id_stock", "tbl_stock");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_stock, "message"  => "Berhasil menghapus stock"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus stock"));
         }
    }
}