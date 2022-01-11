<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
		parent::__construct();
		checkSessionUser();
        $loginstatus = $this->session->userdata('role');

         if($loginstatus!="ADMIN" && $loginstatus!="PRODUKSI" && $loginstatus!="DESAIN"){

            redirect('my404');

        }
        $this->load->model("Model_master");
        $this->load->model("Model_setting");
        $this->load->model("Model_dashboard");
    }

    public function index(){
    	$data["syarat"] = $this->Model_master->getMasterOneTable("*", "tbl_ketentuan", "id_ketentuan", "asc", "");
        $data["stock"]  = $this->Model_master->getMasterOneTable("*", "tbl_stock", "id_stock", "asc", "");
    	$selesai        = $this->Model_dashboard->get_selesai();
        $packing        = $this->Model_dashboard->get_packing();
        $batal          = $this->Model_dashboard->get_batal();
        $antri_cetak    = $this->Model_dashboard->get_antri_cetak();
        $jumlah_selesai       = array();
        $jumlah_packing       = array();
        $jumlah_batal         = array();
        $jumlah_antri_cetak   = array();

    	foreach ($selesai as $k) {
    		$no_pesanan = $k["no_pesanan"];
            array_push($jumlah_selesai, array( $no_pesanan ));
    	}

        foreach ($packing as $k) {
            $no_pesanan = $k["no_pesanan"];
            array_push($jumlah_packing, array( $no_pesanan ));
        }

        foreach ($batal as $k) {
            $no_pesanan = $k["no_pesanan"];
            array_push($jumlah_batal, array( $no_pesanan ));
        }

        foreach ($antri_cetak as $k) {
            $no_pesanan = $k["no_pesanan"];
            array_push($jumlah_antri_cetak, array( $no_pesanan ));
        }
    	$data["selesai"]        = count($jumlah_selesai);
        $data["packing"]        = count($jumlah_packing);
        $data["batal"]          = count($jumlah_batal);
        $data["antri_cetak"]    = count($jumlah_antri_cetak);
        // echo $this->db->last_query();
        //cek status masuk di absensni
        $isMasuk        = $this->Model_dashboard->isMasuk($this->session->userdata('id_user'));
        //cek hari ini sudah masuk
        $isCekinHariIni = $this->Model_dashboard->isCekinHariIni($this->session->userdata('id_user'));
        // echo $this->db->last_query();
        $status = "";
        if (!$isMasuk) {
            // echo "tidak ada status masuk";
            if($isCekinHariIni){
                $status = "SUDAH ABSEN MASUK HARI INI";
            } else {
                $status = "BELUM MASUK HARI INI";
            }
        } else {
            $time_in    = $isMasuk[0]['tanggal_masuk'];
            $time_out   = date('Y-m-d H:i:s');
            $awal       = strtotime($time_in);
            $akhir      = strtotime($time_out);
            $diff1      = $akhir - $awal;

            $jam   = floor($diff1 / (60 * 60));
            $menit = $diff1 - ( $jam * (60 * 60) );
            $detik = $diff1 % 60;

            $jarak_pulang   = 8;//Jam
            if($isCekinHariIni){
                if($jam >= $jarak_pulang){
                    $status = "BELUM ABSEN PULANG";
                }else{
                    $status = "BELUM BISA ABSEN PULANG";
                }
            } else {
                $status = "LUPA MASUK DAN PULANG";
            }
        }
        // echo $status;
        $data['status'] = $status;
        $data['tampilan_absensi'] = $this->Model_dashboard->report_list();
        // echo $this->db->last_query();
        $data['komplain'] = $this->Model_dashboard->get_komplain();
        $data['telat'] = $this->Model_dashboard->get_telat();
        $data['cuti'] = $this->Model_dashboard->get_cuti();
        $data['absensi'] = $this->Model_dashboard->get_absensi();
        // echo $this->db->last_query();
		$this->template->load("template", "dashboard/dashboard_awal", $data);
    }
    
}
        // AND date(tanggal_masuk) = date(NOW())
?>