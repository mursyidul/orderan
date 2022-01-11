<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_point extends CI_Model {

    public function check_existing_name($column, $value){

            $this->db->select("id_total_point, username, jumlah_point");

            $this->db->from("tbl_total_point");

            $this->db->where($column, $value);

            $data = $this->db->get();

            if($data->num_rows() > 0){

                return $data->result();

            } else {

                return false;

            }

    }



    public function check_data_exist($table, $data){

        $this->db->select("*");

        $data = $this->db->get_where($table, $data);

        if($data->num_rows() > 0){

            return true;

        } else {

            return false;

        }

    }

    public function get_point(){
        $this->db->select("point.*, sum(point.jumlah_point) as jumlah_point");
        $this->db->from("tbl_point point");
        $this->db->group_by("point.no_pesanan");
        return $this->db->get()->result();
    }

    public function get_detail_point($username){
        if (isset($username)) {
            $this->db->where("point.username", $username);
        }
        $this->db->select('*');
        $this->db->from('tbl_point point');
        return $this->db->get()->result();

    }

    public function get_point_username($username){
        if (isset($username)) {
            $this->db->where("total.username", $username);
        }

        $this->db->select('*');
        $this->db->from('tbl_total_point total');
        return $this->db->get()->row();
    }

    public function get_tukar_hadiah(){
        $this->db->select('point.*, tukar.tukar_point');
        $this->db->from('tbl_detail_point point');
        $this->db->join('tbl_tukar_point tukar', 'tukar.id_tukar_point=point.id_tukar_point', "left");
        $this->db->order_by('point.id_tukar_point', "asc");
        return $this->db->get()->result();
    }

}

