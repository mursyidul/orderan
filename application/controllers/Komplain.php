<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Komplain extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_komplain");
        $this->load->model("Model_master");

    }

    public function index() {
        $data['komplain'] = $this->Model_komplain->get_komplain();
        $data['produk']   = $this->Model_master->getMasterOneTable("*", "tbl_product", "deskripsi", "asc", "");
        $data['kategori'] = $this->Model_master->getMasterOneTable("*", "tbl_kategori", "nama_kategori", "asc", "");
        $data['user']     = $this->Model_komplain->get_user();
    	$this->template->load("template", "komplain/data-komplain", $data);

    }

    public function tambah(){
        $config['upload_path']          = './file/komplain/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 0;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $this->load->library('upload', $config);

        $var_file_product         = "";

        $list_gambar = array();
        if ($this->upload->do_upload('gambar')){
          $gbr1 = $this->upload->data();
          array_push($list_gambar, array('name' => $gbr1['file_name'], 'size' => $gbr1['file_size']));
          $file_size_company = $gbr1['file_size'];
          $var_file_galeri = $gbr1['file_name'];
        }

        $this->load->library('image_lib');
        foreach($list_gambar as $gambar){
           
           if ($gambar['size'] >= 2048) {
               $config['image_library']    = 'gd2';
               $config['source_image']     ='./file/komplain/'.$gambar['name'];
               $config['create_thumb']     = false;
               $config['maintain_ratio']   = true;
               $config['width']            = '500';
               $config['height']           = '500';   
               $config['master_dim']       = 'height';   
               $config['new_image']        = './file/komplain/'.$gambar['name'];

               $this->image_lib->clear();
               $this->image_lib->initialize($config);
               $this->image_lib->resize();
            } 
        }

        $id_product              = $this->input->post("id_product");
        $id_user                 = $this->input->post("id_user");
        $no_pesanan              = $this->input->post("no_pesanan");
        $id_kategori             = $this->input->post("id_kategori");
        $permintaan_komplain     = $this ->input->post("permintaan_komplain");
        $tanggapan_atas_komplain = $this->input->post("tanggapan_atas_komplain");
        $nominal                 = $this->input->post("nominal");
        $ongkos_kirim            = $this->input->post("ongkos_kirim");
        $status                  = $this->input->post("status");
        $keterangan              = $this->input->post("keterangan");
        $created_date            = date("Y-m-d H:i:s");

    	$data = array(
            "permintaan_komplain"       => $permintaan_komplain,
            "tanggapan_atas_komplain"   => $tanggapan_atas_komplain,
            "id_product"                => $id_product,
            "id_user"                   => $id_user,
            "no_pesanan"                => $no_pesanan,
            "id_kategori"               => $id_kategori,
            "upload_gambar"             => $var_file_galeri,
            "nominal"                   => $nominal,
            "ongkos_kirim"              => $ongkos_kirim,
            "status"                    => $status,
            "keterangan"                => $keterangan,
            "created_date"              => $created_date
    	);
        $action = $this->Model_master->tambahMaster("tbl_komplain", $data);
        if ($action) {
            $this->session->set_flashdata("success", "Berhasil menambahkan komplain");
        } else {
            $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan komplain");
        }
        redirect('komplain');

    }

    public function edit(){
        $id_komplain             = $this->input->post("id_komplain");
        $komplain = $this->db->get_where('tbl_komplain', ['id_komplain' => $id_komplain])->row();

        $config['upload_path']          = './file/komplain/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
          // $config['max_size']             = 2000;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $this->load->library('upload', $config);

        $var_file_galeri     = "";

        $list_gambar = array();

        if ($this->upload->do_upload('gambar')){
            $gbr1 = $this->upload->data();
            array_push($list_gambar, array('name' => $gbr1['file_name'], 'size' => $gbr1['file_size']));
            $file_size = $gbr1['file_size'];
            $var_file_galeri = $gbr1['file_name'];
          }

        $this->load->library('image_lib');
            foreach($list_gambar as $gambar){
                     
               if ($gambar['size'] >= 2048) {
                 $config['image_library']    = 'gd2';
                 $config['source_image']     ='./file/komplain/'.$gambar['name'];
                 $config['create_thumb']     = false;
                 $config['maintain_ratio']   = true;
                 $config['width']            = '500';
                 $config['height']           = '500';   
                 $config['master_dim']       = 'height';   
                 $config['new_image']= './file/komplain/'.$gambar['name'];

                 $this->image_lib->clear();
                 $this->image_lib->initialize($config);
                 $this->image_lib->resize();
                } 
            }
          $file_galeri_var = $var_file_galeri;
          if ($file_galeri_var == "") {
            $file_galeri_var = $komplain->upload_gambar;
          } else {
            unlink("./file/komplain/".$komplain->upload_gambar);
          }

        $id_product              = $this->input->post("id_product");
        $id_user                 = $this->input->post("id_user");
        $permintaan_komplain     = $this ->input->post("permintaan_komplain");
        $tanggapan_atas_komplain = $this->input->post("tanggapan_atas_komplain");
        $no_pesanan              = $this->input->post("no_pesanan");
        $id_kategori             = $this->input->post("id_kategori");
        $nominal                 = $this->input->post("nominal");
        $ongkos_kirim            = $this->input->post("ongkos_kirim");
        $status                  = $this->input->post("status");
        $keterangan              = $this->input->post("keterangan");

        $data = array(
            "id_product"        => $id_product,
            "id_user"           => $id_user,
            "no_pesanan"        => $no_pesanan,
            "id_kategori"       => $id_kategori,
            "nominal"           => $nominal,
            "upload_gambar"     => $file_galeri_var,
            "ongkos_kirim"      => $ongkos_kirim,
            "status"            => $status,
            "keterangan"        => $keterangan
        );

        $action = $this->Model_master->editMaster(array('id_komplain' => $id_komplain), "tbl_komplain", $data);
        if ($action) {
           $this->session->set_flashdata("success", "Berhasil Mengubah komplain");
        }  else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah komplain");
        }
        redirect("komplain");
    }

    public function delete_komplain(){
        $id_komplain = $this->input->post("id_komplain");
        $delete     = $this->Model_master->deleteMaster($id_komplain, "id_komplain", "tbl_komplain");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_komplain, "message"  => "Berhasil menghapus komplain"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus komplain"));
         }
    }
}