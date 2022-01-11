<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// tambah kolom di tbl_orderan kolom jumlah_produk dan id_user_cetak ok
// tbl_variasi kolom nomor_sku ok
// ada tambah di tbl_komplain list lihat di task management
// tambah folder komplain di folder file ok

class Transaksi extends CI_Controller {
    
    public function __construct(){

		parent::__construct();

        checkSessionUser();
        $this->load->library('pdf');
        $this->load->model("Model_master");
        $this->load->model("Model_transaksi");

    }

    public function index() {
        // $data['bahan']      = $this->Model_master->get_bahan();
        $data['produk']      = $this->Model_master->getMasterOneTable("*", "tbl_product", "  deskripsi", "asc", "");
        $data['customer']      = $this->Model_master->getMasterOneTable("*", "tbl_customer", "nama_customer", "asc", "");
        $data['opsi_pembayaran']  = $this->Model_master->getMasterOneTable("*", "tbl_opsi_pembayaran", "  jenis_pembayaran", "asc", "");
        $data['draft_pesanan'] = $this->Model_transaksi->get_no_pesanan_draft();
        $data['total_tagihan'] = $this->Model_transaksi->get_total_tagihan();
        $data1 = $this->Model_transaksi->get_transaksi("");
    	$this->template->load("template", "transaksi/data-transaksi", $data);
    }

    public function get_transaksi($id_orderan = null){
        $data = $this->Model_transaksi->get_transaksi($id_orderan);
        if(!empty($data)) {
            $i=0;

            foreach ((array) $data as $k) {
                $id_orderan    = $k->id_orderan;
                $total_tagihan   = $this->Model_transaksi->get_total_tagihan();

                $data[$i]->total_tagihan  = $total_tagihan; 

                $i++; 

            }
        }
        // echo print_r($data);
        // echo "<pre>", print_r($data, 1), "</pre>";
        echo json_encode(array("status" => "success", "data" => $data));
    }

    public function get_transaksi_edit($no_pesanan){
        $data = $this->Model_transaksi->get_transaksi_edit($no_pesanan);
        // echo $this->db->last_query();
        if(!empty($data)) {
            $i=0;

            foreach ((array) $data as $k) {
                $id_orderan    = $k->id_orderan;
                $jumlah_orderan   = $this->Model_transaksi->get_jumlah_orderan($no_pesanan);

                $data[$i]->jumlah_orderan  = $jumlah_orderan; 

                $i++; 

            }
        // echo "<pre>", print_r($data, 1), "</pre>";
        // echo print_r($data);
        echo json_encode(array("status" => "success", "data" => $data));
        }
    }
    
    public function get_transaksi_edit_perpesanan($id_orderan){
        $data = $this->Model_transaksi->get_transaksi_edit_perpesanan($id_orderan);
        // echo $this->db->last_query();
        if(!empty($data)) {
            $i=0;

            foreach ((array) $data as $k) {
                $id_orderan    = $k->id_orderan;
                $jumlah_orderan   = $this->Model_transaksi->get_jumlah_orderan($id_orderan);

                $data[$i]->jumlah_orderan  = $jumlah_orderan; 

                $i++; 

            }
        // echo "<pre>", print_r($data, 1), "</pre>";
        // echo print_r($data);
        echo json_encode(array("status" => "success", "data" => $data));
        }
    }

    // public function get_transaksi($id_orderan = null){
    //     $data = $this->Model_transaksi->get_transaksi($id_orderan);
    //     echo json_encode(array("status" => "success", "data" => $data));
    // }

    public function get_sub_variasi(){
        $id=$this->input->post('id');
        // echo print_r($id);
        $data=$this->Model_transaksi->get_sub_variasi($id);
        echo json_encode($data);
    }

    public function get_nama_produk(){
        $id=$this->input->post('id');
        // echo print_r($id);
        $data=$this->Model_transaksi->get_nama_produk($id);
        echo json_encode($data);
    }

    public function get_nama_variasi(){
        $id=$this->input->post('id');
        // echo print_r($id);
        $data=$this->Model_transaksi->get_nama_variasi($id);
        echo json_encode($data);
    }

