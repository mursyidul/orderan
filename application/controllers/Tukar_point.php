<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Tukar_point extends CI_Controller {



    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");
        $this->load->model("Model_setting");

    }

    public function index() {
        $data['tukar_point'] = $this->Model_master->getMasterOneTable("*", "tbl_tukar_point", "id_tukar_point", "asc", "");
    	$this->template->load("template", "setting/data-tukar-point", $data);

    }

    public function tambah(){
    	$tukar_point  = $this->input->post("tukar_point");

    	$data = array(
    		"tukar_point" => $tukar_point
    	);

        $point_sama = $this->Model_master->check_existing_name_master("id_tukar_point", "tbl_tukar_point", "tukar_point", $tukar_point);

        if ($point_sama) {
            $this->session->set_flashdata("error", "Point sudah ada, mohon gunakan point lain");
            redirect('tukar_point');
        } else {
            $action = $this->Model_master->tambahMaster("tbl_tukar_point", $data);
            if ($action) {
                $id_tukar_point = $action;
                $this->session->set_flashdata("success", "Berhasil menambahkan point");
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan point");
            }
    	redirect('tukar_point/detail/'.$id_tukar_point);
        }
    }

    public function edit(){
        $id_tukar_point = $this->input->post("id_tukar_point");
        $tukar_point    = $this->input->post("tukar_point");

        $data_point     = array(
            "tukar_point"         => $tukar_point,
            "id_tukar_point !="   => $id_tukar_point
        ); 
        $point_exist = $this->Model_master->check_data_exist("tbl_tukar_point", $data_point);

        $data = array(
            "tukar_point" => $tukar_point
        );

        if ($point_exist) {
            $this->session->set_flashdata("error", "Point sudah ada, mohon gunakan point lain");
        } else {
            $action = $this->Model_master->editMaster(array('id_tukar_point' => $id_tukar_point), "tbl_tukar_point", $data);
            if ($action) {
               $this->session->set_flashdata("success", "Berhasil Mengubah Point");
            }  else {
                $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah point");
            }
        }
        redirect("tukar_point");
    }

    public function delete_tukar_point(){
        $id_tukar_point = $this->input->post("id_tukar_point");
        $delete         = $this->Model_master->deleteMaster($id_tukar_point, "id_tukar_point", "tbl_tukar_point");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_tukar_point, "message"  => "Berhasil menghapus point"));
            $this->db->where('id_tukar_point', $id_tukar_point);
            $this->db->delete('tbl_detail_point');
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus point"));
         }
    }

    public function detail($id_tukar_point){
        $data['detail_hadiah']  = $this->Model_setting->get_detail_hadiah($id_tukar_point);
        $data['point']          = $this->db->get_where('tbl_tukar_point', ['id_tukar_point' => $id_tukar_point])->row();
        $this->template->load("template", "setting/data-detail-point", $data);
    }


    public function tambah_detail(){
        $id_tukar_point = $this->input->post("id_tukar_point");
        $barang_point   = $this->input->post("barang_point");
        $keterangan     = $this->input->post("keterangan");
        $config['upload_path']          = './file/dokumen/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 0;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $this->load->library('upload', $config);

        $var_file_galeri         = "";

        $list_gambar = array();
        if ($this->upload->do_upload('gambar_detail')){
          $gbr1 = $this->upload->data();
          array_push($list_gambar, array('name' => $gbr1['file_name'], 'size' => $gbr1['file_size']));
          $file_size_company = $gbr1['file_size'];
          $var_file_galeri = $gbr1['file_name'];
        }

        $this->load->library('image_lib');
        foreach($list_gambar as $gambar){
           
           if ($gambar['size'] >= 2048) {
               $config['image_library']    = 'gd2';
               $config['source_image']     ='./file/dokumen/'.$gambar['name'];
               $config['create_thumb']     = false;
               $config['maintain_ratio']   = true;
               $config['width']            = '500';
               $config['height']           = '500';   
               $config['master_dim']       = 'height';   
               $config['new_image']= './file/dokumen/'.$gambar['name'];

               $this->image_lib->clear();
               $this->image_lib->initialize($config);
               $this->image_lib->resize();
            } 
        }

        $data = array(
            "id_tukar_point"  => $id_tukar_point,
            "gambar_point"    => $var_file_galeri,
            "keterangan"      => $keterangan,
            "barang_point"    => $barang_point
        );

        $action = $this->Model_master->tambahMaster("tbl_detail_point", $data);
        if ($action) {
            $this->session->set_flashdata("success", "Berhasil Menambahkan Hadiah");
        } else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat menambahkan hadiah");
        }
        redirect("tukar_point/detail/".$id_tukar_point);
    }

    public function edit_detail(){
        $id_tukar_point  = $this->input->post("id_tukar_point");
        $id_detail_point = $this->input->post("id_detail_point");
        $barang_point    = $this->input->post("barang_point");
        $keterangan      = $this->input->post("keterangan");

        $hadiah = $this->db->get_where('tbl_detail_point', ['id_detail_point' => $id_detail_point])->row();
        $config['upload_path']          = './file/dokumen/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        // $config['max_size']             = 2000;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $this->load->library('upload', $config);

        $var_file_galeri     = "";

        $list_gambar = array();

        if ($this->upload->do_upload('gambar_detail')){
            $gbr1 = $this->upload->data();
            array_push($list_gambar, array('name' => $gbr1['file_name'], 'size' => $gbr1['file_size']));
            $file_size = $gbr1['file_size'];
            $var_file_galeri = $gbr1['file_name'];
        }

        $this->load->library('image_lib');
            foreach($list_gambar as $gambar){
                 
                if ($gambar['size'] >= 2048) {
                    $config['image_library']    = 'gd2';
                    $config['source_image']     ='./file/dokumen/'.$gambar['name'];
                    $config['create_thumb']     = false;
                    $config['maintain_ratio']   = true;
                    $config['width']            = '500';
                    $config['height']           = '500';   
                    $config['master_dim']       = 'height';   
                    $config['new_image']= './file/dokumen/'.$gambar['name'];

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                } 
            }
        $file_galeri_var = $var_file_galeri;
        if ($file_galeri_var == "") {
            $file_galeri_var = $hadiah->gambar_point;
        } else {
            unlink("./file/dokumen/".$hadiah->gambar_point);
        }

        $data = array(
            "id_detail_point" => $id_detail_point,
            "gambar_point"    => $file_galeri_var,
            "keterangan"      => $keterangan,  
            "barang_point"    => $barang_point  
        );

        $action = $this->Model_master->editMaster(array("id_detail_point" => $id_detail_point), "tbl_detail_point", $data);
        if ($action) {
            $this->session->set_flashdata("success", "Berhasil Mengubah Hadiah");
        } else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat menambahkan hadiah");
        }

        redirect("tukar_point/detail/".$id_tukar_point);

    }

    public function detele_detail_point(){
        $id_detail_point = $this->input->post("id_detail_point");
        $delete          = $this->Model_master->deleteMaster($id_detail_point, "id_detail_point", "tbl_detail_point"); 
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_detail_point, "message" => "Berhasil Menghapus Hadiah"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus hadiah"));
        }
    }
}