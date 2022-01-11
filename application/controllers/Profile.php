<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Profile extends CI_Controller {



    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_user");

    }



    public function index() {

        $data['user']    = $this->Model_user->get_user_profil($this->session->userdata("id_user"));

	    $this->template->load("template", "user/edit-profile",$data);

    }



    public function editProfile(){

        $id_user = $this->session->userdata("id_user");
        $full_name = $this->input->post("full_name");
        $phone = $this->input->post("phone");
        $email = $this->input->post("email");
        $password = $this->input->post("password");

        $data = array(
            "full_name" => $full_name,
            "phone" => $phone,
            "email" => $email
        );

        if($password != ""){
            $data["password"] = md5($password);
        }
        print_r($data);
        $query = $this->Model_user->edit_profile($data, $id_user);
        if($query){
            $this->session->set_flashdata("success", "Berhasil mengubah profil");
        } else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah profil");
        }
        redirect("profile");
    }

}