<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orderan_sedang extends CI_Controller {

    public function __construct(){
		parent::__construct();
        checkSessionUser();
        $this->load->library('pdf');
        $this->load->library('PHPExcel','excel');
        $this->load->model("Model_user");
        $this->load->model("Model_master");
        $this->load->model("Model_orderan");
        $this->load->library('session');
    }

    public function index(){

        $list_order = $this->Model_orderan->get_orderan_sedang();
        // echo $this->db->last_query();
        $i=0;
        foreach ($list_order as $k) {
            $no_pesanan       = $k['no_pesanan'];
            // $nomor_sku        = $k['nomor_sku'];
            $opsi_pengiriman  = $k['opsi_pengiriman'];
            $username         = $k['username'];
            $user_packing     = $k['user_packing'];
            $nama_penerima    = $k['nama_penerima'];
            $kota_kabupaten   = $k['kota_kabupaten'];
            $waktu_batas      = $k['waktu_batas'];
            $waktu_dibuat     = $k['waktu_dibuat'];
            $status_pesanan   = $k['status_pesanan'];
            $status_kerjakan  = $k['status_kerjakan'];
            $full_name        = $k['full_name'];
            $user_cetak       = $k['user_cetak'];
            $id_user          = $k['id_user'];
            $jumlah_order     = $this->Model_orderan->get_jumlah_orderan_sedang($no_pesanan);
            $no_pesanan_order = $this->Model_orderan->get_no_pesanan_sedang($no_pesanan);
            // echo "<pre>", print_r($no_pesanan_order, 1), "</pre>";
            $nomor_sku_order = array();
            for ($a=0; $a < $jumlah_order[0]['jumlah']; $a++) { 
                $nomor_sku        = $no_pesanan_order[$a]['nomor_sku'];
                $sku_induk        = $no_pesanan_order[$a]['sku_induk'];
                $no_pesanan       = $no_pesanan_order[$a]['no_pesanan'];
                $id_orderan       = $no_pesanan_order[$a]['id_orderan'];
                $sku_kosong       = "";

                if ($nomor_sku != "") {
                    // echo "tidak kosong";
                    $sku_order  = $this->Model_orderan->get_nomor_sku_sedang($sku_induk, $id_orderan);
                    // echo $this->db->last_query();
                    array_push($nomor_sku_order, array(
                        $sku_order
                    ));
                } else {
                    $sku_order  = $this->Model_orderan->get_nomor_sku_kosong($sku_induk, $id_orderan);
                    // echo "<pre>", print_r($sku_order, 1), "</pre>";
                    array_push($nomor_sku_order, array(
                       $sku_order
                    ));
                    // echo "kosong";
                }
            }
            // $jumlah_kerusakan = $this->Model_orderan->get_jumlah_kerusakan($no_pesanan);
                // echo "<pre>", print_r($nomor_sku_order,1), "</pre>";
            // $list_order[$i]['no_pesanan_order'] = $no_pesanan_order;
            $list_order[$i]['nomor_sku_order']  = $nomor_sku_order;
            $list_order[$i]['jumlah_order']     = $jumlah_order;
            // echo "<pre>", print_r($no_pesanan_order, 1), "</pre>";
            $i++;
        }
        // echo "<pre>", print_r($list_order, 1), "</pre>";
        $data["orderan"]  = $list_order;
		$this->template->load("template", "orderan/data-orderan_sedang", $data);
    }
}
?>