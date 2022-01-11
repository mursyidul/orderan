<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_operasional extends CI_Model {

    public function get_biaya($startdate, $enddate){
        $this->db->select('biaya.*, kategori.nama_kategori');
        $this->db->from('tbl_biaya_operasional biaya');
        $this->db->join('tbl_kategori_operasional kategori ', 'kategori.id_operasional=biaya.id_operasional', "left");
        if($startdate!=""){
            $this->db->where('DATE(biaya.tanggal) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(biaya.tanggal) <=', date('Y-m-d',strtotime($enddate)));
        }
        $this->db->order_by('biaya.id_biaya', "asc");
        return $this->db->get()->result();
    }

    public function get_pemasukan(){
        $this->db->select('pemasukan.*, kategori.nama_kategori');
        $this->db->from('tbl_pemasukan pemasukan');
        $this->db->join('tbl_kategori_operasional kategori ', 'kategori.id_operasional=pemasukan.id_operasional', "left");
        $this->db->order_by('pemasukan.id_pemasukan', "asc");
        return $this->db->get()->result();
    }

}

