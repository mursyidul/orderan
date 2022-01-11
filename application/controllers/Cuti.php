<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Cuti extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");
        $this->load->model("Model_cuti");

    }

    public function index() {
        if ($this->session->userdata("role") == 'ADMIN') {
            if(isset($_GET['startdate']) && ! empty($_GET['startdate']) && isset($_GET['enddate']) && ! empty($_GET['enddate'])){ 
                $startdate =  date('Y-m-d',strtotime($_GET['startdate']));
                $enddate = date('Y-m-d',strtotime($_GET['enddate']));
            }else{
                $startdate = date('Y-m-d',strtotime('-1 month'));
                $enddate = date('Y-m-d');
            }
            if(isset($_GET['user']) && ! empty($_GET['user'])){
                $user = $_GET['user'];
            }else{
                $user = "all";
            }
            if(isset($_GET['jenis_cuti']) && ! empty($_GET['jenis_cuti'])){
                $jenis_cuti = $_GET['jenis_cuti'];
            }else{
                $jenis_cuti = "all";
            }
            $data['jenis_cuti'] = $this->Model_master->getMasterOneTable("*", "tbl_jenis_cuti", "jenis_cuti", "ASC", "");
            $data['user'] = $this->Model_cuti->get_user();
            $data['cuti']   = $this->Model_cuti->get_cuti_admin("", $startdate, $enddate, $user, $jenis_cuti);
            $this->template->load("template", "cuti/data-cuti_admin", $data);
        } else {
            $cuti = $this->Model_cuti->get_cuti();
            $i=0;
            foreach ($cuti as $k) {
                $id_cuti = $k['id_cuti'];
                $id_transaksi = $this->Model_cuti->get_transaksi($id_cuti);
                $cuti[$i]['id_transaksi']  = $id_transaksi;
                $i++;
            }
            $data['cuti']       = $cuti;
            $data['jenis_cuti'] = $this->Model_master->getMasterOneTable("*", "tbl_jenis_cuti", "jenis_cuti", "ASC", "");
    	   $this->template->load("template", "cuti/data-cuti", $data);
        }
    }

    public function tambah(){
        $id_jenis_cuti          = $this->input->post("id_jenis_cuti");
        $tanggal_mulai_cuti     = $this->input->post("tanggal_mulai_cuti");
        if ($id_jenis_cuti == 3) {
            $tanggal_akhir_cuti  = "";
        } else {
            $tanggal_akhir_cuti     = $this->input->post("tanggal_akhir_cuti");
        }
        $jam_masuk_cuti         = $this->input->post("jam_masuk_cuti");
        $jam_keluar_cuti        = $this->input->post("jam_keluar_cuti");
        $keterangan_cuti        = $this->input->post("keterangan_cuti");
        $created_date           = date("Y-m-d H:i:s");

    	$data = array(
            "id_user"               => $this->session->userdata("id_user"),
            "id_jenis_cuti"         => $id_jenis_cuti,
            "tanggal_mulai_cuti"    => date("Y-m-d", strtotime(str_replace("/", "-", $tanggal_mulai_cuti))),
            "tanggal_akhir_cuti"   => date("Y-m-d", strtotime(str_replace("/", "-", $tanggal_akhir_cuti))),
            "jam_masuk_cuti"        => $jam_masuk_cuti,
            "jam_keluar_cuti"       => $jam_keluar_cuti,
            "keterangan_cuti"       => $keterangan_cuti,
            "created_date"          => $created_date 
    	);

        $action = $this->Model_cuti->add_cuti($data);
        if ($action) {
            $jenis_cuti = $this->db->get_where('tbl_jenis_cuti',['id_jenis_cuti' => $id_jenis_cuti])->row();
            $id_transaksi   = $action;
            $user_hrd       = $this->Model_cuti->get_id_admin()[0]->list_id.',';
            $data = array(
                'id_transaksi'  => $id_transaksi,
                'dari'          => $this->session->userdata('id_user'),
                'ke'            => $user_hrd,
                'kategori'      => 'pengajuan '.$jenis_cuti->jenis_cuti,
                'pesan'         => 'Pengajuan '.$jenis_cuti->jenis_cuti.' Berhasil',
                'created_date'  => $created_date
            );
            $this->Model_cuti->add_notifikasi($data);
            $this->session->set_flashdata("success", "Berhasil menambahkan cuti");
        } else {
            $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan cuti");
        }
        redirect('cuti');

    }

    public function edit(){
        $id_cuti                = $this->input->post("id_cuti");
        $id_jenis_cuti          = $this->input->post("id_jenis_cuti");
        if ($id_jenis_cuti == 3) {
            $tanggal_akhir_cuti    = "";
            $jam_masuk_cuti         = $this->input->post("jam_masuk_cuti");
            $jam_keluar_cuti        = $this->input->post("jam_keluar_cuti");
        } else {
            $jam_masuk_cuti     = "";
            $jam_keluar_cuti    = "";
            $tanggal_akhir_cuti = $this->input->post("tanggal_akhir_cuti");
        }
        $tanggal_mulai_cuti     = $this->input->post("tanggal_mulai_cuti");
        $keterangan_cuti        = $this->input->post("keterangan_cuti");
        $created_date           = date("Y-m-d H:i:s");

        $data = array(
            "id_user"               => $this->session->userdata("id_user"),
            "id_jenis_cuti"         => $id_jenis_cuti,
            "tanggal_mulai_cuti"    => date("Y-m-d", strtotime(str_replace("/", "-", $tanggal_mulai_cuti))),
            "tanggal_akhir_cuti"   => date("Y-m-d", strtotime(str_replace("/", "-", $tanggal_akhir_cuti))),
            "jam_masuk_cuti"        => $jam_masuk_cuti,
            "jam_keluar_cuti"       => $jam_keluar_cuti,
            "keterangan_cuti"       => $keterangan_cuti,
            "created_date"          => $created_date 
        );

        $action = $this->Model_master->editMaster(array('id_cuti' => $id_cuti), "tbl_cuti", $data);
        if ($action) {
           $this->session->set_flashdata("success", "Berhasil Mengubah cuti");
        }  else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah cuti");
        }
        redirect("cuti");
    }

    public function delete_cuti(){
        $id_cuti = $this->input->post("id_cuti");
        $delete         = $this->Model_master->deleteMaster($id_cuti, "id_cuti", "tbl_cuti");
        if ($delete) {
            $this->db->where('id_transaksi', $id_cuti);
            $this->db->where('is_seen', '0');
            $this->db->delete('tbl_notifikasi');
            echo json_encode(array("status" => "success", "data" => $id_cuti, "message"  => "Berhasil menghapus cuti"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus cuti"));
         }
    }

    public function reject_cuti(){
        $id_cuti = $this->input->post("id_cuti");
        $delete  = $this->Model_cuti->reject_cuti($id_cuti);
        if ($delete) {
            $creator = $this->Model_master->get_detail(array('id_cuti' => $id_cuti),'tbl_cuti');
            $id_user = $creator[0]->id_user;
            $id_jenis_cuti = $creator[0]->id_jenis_cuti;
            $jenis_cuti = $this->Model_master->get_detail(array('id_jenis_cuti' => $id_jenis_cuti),'tbl_jenis_cuti');
            //Update notifikasi is_seen = 1
            $this->Model_cuti->read_notifikasi(array('id_transaksi'=>$id_cuti));

            $notifikasi = array(
                    'id_transaksi'  => $id_cuti,
                    'dari'          => $this->session->userdata('id_user'),
                    'ke'            => $id_user,
                    'kategori'      => 'pengajuan '.$jenis_cuti[0]->jenis_cuti,
                    'pesan'         => 'pengajuan '.$jenis_cuti[0]->jenis_cuti.' sudah di reject admin'
                );
            $this->Model_cuti->add_notifikasi($notifikasi);
            echo json_encode(array("status" => "success", "data" => $id_cuti, "message"  => "Reject berhasil "));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat reject"));
         }
    }

    public function approve_cuti(){
        $id_cuti = $this->input->post("id_cuti");
        $action  = $this->Model_cuti->approve_cuti($id_cuti);
        if ($action) {
            $creator = $this->Model_master->get_detail(array('id_cuti' => $id_cuti),'tbl_cuti');
            $id_user = $creator[0]->id_user;
            $id_jenis_cuti = $creator[0]->id_jenis_cuti;
            $jenis_cuti = $this->Model_master->get_detail(array('id_jenis_cuti' => $id_jenis_cuti),'tbl_jenis_cuti');
            //Update notifikasi is_seen = 1
            $this->Model_cuti->read_notifikasi(array('id_transaksi'=>$id_cuti));

            $notifikasi = array(
                    'id_transaksi'  => $id_cuti,
                    'dari'          => $this->session->userdata('id_user'),
                    'ke'            => $id_user,
                    'kategori'      => 'pengajuan '.$jenis_cuti[0]->jenis_cuti,
                    'pesan'         => 'pengajuan '.$jenis_cuti[0]->jenis_cuti.' sudah di approve admin'
                );
            $this->Model_cuti->add_notifikasi($notifikasi);
            echo json_encode(array("status" => "success", "data" => $id_cuti, "message"  => "Berhasil approve cuti"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat approve cuti"));
         }
    }

    public function change_is_seen(){
        $id_cuti = $this->input->post("id_cuti");
        $action = $this->Model_cuti->change_is_seen($id_cuti);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $id_cuti, "message" => "Berhasil melihat status pengajuan"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat melihat status pengajuan"));
        }
    }
}