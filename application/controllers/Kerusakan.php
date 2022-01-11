<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Kerusakan extends CI_Controller {



    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");
        $this->load->model("Model_kerusakan");

    }

    public function index() {
        $data['kerusakan'] = $this->Model_kerusakan->get_kerusakan();
        $data['bahan']     = $this->Model_master->getMasterOneTable("*", "tbl_bahan", "jenis_bahan", "asc", "");
        // echo "<pre>", print_r($data['bahan'], 1), "</pre>";
        $data['kategori']  = $this->Model_master->getMasterOneTable("*", "tbl_kategori", "nama_kategori", "asc", "");
        $data['user']      = $this->Model_kerusakan->get_user();
        $data['no_pesanan']= $this->Model_kerusakan->get_no_pesanan();
        // echo "<pre>", print_r($data['no_pesanan'], 1), "</pre>";
        // echo $this->db->last_query();
    	$this->template->load("template", "kerusakan/data-kerusakan", $data);

    }

    public function tambah(){
    	$id_user          = $this->input->post("id_user");
        $id_bahan         = $this->input->post("id_bahan");
        $id_kategori      = $this->input->post("id_kategori");
        $status_bahan     = $this->input->post("status_bahan");
        $no_pesanan       = $this->input->post("no_pesanan");
        $sebab_kerusakan  = $this->input->post("sebab_kerusakan");
        $jumlah_kerusakan = $this->input->post("jumlah_kerusakan");
        $created_date     = date("Y-m-d H:i:s");
        $bahan = $this->db->get_where("tbl_bahan", ['id_bahan' => $id_bahan])->row();
        echo $this->db->last_query();
        if ($status_bahan == "belum cetak") {
            $total_harga = $bahan->harga_kertas * $jumlah_kerusakan;
        } else {
            $total_harga = $bahan->harga_cetak * $jumlah_kerusakan;
        }

        $data = array(
            "id_user"           => $id_user,
            "id_bahan"          => $id_bahan,
            "id_kategori"       => $id_kategori,
            "no_pesanan"        => $no_pesanan,
            "status_bahan"      => $status_bahan,
            "sebab_kerusakan"   => $sebab_kerusakan,
            "jumlah_kerusakan"  => $jumlah_kerusakan,
            "created_date"      => $created_date,
            "total_harga"       => $total_harga
        );
        // echo "<pre>", print_r($data, 1), "</pre>";
    	$action = $this->Model_master->tambahMaster("tbl_kerusakan", $data);

        if ($action) {
            $this->session->set_flashdata("success", "Berhasil Menambahkan Kerusakan Orderan");

            $stock = $this->db->get_where('tbl_stock', ['id_bahan' => $id_bahan])->row();
            if (isset($stock->id_bahan)) {
                // echo "update";
                $total = $stock->jumlah_stock - $jumlah_kerusakan;
                $edit_stock = array(
                        'id_bahan'     => $id_bahan,
                        'jumlah_stock' => $total
                        );

                $this->db->where('id_stock', $stock->id_stock);
                $this->db->update('tbl_stock', $edit_stock);
            }
        } else {
            $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan Kerusakan Orderan");
        }
    	redirect('kerusakan');
    }

    public function edit(){
        $id_kerusakan     = $this->input->post("id_kerusakan");
        $id_bahan         = $this->input->post("id_bahan");
        $id_kategori      = $this->input->post("id_kategori");
        $status_bahan     = $this->input->post("status_bahan");
        $sebab_kerusakan  = $this->input->post("sebab_kerusakan");
        $jumlah_kerusakan = $this->input->post("jumlah_kerusakan");
        $bahan = $this->db->get_where("tbl_bahan", ['id_bahan' => $id_bahan])->row();
        if ($status_bahan == "belum cetak") {
            $total_harga  = $bahan->harga_kertas * $jumlah_kerusakan;
        } else {
            $total_harga  = $bahan->harga_cetak * $jumlah_kerusakan;
        }

        $data = array(
            "id_bahan"          => $id_bahan,
            "id_kategori"       => $id_kategori,
            "sebab_kerusakan"   => $sebab_kerusakan,
            "status_bahan"      => $status_bahan,
            "jumlah_kerusakan"  => $jumlah_kerusakan,
            "total_harga"       => $total_harga
        );
        $action = $this->Model_master->editMaster(array('id_kerusakan' => $id_kerusakan), "tbl_kerusakan", $data);

        if ($action) {
            $this->session->set_flashdata("success", "Berhasil Mengubah Kerusakan Orderan");
        } else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah kerusakan orderan");
        }
        redirect("kerusakan");
    }

    public function delete_kerusakan(){
        $id_kerusakan       = $this->input->post("id_kerusakan");
        $id_bahan           = $this->input->post("id_bahan");
        $jumlah_kerusakan   = $this->input->post("jumlah_kerusakan");
        $delete         = $this->Model_master->deleteMaster($id_kerusakan, "id_kerusakan", "tbl_kerusakan");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_kerusakan, "message"  => "Berhasil menghapus kerusakan"));
            $stock = $this->db->get_where('tbl_stock', ['id_bahan' => $id_bahan])->row();
            $total = $stock->jumlah_stock + $jumlah_kerusakan;
            $edit_stock = array(
                        'id_bahan'     => $id_bahan,
                        'jumlah_stock' => $total
                        );

            $this->db->where('id_stock', $stock->id_stock);
            $this->db->update('tbl_stock', $edit_stock);
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus kerusakan"));
         }
    }

    public function get_bahan_add(){
        $id                         = $this->input->post('id');
        $data                       = $this->Model_kerusakan->get_bahan_add($id);
        echo json_encode($data);
    }

    public function get_bahan_edit(){
        $id                         = $this->input->post('id');
        $data                       = $this->Model_kerusakan->get_bahan_edit($id);
        echo json_encode($data);
    }
}