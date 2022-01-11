<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_kerusakan extends CI_Model {

    public function get_kerusakan(){
        $this->db->select('kerusakan.*,kerusakan.id_kerusakan, user.full_name, bahan.jenis_bahan, kategori.nama_kategori, user.id_user');
        $this->db->from('tbl_kerusakan kerusakan');
        // $this->db->join('tbl_order order', 'order.no_pesanan=kerusakan.no_pesanan', "LEFT");
        $this->db->join('tbl_user user', 'user.id_user=kerusakan.id_user', "LEFT");
        $this->db->join('tbl_bahan bahan', 'bahan.id_bahan=kerusakan.id_bahan', "LEFT");
        $this->db->join('tbl_kategori kategori', "kategori.id_kategori=kerusakan.id_kategori", "LEFT");
        $this->db->order_by('kerusakan.id_kerusakan', "desc");
        return $this->db->get()->result();
    }

    public function get_user(){
        $this->db->select("user.*");
        $this->db->from('tbl_user user');
        $this->db->join('tbl_role role', 'role.id_role=user.id_role', "LEFT");
        $this->db->where("role.name_role !=", "USER");
        $this->db->order_by('user.full_name', "asc");
        return $this->db->get()->result();
    }

    public function get_no_pesanan(){
        $this->db->select("order.no_pesanan");
        $this->db->from("tbl_order order");
        $this->db->where("order.status_pesanan", "Perlu Dikirim");
        $this->db->group_by("order.no_pesanan");
        $this->db->order_by('order.no_pesanan', "asc");
        return $this->db->get()->result();
    }

    public function get_bahan_add($id){
        $this->db->select("bahan.*, kategori.*");
        $this->db->from("tbl_bahan bahan");
        $this->db->join("tbl_kategori kategori", "kategori.id_kategori=bahan.id_kategori", "LEFT");
        $this->db->where("kategori.id_kategori", $id);
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result_array();
        } else {
            return array();
        }
    }

    public function get_bahan_edit($id){
        $hasil=$this->db->query("SELECT * FROM tbl_bahan WHERE id_kategori='$id'");
        return $hasil->result();
    }

}

