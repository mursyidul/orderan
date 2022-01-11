<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_laporan_karyawan extends CI_Model {

    public function get_absensi($bulan, $user){
        $this->db->select('absensi.*');
        $this->db->from('tbl_absensi absensi');
        if($bulan!=""){
    		$this->db->where('MONTH(absensi.tanggal_masuk)',$bulan);
        }
        if($user!="all" && $user!=""){
            $this->db->where('absensi.id_user =', $user);
        }
        $this->db->order_by('absensi.id_absensi', "asc");
        return $this->db->get()->result_array();
    }

    // public function get_task_karyawan($id_user){
    // 	$this->db->select('task.*');
    // 	$this->db->from('tbl_task task');
    // 	$this->db->where("task.status_task", "COMPLETE");
    // }

    public function get_dikerjakan_karyawan($tanggal_masuk, $id_user){
        $hasil=$this->db->query(" SELECT COUNT(*) as jumlah_dikerjakan FROM ( SELECT COUNT(no_pesanan) FROM tbl_order where id_user = '$id_user' AND status_pesanan != 'Batal' AND DATE(tanggal_dikerjakan)= '$tanggal_masuk' GROUP BY no_pesanan ) dikerjakan");
        return $hasil->result_array();
    }

    public function get_cetak_karyawan($tanggal_masuk, $id_user){
        $hasil=$this->db->query(" SELECT COUNT(*) as jumlah_dicetak FROM ( SELECT COUNT(no_pesanan) FROM tbl_order where id_user = '$id_user' AND status_pesanan != 'Batal' AND DATE(tanggal_antri_cetak)= '$tanggal_masuk' GROUP BY no_pesanan ) cetak");
        return $hasil->result_array();
    }

    public function get_orderan_karyawan($tanggal_masuk){
        $hasil=$this->db->query(" SELECT COUNT(*) as jumlah_orderan FROM ( SELECT COUNT(no_pesanan) FROM tbl_order where status_pesanan != 'Batal' AND DATE(waktu_dibuat)= '$tanggal_masuk' GROUP BY no_pesanan ) orderan");
        return $hasil->result_array();
    }

    // SELECT COUNT(*) as jumlah_dikerjakan FROM ( SELECT COUNT(no_pesanan) FROM tbl_order where id_user = '3' AND status_pesanan != 'Batal' AND DATE(tanggal_dikerjakan)= '2021-12-02' GROUP BY no_pesanan ) produksi

}

