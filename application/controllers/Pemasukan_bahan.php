<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pemasukan_bahan extends CI_Controller {



    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");
        $this->load->model("Model_pemasukan_bahan");

    }

    public function index() {
        $data['pemasukan_bahan'] = $this->Model_pemasukan_bahan->get_pemasukan_bahan();
        $data['bahan']     = $this->Model_master->getMasterOneTable("*", "tbl_bahan", "jenis_bahan", "asc", "");
        // echo "<pre>", print_r($data['bahan'], 1), "</pre>";
        $data['supplier']  = $this->Model_master->getMasterOneTable("*", "tbl_supplier", "nama_supplier", "asc", "");
        // echo "<pre>", print_r($data['no_pesanan'], 1), "</pre>";
        // echo $this->db->last_query();
    	$this->template->load("template", "pemasukan bahan/data-pemasukan_bahan", $data);

    }

    public function tambah(){
        $id_bahan         = $this->input->post("id_bahan");
        $id_supplier      = $this->input->post("id_supplier");
        $jumlah           = $this->input->post("jumlah");
        $harga_satuan     = $this->input->post("harga_satuan");
        $harga_total      = $this->input->post("harga_total");
        $tanggal_beli     = $this->input->post("tanggal_beli");
        $deskripsi        = $this->input->post("deskripsi");
        $created_date     = date("Y-m-d H:i:s");

        $data = array(
            "id_bahan"          => $id_bahan,
            "id_supplier"       => $id_supplier,
            "jumlah"            => $jumlah,
            "harga_satuan"      => $harga_satuan,
            "harga_total"       => $harga_total,
            "created_date"      => $created_date,
            "deskripsi"         => $deskripsi,
            "tanggal_beli"      => date("Y-m-d", strtotime(str_replace("/", "-", $tanggal_beli)))
        );

    	$action = $this->Model_master->tambahMaster("tbl_pemasukan_bahan", $data);

        if ($action) {
            $this->session->set_flashdata("success", "Berhasil Menambahkan pemasukan bahan");

            $stock = $this->db->get_where('tbl_stock', ['id_bahan' => $id_bahan])->row();
            if (isset($stock->id_bahan)) {
                // echo "update";
                $total = $jumlah + $stock->jumlah_stock;
                $edit_stock = array(
                        'id_bahan'     => $id_bahan,
                        'jumlah_stock' => $total
                        );

                $this->db->where('id_stock', $stock->id_stock);
                $this->db->update('tbl_stock', $edit_stock);
            } else {
                // echo "insert";
                $tambah_stock = array(
                        'id_bahan'      => $id_bahan,
                        'jumlah_stock'  => $jumlah
                );

                $this->db->insert('tbl_stock', $tambah_stock);
            }
        } else {
            $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan pemasukan bahan");
        }
    	redirect('pemasukan_bahan');
    }

    public function edit(){
        $id_pemasukan_bahan = $this->input->post("id_pemasukan_bahan");
        $id_bahan           = $this->input->post("id_bahan");
        $id_supplier        = $this->input->post("id_supplier");
        $jumlah             = $this->input->post("jumlah");
        $harga_satuan       = $this->input->post("harga_satuan");
        $harga_total        = $this->input->post("harga_total");
        $tanggal_beli       = $this->input->post("tanggal_beli");

        $data = array(
            "id_bahan"      => $id_bahan,
            "id_supplier"   => $id_supplier,
            "jumlah"        => $jumlah,
            "harga_satuan"  => $harga_satuan,
            "harga_total"   => $harga_total,
            "tanggal_beli"  => date("Y-m-d", strtotime(str_replace("/", "-", $tanggal_beli)))
        );
        $action = $this->Model_master->editMaster(array('id_pemasukan_bahan' => $id_pemasukan_bahan), "tbl_pemasukan_bahan", $data);

        if ($action) {
            $this->session->set_flashdata("success", "Berhasil Mengubah pemasukan bahan");
            $stock = $this->db->get_where('tbl_stock', ['id_bahan' => $id_bahan])->row();
            if (isset($stock->id_bahan)) {
                // echo "update";
                $total = $jumlah + $stock->jumlah_stock;
                $edit_stock = array(
                        'id_bahan'     => $id_bahan,
                        'jumlah_stock' => $total
                        );

                $this->db->where('id_stock', $stock->id_stock);
                $this->db->update('tbl_stock', $edit_stock);
            } else {
                $tambah_stock = array(
                        'id_bahan'      => $id_bahan,
                        'jumlah_stock'  => $jumlah_stock
                );

                $this->db->insert('tbl_stock', $tambah_stock);
            }
        } else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah pemasukan bahan");
        }
        redirect("pemasukan_bahan");
    }

    public function delete_pemasukan_bahan(){
        $id_pemasukan_bahan   = $this->input->post("id_pemasukan_bahan");
        $id_bahan             = $this->input->post("id_bahan");
        $jumlah               = $this->input->post("jumlah");
        $delete         = $this->Model_master->deleteMaster($id_pemasukan_bahan, "id_pemasukan_bahan", "tbl_pemasukan_bahan");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_pemasukan_bahan, "message"  => "Berhasil menghapus pemasukan bahan"));
            
            $stock = $this->db->get_where('tbl_stock', ['id_bahan' => $id_bahan])->row();
            $total = $stock->jumlah_stock - $jumlah;
            $edit_stock = array(
                        'id_bahan'     => $id_bahan,
                        'jumlah_stock' => $total
                        );

            $this->db->where('id_stock', $stock->id_stock);
            $this->db->update('tbl_stock', $edit_stock);
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus pemasukan bahan"));
         }
    }
}