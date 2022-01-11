<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Product extends CI_Controller {



    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");

    }

    public function index() {
        $data['product'] = $this->Model_master->getMasterOneTable("*", "tbl_product", "id_product", "desc", "");
    	$this->template->load("template", "product/data-product", $data);

    }

    public function tambah_product(){

        $config['upload_path']          = './file/dokumen/';
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

        $nmr_sku     = $this->input->post("nmr_sku");
        $harga_produk= $this->input->post("harga_produk");
        $deskripsi   = $this->input->post("deskripsi");

        $data = array(
            "nmr_sku"       => $nmr_sku,
            "harga_produk"  => $harga_produk,
            "gambar"        => $var_file_galeri,
            "deskripsi"     => $deskripsi
        );

        $sama_nmr_sku = $this->Model_master->check_existing_name("nmr_sku", $nmr_sku);

        if ($sama_nmr_sku) {
            $this->session->set_flashdata("error", "Nomor SKU sudah ada, mohon cek lagi nomor SKU");
        } else {
          $action = $this->Model_master->tambahMaster("tbl_product", $data);

          if ($action) {
              $this->session->set_flashdata("success", "Berhasil menambahkan product");
          } else {
              $this->session->set_flashdata("error", "Gagal, tidak dapat menyimpan product");
          }
        }

        redirect('product');
    }

    public function edit_product(){

        $id_product            = $this->input->post("id_product");
        $product = $this->db->get_where('tbl_product', ['id_product' => $id_product])->row();
        $config['upload_path']          = './file/dokumen/';
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
            $file_galeri_var = $product->gambar;
          } else {
            unlink("./file/dokumen/".$product->gambar);
          }
        $id_product   = $this->input->post("id_product");
        $nmr_sku      = $this->input->post("nmr_sku");
        $harga_produk = $this->input->post("harga_produk");
        $deskripsi    = $this->input->post("deskripsi");

        $data = array(
            "nmr_sku"         => $nmr_sku,
            "harga_produk"    => $harga_produk,
            "gambar"          => $file_galeri_var,
            "deskripsi"       => $deskripsi
        );

        $action = $this->Model_master->editMaster(array('id_product' => $id_product), "tbl_product", $data);
        if ($action) {
            $this->session->set_flashdata("success", "Berhasil mengubah product");
        } else {
            $this->session->set_flasdata("error", "Gagal, tidak dapat menyimpan product");
        }

        redirect("product");
    }

    public function delete_product(){
        $id_product  = $this->input->post("id_product");
        $_id = $this->db->get_where('tbl_product',['id_product' => $id_product])->row();
        $delete  = $this->Model_master->deleteMaster($id_product, "id_product", "tbl_product");

        if ($delete) {
            if($_id->gambar != ""){
                unlink("./file/dokumen/".$_id->gambar);
            }
            echo json_encode(array("status" => "success", "data" => $id_product, "message" => "Berhasil menghapus gambar"));

        } else {

            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus detail product.!!"));

        }
    }
}