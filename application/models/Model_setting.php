<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_setting extends CI_Model {

	public function get_setting($id = null){

        if(isset($id)){
            $this->db->where("id_setting", $id);
        }

        $this->db->select("*");
        $this->db->from("tbl_setting");
        $this->db->order_by("id_setting", "ASC");
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result();
        } else {
            return array();
        }
    }

    public function add_setting($data){

        $this->db->insert("tbl_setting", $data);

        if ($this->db->affected_rows() > 0) {

            return $this->db->insert_id();

        } else {

            return false;

        }

    }

    public function edit_setting($data, $id_setting){
        $this->db->where("id_setting", $id_setting)->update("tbl_setting",$data);
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function get_detail_hadiah($id_tukar_point){
        if (isset($id_tukar_point)) {
            $this->db->where("detail.id_tukar_point =", $id_tukar_point);
        }
        $this->db->select("detail.*");
        $this->db->from("tbl_detail_point detail");
        $this->db->order_by("detail.id_detail_point", "asc");
        return $this->db->get()->result();
    }

    public function get_history_pengiriman(){
        $this->db->select('pengiriman.no_pesanan as pesanan_pengiriman, pengiriman.jumlah_order, pengiriman.created_date, user.full_name, order.*');
        $this->db->from('tbl_history_pengiriman pengiriman');
        $this->db->join("tbl_user user", "user.id_user=pengiriman.id_user", "LEFT");
        $this->db->join("tbl_order order", "order.no_pesanan=pengiriman.no_pesanan", "LEFT");
        $this->db->order_by("pengiriman.id_history_pengiriman", "desc");
        $this->db->group_by("pengiriman.no_pesanan");
        return $this->db->get()->result();
    }

    public function get_task(){
        $this->db->select("task.*, user.full_name");
        $this->db->from("tbl_task task");
        $this->db->join("tbl_user user", "user.id_user=task.id_user", "LEFT");
        $this->db->order_by("task.id_task", "desc");
        return $this->db->get()->result();
    }
    
    public function get_selesai_jumlah($no_pesanan){
        $this->db->select("count(no_pesanan) as no_pesanan");
        $this->db->from("tbl_order order");
        $this->db->where("order.no_pesanan", $no_pesanan);
        return $this->db->get()->result_array();
    }

    public function cancel_task($id_task){
        $this->db->set("status_task", "CANCEL");
        $this->db->where("id_task", $id_task);
        $this->db->update("tbl_task");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function progres_task($id_task){
        $this->db->set("status_task", "PROGRES");
        $this->db->where("id_task", $id_task);
        $this->db->update("tbl_task");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function complete_task($id_task){
        $this->db->set("status_task", "COMPLETE");
        $this->db->where("id_task", $id_task);
        $this->db->update("tbl_task");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

