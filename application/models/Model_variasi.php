<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_variasi extends CI_Model {

    public function get_variasi(){
        $this->db->select('variasi.*, product.deskripsi');
        $this->db->from('tbl_variasi variasi');
        $this->db->join('tbl_product product', 'product.id_product=variasi.id_produk', "left");
        $this->db->order_by('variasi.id_variasi', "asc");
        return $this->db->get()->result();
    }

}

