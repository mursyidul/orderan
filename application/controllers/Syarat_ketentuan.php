<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Syarat_ketentuan extends CI_Controller {



    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");

    }

    public function index() {
        $data['syarat'] = $this->Model_master->getMasterOneTable("*", "tbl_ketentuan", "id_ketentuan", "asc", "");
    	$this->template->load("template", "setting/data-syarat-ketentuan", $data);
    }

    public function edit($id){
        $data['syarat'] = $this->db->get_where('tbl_ketentuan',['id_ketentuan' => $id])->row();
        $this->template->load("template", "setting/edit-syarat-ketentuan", $data);
    }

    public function update(){
        $id_ketentuan  = $this->input->post("id_ketentuan");
        $judul_ketentuan = $this->input->post("judul_ketentuan");
        $syarat_ketentuan = $this->input->post("syarat_ketentuan");

        $data = array(
            "judul_ketentuan" => $judul_ketentuan,
            "syarat_ketentuan" => $syarat_ketentuan
        );
        $query = $this->Model_master->editMaster(array('id_ketentuan' => $id_ketentuan), "tbl_ketentuan", $data);
        if ($query) {
            $this->session->set_flashdata("success", "Berhasil mengubah syarat dan ketentuan");
        } else {
            $this->session->set_flashdata("error", "Gagal, Tidak dapat mengubah syarat dan ketentuan");
        }
        redirect('syarat_ketentuan');
    }


}