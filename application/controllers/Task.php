<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Task extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");
        $this->load->model("Model_setting");

    }

    public function index() {
        // $data['bahan']      = $this->Model_master->get_bahan();
        $data['task']      = $this->Model_setting->get_task();
        $data['user']      = $this->Model_master->getMasterOneTable("*", "tbl_user", "full_name", "asc", "");
    	$this->template->load("template", "task/data-task", $data);

    }

    public function tambah(){
        $id_user        = $this->input->post("id_user");
        $judul_task     = $this->input->post("judul_task");
        $priorty_task   = $this->input->post("priorty_task");
        $deskripsi_task = $this->input->post("deskripsi_task");
        $tanggal_task   = $this->input->post("tanggal_task");

    	$data = array(
            "id_user"           => $id_user,
            "judul_task"        => $judul_task,
            "deskripsi_task"    => $deskripsi_task,
            "priorty_task"      => $priorty_task,
            "tanggal_task"      => date("Y-m-d", strtotime(str_replace("/", "-", $tanggal_task))) 
    	);
        $action = $this->Model_master->tambahMaster("tbl_task", $data);
        if ($action) {
            $this->session->set_flashdata("success", "Berhasil menambahkan task");
        } else {
            $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan task");
        }
        redirect('task');

    }

    public function edit(){
        $id_task        = $this->input->post("id_task");
        $id_user        = $this->input->post("id_user");
        $judul_task     = $this->input->post("judul_task");
        $priorty_task   = $this->input->post("priorty_task");
        $deskripsi_task = $this->input->post("deskripsi_task");
        $tanggal_task   = $this->input->post("tanggal_task");

        
        $data = array(
            "id_user"           => $id_user,
            "judul_task"        => $judul_task,
            "deskripsi_task"    => $deskripsi_task,
            "priorty_task"      => $priorty_task,
            "tanggal_task"      => date("Y-m-d", strtotime(str_replace("/", "-", $tanggal_task))) 
        );
        $action = $this->Model_master->editMaster(array('id_task' => $id_task), "tbl_task", $data);
        if ($action) {
           $this->session->set_flashdata("success", "Berhasil Mengubah task");
        }  else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah task");
        }

        redirect("task");
    }

    public function delete_task(){
        $id_task    = $this->input->post("id_task");
        $delete     = $this->Model_master->deleteMaster($id_task, "id_task", "tbl_task");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_task, "message"  => "Berhasil menghapus task"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus task"));
         }
    }

    public function cancel_task(){
        $id_task    = $this->input->post("id_task");
        $cancel     = $this->Model_setting->cancel_task($id_task);
        if ($cancel) {
            echo json_encode(array("status" => "success", "data" => $id_task, "message"  => "Status berhasil diubah menjadi cancel"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat mengubah status"));
         }
    }

    public function progres_task(){
        $id_task    = $this->input->post("id_task");
        $progres    = $this->Model_setting->progres_task($id_task);
        if ($progres) {
            echo json_encode(array("status" => "success", "data" => $id_task, "message"  => "Status berhasil diubah menjadi progres"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat mengubah status"));
         }
    }

    public function complete_task(){
        $id_task    = $this->input->post("id_task");
        $complete   = $this->Model_setting->complete_task($id_task);
        if ($complete) {
            echo json_encode(array("status" => "success", "data" => $id_task, "message"  => "Status berhasil diubah menjadi complete"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat mengubah status"));
         }
    }
}