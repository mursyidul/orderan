<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_cuti extends CI_Model {

    public function get_cuti(){
        $this->db->select('cuti.*, jenis_cuti.jenis_cuti, jenis_cuti.id_jenis_cuti');
        $this->db->from('tbl_cuti cuti');
        $this->db->join('tbl_jenis_cuti jenis_cuti', 'jenis_cuti.id_jenis_cuti=cuti.id_jenis_cuti', "left");
        $this->db->where("cuti.id_user", $this->session->userdata('id_user'));
        $this->db->order_by('cuti.id_cuti', "desc");
        return $this->db->get()->result_array();
    }

    public function get_user(){
        $this->db->select("");
        $this->db->from("tbl_user user");
        $this->db->where("user.id_role !=", 2);
        $this->db->order_by("user.full_name", "asc");
        return $this->db->get()->result();
    }

    public function get_cuti_admin($id, $startdate, $enddate, $user, $jenis_cuti){
        $this->db->select("cuti.*, jenis_cuti.*, user.full_name");
        $this->db->from("tbl_cuti cuti");
        $this->db->join("tbl_jenis_cuti jenis_cuti", "jenis_cuti.id_jenis_cuti = cuti.id_jenis_cuti", "LEFT");
        $this->db->join("tbl_user user", "user.id_user = cuti.id_user", "LEFT");
        if($startdate!=""){
            $this->db->where('DATE(cuti.created_date) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(cuti.created_date) <=', date('Y-m-d',strtotime($enddate)));
        }
        
        if($user!="all" && $user!=""){
            $this->db->where('cuti.id_user =', $user);
        }
        
        if($jenis_cuti!="all" && $jenis_cuti!=""){
            $this->db->where('cuti.id_jenis_cuti =', $jenis_cuti);
        }
        if($id!=""){
            $this->db->where('cuti.id_cuti =', $id);
        }
        $this->db->order_by("cuti.id_cuti", "desc");
        return $this->db->get()->result();
    }

    public function reject_cuti($id_cuti){
        $this->db->set("status_cuti", "REJECT");
        $this->db->where("id_cuti", $id_cuti);
        $this->db->update("tbl_cuti");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function approve_cuti($id_cuti){
        $this->db->set("status_cuti", "APPROVE");
        $this->db->where("id_cuti", $id_cuti);
        $this->db->update("tbl_cuti");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function add_cuti($data){
        $this->db->insert("tbl_cuti", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function add_notifikasi($data){
        $this->db->insert("tbl_notifikasi", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function get_id_admin(){
        $this->db->select('GROUP_CONCAT(id_user) as list_id');
        $this->db->from('tbl_user u');
        $this->db->join('tbl_role r','r.id_role = u.id_role','LEFT');
        $this->db->where('r.name_role','ADMIN');
        return $this->db->get()->result();
    }

    public function read_notifikasi($where){
        $this->db->where($where);
        $this->db->update('tbl_notifikasi', array('is_seen' => 1));
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function get_transaksi($id_cuti){
        $this->db->select('*');
        $this->db->from('tbl_notifikasi');
        $this->db->where('is_seen', "0");
        $this->db->where('ke', $this->session->userdata("id_user"));
        $this->db->where('id_transaksi', $id_cuti);
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result_array();
        } else {
            return array();
        }
    }

    public function change_is_seen($id_cuti){
        $this->db->set("is_seen", "1");
        $this->db->where("id_transaksi", $id_cuti);
        $this->db->update("tbl_notifikasi");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}

