<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_master extends CI_Model {

    public function getMasterOneTable($query, $table, $order, $sort, $condition){
        $this->db->select($query);
        $this->db->from($table);
        if ($condition != "") {
           $this->db->where($condition);
        }
        $this->db->order_by($order, $sort);
        return $this->db->get()->result();
    }
    public function getMasterOneTable_array($query, $table, $order, $sort, $condition){
        $this->db->select($query);
        $this->db->from($table);
        if ($condition != "") {
           $this->db->where($condition);
        }
        $this->db->order_by($order, $sort);
        return $this->db->get()->result_array();
    }
    public function tambahMaster($table, $data){
        $this->db->insert($table, $data);
        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function editMaster($id_master, $table, $dataMaster){
        $this->db->where($id_master);
        $this->db->update($table, $dataMaster);
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function deleteMaster($id_master, $id_table,$table){
        $this->db->where($id_table, $id_master)->delete($table);
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function get_status($query, $kolom, $keterangan, $order, $sort, $limit, $table){
        $this->db->select($query);
        $this->db->where(array($kolom => $keterangan )); 
        $this->db->order_by($order, $sort);
        $this->db->limit($limit);
        $proses = $this->db->get($table);
        
        if($proses->num_rows() > 0){
            return $proses->result();
        } else{
            return array();
        }
    }

    public function delete($id_ijin){
        $this->db->where("id_ijin", $id_ijin)->delete("tbl_ijin");
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function delete_user($id_user){
        $this->db->where("id_user", $id_user)->delete("tbl_user");
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function get_desa($id){
        $hasil=$this->db->query("SELECT wilayah_desa.* FROM wilayah_desa JOIN wilayah_kecamatan ON wilayah_kecamatan.id=wilayah_desa.kecamatan_id WHERE wilayah_desa.kecamatan_id ='$id'");
        return $hasil->result();
    }

    public function get_ijin($id = null){
        if(isset($id)){
        $this->db->where("id_ijin =", $id);
        }
        $this->db->select("ijin.*, desa.nama as nama_desa, kecamatan.nama as nama_kecamatan");
        $this->db->from("tbl_ijin ijin");
        $this->db->join("wilayah_desa desa", "desa.id=ijin.desa", "left");
        $this->db->join("wilayah_kecamatan kecamatan", "kecamatan.id=ijin.kecamatan", "LEFT");
        
        $this->db->order_by("ijin.id_ijin", "desc");
        return $this->db->get()->result();
    }

    public function get_bahan($id = null){
        if (isset($id)) {
            $this->db->where("id_bahan =", $id);
        }
        $this->db->select("bahan.*, kategori.*");
        $this->db->from("tbl_bahan bahan");
        $this->db->join("tbl_kategori kategori", "kategori.id_kategori=bahan.id_kategori", "LEFT");
        $this->db->order_by("bahan.id_bahan", "desc");
        return $this->db->get()->result();
    }

    public function get_perbahan($kategori, $jenis_bahan){
        $this->db->select("bahan.*, kategori.*");
        $this->db->from("tbl_bahan bahan");
        $this->db->join("tbl_kategori kategori", "kategori.id_kategori=bahan.id_kategori", "LEFT");
        $this->db->where("kategori.nama_kategori =", $kategori);
        $this->db->where("bahan.jenis_bahan =", $jenis_bahan);
        $this->db->order_by("bahan.id_bahan", "asc");
        return $this->db->get()->result();
    }

    public function check_existing_name($column, $value){

            $this->db->select("id_product");

            $this->db->from("tbl_product");

            $this->db->where($column, $value);

            $data = $this->db->get();

            if($data->num_rows() > 0){

                return $data->result();

            } else {

                return false;

            }

    }

    public function check_existing_name_master($id_table, $table, $column, $value){

            $this->db->select($id_table);

            $this->db->from($table);

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

    public function get_detail($where,$table){
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where($where);
        return $this->db->get()->result();
    }

    public function add_bahan($data){

        $this->db->insert("tbl_bahan", $data);

        if ($this->db->affected_rows() > 0) {

            return $this->db->insert_id();

        } else {

            return false;

        }

    }
  
}
?>