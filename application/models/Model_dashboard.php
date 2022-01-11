<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_dashboard extends CI_Model {

    public function get_selesai(){
        $this->db->select("order.no_pesanan");
        $this->db->from("tbl_order order");
        $this->db->where("order.status_pesanan", "Selesai");
        $this->db->group_by("order.no_pesanan");
        return $this->db->get()->result_array();
    }
    public function get_batal(){
        $this->db->select("order.no_pesanan");
        $this->db->from("tbl_order order");
        $this->db->where("order.status_pesanan", "Batal");
        $this->db->group_by("order.no_pesanan");
        return $this->db->get()->result_array();
    }
    public function get_packing(){
        $this->db->select("order.no_pesanan");
        $this->db->from("tbl_order order");
        $this->db->where("order.status_kerjakan", "PACKING");
        $this->db->group_by("order.no_pesanan");
        return $this->db->get()->result_array();
    }
    public function get_antri_cetak(){
        $this->db->select("order.no_pesanan");
        $this->db->from("tbl_order order");
        $this->db->where("order.status_kerjakan", "ANTRI CETAK");
        $this->db->group_by("order.no_pesanan");
        return $this->db->get()->result_array();
    }

    public function isMasuk($id = null){
        if(isset($id)){
            $this->db->where("id_user", $id);
        }
        $this->db->select("*");
        $this->db->from("tbl_absensi");
        $this->db->where("status_absensi", "MASUK");
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result_array();
        } else {
            return false;
        }
    }
    public function isCekinHariIni($id = null){
        if(isset($id)){
            $this->db->where("id_user", $id);
        }
        $this->db->select("*");
        $this->db->from("tbl_absensi");
        $this->db->where("date(tanggal_masuk) =  date(NOW())");
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }
    public function report_list(){
        $this->db->select("absensi.*");
        $this->db->from("tbl_absensi absensi");
        $this->db->where("absensi.status_absensi", "MASUK");
        $this->db->where("absensi.id_user", $this->session->userdata('id_user'));
        $this->db->order_by("absensi.tanggal_masuk", "DESC");
        $query = $this->db->get();
        return $query->row();
    }
        // $this->db->where("date(absensi.tanggal_masuk) =  date(NOW())");
    // public function report_list(){
    //     $this->db->select("absensi.*, schadule.*, shift.jam_masuk");
    //     $this->db->from("tbl_absensi absensi");
    //     $this->db->join("tbl_schadule schadule", "schadule.id_user=absensi.id_user", "left");
    //     $this->db->join("tbl_shift shift", "shift.nama_shift=schadule.shift_kerja", "left");
    //     $this->db->where("absensi.status_absensi", "MASUK");
    //     $this->db->where("absensi.id_user", $this->session->userdata('id_user'));
    //     $this->db->where("date(schadule.tanggal) =  date(absensi.tanggal_masuk)");
    //     $this->db->order_by("absensi.tanggal_masuk", "DESC");
    //     $query = $this->db->get();
    //     return $query->row();

    //   }

    public function get_komplain(){
        $this->db->select("count(komplain.id_komplain) as jumlah_komplain");
        $this->db->from("tbl_komplain komplain");
        $this->db->order_by("komplain.id_komplain", "DESC");
        return $this->db->get()->row();
    }

    public function get_telat(){
        $this->db->select("count(absensi.id_absensi) as jumlah_telat");
        $this->db->from("tbl_absensi absensi");
        $this->db->where("absensi.status_jadwal", "Telat");
        $this->db->order_by("absensi.id_absensi", "DESC");
        return $this->db->get()->row();
    }

    public function get_absensi(){
        $this->db->select("count(absensi.id_absensi) as jumlah_salah");
        $this->db->from("tbl_absensi absensi");
        $this->db->where("absensi.edit_by", "1");
        $this->db->order_by("absensi.id_absensi", "DESC");
        return $this->db->get()->row();
    }

    public function get_cuti(){
        $this->db->select("count(cuti.id_cuti) as jumlah_cuti");
        $this->db->from("tbl_cuti cuti");
        // $this->db->join("tbl_jenis_cuti jenis", "jenis.id_jenis_cuti=cuti.id_jenis_cuti", "left");
        $this->db->where("cuti.id_jenis_cuti", "1");
        $this->db->or_where("cuti.id_jenis_cuti", "2");
        $this->db->order_by("cuti.id_cuti", "DESC");
        return $this->db->get()->row();
    }

}

