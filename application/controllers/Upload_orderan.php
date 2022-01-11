<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_orderan extends CI_Controller {

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

        $list_order = $this->Model_orderan->get_upload();
            // echo "<pre>", print_r($list_order,1), "</pre>";
        // echo $this->db->last_query();
        $i=0;
        foreach ($list_order as $k) {
            $no_pesanan       = $k['no_pesanan'];
            // $nomor_sku        = $k['nomor_sku'];
            $source           = $k['source'];
            $opsi_pengiriman  = $k['opsi_pengiriman'];
            $username         = $k['username'];
            $user_packing     = $k['user_packing'];
            $user_cetak       = $k['user_cetak'];
            $nama_penerima    = $k['nama_penerima'];
            $kota_kabupaten   = $k['kota_kabupaten'];
            $waktu_batas      = $k['waktu_batas'];
            $waktu_dibuat     = $k['waktu_dibuat'];
            $status_pesanan   = $k['status_pesanan'];
            $status_kerjakan  = $k['status_kerjakan'];
            $full_name        = $k['full_name'];
            $no_telepon       = $k['no_telepon'];
            $id_user          = $k['id_user'];
            $jumlah_order     = $this->Model_orderan->get_jumlah_orderan($no_pesanan);
            $no_pesanan_order = $this->Model_orderan->get_no_pesanan($no_pesanan);
            // echo $this->db->last_query();
            // echo "<pre>", print_r($no_pesanan_order, 1), "</pre>";
            $nomor_sku_order = array();
            for ($a=0; $a < $jumlah_order[0]['jumlah']; $a++) { 
                $nomor_sku        = $no_pesanan_order[$a]['nomor_sku'];
                $sku_induk        = $no_pesanan_order[$a]['sku_induk'];
                $id_orderan       = $no_pesanan_order[$a]['id_orderan'];
                $no_pesanan       = $no_pesanan_order[$a]['no_pesanan'];
                $sku_kosong       = "";

                if ($nomor_sku != "") {
                    // echo "tidak kosong";
                    $sku_order  = $this->Model_orderan->get_nomor_sku($sku_induk, $id_orderan);
                    // echo $this->db->last_query();
                    
                    array_push($nomor_sku_order, array(
                        $sku_order
                    ));
                } else {
                    // perubahan dari sku kosong ke skuinduk tgl 24 12 2021
                    $sku_order  = $this->Model_orderan->get_nomor_sku_kosong($sku_induk, $id_orderan);
                    // echo $this->db->last_query();
                    array_push($nomor_sku_order, array(
                       $sku_order
                    ));
                    // echo "kosong";
                }
                
            };
            // echo "<pre>", print_r($nomor_sku_order, 1), "</pre>";
            $list_order[$i]['nomor_sku_order']  = $nomor_sku_order;
            $list_order[$i]['jumlah_order']     = $jumlah_order;
            $i++;
        }
        // echo "<pre>", print_r($list_order, 1), "</pre>";
        $data["orderan"]  = $list_order;
        $data['bahan']  = $this->Model_master->getMasterOneTable("*", "tbl_bahan", "id_bahan", "asc", "");
        $data['kategori'] = $this->Model_master->getMasterOneTable("*", "tbl_kategori", "id_kategori", "asc", "");
		$this->template->load("template", "orderan/data-orderan", $data);
    }

    public function tambah_kerusakan(){
        $id_user          = $this->input->post("id_user");
        $id_bahan         = $this->input->post("id_bahan");
        $id_kategori      = $this->input->post("id_kategori");
        $status_bahan     = $this->input->post("status_bahan");
        $no_pesanan       = $this->input->post("no_pesanan");
        $sebab_kerusakan  = $this->input->post("sebab_kerusakan");
        $jumlah_kerusakan = $this->input->post("jumlah_kerusakan");
        $created_date     = date("Y-m-d H:i:s");
        $bahan = $this->db->get_where("tbl_bahan", ['id_bahan' => $id_bahan])->row();
        // echo $this->db->last_query();
        if ($status_bahan == "belum cetak") {
            $total_harga = $bahan->harga_kertas * $jumlah_kerusakan;
        } else {
            $total_harga = $bahan->harga_cetak * $jumlah_kerusakan;
        }

        $data = array(
            "id_user"           => $id_user,
            "id_bahan"          => $id_bahan,
            "id_kategori"       => $id_kategori,
            "no_pesanan"        => $no_pesanan,
            "status_bahan"      => $status_bahan,
            "sebab_kerusakan"   => $sebab_kerusakan,
            "jumlah_kerusakan"  => $jumlah_kerusakan,
            "created_date"      => $created_date,
            "total_harga"       => $total_harga
        );

        // echo "<pre>", print_r($bahan, 1), "</pre>";
        // echo "<pre>", print_r($data, 1), "</pre>";

        $action = $this->Model_master->tambahMaster("tbl_kerusakan", $data);

        if ($action) {
            $this->session->set_flashdata("success", "Berhasil Menambahkan kerusakan orderan");

            $stock = $this->db->get_where('tbl_stock', ['id_bahan' => $id_bahan])->row();
            if (isset($stock->id_bahan)) {
                // echo "update";
                $total = $stock->jumlah_stock - $jumlah_kerusakan;
                $edit_stock = array(
                        'id_bahan'     => $id_bahan,
                        'jumlah_stock' => $total
                        );

                $this->db->where('id_stock', $stock->id_stock);
                $this->db->update('tbl_stock', $edit_stock);
            }
        } else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat menambahkan kerusakan orderan");
        }
        redirect("upload_orderan/detail/".$no_pesanan);
    }

    public function tambah_pengeluaran(){
        $no_pesanan     = $this->input->post("no_pesanan");
        $nama_produk    = $this->input->post("nama_produk");
        $id_user        = $this->input->post("id_user");
        $id_bahan       = $this->input->post("id_bahan");
        $jumlah_bahan   = $this->input->post("jumlah_bahan");
        $deskripsi      = $this->input->post("deskripsi");
        $created_date   = date("Y-m-d H:i:s");

        $bahan = $this->db->get_where("tbl_bahan", ['id_bahan' => $id_bahan])->row();
        $total = $jumlah_bahan * $bahan->harga_kertas;
        $data = array(
            "id_user"           => $id_user,
            "id_bahan"          => $id_bahan,
            "no_pesanan"        => $no_pesanan,
            "nama_produk"       => trim($nama_produk),
            "jumlah_bahan"      => $jumlah_bahan,
            "harga_barang"      => $bahan->harga_kertas,
            "total_harga"       => $total,
            "deskripsi"         => $deskripsi,
            "created_date"      => $created_date
        );
        // echo "<pre>", print_r($data, 1), "</pre>";
        $action = $this->Model_master->tambahMaster("tbl_pengeluaran_bahan", $data);

        if ($action) {
            $this->session->set_flashdata("success", "Berhasil Menambahkan pengeluaran bahan");
            $stock = $this->db->get_where('tbl_stock', ['id_bahan' => $id_bahan])->row();
            if (isset($stock->id_bahan)) {
                // echo "update";
                $total = $stock->jumlah_stock - $jumlah_bahan;
                $edit_stock = array(
                        'id_bahan'     => $id_bahan,
                        'jumlah_stock' => $total
                        );

                $this->db->where('id_stock', $stock->id_stock);
                $this->db->update('tbl_stock', $edit_stock);
            }
        } else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat menambahkan pengeluaran bahan");
        }
        redirect("upload_orderan/detail/".$no_pesanan);

    }

    public function edit_pengeluaran(){
        $id_pengeluaran_bahan     = $this->input->post("id_pengeluaran_bahan");
        $no_pesanan     = $this->input->post("no_pesanan");
        $nama_produk    = $this->input->post("nama_produk");
        $id_user        = $this->input->post("id_user");
        $id_bahan       = $this->input->post("id_bahan");
        $jumlah_bahan   = $this->input->post("jumlah_bahan");

        $data = array(
            "id_user"           => $id_user,
            "id_bahan"          => $id_bahan,
            "no_pesanan"        => $no_pesanan,
            "nama_produk"       => trim($nama_produk),
            "jumlah_bahan"      => $jumlah_bahan
        );
         $action = $this->Model_master->editMaster(array('id_pengeluaran_bahan' => $id_pengeluaran_bahan), "tbl_pengeluaran_bahan", $data);
        if ($action) {
            $this->session->set_flashdata("success", "Berhasil mengubah pengeluaran bahan");
        } else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat mengubah pengeluaran bahan");
        }
        redirect("upload_orderan/detail/".$no_pesanan);

    }

    public function tambah_desain(){
        $config['upload_path']          = './file/desain/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 0;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $this->load->library('upload', $config);

        $var_file_product         = "";

        $list_gambar = array();
        if ($this->upload->do_upload('gambar')){
          $gbr1 = $this->upload->data();
          array_push($list_gambar, array('name' => $gbr1['file_name'], 'size' => $gbr1['file_size']));
          $file_size_company = $gbr1['file_size'];
          $var_file_galeri = $gbr1['file_name'];
        }

        $this->load->library('image_lib');
        foreach($list_gambar as $gambar){
           
           if ($gambar['size'] >= 2048) {
               $config['image_library']    = 'gd2';
               $config['source_image']     ='./file/desain/'.$gambar['name'];
               $config['create_thumb']     = false;
               $config['maintain_ratio']   = true;
               $config['width']            = '500';
               $config['height']           = '500';   
               $config['master_dim']       = 'height';   
               $config['new_image']= './file/desain/'.$gambar['name'];

               $this->image_lib->clear();
               $this->image_lib->initialize($config);
               $this->image_lib->resize();
            } 
        }

        $id_user        = $this->input->post("id_user");
        $no_pesanan     = $this->input->post("no_pesanan");
        $nama_produk    = $this->input->post("nama_produk");
        $jumlah_order   = $this->input->post("jumlah_order");

        $data = array(
            "id_user"       => $id_user,
            "no_pesanan"    => $no_pesanan,
            "nama_produk"   => trim($nama_produk),
            "upload_gambar"        => $var_file_galeri,
            "jumlah_order"  => $jumlah_order
        );
        // echo "<pre>", print_r($data, 1), "</pre>";
        $action = $this->Model_master->tambahMaster("tbl_upload_desain", $data);

        if ($action) {
            $this->session->set_flashdata("success", "Berhasil Menambahkan desain");
        } else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat menambahkan desain");
        }
        redirect("upload_orderan/detail/".$no_pesanan);
    }

    public function detail($no_pesanan){
        $data['detail_orderan']     = $this->Model_orderan->get_detail_orderan($no_pesanan);
        $data['pengeluaran_bahan']  = $this->Model_orderan->get_pengeluaran_bahan($no_pesanan);
        $data['desain']         = $this->Model_orderan->get_desain($no_pesanan);
        $detail_orderan         = $this->Model_orderan->get_detail_orderan($no_pesanan);
        $i=0;
        foreach ($detail_orderan as $k) {
            $no_pesanan     = $k['no_pesanan'];
            $jumlah_order   = $this->Model_orderan->get_jumlah_orderan($no_pesanan);
            $no_pesanan_order = $this->Model_orderan->get_no_pesanan($no_pesanan);
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
                    $sku_order  = $this->Model_orderan->get_nomor_sku($sku_induk, $id_orderan);
                    
                    // echo "<pre>", print_r($sku_order, 1), "</pre>";
                    array_push($nomor_sku_order, array(
                        $sku_order
                    ));
                } else {
                    // perubahan dari sku kosong ke skuinduk tgl 24 12 2021
                    $sku_order  = $this->Model_orderan->get_nomor_sku_kosong($sku_induk, $id_orderan);
                    array_push($nomor_sku_order, array(
                       $sku_order
                    ));
                    // echo "kosong";
                }
                
            }

        $i++;
        }
        // echo "<pre>", print_r($nomor_sku_order, 1), "</pre>";
        $data['nama_produk'] = $nomor_sku_order;
        $data['bahan']      = $this->Model_master->getMasterOneTable("*", "tbl_bahan", "jenis_bahan", "asc", "");
        $data['kategori']   = $this->Model_master->getMasterOneTable("*", "tbl_kategori", "nama_kategori", "asc", "");
        $data['kerusakan']  = $this->Model_orderan->get_kerusakan($no_pesanan);
        $this->template->load("template", "orderan/data-detail_orderan", $data);
    }

    public function upload_orderan(){
        $no_pesanan_column = '';
        $status_pesanan_column = '';
        $alasan_pembatalan_column = '';
        $status_pembatalan_column = '';
        $no_resi_column = '';
        $opsi_pengiriman_column = '';
        $antar_ke_counter_column = '';
        $waktu_batas_column = '';
        $waktu_pengiriman_column = '';
        $waktu_dibuat_column = '';
        $waktu_pembayaran_column = '';
        $sku_induk_column = '';
        $nama_produk_column = '';
        $nomor_sku_column = '';
        $nama_variasi_column = '';
        $harga_awal_column = '';
        $harga_diskon_column = '';
        $total_qty_column = '';
        $total_harga_column = '';
        $total_diskon_column = '';
        $diskon_penjual_column = '';
        $diskon_ecommerce_column = '';
        $berat_produk_column = '';
        $jumlah_produk_column = '';
        $ongkir_pembeli_column = '';
        $total_pembayaran_column = '';
        $perkiraan_ongkir_column = '';
        $catatan_pembeli_column = '';
        $username_column = '';
        $nama_penerima_column = '';
        $no_telepon_column = '';
        $alamat_pengiriman_column = '';
        $kota_kabupaten_column = '';
        $provinsi_column = '';
        $waktu_selesai_column = '';
        $file_excel = $_FILES["fileExcel"]["name"];
        echo "<pre>", print_r($file_excel, 1), "</pre>";
        if (substr($file_excel,0,9) == "Order.all") {
            if (isset($_FILES["fileExcel"]["name"])) {
                $source    = $this->input->post('source');
                $path = $_FILES["fileExcel"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);

                $row_start = 0;
                if($source == "SHOPEE"){
                    $row_start = 2;
                    $no_pesanan_column = 'A';
                    $status_pesanan_column = 'B';
                    $alasan_pembatalan_column = 'C';
                    $status_pembatalan_column = 'D';
                    $no_resi_column = 'E';
                    $opsi_pengiriman_column = 'F';
                    $antar_ke_counter_column = 'G';
                    $waktu_batas_column = 'H';
                    $waktu_pengiriman_column = 'I';
                    $waktu_dibuat_column = 'J';
                    $waktu_pembayaran_column = 'K';
                    $sku_induk_column = 'L';
                    $nama_produk_column = 'M';
                    $nomor_sku_column = 'N';
                    $nama_variasi_column = 'O';
                    $harga_awal_column = 'P';
                    $harga_diskon_column = 'Q';
                    $total_qty_column = 'R';
                    $total_harga_column = 'S';
                    $total_diskon_column = 'T';
                    $diskon_penjual_column = 'U';
                    $diskon_ecommerce_column = 'V';
                    $berat_produk_column = 'W';
                    $jumlah_produk_column = 'X';
                    $ongkir_pembeli_column = 'AH';
                    $total_pembayaran_column = 'AK';
                    $perkiraan_ongkir_column = 'AL';
                    $catatan_pembeli_column = 'AM';
                    $username_column = 'AO';
                    $nama_penerima_column = 'AP';
                    $no_telepon_column = 'AQ';
                    $alamat_pengiriman_column = 'AR';
                    $kota_kabupaten_column = 'AS';
                    $provinsi_column = 'AT';
                    $waktu_selesai_column = 'AU';
                }else if($source == "TOKOPEDIA"){
                    $row_start = 5;
                    $no_pesanan_column = 'C';
                    $status_pesanan_column = 'E';
                    $no_resi_column = 'X';
                    $opsi_pengiriman_column = 'S';
                    $waktu_batas_column = 'AC';
                    $waktu_dibuat_column = 'D';
                    $waktu_pembayaran_column = 'D';
                    $sku_induk_column = 'F';
                    $nama_produk_column = 'G';
                    $nomor_sku_column = 'I';
                    $nama_variasi_column = 'G';
                    $harga_awal_column = 'K';
                    $harga_diskon_column = 'L';
                    $total_qty_column = 'H';
                    $total_harga_column = 'AC';
                    $total_diskon_column = 'AC';
                    $diskon_penjual_column = 'AC';
                    $diskon_ecommerce_column = 'M';
                    $berat_produk_column = 'AC';
                    $ongkir_pembeli_column = 'V';
                    $total_pembayaran_column = 'W';
                    $perkiraan_ongkir_column = 'V';
                    $catatan_pembeli_column = 'J';
                    $username_column = 'N';
                    $nama_penerima_column = 'P';
                    $no_telepon_column = 'Q';
                    $alamat_pengiriman_column = 'R';
                    $kota_kabupaten_column = 'AC';
                    $provinsi_column = 'AC';
                    $waktu_selesai_column = 'AC';
                }
                $created_date = date("Y-m-d H:i:s");
                $error_data = array();
                foreach($object->getWorksheetIterator() as $worksheet){
                    $row_count = $worksheet->getHighestRow();
                    $column_count = $worksheet->getHighestColumn();    
                    for($row = $row_start; $row<=$row_count; $row++){
                        $no_pesanan = $worksheet->getCell($no_pesanan_column.$row)->getValue();
                        $status_pesanan = $worksheet->getCell($status_pesanan_column.$row)->getValue();
                        $alasan_pembatalan = $worksheet->getCell($alasan_pembatalan_column.$row)->getValue();
                        $status_pembatalan = $worksheet->getCell($status_pembatalan_column.$row)->getValue();
                        $no_resi = $worksheet->getCell($no_resi_column.$row)->getValue();
                        $opsi_pengiriman = $worksheet->getCell($opsi_pengiriman_column.$row)->getValue();
                        $antar_ke_counter = $worksheet->getCell($antar_ke_counter_column.$row)->getValue();
                        $waktu_batas = $worksheet->getCell($waktu_batas_column.$row)->getValue();
                        $waktu_pengiriman = $worksheet->getCell($waktu_pengiriman_column.$row)->getValue();
                        $waktu_dibuat = $worksheet->getCell($waktu_dibuat_column.$row)->getValue();
                        $waktu_pembayaran = $worksheet->getCell($waktu_pembayaran_column.$row)->getValue();
                        $sku_induk = $worksheet->getCell($sku_induk_column.$row)->getValue();
                        $nama_produk = $worksheet->getCell($nama_produk_column.$row)->getValue();
                        $nomor_sku = $worksheet->getCell($nomor_sku_column.$row)->getValue();
                        $nama_variasi = $worksheet->getCell($nama_variasi_column.$row)->getValue();
                        $harga_awal = $worksheet->getCell($harga_awal_column.$row)->getValue();
                        $harga_awal = str_replace('Rp ','',$harga_awal);
                        $harga_awal = str_replace('.','',$harga_awal);

                        $harga_diskon = $worksheet->getCell($harga_diskon_column.$row)->getValue();
                        $harga_diskon = str_replace('Rp ','',$harga_diskon);
                        $harga_diskon = str_replace('.','',$harga_diskon);

                        $total_qty = $worksheet->getCell($total_qty_column.$row)->getValue();
                        $total_harga = $worksheet->getCell($total_harga_column.$row)->getValue();
                        $total_harga = str_replace('Rp ','',$total_harga);
                        $total_harga = str_replace('.','',$total_harga);

                        $total_diskon = $worksheet->getCell($total_diskon_column.$row)->getValue();
                        $total_diskon = str_replace('Rp ','',$total_diskon);
                        $total_diskon = str_replace('.','',$total_diskon);

                        $diskon_penjual = $worksheet->getCell($diskon_penjual_column.$row)->getValue();
                        $diskon_penjual = str_replace('Rp ','',$diskon_penjual);
                        $diskon_penjual = str_replace('.','',$diskon_penjual);

                        $diskon_ecommerce = $worksheet->getCell($diskon_ecommerce_column.$row)->getValue();
                        $diskon_ecommerce = str_replace('Rp ','',$diskon_ecommerce);
                        $diskon_ecommerce = str_replace('.','',$diskon_ecommerce);

                        $berat_produk = $worksheet->getCell($berat_produk_column.$row)->getValue();
                        $jumlah_produk = $worksheet->getCell($jumlah_produk_column.$row)->getValue();
                        $total_diskon = str_replace(' gr','',$total_diskon);

                        $ongkir_pembeli = $worksheet->getCell($ongkir_pembeli_column.$row)->getValue();
                        $ongkir_pembeli = str_replace('Rp ','',$ongkir_pembeli);
                        $ongkir_pembeli = str_replace('.','',$ongkir_pembeli);

                        $total_pembayaran = $worksheet->getCell($total_pembayaran_column.$row)->getValue();
                        $total_pembayaran = str_replace('Rp ','',$total_pembayaran);
                        $total_pembayaran = str_replace('.','',$total_pembayaran);

                        $perkiraan_ongkir = $worksheet->getCell($perkiraan_ongkir_column.$row)->getValue();
                        $perkiraan_ongkir = str_replace('Rp ','',$perkiraan_ongkir);
                        $perkiraan_ongkir = str_replace('.','',$perkiraan_ongkir);

                        $catatan_pembeli = $worksheet->getCell($catatan_pembeli_column.$row)->getValue();
                        $username = $worksheet->getCell($username_column.$row)->getValue();
                        $nama_penerima = $worksheet->getCell($nama_penerima_column.$row)->getValue();
                        $no_telepon = $worksheet->getCell($no_telepon_column.$row)->getValue();
                        if (substr($no_telepon, 0, 1) === '0') {
                           $no_telepon = '62' . substr($no_telepon, 1);
                        }
                        $alamat_pengiriman = $worksheet->getCell($alamat_pengiriman_column.$row)->getValue();
                        $kota_kabupaten = $worksheet->getCell($kota_kabupaten_column.$row)->getValue();
                        $provinsi = $worksheet->getCell($provinsi_column.$row)->getValue();
                        $waktu_selesai = $worksheet->getCell($waktu_selesai_column.$row)->getValue();
                        $created_by = $this->session->userdata("id_user");
                        $unique_key = $no_pesanan."_".$nama_produk."_".$nama_variasi; 
                        $query = $this->db->get_where('tbl_order', array('tbl_order.unique_key' => $unique_key));
                        $exist = $query->num_rows();
                        $customer_data = array(
                            'nama_customer' => $nama_penerima,
                            'wa_customer' => $no_telepon,
                            'alamat_customer' => $alamat_pengiriman,
                            'kabupaten_customer' => $kota_kabupaten,
                            'provinsi_customer' => $provinsi
                            );
                        $upload_data = array(
                            'source' => $source,
                            'no_pesanan' => $no_pesanan,
                            'unique_key' => $unique_key,
                            'status_pesanan' => $status_pesanan,
                            'alasan_pembatalan' => $alasan_pembatalan,
                            'status_pembatalan' => $status_pembatalan,
                            'no_resi' => $no_resi,
                            'opsi_pengiriman' => $opsi_pengiriman,
                            'antar_ke_counter' => $antar_ke_counter,
                            'waktu_batas' => $waktu_batas,
                            'waktu_pengiriman' => $waktu_pengiriman,
                            'waktu_dibuat' => $waktu_dibuat,
                            'waktu_pembayaran' => $waktu_pembayaran,
                            'sku_induk' => $sku_induk,
                            'nama_produk' => $nama_produk,
                            'nomor_sku' => $nomor_sku,
                            'nama_variasi' => $nama_variasi,
                            'harga_awal' => $harga_awal,
                            'harga_diskon' => $harga_diskon,
                            'total_qty' => $total_qty,
                            'total_harga' => $total_harga,
                            'total_diskon' => $total_diskon,
                            'diskon_penjual' => $diskon_penjual,
                            'diskon_ecommerce' => $diskon_ecommerce,
                            'berat_produk' => $berat_produk,
                            'jumlah_produk' => $jumlah_produk,
                            'ongkir_pembeli' => $ongkir_pembeli,
                            'total_pembayaran' => $total_pembayaran,
                            'perkiraan_ongkir' => $perkiraan_ongkir,
                            'catatan_pembeli' => $catatan_pembeli,
                            'username' => $username,
                            'nama_penerima' => $nama_penerima,
                            'no_telepon' => $no_telepon,
                            'alamat_pengiriman' => $alamat_pengiriman,
                            'kota_kabupaten' => $kota_kabupaten,
                            'provinsi' => $provinsi,
                            'waktu_selesai' => $waktu_selesai,
                            'created_by' => $created_by,
                            'created_date' => $created_date
                        );
                        // echo '<pre>',print_r($status_pesanan." - ".$no_pesanan." - ".$no_telepon,1),'</pre>';
                        // if ($status_pesanan == "Diproses") {
                        //     echo "kirim ke no pesanan ".$no_pesanan." - ".$no_telepon." dengan status diproses";
                        // } else if($status_pesanan == "Selesai"){
                        //     echo "kirim ke no pesanan ".$no_pesanan." - ".$no_telepon." dengan status selesai";
                        // }

                        $insert_query = $this->db->insert_string('tbl_customer', $customer_data);
                        $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
                        $this->db->query($insert_query);
                        if ($exist == 0) {
                            // echo '<pre> Insert ',print_r($upload_data,1),'</pre>';
                            $insert = $this->Model_orderan->tambah_orderan(array($upload_data));
                            if(!$insert){
                                array_push($error_data, $upload_data);
                            }
                        } else {
                            // echo '<pre> Update ',print_r($upload_data,1),'</pre>';
                            $update = $this->Model_orderan->edit_orderan(array($upload_data));
                            if(!$update){
                                array_push($error_data, $upload_data);
                            }
                        }
                    }
                }
                $data = array(
                    'full_name' => $this->input->post('full_name'),
                    'toko_online' => $this->input->post('source'),
                    'tanggal' => $created_date
                );

                $this->db->insert('tbl_upload', $data);                        
            } else{
                $this->session->set_flashdata("error", "Tidak ada file yang di uplaod");
            }
            if(count($error_data)>0){
                $this->session->set_flashdata("error", "Ada data yang gagal ditambahkan");
            }else{
                $this->session->set_flashdata("success", "Data berhasil ditambahkan");
            }
        } else {
            $this->session->set_flashdata("error", "File Excel tidak bisa di upload, yang bisa di upload adalah pilih menu semua di shopee dan pilih export");
            // echo "gagal insert data";
        }

        
        redirect('upload_orderan');
    }

    // kalau ada eror atur database dulu di link ini...  https://stackoverflow.com/questions/1008287/illegal-mix-of-collations-mysql-error

    public function insert_batch_string($table='',$data=[],$ignore=false){
        $CI = &get_instance();
        $sql = '';

        if ($table && !empty($data)){
            $rows = [];

            foreach ($data as $row) {
                $insert_string = $CI->db->insert_string($table,$row);
                if(empty($rows) && $sql ==''){
                    $sql = substr($insert_string,0,stripos($insert_string,'VALUES'));
                }
                $rows[] = trim(substr($insert_string,stripos($insert_string,'VALUES')+6));
            }

            $sql.=' VALUES '.implode(',',$rows);

            if ($ignore) $sql = str_ireplace('INSERT INTO', 'INSERT IGNORE INTO', $sql);
        }
        return $sql;
    }

    public function change_status_kerjakan(){
        $id_user      = $this->input->post("id_user");
        $no_pesanan   = $this->input->post("no_pesanan");
        $created_date = date("Y-m-d H:i:s");

        $action = $this->Model_orderan->change_status_kerjakan($id_user, $no_pesanan, $created_date);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Status berhasil diubah menjadi dikerjakan"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, status tidak dapat diubah menjadi dikerjakan"));
        }
    }

    public function change_status_desain(){
        $no_pesanan   = $this->input->post("no_pesanan");
        $created_date = date("Y-m-d H:i:s");
        $action  = $this->Model_orderan->change_status_desain($no_pesanan, $created_date);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Status berhasil diubah menjadi desain"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, status tidak dapat diubah menjadi desain"));
        }
    }

    public function change_status_antri_cetak(){
        $no_pesanan   = $this->input->post("no_pesanan");
        $created_date = date("Y-m-d H:i:s");
        $action = $this->Model_orderan->change_status_antri_cetak($no_pesanan, $created_date);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Status berhasil diubah menjadi antri cetak"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, status tidak dapat diubah menjadi antri cetak"));
        }
    }

    public function change_status_cetak_diluar(){
        $no_pesanan   = $this->input->post("no_pesanan");
        $created_date = date("Y-m-d H:i:s");
        $action = $this->Model_orderan->change_status_cetak_diluar($no_pesanan, $created_date);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Status berhasil diubah menjadi cetak diluar"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, status tidak dapat diubah menjadi cetak diluar"));
        }
    }

    public function change_status_desain_selesai(){
        $no_pesanan   = $this->input->post("no_pesanan");
        $created_date = date("Y-m-d H:i:s");
        $action = $this->Model_orderan->change_status_desain_selesai($no_pesanan, $created_date);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Status berhasil diubah menjadi antri cetak"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, status tidak dapat diubah menjadi antri cetak"));
        }
    }

    public function change_status_cetak_selesai(){
        $no_pesanan   = $this->input->post("no_pesanan");
        $id_user_cetak   = $this->input->post("id_user_cetak");
        $created_date = date("Y-m-d H:i:s");
        $action = $this->Model_orderan->change_status_cetak_selesai($no_pesanan, $created_date, $id_user_cetak);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Status berhasil diubah menjadi packing"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, status tidak dapat diubah menjadi packing"));
        }
    }

    public function change_status_sudah_order(){
        $no_pesanan   = $this->input->post("no_pesanan");
        $created_date = date("Y-m-d H:i:s");
        $action = $this->Model_orderan->change_status_sudah_order($no_pesanan, $created_date);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Status berhasil diubah menjadi menunggu pengiriman"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, status tidak dapat diubah menjadi menunggu pengiriman"));
        }
    }

    public function change_status_packing(){
        $no_pesanan   = $this->input->post("no_pesanan");
        $created_date = date("Y-m-d H:i:s");
        $action = $this->Model_orderan->change_status_packing($no_pesanan, $created_date);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Status berhasil diubah menjadi packing"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, status tidak dapat diubah menjadi packing"));
        }
    }

    public function change_status_siap_kirim(){
        $no_pesanan   = $this->input->post("no_pesanan");
        $created_date = date("Y-m-d H:i:s");
        $action = $this->Model_orderan->change_status_siap_kirim($no_pesanan, $created_date);
        if ($action) {
            echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Status berhasil diubah menjadi dikirim"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Gagal, status tidak dapat diubah menjadi dikirim"));
        }
    }

    public function change_status_batal_orderan(){
        $no_pesanan = $this->input->post('no_pesanan');
        $alasan_pembatalan = $this->input->post('alasan_pembatalan');
        $action = $this->Model_orderan->change_status_batal_orderan($no_pesanan, $alasan_pembatalan);
        if ($action) {
            $this->session->set_flashdata("success", "Status berhasil diubah menjadi batal");
        } else {
            $this->session->set_flashdata("error", "Gagal, status tidak dapat diubah menjadi batal");
        }
        redirect('upload_orderan');
    } 

