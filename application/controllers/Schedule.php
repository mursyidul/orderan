<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller {

    public function __construct(){
		parent::__construct();
		checkSessionUser();
        $this->load->model("Model_master");
        $this->load->model("Model_schedule");
    }

    public function index(){
        $data['calendar']  = $this->Model_schedule->get_schedule_count();
        $data['calendar_user']  = $this->Model_schedule->get_schedule_user($this->session->userdata("id_user"));
        // echo $this->db->last_query();
		$this->template->load("template", "schedule/data-schedule", $data);
    }

    public function tambah(){
        // tambah
        if(isset($_GET['date']) && ! empty($_GET['date']) ){ 
            $date = $_GET['date'];
        }else{
            $date = date('Y-m-d');
        }
    	$data['user'] = $this->Model_schedule->get_user();

        // edit
        // if(isset($_GET['date']) && ! empty($_GET['date']) ){ 
        //     $date = $_GET['date'];
        // }else{
        //     $date = date('Y-m-d');
        // }
        // $data['edit_user'] = $this->Model_schedule->update_user($date);
        // if ($this->session->userdata("role") == "ADMIN") {
    	   $this->template->load("template", "schedule/tambah-schedule", $data);
        // } else if ($this->session->userdata("role") == "DESAIN"){
        //    $this->template->load("template", "schedule/list-schedule", $data);
        // }
    }


    // public function edit(){
    //     if(isset($_GET['date']) && ! empty($_GET['date']) ){ 
    //         $date = $_GET['date'];
    //     }else{
    //         $date = date('Y-m-d');
    //     }
    //     $data['edit_user'] = $this->Model_schedule->update_user($date);
    //     $this->template->load("template", "schedule/edit-schedule", $data);
    // }

    public function tambah_schedule(){
        $tanggal     = $this->input->post('tanggal');
        // $id_user     = $this->input->post('id_user');

        $list_user = $this->Model_schedule->get_user();

        foreach ($list_user as $s) {

        $shift_kerja = $this->input->post('shift_kerja'.$s->id_user);
        $id_schadule = $this->input->post('id_schadule'.$s->id_user);
        
        $data_schedule = array();
            array_push($data_schedule, array(
            "tanggal"         => $tanggal,
            "id_user"         => $s->id_user,
            "shift_kerja"     => $shift_kerja
            )
        );

        $update = array();
            array_push($update, array(
            "id_schadule"     => $id_schadule,
            "tanggal"         => $tanggal,
            "id_user"         => $s->id_user,
            "shift_kerja"     => $shift_kerja
            )
        );
            // echo '<pre>',print_r($id_schedule,1),'</pre>';
        $query = $this->db->get_where('tbl_schadule', array('tbl_schadule.id_user' => $s->id_user,'tanggal' => $tanggal));
        // echo $this->db->last_query();
        // print_r($query);
        $exist =  $query->num_rows();
        if($exist == 0){
            //Insert
            $this->Model_schedule->tambah_schedule($data_schedule);
        }else{
            // update
            // echo '<pre>',print_r($update,1),'</pre>';
            $this->Model_schedule->edit_schedule($update);
        }   
        }
        redirect('schedule');
    }

    // public function edit_schedule(){
    //     $tanggal         = $this->input->post('tanggal');
    //     $list_user = $this->Model_schedule->get_user();

    //     foreach ($list_user as $s) {

    //     $shift_kerja = $this->input->post('shift_kerja'.$s->id_user);
    //     $id_schedule = $this->input->post('id_schedule'.$s->id_user);
        
    //     $update = array();
    //         array_push($update, array(
    //         "id_schedule"     => $id_schedule,
    //         "tanggal"         => date("Y-m-d", strtotime($tanggal)),
    //         "id_user"         => $s->id_user,
    //         "shift_kerja"     => $shift_kerja
    //         )
    //     );
    //         // print_r($data_schedule);

    //     // $tambahKuisioner = $this->Model_kuisioner->tambahKuisioner($dataKuisioner);
    //     //  if ($tambahKuisioner) {
    //     //      echo json_encode(array("status" => "success", "message" => "Berhasil menambahkan kuisioner", "data" => $dataKuisioner));
    //     //  } else {
    //     //      echo json_encode(array("status" => "error", "message" => "Gagal menambahkan kuisioner"));
    //     //  }
    //         // $query = $this->db->update_batch('tbl_schedule',$data_schedule,'id_schedule');
    //         // print_r($update);
    //         $edit = $this->Model_schedule->edit_schedule($update);
    //         // print_r($edit);
    //         if($edit){
    //             $this->session->set_flashdata('success', 'BERHASIL MENYIMPAN');
    //         } else {
    //             $this->session->set_flashdata('error', 'GAGAL MENYIMPAN');
    //         }   
    //     }
    //     redirect('schedule');
    // }

}
?>