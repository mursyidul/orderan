<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orderan_siap extends CI_Controller {

    public function __construct(){
		parent::__construct();
        checkSessionUser();
        $this->load->library('pdf');
        $this->load->library('PHPExcel','excel');
        $this->load->model("Model_master");
        $this->load->model("Model_orderan");
        $this->load->library('session');
    }

    public function index(){

        $list_order = $this->Model_orderan->get_orderan_siap();
        $i=0;
        foreach ($list_order as $k) {
            $no_pesanan       = $k['no_pesanan'];
            // $nomor_sku        = $k['nomor_sku'];
            $opsi_pengiriman  = $k['opsi_pengiriman'];
            $username         = $k['username'];
            $nama_penerima    = $k['nama_penerima'];
            $kota_kabupaten   = $k['kota_kabupaten'];
            $waktu_batas      = $k['waktu_batas'];
            $waktu_dibuat     = $k['waktu_dibuat'];
            $status_pesanan   = $k['status_pesanan'];
            $status_kerjakan  = $k['status_kerjakan'];
            $full_name        = $k['full_name'];
            $user_cetak       = $k['user_cetak'];
            $id_user          = $k['id_user'];
            $jumlah_order     = $this->Model_orderan->get_jumlah_orderan_siap($no_pesanan);
            $no_pesanan_order = $this->Model_orderan->get_no_pesanan_siap($no_pesanan);
            $nomor_sku_order  = array();
            for ($a=0; $a < $jumlah_order[0]['jumlah']; $a++) { 
                $nomor_sku        = $no_pesanan_order[$a]['nomor_sku'];
                $sku_induk        = $no_pesanan_order[$a]['sku_induk'];
                $no_pesanan       = $no_pesanan_order[$a]['no_pesanan'];
                $id_orderan       = $no_pesanan_order[$a]['id_orderan'];
                $sku_kosong       = "";

                if ($nomor_sku != "") {
                    // echo "tidak kosong";
                    $sku_order  = $this->Model_orderan->get_nomor_sku_siap($sku_induk, $id_orderan);
                    array_push($nomor_sku_order, array(
                        $sku_order
                    ));
                } else {
                    $sku_order  = $this->Model_orderan->get_nomor_sku_kosong($sku_induk, $id_orderan);
                    // echo $this->db->last_query();
                    // echo "<pre>", print_r($sku_order, 1), "</pre>";
                    array_push($nomor_sku_order, array(
                       $sku_order
                    ));
                    // echo "kosong";
                }

                // $sku_order  = $this->Model_orderan->get_nomor_sku_siap($nomor_sku);
                // array_push($nomor_sku_order, array(
                //     $sku_order
                // ));
            }
                // echo "<pre>", print_r($no_pesanan_order,1), "</pre>";
            // echo "<pre>", print_r($nama_variasi_order, 1), "</pre>";
            // $list_order[$i]['no_pesanan_order'] = $no_pesanan_order;
            $list_order[$i]['nomor_sku_order']  = $nomor_sku_order;
            $list_order[$i]['jumlah_order']     = $jumlah_order;
            $i++;
        }
        // echo "<pre>", print_r($list_order, 1), "</pre>";
        $data["orderan"]  = $list_order;
        $data["no_pesanan"] = $this->Model_orderan->get_orderan_siap();
        $data['bahan']  = $this->Model_master->getMasterOneTable("*", "tbl_bahan", "jenis_bahan", "asc", "");
        $data['kategori']  = $this->Model_master->getMasterOneTable("*", "tbl_kategori", "nama_kategori", "asc", "");
        $data['bahan']  = $this->Model_orderan->get_bahan();
        // echo $this->db->last_query();
        // $data['kraft']  = $this->Model_master->get_perbahan("ROLL", "KRAFT PAPER");
        // $data['art']  = $this->Model_master->get_perbahan("ROLL", "ART PAPER");
        // $data['roll']  = $this->Model_master->get_perbahan("THANK YOU CARD", "SAMSON");
        // echo "<pre>", print_r($data['kraft'], 1), "</pre>";
		$this->template->load("template", "orderan/data-orderan-siap", $data);
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
        echo $this->db->last_query();
        if ($status_bahan == "belum cetak") {
            $total_harga  = $bahan->harga_kertas * $jumlah_kerusakan;
        } else {
            $total_harga  = $bahan->harga_cetak * $jumlah_kerusakan;
        }

        $data = array(
            "id_user"           => $id_user,
            "id_bahan"          => $id_bahan,
            "id_kategori"       => $id_kategori,
            "no_pesanan"        => $no_pesanan,
            "sebab_kerusakan"   => $sebab_kerusakan,
            "jumlah_kerusakan"  => $jumlah_kerusakan,
            "created_date"      => $created_date,
            "total_harga"       => $total_harga
        );

        // echo "<pre>", print_r($id_bahan, 1), "</pre>";
        // echo "<pre>", print_r($data, 1), "</pre>";

        $action = $this->Model_master->tambahMaster("tbl_kerusakan", $data);

        if ($action) {
            $this->session->set_flashdata("success", "Berhasil Menambahkan kerusakan orderan");
        } else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat menambahkan kerusakan orderan");
        }
        redirect("orderan_siap");
    }

    public function tambah_detail_orderan(){
        $id_user        = $this->input->post("id_user");
        $no_pesanan     = $this->input->post("no_pesanan");
        $perlembar_kraft= $this->input->post("perlembar_kraft");
        $perlembar_art  = $this->input->post("perlembar_art");
        $perlembar_samson = $this->input->post("perlembar_samson");
        $jumlah_kraft   = $this->input->post("jumlah_kraft");
        $jumlah_art     = $this->input->post("jumlah_art");
        $jumlah_samson  = $this->input->post("jumlah_samson");
        $keterangan     = $this->input->post("keterangan");
        $created_date   = date("Y-m-d H:i:s");

        $kraft_paper    = $jumlah_kraft / $perlembar_kraft;
        $art_paper      = $jumlah_art / $perlembar_art;
        $roll_e         = $jumlah_samson / $perlembar_samson;  

        $stock          = $this->db->get_where("tbl_stock", ['id_stock', 1])->row(); 
        $stock_kraft    = $stock->kraft_paper - $kraft_paper;
        $stock_art      = $stock->art_paper - $art_paper;
        $stock_samson   = $stock->samson - $roll_e;

        $data = array(
            "id_user"            => $id_user,
            "no_pesanan"         => $no_pesanan,
            "perlembar_kraft"    => $perlembar_kraft,
            "perlembar_art"      => $perlembar_art,
            "perlembar_samson"   => $perlembar_samson,
            "jumlah_kraft"       => $jumlah_kraft,
            "jumlah_art"         => $jumlah_art,
            "jumlah_samson"      => $jumlah_samson,
            "keterangan"         => $keterangan,
            "created_date"       => $created_date   
        );
        /*echo "<pre>", print_r($data, 1), "</pre>";
        echo "<pre>", print_r($kraft_paper, 1), "</pre>";
        echo "<pre>", print_r($art_paper, 1), "</pre>";
        echo "<pre>", print_r($roll_e, 1), "</pre>";
        echo "<pre>", print_r($stock, 1), "</pre>";
        echo "<pre>", print_r($stock_kraft, 1), "</pre>";
        echo "<pre>", print_r($stock_art, 1), "</pre>";
        echo "<pre>", print_r($stock_roll, 1), "</pre>";*/
        $action = $this->Model_master->tambahMaster("tbl_list_order", $data);
        if ($action) {
            $this->db->set('kraft_paper', $stock_kraft);
            $this->db->set('art_paper', $stock_art);
            $this->db->set('samson', $stock_samson);
            $this->db->where('id_stock', 1);
            $this->db->update('tbl_stock');

            // $this->db->set('status_detail', 'Ada');
            $this->db->where('no_pesanan', $no_pesanan);
            $this->db->update('tbl_order');
            $this->session->set_flashdata("success", "Berhasil menambahkan detail orderan");
        } else {
            $this->session->set_flashdata("error", "Gagal, tidak dapat menambahakan detail orderan");
        }
        redirect("orderan_siap");

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
        $pesanan_no      = $this->input->post("pesanan_no");
        $id_bahan        = $this->input->post("id_bahan");
        $total           = $this->input->post("total");
        $jumlah_order    = $this->input->post("jumlah_order");
        $bonus_order     = $this->input->post("bonus_order");
        $id_user         = $this->input->post("id_user");
        $id_orderan      = $this->input->post("id_orderan");
        $nomor_sku       = $this->input->post("nomor_sku");
        $status_kerjakan = $this->input->post("status_kerjakan");
        $created_date    = $this->input->post("created_date");
        $image           = $this->input->post('picture');
        $image           = str_replace('data:image/jpeg;base64,','', $image);
        $image           = base64_decode($image);
        $filename        = 'image_'.time().'.png';
        file_put_contents(FCPATH.'/file/foto_produk/'.$filename,$image);
        // $pesanan_no      = $this->input->post("pesanan_no");
        // $date_created = date("Y-m-d H:i:s");
        // echo "<pre>", print_r($filename,1), "</pre>";
        $update = array();
        foreach( $id_user as $key => $n ) {
            array_push($update, array(
                // "no_pesanan"        => $n,
                "id_user_packing"   => $n,
                "nomor_sku"         => $nomor_sku[$key],
                "id_orderan"        => $id_orderan[$key],
                "jumlah_order"      => $jumlah_order[$key],
                "bonus_order"       => $bonus_order[$key],
                "gambar_orderan"    => $filename,
                "status_kerjakan"   => $status_kerjakan[$key],
                "tanggal_dikirim"   => $created_date[$key]
            ));
        }
        // echo "<pre>", print_r($update, 1), "</pre>";

        $action = $this->Model_orderan->change_status_siap_kirim($update);
        if ($action) {
            if ($id_bahan == "8") {
                // echo "maka insert id bahan 8 dan 11";
                $bahan_8 = $this->db->get_where("tbl_bahan", ['id_bahan' => '8'])->row();
                $total_8 = 1 * $bahan_8->harga_kertas;
                $bahan_11 = $this->db->get_where("tbl_bahan", ['id_bahan' => '11'])->row();
                $total_11 = 1 * $bahan_11->harga_kertas;

                $data = array(
                        array(
                                
                            "id_user"           => $this->session->userdata('id_user'),
                            "id_bahan"          => '8',
                            "no_pesanan"        => $pesanan_no,
                            "nama_produk"       => "AMPLOP COKLAT KECIL (28 x 12 CM)",
                            "jumlah_bahan"      => "1",
                            "harga_barang"      => $bahan_8->harga_kertas,
                            "total_harga"       => $total_8,
                            "deskripsi"         => "AMPLOP COKLAT KECIL (28 x 12 CM)",
                            "created_date"      => date("Y-m-d H:i:s")
                        ),
                        array(
                            "id_user"           => $this->session->userdata('id_user'),
                            "id_bahan"          => '11',
                            "no_pesanan"        => $pesanan_no,
                            "nama_produk"       => "POLYMAILER KECIL (13 x 30 CM)",
                            "jumlah_bahan"      => "1",
                            "harga_barang"      => $bahan_11->harga_kertas,
                            "total_harga"       => $total_11,
                            "deskripsi"         => "POLYMAILER KECIL (13 x 30 CM)",
                            "created_date"      => date("Y-m-d H:i:s")
                        )
                    );
                // echo "<pre>", print_r($data, 1), "</pre>";
                $this->db->insert_batch('tbl_pengeluaran_bahan', $data);
                $stock_8 = $this->db->get_where('tbl_stock', ['id_bahan' => '8'])->row();
                $stock_11 = $this->db->get_where('tbl_stock', ['id_bahan' => '11'])->row();
                if (isset($stock_8->id_bahan) && isset($stock_11->id_bahan)) {
                    $total_8  = $stock_8->jumlah_stock - 1;
                    $total_11 = $stock_11->jumlah_stock - 1;
                    // echo "update";
                    $data_update = array(
                       array(
                          'id_bahan' => '8' ,
                          'jumlah_stock' => $total_8
                       ),
                       array(
                          'id_bahan' => '11' ,
                          'jumlah_stock' => $total_11
                       )
                    );
                    // echo "<pre>", print_r($data_update, 1), "</pre>";
                    $this->db->update_batch('tbl_stock', $data_update, 'id_bahan');
                }

            } else if ($id_bahan == "9") {
                echo "maka insert id bahan 9 dan 12";
                $bahan_9 = $this->db->get_where("tbl_bahan", ['id_bahan' => '9'])->row();
                $total_9 = 1 * $bahan_9->harga_kertas;
                $bahan_12 = $this->db->get_where("tbl_bahan", ['id_bahan' => '12'])->row();
                $total_12 = 1 * $bahan_12->harga_kertas;

                $data = array(
                        array(
                                
                            "id_user"           => $this->session->userdata('id_user'),
                            "id_bahan"          => '9',
                            "no_pesanan"        => $pesanan_no,
                            "nama_produk"       => "AMPLOP COKLAT SEDANG (18 x 28 CM)",
                            "jumlah_bahan"      => "1",
                            "harga_barang"      => $bahan_9->harga_kertas,
                            "total_harga"       => $total_9,
                            "deskripsi"         => "AMPLOP COKLAT SEDANG (18 x 28 CM)",
                            "created_date"      => date("Y-m-d H:i:s")
                        ),
                        array(
                            "id_user"           => $this->session->userdata('id_user'),
                            "id_bahan"          => '12',
                            "no_pesanan"        => $pesanan_no,
                            "nama_produk"       => "POLYMAILER SEDANG (20 x 30 CM)",
                            "jumlah_bahan"      => "1",
                            "harga_barang"      => $bahan_12->harga_kertas,
                            "total_harga"       => $total_12,
                            "deskripsi"         => "POLYMAILER SEDANG (20 x 30 CM)",
                            "created_date"      => date("Y-m-d H:i:s")
                        )
                    );
                // echo "<pre>", print_r($data, 1), "</pre>";
                $this->db->insert_batch('tbl_pengeluaran_bahan', $data);
                $stock_9 = $this->db->get_where('tbl_stock', ['id_bahan' => '9'])->row();
                $stock_12 = $this->db->get_where('tbl_stock', ['id_bahan' => '12'])->row();
                if (isset($stock_9->id_bahan) && isset($stock_12->id_bahan)) {
                    $total_9  = $stock_9->jumlah_stock - 1;
                    $total_12 = $stock_12->jumlah_stock - 1;
                    // echo "update";
                    $data_update = array(
                       array(
                          'id_bahan' => '9' ,
                          'jumlah_stock' => $total_9
                       ),
                       array(
                          'id_bahan' => '12' ,
                          'jumlah_stock' => $total_12
                       )
                    );
                    // echo "<pre>", print_r($data_update, 1), "</pre>";
                    $this->db->update_batch('tbl_stock', $data_update, 'id_bahan');
                }
            } else if($id_bahan == "10") {
                echo "maka insert id bahan 10 dan 13";
                $bahan_10 = $this->db->get_where("tbl_bahan", ['id_bahan' => '10'])->row();
                $total_10 = 1 * $bahan_10->harga_kertas;
                $bahan_13 = $this->db->get_where("tbl_bahan", ['id_bahan' => '13'])->row();
                $total_13 = 1 * $bahan_12->harga_kertas;

                $data = array(
                        array(
                                
                            "id_user"           => $this->session->userdata('id_user'),
                            "id_bahan"          => '10',
                            "no_pesanan"        => $pesanan_no,
                            "nama_produk"       => "AMPLOP COKLAT BESAR (24 x 35 CM)",
                            "jumlah_bahan"      => "1",
                            "harga_barang"      => $bahan_10->harga_kertas,
                            "total_harga"       => $total_10,
                            "deskripsi"         => "AMPLOP COKLAT BESAR (24 x 35 CM)",
                            "created_date"      => date("Y-m-d H:i:s")
                        ),
                        array(
                            "id_user"           => $this->session->userdata('id_user'),
                            "id_bahan"          => '13',
                            "no_pesanan"        => $pesanan_no,
                            "nama_produk"       => "POLYMAILER BESAR (32 x 45 CM)",
                            "jumlah_bahan"      => "1",
                            "harga_barang"      => $bahan_13->harga_kertas,
                            "total_harga"       => $total_13,
                            "deskripsi"         => "POLYMAILER BESAR (32 x 45 CM)",
                            "created_date"      => date("Y-m-d H:i:s")
                        )
                    );
                // echo "<pre>", print_r($data, 1), "</pre>";
                $this->db->insert_batch('tbl_pengeluaran_bahan', $data);
                $stock_10 = $this->db->get_where('tbl_stock', ['id_bahan' => '10'])->row();
                $stock_13 = $this->db->get_where('tbl_stock', ['id_bahan' => '13'])->row();
                if (isset($stock_10->id_bahan) && isset($stock_13->id_bahan)) {
                    $total_10  = $stock_10->jumlah_stock - 1;
                    $total_13 = $stock_13->jumlah_stock - 1;
                    $data_update = array(
                       array(
                          'id_bahan' => '10' ,
                          'jumlah_stock' => $total_10
                       ),
                       array(
                          'id_bahan' => '13' ,
                          'jumlah_stock' => $total_13
                       )
                    );
                    // echo "<pre>", print_r($data_update, 1), "</pre>";
                    $this->db->update_batch('tbl_stock', $data_update, 'id_bahan');
                }
            }
            $this->session->set_flashdata("success", "Status berhasil diubah menjadi dikirim");
        } else {
            $this->session->set_flashdata("error", "Gagal, status tidak dapat diubah menjadi dikirim");
        }
        redirect("orderan_siap");
    }

    public function get_bahan_add(){
        $id                         = $this->input->post('id');
        $data                       = $this->Model_orderan->get_bahan_add($id);
        echo json_encode($data);
    }

    // public function change_status_siap_kirim(){
    //     $no_pesanan   = $this->input->post("no_pesanan");
    //     $created_date = date("Y-m-d H:i:s");
    //     $action = $this->Model_orderan->change_status_siap_kirim($no_pesanan, $created_date);
    //     if ($action) {
    //         echo json_encode(array("status" => "success", "data" => $no_pesanan, "message" => "Status berhasil diubah menjadi dikirim"));
    //     } else {
    //         echo json_encode(array("status" => "error", "message" => "Gagal, status tidak dapat diubah menjadi dikirim"));
    //     }
    // }

//     status pesanan
// - perlu di kirim 
// - dikirim
// - selesai

}
?>