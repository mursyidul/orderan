<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_komplain extends CI_Model {

    public function get_komplain(){
        $this->db->select('komplain.*, product.deskripsi, user.full_name, kategori.nama_kategori');
        $this->db->from('tbl_komplain komplain');
        $this->db->join('tbl_product product', 'product.id_product=komplain.id_product', "left");
        $this->db->join('tbl_user user', 'user.id_user=komplain.id_user', "left");
        $this->db->join('tbl_kategori kategori', 'kategori.id_kategori=komplain.id_kategori', "left");
        $this->db->order_by('komplain.id_komplain', "asc");
        return $this->db->get()->result();
    }

    public function get_user(){
    	$this->db->select('user.*');
    	$this->db->from('tbl_user user');
    	$this->db->where('user.id_role !=', "2");
    	$this->db->order_by('user.full_name', 'asc');
    	return $this->db->get()->result();
    }

}

