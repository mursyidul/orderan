<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_orderan extends CI_Model {

    public function tambah_customer($insert_data){
        $this->db->insert_batch("tbl_customer", $insert_data);
        if($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_customer($update_data){
        $this->db->update_batch("tbl_customer", $update_data, 'wa_customer');
        if($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function tambah_orderan($insert_data){
        $this->db->insert_batch("tbl_order", $insert_data);
        if($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_orderan($update_data){
        $this->db->update_batch("tbl_order", $update_data, 'unique_key');
        if($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_orderan($unique_key){
        $this->db->select("order.*");
        $this->db->from("tbl_order order");
        $this->db->where("order.unique_key =", $unique_key);
        $this->db->order_by("order.id_orderan", "desc");
        return $this->db->get()->result();
    }

    public function get_bahan(){
        $id_bahan = array('8', '9', '10', '14', '15', '16');
        $this->db->select("bahan.*");
        $this->db->from("tbl_bahan bahan");
        $this->db->where_in('bahan.id_bahan', $id_bahan);
        $this->db->order_by("bahan.jenis_bahan", "asc");
        return $this->db->get()->result();
    }

    public function get_detail_orderan($no_pesanan){
        $this->db->select('order.no_pesanan, order.nama_penerima, order.waktu_dibuat, order.waktu_batas, order.nama_produk, order.no_telepon, order.status_kerjakan');
        $this->db->from("tbl_order order");
        $this->db->where("order.no_pesanan", $no_pesanan);
        $this->db->order_by("order.id_orderan", "DESC");
        return $this->db->get()->result_array();
    }

    public function get_pengeluaran_bahan($no_pesanan){
        $this->db->select('pengeluaran.*, bahan.jenis_bahan, user.full_name');
        $this->db->from("tbl_pengeluaran_bahan pengeluaran");
        $this->db->join("tbl_bahan bahan", "bahan.id_bahan=pengeluaran.id_bahan", "LEFT");
        $this->db->join("tbl_user user", "user.id_user=pengeluaran.id_user", "LEFT");
        $this->db->where("pengeluaran.no_pesanan", $no_pesanan);
        $this->db->order_by("pengeluaran.id_pengeluaran_bahan", "DESC");
        return $this->db->get()->result_array();
    }

    public function get_desain($no_pesanan){
        $this->db->select("desain.*, user.full_name");
        $this->db->from("tbl_upload_desain desain");
        $this->db->join("tbl_user user", "user.id_user=desain.id_user", "LEFT");
        $this->db->where("desain.no_pesanan", $no_pesanan);
        $this->db->order_by("desain.id_upload_gambar", "DESC");
        return $this->db->get()->result_array();
    }

    public function get_upload($no_pesanan = null){
        if (isset($no_pesanan)) {
            $this->db->where("no_pesanan", $no_pesanan);
        }
        $this->db->select("order.source, order.status_pesanan, order.no_pesanan, order.nomor_sku, order.opsi_pengiriman, order.username, order.nama_penerima, order.kota_kabupaten, order.waktu_batas, order.waktu_dibuat, order.status_pesanan, order.no_telepon, order.status_kerjakan, user.full_name, user.id_user, packing.full_name as user_packing, cetak.full_name as user_cetak, product.deskripsi");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_user user", "user.id_user=order.id_user", "LEFT");
        $this->db->join("tbl_user packing", "packing.id_user=order.id_user_packing", "LEFT");
        $this->db->join("tbl_user cetak", "cetak.id_user=order.id_user_cetak", "LEFT");
        $this->db->join("tbl_product product", "product.nmr_sku=order.nomor_sku", "LEFT");
        
        $this->db->group_start();
        $this->db->where("order.status_pesanan", "Perlu Dikirim");
        $this->db->where("order.status_kerjakan !=", "DIKIRIM");
        $this->db->where("order.status_kerjakan !=", "PACKING");
        $this->db->group_end();
        $this->db->or_group_start();
        $this->db->where("order.status_pesanan", "Sedang Dikirim");
        $this->db->where("order.status_kerjakan !=", "DIKIRIM");
        $this->db->where("order.status_kerjakan !=", "PACKING");
        $this->db->group_end();
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("order.id_orderan", "ASC");
        $this->db->group_by("order.no_pesanan");
        return $this->db->get()->result_array();
    }

    public function get_no_pesanan($no_pesanan){
        $this->db->select("order.id_orderan, order.status_pesanan, order.no_pesanan,order.nama_produk, order.nama_variasi, order.total_qty, order.nomor_sku, order.sku_induk");
        $this->db->from("tbl_order order");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->where("order.status_pesanan !=", "Batal");
        $this->db->where("order.status_pesanan !=", "Selesai");
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("order.id_orderan", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_jumlah_orderan($no_pesanan){
        $this->db->select("count(id_orderan) as jumlah");
        $this->db->from("tbl_order order");
        $this->db->where("no_pesanan", $no_pesanan);
        // $this->db->where("order.status_kerjakan !=", "PACKING");
        $this->db->where("order.status_pesanan !=", "Batal");
        $this->db->where("order.status_pesanan !=", "Selesai");
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("order.id_orderan", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_nomor_sku($nomor_sku, $id_orderan){
        $this->db->select("order.no_pesanan, order.status_pesanan, product.nmr_sku, product.gambar, product.deskripsi, order.nama_variasi, order.nama_produk, order.total_qty, order.nomor_sku, order.sku_induk");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_product product", "product.nmr_sku=order.sku_induk", "LEFT");
        // $this->db->group_start();
        // $this->db->where("order.status_pesanan", "Perlu Dikirim");
        // $this->db->group_end();
        // $this->db->or_group_start();
        // $this->db->where("order.status_pesanan", "Sedang Dikirim");
        // $this->db->group_end();
        $this->db->where("order.sku_induk", $nomor_sku);
        $this->db->where("order.id_orderan", $id_orderan);
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("product.id_product", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_nomor_sku_kosong($sku_kosong, $id_orderan){
        $this->db->select("product.nmr_sku, product.gambar, product.deskripsi, order.nama_variasi, order.nama_produk, order.total_qty, order.nomor_sku, order.id_orderan as orderan_kosong, order.sku_induk");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_product product", "product.nmr_sku=order.sku_induk", "LEFT");
        $this->db->where("order.sku_induk", $sku_kosong); 
        $this->db->where("order.id_orderan", $id_orderan); 
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("order.id_orderan", "ASC");
        return $this->db->get()->result_array();
    }

    // public function get_upload_orderan($no_pesanan = null){
    //     if (isset($no_pesanan)) {
    //         $this->db->where("no_pesanan", $no_pesanan);
    //     }
    //     $this->db->select("order.*, GROUP_CONCAT(order.nama_produk,'<br><b>Variasi : ',order.nama_variasi,'</b>','<br><b>Qty : ',order.total_qty,'</b>'  SEPARATOR '@$@') as list_produk");
    //     $this->db->from("tbl_order order");
    //     // $this->db->join("tbl_product product", "product.nmr_sku=order.nomor_sku");
    //     $this->db->where("order.status_pesanan !=", "Selesai");
    //     $this->db->where("order.status_kerjakan !=", "PACKING");
    //     // $this->db->where("order.no_resi !=","");
    //     // $this->db->where("order.status_point =", "");
    //     $this->db->order_by("order.id_orderan", "ASC");
    //     $this->db->group_by("order.no_pesanan");
    //     return $this->db->get()->result_array();
    // }

    // public function get_orderan_selesai($no_pesanan = null){
    //     if (isset($no_pesanan)) {
    //         $this->db->where("no_pesanan", $no_pesanan);
    //     }
    //     $this->db->select("order.*, GROUP_CONCAT(product.deskripsi,'<br><b>Variasi : ',order.nama_variasi,'</b>','<br><b>Qty : ',order.total_qty,'</b>'  SEPARATOR '@$@') as list_produk, sum(total_harga) as harga_total");
    //     $this->db->from("tbl_order order");
    //     $this->db->join("tbl_product product", "product.nmr_sku=order.nomor_sku");
    //     $this->db->where("order.status_pesanan =", "Selesai");
    //     // $this->db->where("order.status_point =", "");
    //     $this->db->order_by("order.id_orderan", "ASC");
    //     $this->db->group_by("order.no_pesanan");
    //     return $this->db->get()->result_array();
    // }

    public function change_status_batal_orderan($no_pesanan, $alasan_pembatalan){
        $this->db->set("alasan_pembatalan", $alasan_pembatalan);
        $this->db->set("status_pesanan", "Batal");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function change_status_reject($no_pesanan, $alasan){
        $this->db->set("status_point", "REJECT");
        $this->db->set("alasan", $alasan);
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function change_status_approve($no_pesanan){
        $this->db->set("status_point", "APPROVE");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function change_status_kerjakan($id_user, $no_pesanan, $created_date){
        $this->db->set("tanggal_dikerjakan", $created_date);
        $this->db->set("id_user", $id_user);
        $this->db->set("status_kerjakan", "DIKERJAKAN");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function change_status_desain($no_pesanan, $created_date){
        $this->db->set("tanggal_desain", $created_date);
        $this->db->set("status_kerjakan", "DESAIN");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function change_status_antri_cetak($no_pesanan, $created_date){
        $this->db->set("tanggal_antri_cetak", $created_date);
        $this->db->set("status_kerjakan", "ANTRI CETAK");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function change_status_cetak_diluar($no_pesanan, $created_date){
        $this->db->set("tanggal_cetak_diluar", $created_date);
        $this->db->set("status_kerjakan", "CETAK DILUAR");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function change_status_desain_selesai($no_pesanan, $created_date){
        $this->db->set("tanggal_antri_cetak", $created_date);
        $this->db->set("status_kerjakan", "ANTRI CETAK");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function change_status_cetak_selesai($no_pesanan, $created_date, $id_user_cetak){
        $this->db->set("tanggal_packing", $created_date);
        $this->db->set("id_user_cetak", $id_user_cetak);
        $this->db->set("status_kerjakan", "PACKING");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function change_status_sudah_order($no_pesanan, $created_date){
        $this->db->set("tanggal_menunggu_pengiriman", $created_date);
        $this->db->set("status_kerjakan", "MENUNGGU PENGIRIMAN");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function change_status_packing($no_pesanan, $created_date){
        $this->db->set("tanggal_packing", $created_date);
        $this->db->set("status_kerjakan", "PACKING");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->update("tbl_order");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function change_status_siap_kirim($update){
        $this->db->update_batch("tbl_order", $update, 'id_orderan');
        if($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_orderan_siap($no_pesanan = null){
        if (isset($no_pesanan)) {
            $this->db->where("no_pesanan", $no_pesanan);
        }
        $this->db->select("order.no_pesanan, order.source, order.nomor_sku, order.opsi_pengiriman, order.username, order.nama_penerima, order.kota_kabupaten, order.waktu_batas, order.waktu_dibuat, order.status_pesanan, order.status_kerjakan, user.full_name, user.id_user, cetak.full_name as user_cetak");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_user user", "user.id_user=order.id_user", "LEFT");
        $this->db->join("tbl_user cetak", "cetak.id_user=order.id_user_cetak", "LEFT");
        $this->db->where("order.status_pesanan !=", "Selesai");
        $this->db->where("order.status_pesanan !=", "Batal");
        $this->db->where("order.status_kerjakan", "PACKING");
        // $this->db->where("order.status_kerjakan", "DIKIRIM");
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("order.id_orderan", "ASC");
        $this->db->group_by("order.no_pesanan");
        return $this->db->get()->result_array();
    }

    public function get_no_pesanan_siap($no_pesanan){
        $this->db->select("order.id_orderan, order.no_pesanan, order.nama_produk, order.nama_variasi, order.total_qty, order.nomor_sku, order.sku_induk");
        $this->db->from("tbl_order order");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->where("order.status_pesanan !=", "Selesai");
        $this->db->where("order.status_pesanan !=", "Batal");
        $this->db->where("order.status_kerjakan", "PACKING");
        // $this->db->where("order.status_kerjakan", "DIKIRIM");
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("order.id_orderan", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_jumlah_orderan_siap($no_pesanan){
        $this->db->select("count(id_orderan) as jumlah");
        $this->db->from("tbl_order order");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->where("order.status_pesanan !=", "Selesai");
        $this->db->where("order.status_pesanan !=", "Batal");
        $this->db->where("order.status_kerjakan", "PACKING");
        // $this->db->where("order.status_kerjakan", "DIKIRIM");
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("order.id_orderan", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_nomor_sku_siap($nomor_sku, $id_orderan){
        $this->db->select("product.nmr_sku, product.gambar, product.deskripsi, order.nama_variasi, order.nama_produk, order.total_qty, order.nomor_sku, order.id_orderan as orderan_ada, order.sku_induk");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_product product", "product.nmr_sku=order.sku_induk", "LEFT");
        $this->db->where("order.sku_induk", $nomor_sku);
        $this->db->where("order.id_orderan", $id_orderan);
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("product.id_product", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_orderan_selesai($no_pesanan = null){
        if (isset($no_pesanan)) {
            $this->db->where("no_pesanan", $no_pesanan);
        }
        $this->db->select("order.no_pesanan, order.source, order.nomor_sku, order.opsi_pengiriman, order.username, order.nama_penerima, order.kota_kabupaten, order.waktu_batas, order.waktu_dibuat, order.status_pesanan, order.status_kerjakan, order.status_point, user.full_name, user.id_user, sum(order.total_harga) as harga_total, order.tanggal_dikerjakan, order.tanggal_desain, order.tanggal_antri_cetak, order.tanggal_cetak_diluar, order.tanggal_menunggu_pengiriman, order.tanggal_packing, order.tanggal_dikirim, packing.full_name as user_packing, cetak.full_name as user_cetak");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_user user", "user.id_user=order.id_user", "LEFT");
        $this->db->join("tbl_user cetak", "cetak.id_user=order.id_user_cetak", "LEFT");
        $this->db->join("tbl_user packing", "packing.id_user=order.id_user_packing", "LEFT");
        // if ($this->session->userdata('role') == 'DESAIN') {
        //     $this->db->where("order.id_user",$this->session->userdata('id_user'));
        // }
        // if ($this->session->userdata('role') == 'PRODUKSI') {
        //     $this->db->where("order.id_user_packing",$this->session->userdata('id_user'));
        // }
        $this->db->where("order.status_pesanan", "Selesai");
        // $this->db->where("order.status_kerjakan", "DIKIRIM");
        $this->db->order_by("order.status_point", "ASC");
        $this->db->order_by("order.id_orderan", "ASC");
        $this->db->group_by("order.no_pesanan");
        return $this->db->get()->result_array();
    }

    public function get_no_pesanan_selesai($no_pesanan){
        $this->db->select("order.id_orderan, order.no_pesanan, order.nama_produk, order.nama_variasi, order.total_qty, order.nomor_sku, order.sku_induk");
        $this->db->from("tbl_order order");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->where("order.status_pesanan", "Selesai");
        // $this->db->where("order.status_kerjakan", "DIKIRIM");
        $this->db->order_by("order.status_point", "ASC");
        $this->db->order_by("order.id_orderan", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_jumlah_orderan_selesai($no_pesanan){
        $this->db->select("count(id_orderan) as jumlah");
        $this->db->from("tbl_order order");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->where("order.status_pesanan", "Selesai");
        // $this->db->where("order.status_kerjakan", "DIKIRIM");
        $this->db->order_by("order.status_point", "ASC");
        $this->db->order_by("order.id_orderan", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_nomor_sku_selesai($nomor_sku, $id_orderan){
        $this->db->select("product.nmr_sku, product.gambar, product.deskripsi, order.nama_variasi, order.nama_produk, order.total_qty, order.nomor_sku, order.sku_induk");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_product product", "product.nmr_sku=order.sku_induk", "LEFT");
        $this->db->where("order.sku_induk", $nomor_sku);
        $this->db->where("order.id_orderan", $id_orderan);
        $this->db->order_by("order.status_point", "ASC");
        $this->db->order_by("product.id_product", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_jumlah_kerusakan($no_pesanan){
        $this->db->select('count(id_kerusakan) as jumlah_kerusakan');
        $this->db->from('tbl_kerusakan rusak');
        $this->db->where("rusak.no_pesanan", $no_pesanan);
        $this->db->order_by("rusak.id_kerusakan", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_orderan_batal($no_pesanan = null){
        if (isset($no_pesanan)) {
            $this->db->where("no_pesanan", $no_pesanan);
        }
        $this->db->select("order.no_pesanan, order.source, order.nomor_sku, order.opsi_pengiriman, order.username, order.nama_penerima, order.kota_kabupaten, order.waktu_batas, order.waktu_dibuat, order.status_pesanan, order.status_kerjakan, user.full_name, user.id_user, packing.full_name as user_packing, cetak.full_name as user_cetak");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_user user", "user.id_user=order.id_user", "LEFT");
        $this->db->join("tbl_user cetak", "cetak.id_user=order.id_user_cetak", "LEFT");
        $this->db->join("tbl_user packing", "packing.id_user=order.id_user_packing", "LEFT");
        $this->db->where("order.status_pesanan", "Batal");
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("order.id_orderan", "ASC");
        $this->db->group_by("order.no_pesanan");
        return $this->db->get()->result_array();
    }


    public function get_no_pesanan_batal($no_pesanan){
        $this->db->select("order.id_orderan, order.no_pesanan, order.nama_produk, order.nama_variasi, order.total_qty, order.nomor_sku, order.sku_induk");
        $this->db->from("tbl_order order");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->where("order.status_pesanan", "Batal");
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("order.id_orderan", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_jumlah_orderan_batal($no_pesanan){
        $this->db->select("count(id_orderan) as jumlah");
        $this->db->from("tbl_order order");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->where("order.status_pesanan", "Batal");
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("order.id_orderan", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_nomor_sku_batal($nomor_sku, $id_orderan){
        $this->db->select("product.nmr_sku, product.gambar, product.deskripsi, order.nama_variasi, order.nama_produk, order.total_qty, order.nomor_sku, order.sku_induk");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_product product", "product.nmr_sku=order.sku_induk", "LEFT");
        $this->db->where("order.sku_induk", $nomor_sku);
        $this->db->where("order.id_orderan", $id_orderan);
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("product.id_product", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_orderan_sedang($no_pesanan = null){
        if (isset($no_pesanan)) {
            $this->db->where("no_pesanan", $no_pesanan);
        }
        $this->db->select("order.no_pesanan, order.source, order.nomor_sku, order.opsi_pengiriman, order.username, order.nama_penerima, order.kota_kabupaten, order.waktu_batas, order.waktu_dibuat, order.status_pesanan, order.status_kerjakan, user.full_name, user.id_user, packing.full_name as user_packing, cetak.full_name as user_cetak");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_user user", "user.id_user=order.id_user", "LEFT");
        $this->db->join("tbl_user cetak", "cetak.id_user=order.id_user_cetak", "LEFT");
        $this->db->join("tbl_user packing", "packing.id_user=order.id_user_packing", "LEFT");
        $this->db->where("order.status_pesanan", "Sedang Dikirim");
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("order.id_orderan", "ASC");
        $this->db->group_by("order.no_pesanan");
        return $this->db->get()->result_array();
    }

    public function get_no_pesanan_sedang($no_pesanan){
        $this->db->select("order.id_orderan, order.no_pesanan, order.nama_produk, order.nama_variasi, order.total_qty, order.nomor_sku, order.sku_induk");
        $this->db->from("tbl_order order");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->where("order.status_pesanan", "Sedang Dikirim");
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("order.id_orderan", "ASC");
        return $this->db->get()->result_array();
    }
    
    public function get_jumlah_orderan_sedang($no_pesanan){
        $this->db->select("count(id_orderan) as jumlah");
        $this->db->from("tbl_order order");
        $this->db->where("no_pesanan", $no_pesanan);
        $this->db->where("order.status_pesanan", "Sedang Dikirim");
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("order.id_orderan", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_nomor_sku_sedang($nomor_sku, $id_orderan){
        $this->db->select("product.nmr_sku, product.gambar, product.deskripsi, order.nama_variasi, order.nama_produk, order.total_qty, order.nomor_sku, order.sku_induk");
        $this->db->from("tbl_order order");
        $this->db->join("tbl_product product", "product.nmr_sku=order.sku_induk", "LEFT");
        $this->db->where("order.sku_induk", $nomor_sku);
        $this->db->where("order.id_orderan", $id_orderan);
        $this->db->order_by("order.status_kerjakan", "DESC");
        $this->db->order_by("product.id_product", "ASC");
        return $this->db->get()->result_array();
    }

    public function get_kerusakan($no_pesanan){
        $this->db->select("kerusakan.*,kerusakan.id_kerusakan, user.full_name, bahan.jenis_bahan, kategori.nama_kategori, user.id_user");
        $this->db->from("tbl_kerusakan kerusakan");
        $this->db->join("tbl_bahan bahan", "bahan.id_bahan=kerusakan.id_bahan", "LEFT");
        $this->db->join("tbl_kategori kategori", "kategori.id_kategori=kerusakan.id_kategori", "LEFT");
        $this->db->join("tbl_user user", "user.id_user=kerusakan.id_user", "LEFT");
        $this->db->where("kerusakan.no_pesanan", $no_pesanan);
        $this->db->order_by("kerusakan.id_kerusakan", "DESC");
        return $this->db->get()->result();

    }

}