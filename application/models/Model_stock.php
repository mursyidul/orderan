<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_stock extends CI_Model {

    public function get_stock(){
        $this->db->select('stock.*, bahan.jenis_bahan');
        $this->db->from('tbl_stock stock');
        $this->db->join('tbl_bahan bahan', 'bahan.id_bahan=stock.id_bahan', "left");
        $this->db->order_by('stock.id_stock', "asc");
        return $this->db->get()->result();
    }

}

