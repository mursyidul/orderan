<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_transaksi extends CI_Model {

    public function get_sub_variasi($id){
        $hasil=$this->db->query("SELECT tbl_variasi.*, tbl_product.deskripsi FROM tbl_variasi INNER JOIN tbl_product ON tbl_product.id_product=tbl_variasi.id_produk WHERE tbl_variasi.id_produk='$id'");
        return $hasil->result();
    }

    public function get_no_pesanan_draft(){
        $hasil = $this->db->query("SELECT max(no_pesanan) as last FROM tbl_order WHERE source = 'STORE'");
        return $hasil->result();
    }

    public function get_nama_produk($id){
        $hasil=$this->db->query("SELECT tbl_product.deskripsi, tbl_product.nmr_sku FROM tbl_product WHERE tbl_product.id_product='$id'");
        return $hasil->result();
    }

    public function get_nama_variasi($id){
        $hasil=$this->db->query("SELECT tbl_variasi.nama_variasi, tbl_variasi.harga_variasi FROM tbl_variasi WHERE tbl_variasi.id_variasi='$id'");
        return $hasil->result();
    }

    public function get_transaksi($id = null){
        if(isset($id)){
            $this->db->where("id_orderan", $id);
        }
        $this->db->select("order.id_orderan, order.source, order.no_pesanan, order.status_pesanan, produk.deskripsi as nama_produk, order.sku_induk, variasi.nama_variasi as nama_variasi, order.harga_awal, order.total_qty, order.total_harga, order.catatan_pembeli, order.waktu_dibuat, produk.id_product as id_produk, variasi.id_variasi, order.waktu_pembayaran, order.harga_awal as harga_variasi");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_product produk", "produk.id_product=order.id_produk", "LEFT");
        $this->db->join("tbl_variasi variasi", "variasi.id_variasi=order.id_variasi", "LEFT");
        $this->db->where('order.status_pesanan', 'Draft');
        $this->db->where('order.source', 'STORE');
        $this->db->order_by("id_orderan", "desc");
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result();
        } else {
            return false;
        }
    }

    public function get_transaksi_edit($no_pesanan){
        $this->db->select("order.id_orderan, order.source, order.no_pesanan, order.status_pesanan, order.nama_produk, order.sku_induk, order.nama_variasi, order.harga_awal, order.total_qty, order.total_harga, order.catatan_pembeli, order.waktu_dibuat, produk.id_product as id_produk, variasi.id_variasi, order.waktu_pembayaran, order.harga_awal as harga_variasi");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_product produk", "produk.id_product=order.id_produk", "LEFT");
        $this->db->join("tbl_variasi variasi", "variasi.id_variasi=order.id_variasi", "LEFT");
        $this->db->where('order.no_pesanan', $no_pesanan);
        $this->db->where('order.source', 'STORE');
        $this->db->order_by("id_orderan", "desc");
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result();
        } else {
            return false;
        }
    }

    public function get_transaksi_edit_perpesanan($id_orderan){
        $this->db->select("order.id_orderan, order.source, order.no_pesanan, order.status_pesanan, order.nama_produk, order.sku_induk, order.nama_variasi, order.harga_awal, order.total_qty, order.total_harga, order.catatan_pembeli, order.waktu_dibuat, produk.id_product as id_produk, variasi.id_variasi, order.waktu_pembayaran, order.harga_awal as harga_variasi");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_product produk", "produk.id_product=order.id_produk", "LEFT");
        $this->db->join("tbl_variasi variasi", "variasi.id_variasi=order.id_variasi", "LEFT");
        $this->db->where('order.id_orderan', $id_orderan);
        $this->db->where('order.source', 'STORE');
        $this->db->order_by("id_orderan", "desc");
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result();
        } else {
            return false;
        }
    }

    public function get_total_tagihan(){
        $this->db->select("sum(order.total_harga) as total_harga, sum(total_qty) as total_qty");
        $this->db->from("tbl_order order");
        $this->db->where("order.status_pesanan", "Draft");
        $this->db->where("order.source", "STORE");
        $this->db->order_by("id_orderan", "desc");
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else {
            return false;
        }
    }

    public function get_jumlah_orderan($no_pesanan){
        $this->db->select("count(order.id_orderan) as jumlah_orderan");
        $this->db->from("tbl_order order");
        $this->db->where("order.no_pesanan", $no_pesanan);
        $this->db->order_by("id_orderan", "desc");
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else {
            return false;
        }
    }

    public function get_pembayaran($no_pesanan){
        $this->db->select("order.no_pesanan, produk.deskripsi as nama_produk, variasi.nama_variasi as nama_variasi, order.harga_awal, order.total_qty, order.total_harga, order.waktu_dibuat, invoice.total_biaya, invoice.diskon, invoice.potongan_harga");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_product produk", "produk.id_product=order.nama_produk", "LEFT");
        $this->db->join("tbl_variasi variasi", "variasi.id_variasi=order.nama_variasi", "LEFT");
        $this->db->join("tbl_invoice invoice", "invoice.no_pesanan=order.no_pesanan", "LEFT");
        $this->db->where("order.no_pesanan", $no_pesanan);
        $this->db->order_by("order.id_orderan", "desc");
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else {
            return false;
        }
    }

    public function get_list_transaksi($startdate, $enddate, $customer){
        $this->db->select("order.nama_penerima, order.status_pesanan, invoice.*");
        $this->db->from("tbl_invoice invoice");
        $this->db->join("tbl_order order", "order.no_pesanan=invoice.no_pesanan", "left");
        $this->db->join("tbl_pembayaran pembayaran", "pembayaran.no_pesanan=invoice.no_pesanan", "left");
        $this->db->where("order.source", "STORE");
        if($startdate!=""){
            $this->db->where('DATE(invoice.waktu_dibuat) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(invoice.waktu_dibuat) <=', date('Y-m-d',strtotime($enddate)));
        }
        if($customer!="all" && $customer!=""){
            $this->db->where('order.nama_penerima =', $customer);
        }
        // $this->db->where("invoice");
        $this->db->group_by("invoice.no_pesanan");
        $this->db->order_by("invoice.no_pesanan", "desc");
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }

    public function get_total_pembayaran($no_pesanan){
        $this->db->select("sum(pembayaran.jumlah_pembayaran) as jumlah_pembayaran");
        $this->db->from('tbl_pembayaran pembayaran');
        $this->db->where("pembayaran.no_pesanan", $no_pesanan);
        
        $this->db->order_by("pembayaran.no_pesanan", "desc");
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }

    public function detail_transaksi($no_pesanan){
        $this->db->select("order.no_pesanan, order.harga_awal, order.total_qty, order.total_harga, order.nama_produk, order.nama_variasi");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_product product", "product.id_product=order.id_produk", "LEFT");
        $this->db->join("tbl_variasi variasi", "variasi.id_variasi=order.id_variasi", "LEFT");
        $this->db->where("order.no_pesanan", $no_pesanan);
        $this->db->order_by("order.id_orderan", "desc");
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }

    public function get_detail_transaksi($no_pesanan){
        $this->db->select("order.nama_penerima, order.nama_produk, order.nama_variasi, order.no_telepon, order.alamat_pengiriman, invoice.waktu_dibuat, invoice.tanggal_deadline, invoice.*, user.full_name");
        $this->db->from("tbl_invoice invoice");
        $this->db->join("tbl_order order", "order.no_pesanan=invoice.no_pesanan", "left");
        $this->db->join("tbl_pembayaran pembayaran", "pembayaran.no_pesanan=invoice.no_pesanan", "left");
        $this->db->join("tbl_user user", "user.id_user=pembayaran.id_user", "LEFT");
        $this->db->where("order.source", "STORE");
        $this->db->where("invoice.no_pesanan", $no_pesanan);
        $this->db->group_by("invoice.no_pesanan");
        $this->db->order_by("invoice.no_pesanan", "desc");
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }

    public function get_edit_pembayaran($no_pesanan){
        $this->db->select("sum(pembayaran.jumlah_pembayaran) as jumlah_pembayaran");
        $this->db->from("tbl_pembayaran pembayaran");
        $this->db->where("pembayaran.no_pesanan", $no_pesanan);
        $this->db->order_by("pembayaran.id_pembayaran", "desc");
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else {
            return false;
        }
    }

    public function get_edit_orderan($no_pesanan){
        $this->db->select("sum(order.total_qty) as total_qty, sum(order.total_harga) as total_harga");
        $this->db->from("tbl_order order");
        $this->db->where("order.no_pesanan", $no_pesanan);
        $this->db->order_by("order.id_orderan", "desc");
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else {
            return false;
        }
    }

    public function batal_transaksi($no_pesanan){
        $this->db->set("status_pesanan", "Batal");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function selesai_transaksi($no_pesanan){
        $this->db->set("status_pesanan", "Selesai");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function sedang_transaksi($no_pesanan){
        $this->db->set("status_pesanan", "Sedang Dikirim");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}

