<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Report extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();

        $this->load->library('pdf');
        $this->load->model("Model_master");
        $this->load->model("Model_report");

    }

    public function index() {
        if(isset($_GET['startdate']) && ! empty($_GET['startdate']) && isset($_GET['enddate']) && ! empty($_GET['enddate'])){ 
            $startdate =  date('Y-m-d',strtotime($_GET['startdate']));
            $enddate = date('Y-m-d',strtotime($_GET['enddate']));
        }else{
            $startdate = date('Y-m-01');
            $enddate = date('Y-m-d');
        }

        $data['selesai']       = $this->Model_report->get_selesai("", $startdate, $enddate);
        // echo $this->db->last_query();
        $data['batal']         = $this->Model_report->get_batal("", $startdate, $enddate);
        $data['perlu_dikirim'] = $this->Model_report->get_perlu_dikirim("", $startdate, $enddate);
        $data['dikerjakan']    = $this->Model_report->get_dikerjakan("", $startdate, $enddate);
        $data['desain']        = $this->Model_report->get_desain("", $startdate, $enddate);
        $data['cetak_diluar']  = $this->Model_report->get_cetak_diluar("", $startdate, $enddate);
        $data['antri_cetak']   = $this->Model_report->get_antri_cetak("", $startdate, $enddate);
        $data['packing']       = $this->Model_report->get_packing("", $startdate, $enddate);
        // echo $this->db->last_query();
        $data['menunggu_pengiriman']  = $this->Model_report->get_menunggu_pengiriman("", $startdate, $enddate);
        $data['sedang_dikirim']  = $this->Model_report->get_sedang_dikirim("", $startdate, $enddate);
        $data['bahan']         = $this->Model_report->get_bahan("", $startdate, $enddate);
        // echo "<pre>", print_r($bahan, 1), "</pre>";
        $data['kategori']      = $this->Model_report->get_kategori("", $startdate, $enddate);
        // echo $this->db->last_query();
        $data['total_kerusakan_bahan']      = $this->Model_report->get_total_kerusakan_bahan($startdate, $enddate);
        $data['total_pemasukan_bahan']      = $this->Model_report->get_total_pemasukan_bahan($startdate, $enddate);
        // echo $this->db->last_query();
        $data['total_ongkir_kirim']      = $this->Model_report->get_total_ongkir_kirim($startdate, $enddate);
        // echo "<pre>", print_r($total_ongkir_kirim, 1), "</pre>";

        $data['total_harga_barang']      = $this->Model_report->get_total_harga_barang($startdate, $enddate);
        $data['pemasukan_bahan']      = $this->Model_report->get_pemasukan_bahan($startdate, $enddate);
        $data['pemakaian_bahan']      = $this->Model_report->get_total_pemakaian_bahan($startdate, $enddate);
        $data['list_pemakaian_bahan']      = $this->Model_report->get_pemakaian_bahan($startdate, $enddate);
        // echo $this->db->last_query();
        $data['biaya_operasional']      = $this->Model_report->get_total_biaya_operasional($startdate, $enddate);
        $data['pemasukan']      = $this->Model_report->get_total_pemasukan($startdate, $enddate);   
        $data['pengeluaran_bahan'] = $this->Model_report->get_nol_pengeluaran($startdate, $enddate);
            // echo $this->db->last_query();
            // echo "<pre>", print_r($pengeluaran, 1), "</pre>";
        $user = $this->Model_report->get_user();
        $i=0;
        foreach ($user as $us) {
            $id_user  = $us['id_user'];
            $user_produksi  = $this->Model_report->get_user_produksi($id_user, $startdate, $enddate);
            $user_non_produksi  = $this->Model_report->get_user_non_produksi($id_user, $startdate, $enddate);
        // echo '<pre>',print_r($user_produksi,1),'</pre>';
            $user[$i]['user_produksi']  = $user_produksi; 
            $user[$i]['user_non_produksi']  = $user_non_produksi; 
            $i++;
        }

        $per_user = $this->Model_report->get_user();
        $per=0;
        foreach ($per_user as $user){
            $id_user = $user['id_user'];
            $hari_kerja = $this->Model_report->get_total_hari_kerja($id_user, $startdate, $enddate);
            // echo $this->db->last_query();
            // echo "<pre>", print_r($hari_kerja, 1), "</pre>";
            $edit_absen = $this->Model_report->get_total_edit_absen($id_user, $startdate, $enddate);
            $telat = $this->Model_report->get_total_telat($id_user, $startdate, $enddate);
            $on_time = $this->Model_report->get_total_on_time($id_user, $startdate, $enddate);
            $proses = $this->Model_report->get_jumlah_proses($id_user, $startdate, $enddate);
            $cetak = $this->Model_report->get_jumlah_cetak($id_user, $startdate, $enddate);
            $task = $this->Model_report->get_jumlah_task($id_user, $startdate, $enddate);
            $durasi_kerja = $this->Model_report->get_durasi_kerja($id_user, $startdate, $enddate);
            $cuti = $this->Model_report->get_cuti($id_user, $startdate, $enddate);
            

            $per_user[$per]['hari_kerja']  = $hari_kerja; 
            $per_user[$per]['edit_absen']  = $edit_absen; 
            $per_user[$per]['telat']  = $telat; 
            $per_user[$per]['on_time']  = $on_time; 
            $per_user[$per]['proses']  = $proses; 
            $per_user[$per]['cetak']  = $cetak; 
            $per_user[$per]['task']  = $task; 
            $per_user[$per]['durasi_kerja']  = $durasi_kerja; 
            $per_user[$per]['cuti']  = $cuti; 
            $per++;
        }
        // echo "<pre>", print_r($per_user, 1), "</pre>";

        // echo $this->db->last_query();
        // echo $this->db->last_query();
        $data['orderan']      = $user;
        $data['per_user']     = $per_user;
        $data['orderan_rusak']= $this->Model_report->get_orderan_kerusakan($startdate, $enddate);
    	$this->template->load("template", "report/data-report", $data);

    }

    public function cetak_kerja_karyawan($startdate, $enddate, $user){
        $nama = $this->db->get_where("tbl_user", ['id_user' => $user])->row();
        $jabatan = $this->db->get_where("tbl_role", ['id_role' => $nama->id_role])->row();
        $start = date('Y-m-d',strtotime($startdate));
        $end = date('Y-m-d',strtotime($enddate));
        $hari_kerja = $this->Model_report->get_total_hari_kerja($user, $start, $end);
        // echo $this->db->last_query();
        // echo "<pre>", print_r($hari_kerja, 1), "</pre>";
        $edit_absen = $this->Model_report->get_total_edit_absen($user, $start, $end);
        $telat = $this->Model_report->get_total_telat($user, $start, $end);
        $on_time = $this->Model_report->get_total_on_time($user, $start, $end);
        $proses = $this->Model_report->get_jumlah_proses($user, $start, $end);
        $cetak = $this->Model_report->get_jumlah_cetak($user, $start, $end);
        $task = $this->Model_report->get_jumlah_task($user, $start, $end);
        $durasi_kerja = $this->Model_report->get_durasi_kerja($user, $start, $end);
        $cuti = $this->Model_report->get_cuti($user, $start, $end);

        if (!empty($cuti[0]->cuti)) {
            $cuti_karyawan = $cuti[0]->cuti;
        } else {
            $cuti_karyawan = "0";
        }

        if (!empty($proses[0]->jumlah_proses)) {
            $proses_karyawan = $proses[0]->jumlah_proses;
        } else {
            $proses_karyawan = "0";
        }

        if (!empty($cetak[0]->jumlah_cetak)) {
            $cetak_karyawan = $cetak[0]->jumlah_cetak;
        } else {
            $cetak_karyawan = "0";
        }

        if (!empty($task[0]->jumlah_task)) {
            $task_karyawan = $task[0]->jumlah_task;
        } else {
            $task_karyawan = "0";
        }

        if (!empty($proses[0]->jumlah_proses) && !empty($cetak[0]->jumlah_cetak)) {
         $kpi_cetak_karyawan = round($proses[0]->jumlah_proses/$cetak[0]->jumlah_cetak * 100,2);
        } else {
         $kpi_cetak_karyawan = "0";
        }

        if (!empty($edit_absen[0]->total_edit_absen)) {
            $edit_absen_karyawan = $edit_absen[0]->total_edit_absen;
        } else {
            $edit_absen_karyawan = "0";
        }

        if (!empty($telat[0]->total_telat)) {
            $telat_karyawan = $telat[0]->total_telat;
        } else {
            $telat_karyawan = "0";
        }

        if (!empty($on_time[0]->total_on_time)) {
            $on_time_karyawan = $on_time[0]->total_on_time;
        } else {
            $on_time_karyawan = "0";
        }


        $absensi = $this->Model_report->get_absensi_report($startdate, $enddate, $user);
        $i=0;
        foreach ($absensi as $ab) {
            $tanggal_masuk = date('Y-m-d', strtotime($ab['tanggal_masuk']));
            $id_user    = $ab['id_user'];
            $proses = $this->Model_report->get_dikerjakan_karyawan($tanggal_masuk, $id_user);
            $cetak      = $this->Model_report->get_cetak_karyawan($tanggal_masuk, $id_user);
            $orderan    = $this->Model_report->get_orderan_karyawan($tanggal_masuk);
            $task       = $this->Model_report->get_task_karyawan($tanggal_masuk, $id_user);
            $telat       = $this->Model_report->get_telat_karyawan($tanggal_masuk, $id_user);
            $ontime       = $this->Model_report->get_ontime_karyawan($tanggal_masuk, $id_user);
            // echo $this->db->last_query();
            // echo "<pre>", print_r($ontime, 1), "</pre>";
            $absensi[$i]['proses']  = $proses; 
            $absensi[$i]['cetak']  = $cetak; 
            $absensi[$i]['orderan']  = $orderan; 
            $absensi[$i]['task']  = $task; 
            $absensi[$i]['telat']  = $telat; 
            $absensi[$i]['ontime']  = $ontime; 
            $i++;
        }
        // echo "<pre>", print_r($absensi, 1), "</pre>";
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintFooter(false);
        $pdf->setPrintHeader(false);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->AddPage('L','A4');
        $pdf->SetFont('courier', '', '10');
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
                <td width="30%"><p>: '.$nama->full_name.'</p></td>
                <td width="4%"></td>
                <td width="10%">Periode </td>
                <td width="30%"><p>: '.substr($startdate, 0,2).' s/d '.date("d F Y", strtotime($enddate)).'</p></td>
              </tr>
              <tr>
                <td width="1%"></td>
                <td width="10%">Jabatan </td>
                <td width="30%"><p>: '.$jabatan->name_role.'</p></td>
                <td width="4%"></td>
                <td width="10%">Cetak </td>
                <td width="30%"><p>: '.date("d F Y").'</p></td>
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
                  <td width="15%" align="center"><strong>TANGGAL</strong></td>
                  <td width="10%" align="center"><strong>MASUK</strong></td>
                  <td width="10%" align="center"><strong>PULANG</strong></td>
                  <td width="10%" align="center"><strong>DURASI</strong></td>
                  <td width="7%" align="center"><strong>TELAT</strong></td>
                  <td width="7%" align="center"><strong>ON TIME</strong></td>
                  <td width="7%" align="center"><strong>PROSES</strong></td>
                  <td width="7%" align="center"><strong>CETAK</strong></td>
                  <td width="10%" align="center"><strong>ORDERAN</strong></td>
                  <td width="7%" align="center"><strong>TASK</strong></td>
                  <td width="10%" align="center"><strong>KPI CETAK</strong></td>
                </tr>';
        $q = 1;
        foreach ($absensi as $k) {
            if (!empty($k['proses'][0]['jumlah_dikerjakan']) && !empty($k['orderan'][0]['jumlah_orderan'])) {
                $hasil_kpi = "";
                $kpi_cetak = round($k['proses'][0]['jumlah_dikerjakan']/$k['orderan'][0]['jumlah_orderan'] * 100,2);
            } else {
                $kpi_cetak = "0";
            }

            if (!empty($k['telat'][0]['jumlah_telat'])) {
                $telat = $k['telat'][0]['jumlah_telat'];
            } else {
                $telat = "0";
            }
            
            if (!empty($k['ontime'][0]['jumlah_ontime'])) {
                $ontime = $k['ontime'][0]['jumlah_ontime'];
            } else {
                $ontime = "0";
            }
        // $jumlah = $kpi_cetak * 10;
        $tabel.='<tr>
                  <td align="center">'.date("d F Y", strtotime($k['tanggal_masuk'])).'</td>
                  <td align="center">'.date("H:i", strtotime($k['tanggal_masuk'])).'</td>
                  <td align="center">'.date("H:i", strtotime($k['tanggal_keluar'])).'</td>
                  <td align="center">'.date("H:i", strtotime($k['durasi_kerja'])).'</td>
                  <td align="center">'.$telat.'</td>
                  <td align="center">'.$ontime.'</td>
                  <td align="center">'.$k['proses'][0]['jumlah_dikerjakan'].'</td>
                  <td align="center">'.$k['cetak'][0]['jumlah_cetak'].'</td>
                  <td align="center">'.$k['orderan'][0]['jumlah_orderan'].'</td>
                  <td align="center">'.$k['task'][0]['jumlah_task'].'</td>
                  <td align="center">'.$kpi_cetak."%".'</td>
                </tr>';
        $q++;
        }
        $tabel.= '</table>
            <div></div>
            <div></div>
            <table >
              <tr>
                <td width="20%" align="center"><strong>Total Hari Kerja</strong></td>
                <td width="20%" align="center"><strong>Total Durasi Kerja</strong></td>
                <td width="20%" align="center"><strong>Jumlah Cuti</strong></td>
                <td width="20%" align="center"><strong>Jumlah Proses</strong></td>
                <td width="20%" align="center"><strong>Jumlah Cetak</strong></td>
              </tr>
              <tr>
                <td align="center">'.$hari_kerja[0]->total_hari_kerja.'</td>
                <td align="center">'.$durasi_kerja[0]->durasi_kerja.'</td>
                <td align="center">'.$cuti_karyawan.'</td>
                <td align="center">'.$proses_karyawan.'</td>
                <td align="center">'.$cetak_karyawan.'</td>
              </tr>
              <tr>
                <td width="20%" align="center"></td>
                <td width="20%" align="center"></td>
                <td width="20%" align="center"></td>
                <td width="20%" align="center"></td>
                <td width="20%" align="center"></td>
              </tr>
              <tr>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
              </tr>
              <tr>
                <td width="20%" align="center"><strong>Jumlah Task</strong></td>
                <td width="20%" align="center"><strong>KPI</strong></td>
                <td width="20%" align="center"><strong>Total Edit Absen</strong></td>
                <td width="20%" align="center"><strong>Total Telat</strong></td>
                <td width="20%" align="center"><strong>Total Ontime</strong></td>
              </tr>
              <tr>
                <td align="center">'.$task_karyawan.'</td>
                <td align="center">'.$kpi_cetak_karyawan."%".'</td>
                <td align="center">'.$edit_absen_karyawan.'</td>
                <td align="center">'.$telat_karyawan.'</td>
                <td align="center">'.$on_time_karyawan.'</td>
              </tr>
            </table>
            ';
        $pdf->writeHTML($tabel);
        $pdf->Output();
    }
    // mencari per tanggal berdasarkan status pesanan selesai
    // SELECT COUNT(*)
    // FROM
    // (
    //     SELECT COUNT(no_pesanan)
    //     FROM tbl_order 
    //     where status_pesanan = 'Selesai' AND DATE(waktu_dibuat) >= '2021-10-02' AND DATE(waktu_dibuat) <= '2021-11-02'
    //     GROUP BY no_pesanan
    // ) selesai
}