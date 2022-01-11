<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Laporan_karyawan extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->library('pdf');
        $this->load->model("Model_master");
        $this->load->model("Model_laporan_karyawan");
        $this->load->model("Model_absensi");

    }

    public function index() {
        if(isset($_GET['startdate']) && ! empty($_GET['startdate'])){ 
            $startdate = $_GET['startdate'];
        } else {
            $startdate = date('F Y');
        }

        if (isset($_GET['user']) && ! empty($_GET['user'])){
            $user = $_GET['user'];
        } else {
            $user = "all";
        }

        $newdateformat = date("m Y", strtotime($startdate));
        $bulan      = substr($newdateformat,0,2);
        $tahun      = substr($newdateformat,3,10);

        $absensi   = $this->Model_laporan_karyawan->get_absensi($bulan, "3");
        $i=0;
        foreach ($absensi as $ab) {
            $tanggal_masuk = date('Y-m-d', strtotime($ab['tanggal_masuk']));
            $id_user    = $ab['id_user'];
            $dikerjakan = $this->Model_laporan_karyawan->get_dikerjakan_karyawan($tanggal_masuk, $id_user);
            $cetak      = $this->Model_laporan_karyawan->get_cetak_karyawan($tanggal_masuk, $id_user);
            $orderan    = $this->Model_laporan_karyawan->get_orderan_karyawan($tanggal_masuk);
            // $task       = $this->Model_laporan_karyawan->get_task_karyawan($id_user);
            echo $this->db->last_query();
            echo "<pre>", print_r($orderan, 1), "</pre>";
        }

        $data['user']     = $this->Model_absensi->get_user();
    	$this->template->load("template", "laporan_karyawan/data-laporan_karyawan", $data);
    }

    public function cetak_kerja_karyawan(){
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintFooter(false);
        $pdf->setPrintHeader(false);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->AddPage('L','A4');
        $pdf->SetFont('courier', '', '8');
        // $pdf->SetFont('dejavusans', '', '7');
        $tabel = '
            <table>
              <tr>
                <td width="15%" rowspan="4"><img class="img-thumbnail" src="./assets/images/logo.JPG" style="margin-top:10%; max-width: 120px; width: auto; max-height: 120px;"></td>
                <td width="70%"><h2 style="text-align: center;">LAPORAN KERJA KARYAWAN</h2></td>
                <td width="15%"></td>
              </tr>
              <tr>
                <td width="1%"></td>
                <td width="40%"></td>
                <td width="4%"></td>
                <td width="40%"></td>
              </tr>
              <tr>
                <td width="1%"></td>
                <td width="10%">Nama </td>
                <td width="30%"><p>: <strong></strong></p></td>
                <td width="4%"></td>
                <td width="10%">Periode </td>
                <td width="30%"><p>: <strong></strong></p></td>
              </tr>
              <tr>
                <td width="1%"></td>
                <td width="10%">Jabatan </td>
                <td width="30%"><p>: <strong></strong></p></td>
                <td width="4%"></td>
                <td width="10%">Cetak </td>
                <td width="30%"><p>: </p></td>
              </tr>
              <tr>
                <td width="15%"></td>
                <td width="35%"></td>
                <td width="10%"></td>
                <td width="40%"></td>
              </tr>
            </table>
            <table border="1">
                <tr>
                  <td width="15%" align="center">TANGGAL</td>
                  <td width="12%" align="center">MASUK</td>
                  <td width="12%" align="center">PULANG</td>
                  <td width="11%" align="center">DURASI</td>
                  <td width="10%" align="center">PROSES</td>
                  <td width="10%" align="center">CETAK</td>
                  <td width="10%" align="center">ORDERAN</td>
                  <td width="10%" align="center">TASK</td>
                  <td width="10%" align="center">KPI CETAK</td>
                </tr>
            </table>
        ';
        $pdf->writeHTML($tabel);
        $pdf->Output();
    }
    // if ($startdate == date('F Y')) {
    //     $hari      = date("d");//cal_days_in_month($kalender, $bulan, $tahun);
    //     // echo "bulan ini";
    // } else {
    //     // echo "bulan kemarin";
    //     $hari       = cal_days_in_month($kalender, $bulan, $tahun);
    // }
    // for ($tanggal = 1; $tanggal <= $hari; $tanggal++) {

    //     $date = $tahun.'/'.$bulan.'/'.$tanggal; //format date
    //     $get_name = date('l', strtotime($date)); //get week day
    //     $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars

    //     if($day_name != 'Sun' && $day_name != 'Sat'){
    //         $workdays = $date;
    //      // echo "<pre>", print_r($workdays, 1), "</pre>";
    //     }

    // }
}