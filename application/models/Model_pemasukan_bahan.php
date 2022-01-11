<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_pemasukan_bahan extends CI_Model {

    public function get_pemasukan_bahan(){
        $this->db->select('pemasukan.*, bahan.jenis_bahan, supplier.nama_supplier');
        $this->db->from('tbl_pemasukan_bahan pemasukan');
        $this->db->join('tbl_bahan bahan', 'bahan.id_bahan=pemasukan.id_bahan', "left");
        $this->db->join('tbl_supplier supplier', 'supplier.id_supplier=pemasukan.id_supplier', "left");
        $this->db->order_by('pemasukan.id_pemasukan_bahan', "asc");
        return $this->db->get()->result();
    }

}