    public function action_tambah(){
        $no_pesanan     = $this->input->post("no_pesanan");
        $id_produk      = $this->input->post("id_produk");
        $sku_induk      = $this->input->post("sku_induk");
        $id_variasi     = $this->input->post("id_variasi");
        $harga_variasi  = $this->input->post("harga_variasi");
        $qty            = $this->input->post("qty");
        $catatan_pembeli= $this->input->post("catatan_pembeli");
        $produk    = $this->db->get_where("tbl_product", ['id_product' => $id_produk])->row();
        $nama_produk    = $produk->deskripsi;
        $variasi    = $this->db->get_where("tbl_variasi", ['id_variasi' => $id_variasi])->row();
        $nomor_sku      = $variasi->nomor_sku;
        $nama_variasi   = $variasi->nama_variasi;
        $total_harga    = $harga_variasi * $qty;

        $data = array(
            "source"            => 'STORE',
            "no_pesanan"        => $no_pesanan,
            "status_pesanan"    => 'Draft',
            "id_produk"         => $id_produk,
            "nama_produk"       => $nama_produk,
            "sku_induk"         => $sku_induk,
            "nomor_sku"         => $nomor_sku,
            "id_variasi"        => $id_variasi,
            "nama_variasi"      => $nama_variasi,
            "harga_awal"        => $harga_variasi,
            "total_qty"         => $qty,
            "total_harga"       => $total_harga,
            "catatan_pembeli"   => $catatan_pembeli,
            "waktu_dibuat"      => date("Y-m-d H:i:s"),
            "waktu_pembayaran"  => date("Y-m-d H:i:s")
            );
        $action = $this->Model_master->tambahMaster("tbl_order", $data);
            if($action){
                echo json_encode(array("status" => "success", "message" => "Transaksi berhasil ditambahkan", "data" => $data));
            } else {
                echo json_encode(array("status" => "error", "message" => "Transaksi gagal di tambahkan"));
            }
    }

    public function action_ubah(){
        $id_orderan     = $this->input->post("id_orderan");
        $no_pesanan     = $this->input->post("no_pesanan");
        $id_produk      = $this->input->post("id_produk");
        $sku_induk      = $this->input->post("sku_induk");
        $id_variasi     = $this->input->post("id_variasi");
        $harga_variasi  = $this->input->post("harga_variasi");
        $qty            = $this->input->post("qty");
        $catatan_pembeli= $this->input->post("catatan_pembeli");
        $produk    = $this->db->get_where("tbl_product", ['id_product' => $id_produk])->row();
        $nama_produk    = $produk->deskripsi;
        $variasi    = $this->db->get_where("tbl_variasi", ['id_variasi' => $id_variasi])->row();
        $nomor_sku      = $variasi->nomor_sku;
        $nama_variasi   = $variasi->nama_variasi;
        $total_harga    = $harga_variasi * $qty;

        $data = array(
            "no_pesanan"        => $no_pesanan,
            "id_produk"         => $id_produk,
            "nama_produk"       => $nama_produk,
            "sku_induk"         => $sku_induk,
            "id_variasi"        => $id_variasi,
            "nama_variasi"      => $nama_variasi,
            "nomor_sku"         => $nomor_sku,
            "harga_awal"        => $harga_variasi,
            "total_qty"         => $qty,
            "total_harga"       => $total_harga,
            "catatan_pembeli"   => $catatan_pembeli
            );
        // echo "<pre>", print_r($data, 1), "<pre>";
        $action = $this->Model_master->editMaster(array('id_orderan' => $id_orderan), "tbl_order", $data);
            if($action){
                echo json_encode(array("status" => "success", "message" => "Transaksi berhasil diubah", "data" => $data));
            } else {
                echo json_encode(array("status" => "error", "message" => "Transaksi gagal di ubah"));
            }
    }

