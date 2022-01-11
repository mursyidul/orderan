<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_user extends CI_Model {

   public $table  = 'tbl_user';
   public $id     = 'tbl_user.id_user';

public function update($data, $id)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }
 
    public function get_by_id($id)
    {
        $this->db->select('
            tbl_user.*
            ');
        // $this->db->join('tbl_role', 'tbl_user.id_role = tbl_role.id');
        $this->db->from($this->table);
        $this->db->where($this->id, $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_login($id = null){
        if(isset($id)){
            $this->db->where("id_user", $id);
        }
        $this->db->select("id_user, password");
        $this->db->from("tbl_user");
        $this->db->order_by("id_user", "desc");
        
        return $this->db->get()->result();
        // $this->db->last_query();
    }

    public function delete_user($id_user){

        $this->db->where("id_user", $id_user)->delete("tbl_user");

        if($this->db->affected_rows() > 0){

            return true;

        } else {

            return false;

        }

    }

    public function role_list(){

        $this->db->select("*");

        $this->db->from("tbl_role");
        
        // $this->db->where("name_role!=", "ADMIN");

        $this->db->order_by("name_role", "ASC");

        return $this->db->get()->result();

    }

    public function check_existing_user($column, $value){

            $this->db->select("id_user");

            $this->db->from("tbl_user");

            $this->db->where($column, $value);

            $data = $this->db->get();

            if($data->num_rows() > 0){

                return $data->result();

            } else {

                return false;

            }

        }

    public function add_user($data){

        $this->db->insert("tbl_user", $data);

        if ($this->db->affected_rows() > 0) {

            return $this->db->insert_id();

        } else {

            return false;

        }

    }

    public function edit_user($data, $id_user){

        $this->db->where("id_user", $id_user)->update("tbl_user", $data);

        if($this->db->affected_rows() > 0){

            return true;

        } else {

            return false;

        }

    }

    public function getUser($id = null){
        if(isset($id)){
            $this->db->where("user.id_user", $id);
        }
        $this->db->select("user.id_user, user.id_role, user.full_name, user.phone, user.email, user.username, user.status, user.jumlah_cuti, role.name_role");

        $this->db->from("tbl_user user");
        $this->db->join("tbl_role role", "role.id_role=user.id_role", "LEFT");
        // $this->db->where("role.name_role!=", "ADMIN");
        // $this->db->group_by("user.id_user");
        $this->db->order_by("user.id_user", "desc");
        $data = $this->db->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
    }

    public function get_user_profil($id = null){
        if(isset($id)){
            $this->db->where("user.id_user", $id);
        }
        $this->db->select("user.*, role.name_role");
        $this->db->from("tbl_user user");
        $this->db->join("tbl_role role", "role.id_role=user.id_role", "LEFT");
        $this->db->where("role.name_role!=", "ADMIN");
        $this->db->where("user.status!=", 0);
        $this->db->order_by("id_user", "desc");
        $data = $this->db->get();
            if($data->num_rows() > 0){
                return $data->result();
            } else {
                return array();
            }
    }

    public function edit_profile($data, $id_user){
        $this->db->where("id_user", $id_user)->update("tbl_user", $data);
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }
}
?>