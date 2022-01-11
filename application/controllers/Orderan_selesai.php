<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orderan_selesai extends CI_Controller {

    public function __construct(){
		parent::__construct();
        checkSessionUser();
        $this->load->model("Model_orderan");
        $this->load->model("Model_point");
    }

    public function index(){
        // $data["orderan_selesai"] = $this->Model_orderan->get_orderan_selesai();
        $list_order = $this->Model_orderan->get_orderan_selesai();
        $i=0;
        foreach ($list_order as $k) {
            $no_pesanan                     = $k['no_pesanan'];
            // $nomor_sku        = $k['nomor_sku'];
            $opsi_pengiriman                = $k['opsi_pengiriman'];
            $username                       = $k['username'];
            $user_packing                   = $k['user_packing'];
            $nama_penerima                  = $k['nama_penerima'];
            $kota_kabupaten                 = $k['kota_kabupaten'];
            $waktu_batas                    = $k['waktu_batas'];
            $waktu_dibuat                   = $k['waktu_dibuat'];
            $status_pesanan                 = $k['status_pesanan'];
            $status_kerjakan                = $k['status_kerjakan'];
            $full_name                      = $k['full_name'];
            $user_cetak                     = $k['user_cetak'];
            $id_user                        = $k['id_user'];
            $status_point                   = $k['status_point'];
            $tanggal_dikerjakan             = $k['tanggal_dikerjakan'];
            $tanggal_desain                 = $k['tanggal_desain'];
            $tanggal_antri_cetak            = $k['tanggal_antri_cetak'];
            $tanggal_cetak_diluar           = $k['tanggal_cetak_diluar'];
            $tanggal_menunggu_pengiriman    = $k['tanggal_menunggu_pengiriman'];
            $tanggal_packing                = $k['tanggal_packing'];
            $tanggal_dikirim                = $k['tanggal_dikirim'];
            $jumlah_order     = $this->Model_orderan->get_jumlah_orderan_selesai($no_pesanan);
            $no_pesanan_order = $this->Model_orderan->get_no_pesanan_selesai($no_pesanan);
                // echo "<pre>", print_r($no_pesanan_order,1), "</pre>";
            $nomor_sku_order = array();
            for ($a=0; $a < $jumlah_order[0]['jumlah']; $a++) { 
                $nomor_sku        = $no_pesanan_order[$a]['nomor_sku'];
                $sku_induk        = $no_pesanan_order[$a]['sku_induk'];
                $no_pesanan       = $no_pesanan_order[$a]['no_pesanan'];
                $id_orderan       = $no_pesanan_order[$a]['id_orderan'];
                // $sku_order  = $this->Model_orderan->get_nomor_sku_selesai($nomor_sku);
                // array_push($nomor_sku_order, array(
                //     $sku_order
                // ));
                $sku_kosong       = "";

                if ($nomor_sku != "") {
                    // echo "tidak kosong";
                    $sku_order  = $this->Model_orderan->get_nomor_sku_selesai($sku_induk, $id_orderan);
                    // echo $this->db->last_query();
                    // echo "<pre>", print_r($sku_order, 1), "</pre>";
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
            // echo "<pre>", print_r($nama_variasi_order, 1), "</pre>";
            // $list_order[$i]['no_pesanan_order'] = $no_pesanan_order;
            $list_order[$i]['nomor_sku_order']  = $nomor_sku_order;
            $list_order[$i]['jumlah_order']     = $jumlah_order;
            $i++;
        }
        // echo "<pre>", print_r($list_order, 1), "</pre>";
        $data["orderan_selesai"]  = $list_order;
		$this->template->load("template", "orderan/orderan-selesai", $data);
    }

    public function change_status_reject(){

        $no_pesanan = $this->input->post("no_pesanan");
        $alasan     = $this->input->post("alasan");

        $action = $this->Model_orderan->change_status_reject($no_pesanan, $alasan);
        if ($action) {
            $this->session->set_flashdata("success", "Reject Orderan Berhasil");
        } else {
            $this->session->set_flashdata("error", "Gagal, orderan tidak dapat di reject");
        }
        redirect("orderan_selesai");
    }

    public function change_status_approve(){
        $no_pesanan   = $this->input->post('no_pesanan');
        $username     = $this->input->post('username');
        $harga_total  = $this->input->post('harga_total');
        $setting      = $this->db->get_where('tbl_setting', ['id_setting' => 1])->row();
        $jumlah_point = $harga_total / $setting->harga_setting; 
        $tanggal      = date("Y-m-d H:i:s");
        // print_r($username." - ".$harga_total." - ".$no_pesanan);
        // print_r($jumlah_point);
        $action      = $this->Model_orderan->change_status_approve($no_pesanan);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Approve Orderan Berhasil"));

            $same_username = $this->Model_point->check_existing_name("username", $username);

            if ($same_username) {
                // print_r("username sama");
                // print_r($same_username[0]->jumlah_point);
                $total = $same_username[0]->jumlah_point + $jumlah_point;
                $this->db->set('jumlah_point', $total);
                $this->db->where('username', $username);
                $this->db->update('tbl_total_point');
            } else {
                // print_r("username tidak ada");
                $data = array(
                    "username"      => $username,
                    "jumlah_point"  => $jumlah_point
                );
                $this->db->insert('tbl_total_point', $data);
            }

            $data = array(
                'username'       => $username,
                'no_pesanan'     => $no_pesanan,
                'jumlah_point'   => $jumlah_point,
                'nominal'        => $setting->harga_setting,
                'point'          => $setting->jumlah_setting,
                'tgl_entry'      => $tanggal
            );

            $this->db->insert('tbl_point', $data); 

        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, orderan tidak dapat di approve"));
        } 
    }

}
?>