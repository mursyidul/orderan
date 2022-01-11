<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Absensi extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->model("Model_master");
        $this->load->model("Model_absensi");

    }

    public function index() {
        if ($this->session->userdata("role") == "ADMIN") {
            if(isset($_GET['startdate']) && ! empty($_GET['startdate']) && isset($_GET['enddate']) && ! empty($_GET['enddate'])){ 
                $startdate =  date('Y-m-d',strtotime($_GET['startdate']));
                $enddate = date('Y-m-d',strtotime($_GET['enddate']));
            }else{
                $startdate = date('Y-m-d',strtotime('-0 Day'));
                $enddate = date('Y-m-d');
            }

            if (isset($_GET['user']) && ! empty($_GET['user'])){
                $user = $_GET['user'];
            } else {
                $user = "all";
            }
            $data['user']     = $this->Model_absensi->get_user();      
            $data['absensi']  = $this->Model_absensi->get_absensi_admin("", $startdate, $enddate, $user);
            // echo $this->db->last_query();
            $this->template->load("template", "absensi/data-absensi_admin", $data);
        } else {
            $data['absensi']      = $this->Model_absensi->get_absensi();
            $this->template->load("template", "absensi/data-absensi", $data);
        }    
    }

    public function tambah(){
        $get_schadule = $this->Model_absensi->get_schadule();
        echo "<pre>", print_r($get_schadule, 1), "</pre>";
        $jam_awal  = date('H:i:s', strtotime($get_schadule->jam_masuk));
        $jam_akhir = date('H:i:s');
        $awal  = strtotime($jam_awal);
        $akhir = strtotime($jam_akhir);
        // echo $jam_akhir;
        // $awal  = strtotime('12:30:00');
        // $akhir = strtotime('13:00:45');
        $diff  = $akhir - $awal;
        $jam   = floor($diff / (60 * 60));
        $menit = $diff - ( $jam * (60 * 60) );
        $detik = $diff % 60;
        $total_menit = floor( $menit / 60 );
        $status_jam= "";
        if ($jam < 0 ) {
            if ($jam < 0 || $total_menit > 0 || $detik > 0) {
                // $status_jam = "On Time1";
                $status_jam = "On Time";
            }
        } else if($jam == 0) {
            if ($jam == 0 && $total_menit == 30 && $detik == 0){
                // $status_jam = "On Time2";
                $status_jam = "On Time";
            } else if ($jam == 0 && $total_menit < 30 || $detik < 0) {
                // $status_jam = "On Time3";
                $status_jam = "On Time";
            } else if ($jam == 0 || $total_menit == 30 || $detik > 0) {
                // $status_jam = "Telat1";
                $status_jam = "Telat";
            }
        } else {
            // $status_jam = "Telat2";
            $status_jam = "Telat";
        }
        // echo "<br>".'Waktu tinggal: ' . $jam .  ' jam, ' . floor( $menit / 60 ) . ' menit, ' . $detik . ' detik'."<br>"; 
        // echo $jam_awal."<br>";
        // echo $jam_akhir."<br>";
        // echo $total_menit."<br>";
        // echo $status_jam;
    	$data = array(
            "id_user"           => $this->session->userdata("id_user"),
            "tanggal_masuk"     => date("Y-m-d H:i:s"),
            "status_absensi"    => "MASUK",
            "status_jadwal"     => $status_jam,
            "created_date"      => date("Y-m-d H:i:s")
    	);
        // echo "<pre>", print_r($data, 1), "</pre>";
        if ($get_schadule == "") {
            $this->session->set_flashdata("error", "Gagal, Jadwal belum ada segera hubungi admin");
        } else {
            $action = $this->Model_master->tambahMaster("tbl_absensi", $data);
            if ($action) {
                $this->session->set_flashdata("success", "Berhasil menambahkan absensi masuk");
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan absensi masuk");
            }
        }
        
        redirect('dashboard');
    }

    // jika jam kurang dari 0 maka on time1
    // jika jam kurang dari 0 dan menit lebih dari 0 dan detik lebih dari 0 maka on time2
    // jika jam sama dengan 0 dan menit kurang dari 30 maka on time2
    // jika jam sama dengan 0 dan menit sama dengan 30 dan detik kurang dari 0 maka on time3
    // jika jam lebih dari 0 maka telat1
    // jika jam sama dengan 0 dan menit lebih dari 30 maka  telat 2
    // jika jam sama dengan 0 dan menit sama degan 30 dan detik lebih dari 0 maka telat 3

    public function edit(){
        $id_absensi = $this->input->post("id_absensi");
        $data = array(
            "id_user"           => $this->session->userdata("id_user"),
            "tanggal_keluar"    => date("Y-m-d H:i:s"),
            "status_absensi"    => "KELUAR"
        );

        $action = $this->Model_master->editMaster(array('id_absensi' => $id_absensi), "tbl_absensi", $data);
        if ($action) {
           $this->session->set_flashdata("success", "Berhasil melakukan absensi keluar");
        }  else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat melakukan absensi keluar");
        }

        redirect("dashboard");
    }

    public function delete_bahan(){
        $id_bahan = $this->input->post("id_bahan");
        $delete         = $this->Model_master->deleteMaster($id_bahan, "id_bahan", "tbl_bahan");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_bahan, "message"  => "Berhasil menghapus bahan"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus bahan"));
         }
    }

    public function tambah_admin(){
        $id_user     = $this->input->post("id_user");
        $get_schadule = $this->Model_absensi->get_schadule_admin($id_user);
        $tanggal_masuk = $this->input->post("tanggal_masuk");
        $jam_masuk  = $this->input->post("jam_masuk");
        $gabung_masuk = $tanggal_masuk." ".$jam_masuk;

        $data = array(
          "id_user"        => $id_user,
          "tanggal_masuk"  => date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $gabung_masuk))),
          "created_date"   => date("Y-m-d H:i:s"),
          "status_absensi" => "MASUK"
        );

        if ($get_schadule == "") {
            // echo "schadule kosong";
            $this->session->set_flashdata("error", "Gagal, Harap mangisi data di schadule");
        } else {
            // echo "schadule ada";
            $action = $this->Model_master->tambahMaster("tbl_absensi", $data);
            if ($action) {
                $this->session->set_flashdata("success", "Berhasil menambahkan absensi masuk");
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan absensi masuk");
            }
        }
        // echo "<pre>", print_r($get_schadule, 1), "</pre>";
        // echo "<pre>", print_r($data, 1), "</pre>";
        
        redirect('absensi');
    }   

    public function edit_admin(){
        $id_absensi     = $this->input->post("id_absensi");
        $id_user        = $this->input->post("id_user");
        $status_jadwal  = $this->input->post("status_jadwal");
        $tanggal_masuk  = $this->input->post("tanggal_masuk");
        $tanggal_keluar = $this->input->post("tanggal_keluar");
        $jam_masuk      = $this->input->post("jam_masuk");
        $jam_keluar     = $this->input->post("jam_keluar");
        $gabung_masuk   = $tanggal_masuk." ".$jam_masuk;
        $gabung_keluar  = $tanggal_keluar." ".$jam_keluar;

        if ($jam_keluar == "00:00:00") {
            $status_absensi  = "MASUK";
        } else {
            $status_absensi  = "KELUAR";
        }

        $data = array(
            "id_user"        => $id_user,
            "status_jadwal"  => $status_jadwal,
            "tanggal_masuk"  => $gabung_masuk,
            "tanggal_keluar" => $gabung_keluar,
            "status_absensi" => $status_absensi,
            "edit_by"        => "1"
        );

        // echo "<pre>", print_r($data, 1), "</pre>";
        $action = $this->Model_master->editMaster(array('id_absensi' => $id_absensi), "tbl_absensi", $data);
        if ($action) {
           $this->session->set_flashdata("success", "Berhasil mengubah absensi");
        }  else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah absensi");
        }

        redirect("absensi");
    }

    public function export(){

        $this->load->library('PHPExcel', 'excel');

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');

        // $objPHPExcel = $objReader->load("uploads/files/percobaan.xlsx");

        $objPHPExcel = $objReader->load('file/excel/Absensi.xlsx');



        $styleLeft = array(

          'font' => array('bold' => false,),

          'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,),

          'borders' => array(

            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

            'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

          )

        );



        $styleCenter = array(

          'font' => array('bold' => false,),

          'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,),

          'borders' => array(

            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

            'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

          )

        );

        $startdate     ="";
        $enddate       ="";
        $user          ="";

        if(isset($_GET['startdate']) && ! empty($_GET['startdate']) && isset($_GET['enddate']) && ! empty($_GET['enddate'])){ 
            $startdate =  date('Y-m-d',strtotime($_GET['startdate']));
            $enddate   = date('Y-m-d',strtotime($_GET['enddate']));
        }else{
            $startdate = date('Y-m-d',strtotime('-0 Day'));
            $enddate   = date('Y-m-d');
        }

        if (isset($_GET['user']) && ! empty($_GET['user'])){
            $user = $_GET['user'];
        } else {
            $user = "all";
        }

        $items  = $this->Model_absensi->get_absensi_admin("", $startdate, $enddate, $user);

        $base_row = 5;

        $row = $base_row;

        foreach ($items as $key => $item) {

            $row = $base_row++;
            if ($item->tanggal_keluar == "0000-00-00 00:00:00") {
                $tanggal_keluar = "00:00:00";
            } else {
                $tanggal_keluar = date('H:i:s', strtotime($item->tanggal_keluar));
            }
            if ($item->tanggal_keluar == "0000-00-00 00:00:00") {
                $durasi = "00:00:00";
            } else {
                $durasi = $item->durasi_kerja;
            }
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, ($key+1))

                                        ->setCellValue('B'.$row, $item->full_name)
                                        ->setCellValue('C'.$row, date('H:i:s', strtotime($item->tanggal_masuk)))

                                        ->setCellValue('D'.$row, $tanggal_keluar)
                                        ->setCellValue('E'.$row, $durasi)

                                        ->setCellValue('F'.$row, $item->status_jadwal)
                                        ->setCellValue('G'.$row, date('d F Y', strtotime($item->created_date)));

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleCenter);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleCenter);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($styleLeft);

        }



        $nama_file = "Laporan Absensi";

        header('Content-Type: application/vnd.ms-excel'); //mime type

        header('Content-Disposition: attachment;filename="'.$nama_file.'.xlsx"'); 

        header('Cache-Control: max-age=0'); //no cache

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $objWriter->save('php://output');
    }
}