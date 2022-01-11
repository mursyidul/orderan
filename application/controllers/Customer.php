<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Customer extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");
        $this->load->model("Model_setting");

    }

    public function index() {
        // $data['customer']      = $this->Model_master->get_customer();
        $data['customer']      = $this->Model_master->getMasterOneTable("*", "tbl_customer", "id_customer", "asc", "");
    	$this->template->load("template", "customer/data-customer", $data);

    }

    public function tambah(){
        $nama_customer      = $this->input->post("nama_customer");
        $wa_customer        = $this->input->post("wa_customer");
        $alamat_customer    = $this->input->post("alamat_customer");
        $provinsi_customer  = $this->input->post("provinsi_customer");
        $kabupaten_customer = $this->input->post("kabupaten_customer");
        if (substr($wa_customer, 0, 1) === '0') {
            $wa_customer = '62' . substr($wa_customer, 1);
        }
    	$data = array(
            "nama_customer"         => $nama_customer,
            "wa_customer"           => $wa_customer,
            "kabupaten_customer"    => $kabupaten_customer,
            "provinsi_customer"     => $provinsi_customer,
            "alamat_customer"       => $alamat_customer,
    	);

        $wa_sama = $this->Model_master->check_existing_name_master("id_customer", "tbl_customer", "wa_customer", $no_telepon);
        if ($wa_sama) {
            $this->session->set_flashdata("error", "Nomer Telpon sudah ada, mohon gunakan yang lain");
        } else {
            $action = $this->Model_master->tambahMaster("tbl_customer", $data);
            if ($action) {
                $this->session->set_flashdata("success", "Berhasil menambahkan customer");
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan customer");
            }
        }
        redirect('customer');

    }

    public function edit(){
        $id_customer        = $this->input->post("id_customer");
        $nama_customer      = $this->input->post("nama_customer");
        $wa_customer        = $this->input->post("wa_customer");
        $alamat_customer    = $this->input->post("alamat_customer");
        $provinsi_customer  = $this->input->post("provinsi_customer");
        $kabupaten_customer = $this->input->post("kabupaten_customer");
        if (substr($wa_customer, 0, 1) === '0') {
            $wa_customer = '62' . substr($wa_customer, 1);
        }
        $data_customer     = array(
            "wa_customer"   => $wa_customer,
            "id_customer !="   => $id_customer
        ); 
        $customer_exist = $this->Model_master->check_data_exist("tbl_customer", $data_customer);
        $data = array(
            "nama_customer"         => $nama_customer,
            "wa_customer"           => $wa_customer,
            "kabupaten_customer"    => $kabupaten_customer,
            "provinsi_customer"     => $provinsi_customer,
            "alamat_customer"       => $alamat_customer, 
        );
        if ($customer_exist) {
            $this->session->set_flashdata("error", "Nomer Telpoon sudah ada, mohon gunakan yang lain");
        } else {
            $action = $this->Model_master->editMaster(array('id_customer' => $id_customer), "tbl_customer", $data);
            if ($action) {
               $this->session->set_flashdata("success", "Berhasil Mengubah customer");
            }  else {
                $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah customer");
            }
        }

        redirect("customer");
    }

    public function delete_customer(){
        $id_customer = $this->input->post("id_customer");
        $delete         = $this->Model_master->deleteMaster($id_customer, "id_customer", "tbl_customer");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_customer, "message"  => "Berhasil menghapus customer"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus customer"));
         }
    }
}