//     status pesanan
// - perlu di kirim 
// - dikirim
// - selesa

// link firebase = https://www.itwonders-web.com/blog/push-notification-using-firebase-demo-tutorial

    //firebase notifikasi 

    // server_key = AAAAzwO0aDo:APA91bE6DUBVmZ362rVpIFxRMuzyyZIeR0oNplKS-HHBXRcDwBuQxpGhz03V7dzz-JfIhpBEtdbG5mCuDhhRUgNMo0lBJP25jIIPrmmzHl61-Kq12ConjIvuw1-sau9XH2dbpKlWStoe
    // sender ID = 889120385082


    // link tutorial 

    // Ada beberapa tutorial yg agan bisa ikutin:

    // 1. Live Update Codeigniter with Socket.io and Redis
    // Tutorial: [link]http://ericterpstra.com/2013/04/live-updates-in-codeigniter-with-socket-io-and-redis/ [/link]
    // NodeJS: [link]https://nodejs.org/api/ [/link]

    // 2. How to Create Facebook Notification System in PHP with Ajax
    // Web: [link]http://www.webslesson.info/2017/02/facebook-style-notifications-in-php.html [/link]
    // Youtube: [link]https://www.youtube.com/watch?v=IvagmRhTG4w [/link]

    // 3. Send Real Time Notification to Clients Through Pusher in PHP
    // tutorial: [link]https://shareurcodes.com/blog/send%20real%20time%20notification%20to%20clients%20through%20pusher%20in%20php [/link]
    // Bootstrap Notify: http://bootstrap-notify.remabledesigns.com/

    // 4. APE-Project (send real-time notifications via javascript)
    // link: http://ape-project.org/
    // 5. https://github.com/moemoe89/Simple-realtime-message-SocketIO-NodeJS-CI
}
?>