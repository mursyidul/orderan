<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Model_login", "mLogin");
	}

	public function index(){
		if($this->session->userdata("pls_login") == "Y"){
			redirect("dashboard");
		}
		$this->load->view("login_page");
	}

	public function action(){
		$username = $this->input->post("username");
		$password = $this->input->post("password");

		if(isset($username) && isset($password)){
			$checkUser = $this->mLogin->checkUser($username, $password);
			if($checkUser){
				$checkStatus = $this->mLogin->checkStatus($username, $password);
				if($checkStatus){
					$dataUser = array(
					"id_user" => $checkUser->id_user,
					"full_name" => $checkUser->full_name,
					"username"	=> $checkUser->username,
					"role" => $checkUser->name_role,
					"pls_login" => "Y"
				);
				$this->session->set_userdata($dataUser);
					if ($this->session->userdata('role') == 'USER') {
						redirect("tampilan");
					} else {
						redirect("dashboard");
					}
				} else {
					$this->session->set_flashdata("error", "Maaf, akun anda belum diaktifkan");
					redirect("");
				}
			} else {
				$this->session->set_flashdata("error", "Login gagal! Periksa akun anda");
				redirect("");
			}
		}
	}

	public function doLogout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
