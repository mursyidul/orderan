<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_absensi extends CI_Model {

    public function get_absensi(){
        $this->db->select('absensi.*, timediff(absensi.tanggal_keluar, absensi.tanggal_masuk) as durasi_kerja, user.full_name');
        $this->db->from('tbl_absensi absensi');
        $this->db->join('tbl_user user', 'user.id_user=absensi.id_user', "left");
        $this->db->where("absensi.id_user", $this->session->userdata('id_user'));
        $this->db->order_by('absensi.id_absensi', "desc");
        return $this->db->get()->result();
    }
    public function get_absensi_admin($id, $startdate, $enddate, $user){
        $this->db->select('absensi.*, timediff(absensi.tanggal_keluar, absensi.tanggal_masuk) as durasi_kerja, user.full_name');
        $this->db->from('tbl_absensi absensi');
        $this->db->join('tbl_user user', 'user.id_user=absensi.id_user', "left");
        if($startdate!=""){
            $this->db->where('DATE(absensi.created_date) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(absensi.created_date) <=', date('Y-m-d',strtotime($enddate)));
        }
        if($user!="all" && $user!=""){
            $this->db->where('absensi.id_user =', $user);
        }
        if($id!=""){
            $this->db->where('absensi.id_absensi =', $id);
        }
        $this->db->order_by('absensi.id_absensi', "desc");
        return $this->db->get()->result();
    }
    public function get_user(){
        $this->db->select("");
        $this->db->from("tbl_user user");
        $this->db->where("user.id_role !=", 2);
        $this->db->where("user.id_role !=", 1);
        $this->db->order_by("user.full_name", "asc");
        return $this->db->get()->result();
    }
    public function get_user_array(){
        $this->db->select("");
        $this->db->from("tbl_user user");
        $this->db->where("user.id_role !=", 2);
        $this->db->where("user.id_role !=", 1);
        $this->db->order_by("user.id_user", "asc");
        return $this->db->get()->result_array();
    }

    public function get_durasi_peruser($id_user, $startdate, $enddate){
        $this->db->select('absensi.*, SEC_TO_TIME(sum(TIME_TO_SEC(timediff(absensi.tanggal_keluar, absensi.tanggal_masuk)))) as durasi_kerja, user.full_name');
        $this->db->from('tbl_absensi absensi');
        $this->db->join('tbl_user user', 'user.id_user=absensi.id_user', "left");
        if($startdate!=""){
            $this->db->where('DATE(absensi.created_date) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(absensi.created_date) <=', date('Y-m-d',strtotime($enddate)));
        }
        if($id_user!=""){
            $this->db->where('absensi.id_user =', $id_user);
        }
        $this->db->where('absensi.status_absensi', "KELUAR");
        $this->db->order_by('absensi.id_absensi', "desc");
        return $this->db->get()->result_array();
    }

    public function get_schadule(){
        $this->db->select('schadule.*, shift.jam_masuk');
        $this->db->from('tbl_schadule schadule');
        $this->db->join('tbl_shift shift', 'shift.nama_shift=schadule.shift_kerja', 'left');
        $this->db->where('schadule.id_user', $this->session->userdata('id_user'));
        $this->db->where('date(tanggal) =  date(NOW())');
        $this->db->where('schadule.shift_kerja !=', 'OFF');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_schadule_admin($id_user){
        $this->db->select('schadule.*, shift.jam_masuk');
        $this->db->from('tbl_schadule schadule');
        $this->db->join('tbl_shift shift', 'shift.nama_shift=schadule.shift_kerja', 'left');
        $this->db->where('schadule.id_user', $id_user);
        $this->db->where('schadule.shift_kerja !=', 'OFF');
        $this->db->where('date(tanggal) =  date(NOW())');
        $query = $this->db->get();
        return $query->row();
    }

    // SELECT `absensi`.*, SEC_TO_TIME(sum(TIME_TO_SEC(timediff(absensi.tanggal_keluar, absensi.tanggal_masuk)))) as durasi_kerja, `user`.`full_name` FROM `tbl_absensi` `absensi` LEFT JOIN `tbl_user` `user` ON `user`.`id_user`=`absensi`.`id_user` WHERE DATE(absensi.created_date) >= '2021-10-17' AND DATE(absensi.created_date) <= '2021-11-17' GROUP BY absensi.id_user ORDER BY `absensi`.`id_absensi` DESC

}

