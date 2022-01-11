<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
		parent::__construct();
        checkSessionUser();
        $this->load->model("Model_user");
        $this->load->library('session');
    }

    public function index(){
        $data["role"] = $this->Model_user->role_list();
		$this->template->load("template", "user/data-user", $data);
    }

    public function get_data_user($iduser = null){

        $data = $this->Model_user->getUser($iduser);

        echo json_encode(array("status" => "success", "data" => $data));

    }

    public function addUser(){
        $full_name  = $this->input->post("full_name");
        $id_role    = $this->input->post("id_role");
        $phone      = $this->input->post("phone");
        $username   = $this->input->post("username");
        $email      = $this->input->post("email");
        $jumlah_cuti= $this->input->post("jumlah_cuti");
        $password   = $this->input->post("password");
        $status     = $this->input->post("status");

        $dataUser = array(
            "full_name"     => $full_name,
            "id_role"       => $id_role,
            "phone"         => $phone,
            "username"      => $username,
            "email"         => $email,
            "jumlah_cuti"   => $jumlah_cuti,
            "password"      => md5($password),
            "status"        => $status,
            "create_date"   => date("Y-m-d H:i:s")
        );

        $check_when_double_email = $this->Model_user->check_existing_user("email", $email);

        if($check_when_double_email){
            echo json_encode(array("status" => "error", "message" => "Email telah digunakan, mohon masukkan email yang lain.!!"));
        } else {
            $query = $this->Model_user->add_user($dataUser);
            if ($query) {
                echo json_encode(array("status" => "success", "message" => "Berhasil menambahkan user", "data" => $dataUser));
            } else {
                echo json_encode(array("status" => "error", "message" => "Gagal, user tidak dapat disimpan.!!"));
            }
        }
    }

    public function editUser(){
        $id_user        = $this->input->post("id_user");
        $full_name      = $this->input->post("full_name");
        $id_role        = $this->input->post("id_role");
        $phone          = $this->input->post("phone");
        $username       = $this->input->post("username");
        $email          = $this->input->post("email");
        $jumlah_cuti    = $this->input->post("jumlah_cuti");
        $password       = $this->input->post("password");
        $status         = $this->input->post("status");

        $data = array(
            "full_name"     => $full_name,
            "id_role"       => $id_role,
            "phone"         => $phone,
            "username"      => $username,
            "email"         => $email,
            "jumlah_cuti"   => $jumlah_cuti,
            "status"        => $status,
        );

        if($password != ""){
            $data["password"] = md5($password);
        }

        $query = $this->Model_user->edit_user($data, $id_user);
        if ($query) {
            echo json_encode(array("status" => "success", "message" => "Berhasil mengubah user", "data" => $data));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat mengubah user.!!"));
        }
    }

    public function delete_user(){
        $id_user = $this->input->post("id_user");
        $query = $this->Model_user->delete_user($id_user);
        if($query){
            echo json_encode(array("status" => "success", "data" => $id_user, "message" => "Berhasil menghapus user"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus user.!!"));
        }
    }

}
?>