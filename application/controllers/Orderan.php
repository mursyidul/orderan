<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orderan extends CI_Controller {

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
        $data["orderan"]  = $this->Model_master->getMasterOneTable("*", "tbl_order", "id_orderan", "asc", "");
		$this->template->load("template", "orderan/data-orderan", $data);
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
                $ongkir_pembeli_column = 'AH';
                $total_pembayaran_column = 'AJ';
                $perkiraan_ongkir_column = 'AK';
                $catatan_pembeli_column = 'AL';
                $username_column = 'AN';
                $nama_penerima_column = 'AO';
                $no_telepon_column = 'AP';
                $alamat_pengiriman_column = 'AQ';
                $kota_kabupaten_column = 'AR';
                $provinsi_column = 'AS';
                $waktu_selesai_column = 'AT';
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
        }else{
            $this->session->set_flashdata("error", "Tidak ada file yang di uplaod");
        }

        if(count($error_data)>0){
            $this->session->set_flashdata("error", "Ada data yang gagal ditambahkan");
        }else{
            $this->session->set_flashdata("success", "Data berhasil ditambahkan");
        }
        redirect('orderan');
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