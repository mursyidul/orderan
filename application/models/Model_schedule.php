<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_schedule extends CI_Model {

    public function get_user(){
            $this->db->select("user.*");
            $this->db->from("tbl_user user");
            $this->db->join("tbl_role role", "role.id_role = user.id_role", "left");
            $this->db->where("role.name_role", "DESAIN");
            $data = $this->db->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }

    public function update_user($date){
            $this->db->select("tbl_schedule.*, tbl_user.nama_user");
            $this->db->from("tbl_schedule");
            $this->db->join("tbl_user", "tbl_user.id_user = tbl_schedule.id_user", "left");
            $this->db->where("tbl_schedule.tanggal", date('Y-m-d',strtotime($date)));
            $this->db->where("tbl_user.role", "user");
            $this->db->where("tbl_user.id_bagian", $this->session->userdata("id_bagian"));
            // if($date!=""){
            //     $this->db->where('DATE(tanggal) >=', date('Y-m-d',strtotime($date)));
            // }
            // if($id!=""){
            //     $this->db->where('id_schedule =', $id);
            // }
            $this->db->order_by("id_schedule", "desc");

            return $this->db->get()->result();
            
        }

    public function get_edit_user(){
            $this->db->select("tbl_schedule.*");
            $this->db->from("tbl_schedule");
            // $this->db->join("tbl_bagian", "tbl_bagian.id_bagian = tbl_user.id_bagian", "left");
            // $this->db->where("tbl_user.role", "user");
            // $this->db->where("tbl_user.id_bagian", $this->session->userdata("id_bagian"));
            $data = $this->db->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return false;
            }
        }

    public function get_schedule_count(){
        $this->db->select("COUNT(tbl_schadule.id_user) as jumlah, tbl_schadule.tanggal, tbl_shift.nama_shift as nm_shift");
        $this->db->from("tbl_schadule");
        $this->db->join("tbl_user", "tbl_user.id_user = tbl_schadule.id_user", "left");
        $this->db->join("tbl_shift", "tbl_shift.nama_shift = tbl_schadule.shift_kerja", "left");
        $this->db->where("tbl_schadule.shift_kerja !=", "OFF");
        $this->db->group_by("tbl_shift.nama_shift");
        $this->db->group_by("tbl_schadule.tanggal");
        return $this->db->get()->result_array();
    }

    public function get_schedule_user($id_user){
        $this->db->select("tbl_schadule.tanggal, tbl_shift.nama_shift as nm_shift");
        $this->db->from("tbl_schadule");
        $this->db->join("tbl_user", "tbl_user.id_user = tbl_schadule.id_user", "left");
        $this->db->join("tbl_shift", "tbl_shift.nama_shift = tbl_schadule.shift_kerja", "left");
        $this->db->where("tbl_schadule.id_user", $id_user);
        $this->db->where("tbl_schadule.shift_kerja !=", "OFF");
        $this->db->group_by("tbl_shift.nama_shift");
        $this->db->group_by("tbl_schadule.tanggal");
        return $this->db->get()->result_array();
    }

    public function view_user(){
        $this->db->select("*");
        $this->db->from("tbl_user");
        $this->db->order_by("nama_user");
        return $this->db->get()->result();
    }

    public function tambah_schedule($data){
        $this->db->insert_batch("tbl_schadule", $data);
        if($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_schedule($update){
        $this->db->update_batch("tbl_schadule", $update, 'id_schadule');
        if($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        // Check so incoming data is actually an array and not empty
        // if (is_array($edit_schedule) && ! empty($edit_schedule))
        // {
        //     // We already have a correctly formatted array from the controller,
        //     // so no need to do anything else here, just update.
            
        //     // Update rows in database
        //     $this->db->update_batch('tbl_schedule', $edit_schedule, 'id_schedule');
        // }
    }

}
?>