    public function delete_transaksi(){
        $id_orderan = $this->input->post("id_orderan");
        $delete         = $this->Model_master->deleteMaster($id_orderan, "id_orderan", "tbl_order");
        if ($delete) {
            echo json_encode(array("status" => "success", "data" => $id_orderan, "message"  => "Berhasil menghapus transaksi"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus transaksi"));
         }
    }

    public function tambah_transaksi(){
        $no_pesanan         = $this->input->post("no_pesanan");
        $persentase         = $this->input->post("persentase");
        $harga_persen       = $this->input->post("harga_persen");
        $total_tagihan      = $this->input->post("total_tagihan");
        $keterangan         = $this->input->post("keterangan");
        $jumlah_produk      = $this->input->post("jumlah_produk");
        $total_all          = $this->input->post("total_all");
        $tanggal_deadline   = $this->input->post("tanggal_deadline");
        $opsi_pembayaran    = $this->input->post("opsi_pembayaran");
        $jumlah_pembayaran  = $this->input->post("jumlah_pembayaran");
        $jumlah_pembayaran = str_replace('Rp. ','',$jumlah_pembayaran);
        $jumlah_pembayaran = str_replace('.','',$jumlah_pembayaran);
        $id_customer = $this->input->post("id_customer");
        if ($id_customer != "") {
            $customer   = $this->db->get_where("tbl_customer", ['id_customer' => $id_customer])->row();
            $nama_customer      = $customer->nama_customer; 
            $telp_customer      = $customer->wa_customer; 
            $alamat_customer    = $customer->alamat_customer; 
            $kabupaten_customer = $customer->kabupaten_customer; 
            $provinsi_customer  = $customer->provinsi_customer; 
        } else {
            $nama_customer      = $this->input->post("nama_customer");
            $telp_customer      = $this->input->post("telp_customer");
            if (substr($telp_customer, 0, 1) === '0') {
                $telp_customer = '62' . substr($telp_customer, 1);
            }
            $kabupaten_customer = $this->input->post("kabupaten_customer");
            $provinsi_customer  = $this->input->post("provinsi_customer");
            $alamat_customer    = $this->input->post("alamat_customer");  
        }
        $jumlah = $jumlah_pembayaran - $total_all;
        if ($jumlah > 0 ) {
            $kekurangan = "0";
        } else {
            $kekurangan = $jumlah;
        }
        $data = array(
            "nama_penerima"     => $nama_customer,
            "no_telepon"        => $telp_customer,
            "alamat_pengiriman" => $alamat_customer,
            "kota_kabupaten"    => $kabupaten_customer,
            "provinsi"          => $provinsi_customer,
            "jumlah_produk"     => $jumlah_produk,
            "status_pesanan"    => 'Perlu Dikirim',
            "total_pembayaran"  => $total_tagihan,
            "waktu_selesai"     => date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $tanggal_deadline)))
        );
        // echo "<pre>", print_r($id_customer, 1), "</pre>";
        // echo "<pre>", print_r($data, 1), "</pre>";
        $action = $this->Model_master->editMaster(array('no_pesanan' => $no_pesanan), "tbl_order", $data);
        // echo "<pre>", print_r($action, 1), "</pre>";
            if ($action) {

                $tambah_invoice = array(
                    'no_pesanan'        => $no_pesanan,
                    'diskon'            => $persentase,
                    'total_biaya'       => $total_tagihan,
                    'potongan_harga'    => $harga_persen,
                    "status"            => 'Perlu Dikirim',
                    "keterangan"        => $keterangan,
                    "waktu_dibuat"      => date("Y-m-d H:i:s"),
                    "waktu_pembayaran"  => date("Y-m-d H:i:s"),
                    'tanggal_deadline'  => date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $tanggal_deadline)))
                );

                $this->db->insert('tbl_invoice', $tambah_invoice);

                $tambah_pembayaran = array(
                    'id_user'           => $this->session->userdata('id_user'),
                    'no_pesanan'        => $no_pesanan,
                    'jenis_transaksi'   => $opsi_pembayaran,
                    'jumlah_pembayaran' => $jumlah_pembayaran,
                    'tanggal'           => date("Y-m-d H:i:s")
                );
                $this->db->insert('tbl_pembayaran', $tambah_pembayaran);

                if ($id_customer == '') {
                    $tambah_customer  = array(
                        'nama_customer'     => $nama_customer,
                        'wa_customer'       => $telp_customer,
                        'alamat_customer'   => $alamat_customer,
                        'kabupaten_customer'=> $kabupaten_customer,
                        'provinsi_customer' => $provinsi_customer
                    );
                    $insert_query = $this->db->insert_string('tbl_customer', $tambah_customer);
                    $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
                    $this->db->query($insert_query);
                }
                $this->session->set_flashdata("success", "Berhasil menambahkan transaksi");
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan transaksi");
            }
        redirect("transaksi/detail_transaksi/".$no_pesanan);
    }

    public function list_transaksi(){
        if(isset($_GET['startdate']) && ! empty($_GET['startdate']) && isset($_GET['enddate']) && ! empty($_GET['enddate'])){ 
                $startdate =  date('Y-m-d',strtotime($_GET['startdate']));
                $enddate = date('Y-m-d',strtotime($_GET['enddate']));
        }else{
            $startdate = date('Y-m-d',strtotime('-0 Day'));
            $enddate = date('Y-m-d');
        }

        if (isset($_GET['customer']) && ! empty($_GET['customer'])){
            $customer = $_GET['customer'];
        } else {
            $customer = "all";
        }

        $data['customer']  = $this->Model_master->getMasterOneTable("*", "tbl_customer", "  nama_customer", "asc", "");
        $list_transaksi = $this->Model_transaksi->get_list_transaksi($startdate, $enddate, $customer);
        if (!empty($list_transaksi)) {
        
            $i=0;
            foreach ($list_transaksi as $k) {
                $no_pesanan    = $k['no_pesanan'];
                $bayar      = $this->Model_transaksi->get_total_pembayaran($no_pesanan);
                $list_transaksi[$i]['bayar']  = $bayar; 
                $i++; 
            }
        }
                // echo "<pre>", print_r($list_transaksi, 1), "</pre>";
        $data['list_transaksi'] = $list_transaksi;
        $this->template->load("template", "transaksi/data-list_transaksi", $data);
    } 

    public function detail_transaksi($no_pesanan){
        $detail_transaksi = $this->Model_transaksi->get_detail_transaksi($no_pesanan);
        $i=0;

        foreach ($detail_transaksi as $k) {
            $no_pesanan    = $k['no_pesanan'];
            $bayar      = $this->Model_transaksi->get_total_pembayaran($no_pesanan);
            $detail_transaksi[$i]['bayar']  = $bayar; 
            $i++; 
        }
        // echo "<pre>", print_r($detail_transaksi, 1), "</pre>";
        $data['detail_list'] = $detail_transaksi;
        $data['detail_transaksi'] = $this->Model_transaksi->detail_transaksi($no_pesanan);
        // echo "<pre>", print_r($this->Model_transaksi->detail_transaksi($no_pesanan), 1), "</pre>";
        $data['opsi_pembayaran'] = $this->Model_master->getMasterOneTable("*", "tbl_opsi_pembayaran", "jenis_pembayaran", "asc", "");
        $this->template->load("template", "transaksi/data-detail_transaksi", $data);
    }

    public function tambah_pembayaran(){
        $no_pesanan         = $this->input->post("no_pesanan");
        $opsi_pembayaran    = $this->input->post("opsi_pembayaran");
        $jumlah_pembayaran  = $this->input->post("jumlah_pembayaran");
        $jumlah_pembayaran  = str_replace('Rp. ','',$jumlah_pembayaran);
        $jumlah_pembayaran  = str_replace('.','',$jumlah_pembayaran);

        $data = array(
            "no_pesanan"        => $no_pesanan,
            "id_user"           => $this->session->userdata('id_user'),
            "jenis_transaksi"   => $opsi_pembayaran,
            "jumlah_pembayaran" => $jumlah_pembayaran,
            "tanggal"           => date("Y-m-d H:i:s")
        );

        $action = $this->Model_master->tambahMaster("tbl_pembayaran", $data);
            if ($action) {

                $detail_transaksi = $this->Model_transaksi->get_detail_transaksi($no_pesanan);
                $i=0;

                foreach ($detail_transaksi as $k) {
                    $no_pesanan1    = $k['no_pesanan'];
                    $bayar      = $this->Model_transaksi->get_total_pembayaran($no_pesanan1);
                    $detail_transaksi[$i]['bayar']  = $bayar; 
                    $i++; 
                }
                $total = $detail_transaksi[0]['total_biaya'] - $detail_transaksi[0]['potongan_harga'];
                $hasil = $total - $detail_transaksi[0]['bayar'][0]['jumlah_pembayaran'];
                $hasil_akhir = $hasil - $jumlah_pembayaran;
                // echo $hasil_akhir;
                if ($hasil_akhir > 0) {
                    $this->db->set('status', 'Perlu Dikirim');
                    $this->db->where('no_pesanan', $no_pesanan);
                    $this->db->update('tbl_invoice');
                } else {
                    $this->db->set('status', 'Lunas');
                    $this->db->where('no_pesanan', $no_pesanan);
                    $this->db->update('tbl_invoice');
                }

                $this->session->set_flashdata("success", "Berhasil menambahkan pembayaran");
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan pembayaran");
            }
        redirect('transaksi/detail_transaksi/'.$no_pesanan);
    }

    public function tambah_pelunasan(){
        $no_pesanan = $this->input->post("no_pesanan");
        $opsi_pembayaran = $this->input->post("opsi_pembayaran");
        $jumlah_pembayaran  = $this->input->post("jumlah_pembayaran");
        $jumlah_pembayaran = str_replace('Rp. ','',$jumlah_pembayaran);
        $jumlah_pembayaran = str_replace(',','',$jumlah_pembayaran);

        $data = array(
            "no_pesanan"        => $no_pesanan,
            "id_user"           => $this->session->userdata('id_user'),
            "jenis_transaksi"   => $opsi_pembayaran,
            "jumlah_pembayaran" => $jumlah_pembayaran,
            "tanggal"           => date("Y-m-d H:i:s")
        );
        // echo "<pre>", print_r($data, 1), "</pre>";

        $action = $this->Model_master->tambahMaster("tbl_pembayaran", $data);
            if ($action) {
                $this->db->set('status', 'Lunas');
                $this->db->where('no_pesanan', $no_pesanan);
                $this->db->update('tbl_invoice');
                $this->session->set_flashdata("success", "Berhasil menambahkan pembayaran");
            } else {
                $this->session->set_flashdata("error", "Gagal, Tidak dapat menyimpan pembayaran");
            }
        redirect('transaksi/detail_transaksi/'.$no_pesanan);
    }

    public function transaksi_edit($no_pesanan){
        $data['no_pesanan']  = $no_pesanan;
        $data['produk']      = $this->Model_master->getMasterOneTable("*", "tbl_product", "  deskripsi", "asc", "");
        $this->template->load("template", "transaksi/transaksi_edit", $data);
    }

    public function action_transaksi_tambah(){
        $no_pesanan     = $this->input->post("no_pesanan");
        $order          = $this->db->get_where("tbl_order", ['no_pesanan' => $no_pesanan])->row();
        $pembayaran     = $this->Model_transaksi->get_edit_pembayaran($no_pesanan);
        $id_produk      = $this->input->post("id_produk");
        $sku_induk      = $this->input->post("sku_induk");
        $id_variasi     = $this->input->post("id_variasi");
        $harga_variasi  = $this->input->post("harga_variasi");
        $qty            = $this->input->post("qty");
        $catatan_pembeli= $this->input->post("catatan_pembeli");
        $produk    = $this->db->get_where("tbl_product", ['id_product' => $id_produk])->row();
        $nama_produk    = $produk->deskripsi;
        $variasi    = $this->db->get_where("tbl_variasi", ['id_variasi' => $id_variasi])->row();
        $nomor_sku      = $variasi->nomor_sku;
        $nama_variasi   = $variasi->nama_variasi;
        $total_harga    = $harga_variasi * $qty;
        $jumlah_produk  = $order->jumlah_produk + $qty;
        $total_pembayaran = $order->total_pembayaran + $total_harga;

        $data = array(
            "source"            => 'STORE',
            "no_pesanan"        => $no_pesanan,
            "status_pesanan"    => 'Perlu Dikirim',
            "id_produk"         => $id_produk,
            "nama_produk"       => $nama_produk,
            "sku_induk"         => $sku_induk,
            "nomor_sku"         => $nomor_sku,
            "id_variasi"        => $id_variasi,
            "nama_variasi"      => $nama_variasi,
            "harga_awal"        => $harga_variasi,
            "total_qty"         => $qty,
            "total_harga"       => $total_harga,
            "catatan_pembeli"   => $catatan_pembeli,
            "nama_penerima"     => $order->nama_penerima,
            "no_telepon"        => $order->no_telepon,
            "alamat_pengiriman" => $order->alamat_pengiriman,
            "kota_kabupaten"    => $order->kota_kabupaten,
            "provinsi"          => $order->provinsi,
            "waktu_selesai"     => $order->waktu_selesai,
            "waktu_dibuat"      => $order->waktu_dibuat,
            "waktu_pembayaran"  => $order->waktu_pembayaran
            );
        // echo "<pre>", print_r($data, 1), "</pre>";
        $action = $this->Model_master->tambahMaster("tbl_order", $data);
            if($action){

                $this->db->set('jumlah_produk', $jumlah_produk);
                $this->db->set('total_pembayaran', $total_pembayaran);
                $this->db->where('no_pesanan', $no_pesanan);
                $this->db->update('tbl_order');

                $pembayaran     = $this->Model_transaksi->get_edit_pembayaran($no_pesanan);
                $total = $total_pembayaran - $pembayaran[0]->jumlah_pembayaran;
                if ($total > 0) {
                    $status = "Belum Lunas";
                } else {
                    $status = "Lunas";
                }
                $this->db->set('status', $status);
                $this->db->set('total_biaya', $total_pembayaran);
                $this->db->where('no_pesanan', $no_pesanan);
                $this->db->update('tbl_invoice');

                echo json_encode(array("status" => "success", "message" => "Transaksi berhasil ditambahkan", "data" => $data));
            } else {
                echo json_encode(array("status" => "error", "message" => "Transaksi gagal di tambahkan"));
            }
    }

    public function action_transaksi_ubah(){
        $id_orderan     = $this->input->post("id_orderan");
        $no_pesanan     = $this->input->post("no_pesanan");
        $id_produk      = $this->input->post("id_produk");
        $sku_induk      = $this->input->post("sku_induk");
        $id_variasi     = $this->input->post("id_variasi");
        $harga_variasi  = $this->input->post("harga_variasi");
        $qty            = $this->input->post("qty");
        $catatan_pembeli= $this->input->post("catatan_pembeli");
        $produk    = $this->db->get_where("tbl_product", ['id_product' => $id_produk])->row();
        $nama_produk    = $produk->deskripsi;
        $variasi    = $this->db->get_where("tbl_variasi", ['id_variasi' => $id_variasi])->row();
        $nomor_sku      = $variasi->nomor_sku;
        $nama_variasi   = $variasi->nama_variasi;
        $total_harga    = $harga_variasi * $qty;

        $data = array(
            "no_pesanan"        => $no_pesanan,
            "id_produk"         => $id_produk,
            "nama_produk"       => $nama_produk,
            "sku_induk"         => $sku_induk,
            "id_variasi"        => $id_variasi,
            "nama_variasi"      => $nama_variasi,
            "harga_awal"        => $harga_variasi,
            "total_qty"         => $qty,
            "total_harga"       => $total_harga,
            "catatan_pembeli"   => $catatan_pembeli
            );

        $action = $this->Model_master->editMaster(array('id_orderan' => $id_orderan), "tbl_order", $data);
            if($action){
                $orderan        = $this->Model_transaksi->get_edit_orderan($no_pesanan);
                $this->db->set('jumlah_produk', $orderan[0]->total_qty);
                $this->db->set('total_pembayaran', $orderan[0]->total_harga);
                $this->db->where('no_pesanan', $no_pesanan);
                $this->db->update('tbl_order');
                $pembayaran     = $this->Model_transaksi->get_edit_pembayaran($no_pesanan);
                $total = $orderan[0]->total_harga - $pembayaran[0]->jumlah_pembayaran;
                if ($total > 0) {
                    $status = "Belum Lunas";
                } else {
                    $status = "Lunas";
                }
                $this->db->set('status', $status);
                $this->db->set('total_biaya', $orderan[0]->total_harga);
                $this->db->where('no_pesanan', $no_pesanan);
                $this->db->update('tbl_invoice');
                echo json_encode(array("status" => "success", "message" => "Transaksi berhasil diubah", "data" => $data));
            } else {
                echo json_encode(array("status" => "error", "message" => "Transaksi gagal di ubah"));
            }
    }

    public function delete_transaksi_edit(){
        $id_orderan = $this->input->post("id_orderan");
        $no_pesanan = $this->input->post("no_pesanan");
        $total      = $this->input->post("total");
        $delete     = $this->Model_master->deleteMaster($id_orderan, "id_orderan", "tbl_order");
        if ($delete) {
            $orderan   = $this->Model_transaksi->get_edit_orderan($no_pesanan);
            $this->db->set('jumlah_produk', $orderan[0]->total_qty);
            $this->db->set('total_pembayaran', $orderan[0]->total_harga);
            $this->db->where('no_pesanan', $no_pesanan);
            $this->db->update('tbl_order');
            $pembayaran     = $this->Model_transaksi->get_edit_pembayaran($no_pesanan);
            $total = $orderan[0]->total_harga - $pembayaran[0]->jumlah_pembayaran;
            if ($total > 0) {
                $status = "Belum Lunas";
            } else {
                $status = "Lunas";
            }
            $this->db->set('status', $status);
            $this->db->set('total_biaya', $orderan[0]->total_harga);
            $this->db->where('no_pesanan', $no_pesanan);
            $this->db->update('tbl_invoice');
            echo json_encode(array("status" => "success", "data" => $id_orderan, "message"  => "Berhasil menghapus transaksi"));
         } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, tidak dapat menghapus transaksi"));
         }
    }

    public function export(){

        $this->load->library('PHPExcel', 'excel');

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');

        // $objPHPExcel = $objReader->load("uploads/files/percobaan.xlsx");

        $objPHPExcel = $objReader->load('file/excel/List Transaksi.xlsx');



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
        $customer      ="";

        if(isset($_GET['startdate']) && ! empty($_GET['startdate']) && isset($_GET['enddate']) && ! empty($_GET['enddate'])){ 
                $startdate =  date('Y-m-d',strtotime($_GET['startdate']));
                $enddate = date('Y-m-d',strtotime($_GET['enddate']));
        }else{
            $startdate = date('Y-m-d',strtotime('-0 Day'));
            $enddate = date('Y-m-d');
        }

        if (isset($_GET['customer']) && ! empty($_GET['customer'])){
            $customer = $_GET['customer'];
        } else {
            $customer = "all";
        }

        $list_transaksi = $this->Model_transaksi->get_list_transaksi($startdate, $enddate, $customer);
        if (!empty($list_transaksi)) {
        
            $i=0;
            foreach ($list_transaksi as $k) {
                $no_pesanan    = $k['no_pesanan'];
                $bayar      = $this->Model_transaksi->get_total_pembayaran($no_pesanan);
                $list_transaksi[$i]['bayar']  = $bayar; 
                $i++; 
            }
        }

        $items  = $list_transaksi;

        $base_row = 5;

        $row = $base_row;

        foreach ($items as $key => $item) {

            $row = $base_row++;

            $total = $item['total_biaya'] - $item['potongan_harga'];
            $kurang = $total - $item['bayar'][0]['jumlah_pembayaran'];

            if ($kurang < 0) {
                $hasil = "Rp 0";
            } else {
                $hasil = "Rp ".number_format($kurang); 
            }

            $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, ($key+1))

                                        ->setCellValue('B'.$row, $item['no_pesanan'])
                                        ->setCellValue('C'.$row, $item['nama_penerima'])
                                        ->setCellValue('D'.$row, "Rp ".number_format($item['total_biaya']))
                                        ->setCellValue('E'.$row, "Rp ".number_format($item['bayar'][0]['jumlah_pembayaran']))
                                        ->setCellValue('F'.$row, "Rp ".number_format($item['potongan_harga']))
                                        ->setCellValue('G'.$row, $kurang)
                                        ->setCellValue('H'.$row, date('d F Y', strtotime($item['waktu_dibuat'])));

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleCenter);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleCenter);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($styleLeft);

        }



        $nama_file = "Laporan List Transaksi";

        header('Content-Type: application/vnd.ms-excel'); //mime type

        header('Content-Disposition: attachment;filename="'.$nama_file.'.xlsx"'); 

        header('Cache-Control: max-age=0'); //no cache

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $objWriter->save('php://output');
    }

    public function cetak_pdf($no_pesanan){
        $detail_list = $this->Model_transaksi->get_detail_transaksi($no_pesanan);
        $i=0;

        foreach ($detail_list as $k) {
            $no_pesanan    = $k['no_pesanan'];
            $bayar      = $this->Model_transaksi->get_total_pembayaran($no_pesanan);
            $detail_list[$i]['bayar']  = $bayar; 
            $i++; 
        }
        $detail_transaksi = $this->Model_transaksi->detail_transaksi($no_pesanan);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintFooter(false);
        $pdf->setPrintHeader(false);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->AddPage('L','A5');
        $pdf->SetFont('courier', '', '8');
        // $pdf->SetFont('dejavusans', '', '7');
        $total = $detail_list[0]['total_biaya'] - $detail_list[0]['potongan_harga'];
            if ($total >0) {
                $hasil_total = "Rp ".number_format($total);
            } else {
                $hasil_total = "Rp 0";
            }
        $total = $detail_list[0]['total_biaya'] - number_format($detail_list[0]['potongan_harga']);
        $hasil = $total - $detail_list[0]['bayar'][0]['jumlah_pembayaran'];
            if ($hasil > 0) {
                $hasil = '<tr>
                <td width="70%"></td>
                <td width="15%">KURANG</td>
                <td width="15%">'."Rp ".number_format($hasil).'</td>
                </tr>';
            } else {
                $hasil = '<tr>
                <td width="70%"></td>
                <td width="15%">KEMBALI</td>
                <td width="15%">'."Rp ".number_format(substr($hasil, 1)).'</td>
                </tr>';
            }
        $alamat_pengiriman = ucwords(strtolower($detail_list[0]['alamat_pengiriman']), '\',(. '); 
        $tampilan_total = '';
        $tampilan_total = '
        <table>
            <tr>
                <td width="70%"></td>
                <td width="15%">SUBTOTAL</td>
                <td width="15%">'."Rp ".number_format($detail_list[0]['total_biaya']).'</td>
            </tr>
            <tr>
                <td width="35%" align="center">Pelanggan,</td>
                <td width="20%" align="center">Penerima Order,</td>
                <td width="15%"></td>
                <td width="15%">DISKON '.$detail_list[0]['diskon']."%".'</td>
                <td width="15%">'."Rp ".number_format($detail_list[0]['potongan_harga']).'</td>
            </tr>
            <tr>
                <td width="70%"></td>
                <td width="15%">GRANDTOTAL</td>
                <td width="15%">'.$hasil_total.'</td>
            </tr>
            <tr>
                <td width="70%"></td>
                <td width="15%">BAYAR</td>
                <td width="15%">'."Rp ".number_format($detail_list[0]['bayar'][0]['jumlah_pembayaran']).'</td>
            </tr>'
            .$hasil.
            '<tr>
                <td width="35%" align="center">( '.$detail_list[0]['nama_penerima'].' )</td>
                <td width="20%" align="center">( '.$detail_list[0]['full_name'].' )</td>
                <td width="15%"></td>
                <td width="15%"></td>
                <td width="15%"></td>
            </tr>
            <tr>
                <td width="35%" align="center"></td>
                <td width="20%" align="center"></td>
                <td width="15%"></td>
                <td width="15%"></td>
                <td width="15%"></td>
            </tr>
            <tr>
                <td width="15%">Keterangan </td>
                <td width="27%">: </td>
                <td width="3%"></td>
                <td width="15%">Dicetak oleh </td>
                <td width="30%">: '.explode(' ', $this->session->userdata('full_name'))[0].' - '.date('d/m/y H:i').'</td>
            </tr>
            <tr>
                <td width="42%" rowspan="5"><font size="7">'.$detail_list[0]['keterangan'].'</font></td>
                <td width="3%"></td>
                <td width="15%">Estimasi selesai </td>
                <td width="30%">: '.date('d/m/y', strtotime($detail_list[0]['tanggal_deadline'])).'</td>
            </tr>
            <tr>
                <td width="3%"></td>
                <td width="15%">Perhatian </td>
                <td width="30%">: </td>
            </tr>
            <tr>
                <td width="3%"></td>
                <td width="55%"><font size="6">1. Invoice harap dibawa saat pengambilan barang.</font></td>
            </tr>
            <tr>
                <td width="3%"></td>
                <td width="55%"><font size="6">2. Barang yang sudah di beli tidak dapat ditukar/dikembalikan.</font></td>
            </tr>
            <tr>
                <td width="3%"></td>
                <td width="55%"><font size="6">3. DP atau pembayaran yang sudah di bayar tidak bisa dikembalikan jika terjadi pembatalan dari pihak pelanggan.</font></td>
            </tr>
        </table>';
        $tabel = '
            <table>
              <tr>
                <td width="15%"></td>
                <td width="35%" rowspan="2"><h1>INVOICE</h1></td>
                <td width="10%"></td>
                <td width="10%">Nomor </td>
                <td width="30%"><p>: <strong>'.$detail_list[0]['no_pesanan'].'</strong></p></td>
              </tr>
              <tr>
                <td width="15%"></td>
                <td width="10%"></td>
                <td width="10%">Tanggal </td>
                <td width="30%"><p>: '.date('d F Y', strtotime($detail_list[0]['waktu_dibuat'])).'</p></td>
              </tr>
              <tr>
                <td width="15%"></td>
                <td width="35%"></td>
                <td width="10%"></td>
                <td width="40%"></td>
              </tr>
              <tr>
                <td width="15%" rowspan="3"><img class="img-thumbnail" src="./assets/images/logo.JPG" style="margin-top:10%; max-width: 120px; width: auto; max-height: 120px;"></td>
                <td width="35%"><strong>PERCETAKAN STUDIO PRINT</strong></td>
                <td width="10%"></td>
                <td width="40%"><strong>'.$detail_list[0]['nama_penerima'].'</strong></td>
              </tr>
              <tr>
                <td width="35%">Telp. : 0878 8208 2333 (WA)</td>
                <td width="10%"></td>
                <td width="40%">Tlp. '.$detail_list[0]['no_telepon'].'</td>
              </tr>
              <tr>
                <td width="35%">Email : studioprintid@gmail.com <br>Jalan Raya Jatirembe Gang 1<br>Benjeng Gresik Jawa Timur 61172</td>
                <td width="10%"></td>
                <td width="40%">'.$alamat_pengiriman.'</td>
              </tr>
            </table>
            <div></div>
            <table style="margin-top : 100px;">
                <tr>
                    <td width="5%" border="1"><p align="center"><strong>No.</strong></p></td>
                    <td width="30%" border="1"><p align="center"><strong>Nama Produk</strong></p></td>
                    <td width="20%" border="1"><p align="center"><strong>Nama Variasi</strong></p></td>
                    <td width="15%" border="1"><p align="center"><strong>Qty</strong></p></td>
                    <td width="15%" border="1"><p align="center"><strong>Harga</strong></p></td>
                    <td width="15%" border="1"><p align="center"><strong>Total</strong></p></td>
                </tr>
                <tr>
                  <td align="center"></td>
                  <td align="left"></td>
                  <td align="center"></td>
                  <td align="center"></td>
                  <td align="left"></td>
                  <td align="left"></td>
                </tr>
                ';   
        $q = 1;
        foreach ($detail_transaksi as $k) {
        $tabel.='<tr>
                  <td align="center">'.$q.'</td>
                  <td align="left">'.$k['nama_produk'].'</td>
                  <td align="center">'.$k['nama_variasi'].'</td>
                  <td align="center">'.$k['total_qty'].'</td>
                  <td align="left">'."Rp ".number_format($k['harga_awal']).'</td>
                  <td align="left">'."Rp ".number_format($k['total_harga']).'</td>
                </tr>';
        $q++;
        }
        $tabel.= '</table>&nbsp;<hr>'.$tampilan_total;
        $pdf->writeHTML($tabel);
        $pdf->Output();
    }

    public function selesai_transaksi(){
        $no_pesanan   = $this->input->post("no_pesanan");;
        $action  = $this->Model_transaksi->selesai_transaksi($no_pesanan);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Status berhasil diubah menjadi selesai"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, status tidak dapat diubah menjadi selesai"));
        }
    }

    public function sedang_transaksi(){
        $no_pesanan   = $this->input->post("no_pesanan");;
        $action  = $this->Model_transaksi->sedang_transaksi($no_pesanan);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Status berhasil diubah menjadi sedang dikirim"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, status tidak dapat diubah menjadi sedang dikirim"));
        }
    }

    public function batal_transaksi(){
        $no_pesanan   = $this->input->post("no_pesanan");;
        $action  = $this->Model_transaksi->batal_transaksi($no_pesanan);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Status berhasil diubah menjadi batal"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, status tidak dapat diubah menjadi batal"));
        }
    }
    // SELECT max(no_pesanan), LEFT(no_pesanan, 3) FROM tbl_order WHERE no_pesanan LIKE 'INV%'
}