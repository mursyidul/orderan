<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_report extends CI_Model {

    public function get_nol_pengeluaran($startdate, $enddate){
        $hasil=$this->db->query("SELECT orderan.no_pesanan, orderan.id_user, user.full_name as user_pekerja, orderan.id_user_cetak, user_cetak.full_name as user_cetak FROM `tbl_order` `orderan` LEFT JOIN tbl_user user ON user.id_user=orderan.id_user LEFT JOIN tbl_user user_cetak ON user_cetak.id_user=orderan.id_user_cetak where no_pesanan not in (select no_pesanan from tbl_pengeluaran_bahan) and status_pesanan = 'Selesai' AND DATE(waktu_dibuat) >= '$startdate' AND DATE(waktu_dibuat) <= '$enddate' GROUP by no_pesanan ORDER BY `orderan`.`id_orderan` ASC");
        return $hasil->result();
    }

    public function get_selesai($id, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as jumlah_selesai FROM ( SELECT COUNT(no_pesanan) FROM tbl_order  where status_pesanan = 'Selesai' AND DATE(waktu_dibuat) >= '$startdate' AND DATE(waktu_dibuat) <= '$enddate' GROUP BY no_pesanan ) selesai");
        return $hasil->result();
    }

    public function get_batal($id, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as jumlah_batal FROM ( SELECT COUNT(no_pesanan) FROM tbl_order  where status_pesanan = 'Batal' AND DATE(waktu_dibuat) >= '$startdate' AND DATE(waktu_dibuat) <= '$enddate' GROUP BY no_pesanan ) batal");
        return $hasil->result();
    }

    public function get_perlu_dikirim($id, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as jumlah_perlu_dikirim FROM ( SELECT COUNT(no_pesanan) FROM tbl_order  where status_pesanan = 'Perlu Dikirim' AND status_pesanan != 'Batal' AND DATE(waktu_dibuat) >= '$startdate' AND DATE(waktu_dibuat) <= '$enddate' GROUP BY no_pesanan ) perlu");
        return $hasil->result();
    }

    public function get_dikerjakan($id, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as jumlah_dikerjakan FROM ( SELECT COUNT(no_pesanan) FROM tbl_order  where status_kerjakan = 'DIKERJAKAN' AND status_pesanan != 'Batal' AND DATE(waktu_dibuat) >= '$startdate' AND DATE(waktu_dibuat) <= '$enddate' GROUP BY no_pesanan ) kerjakan");
        return $hasil->result();
    }

    public function get_desain($id, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as jumlah_desain FROM ( SELECT COUNT(no_pesanan) FROM tbl_order  where status_kerjakan = 'DESAIN' AND status_pesanan != 'Batal' AND DATE(waktu_dibuat) >= '$startdate' AND DATE(waktu_dibuat) <= '$enddate' GROUP BY no_pesanan ) desain");
        return $hasil->result();
    }

    public function get_cetak_diluar($id, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as jumlah_cetak_diluar FROM ( SELECT COUNT(no_pesanan) FROM tbl_order  where status_kerjakan = 'CETAK DILUAR' AND status_pesanan != 'Batal' AND DATE(waktu_dibuat) >= '$startdate' AND DATE(waktu_dibuat) <= '$enddate' GROUP BY no_pesanan ) luar");
        return $hasil->result();
    }

    public function get_antri_cetak($id, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as jumlah_antri_cetak FROM ( SELECT COUNT(no_pesanan) FROM tbl_order  where status_kerjakan = 'ANTRI CETAK' AND status_pesanan != 'Batal' AND DATE(waktu_dibuat) >= '$startdate' AND DATE(waktu_dibuat) <= '$enddate' GROUP BY no_pesanan ) antri");
        return $hasil->result();
    }

    public function get_menunggu_pengiriman($id, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as jumlah_menunggu_pengiriman FROM ( SELECT COUNT(no_pesanan) FROM tbl_order  where status_kerjakan = 'MENUNGGU PENGIRIMAN' AND status_pesanan != 'Batal' AND DATE(waktu_dibuat) >= '$startdate' AND DATE(waktu_dibuat) <= '$enddate' GROUP BY no_pesanan ) menunggu");
        return $hasil->result();
    }

    public function get_packing($id, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as jumlah_packing FROM ( SELECT COUNT(no_pesanan) FROM tbl_order  where status_kerjakan = 'PACKING' AND status_pesanan != 'Batal' AND DATE(waktu_dibuat) >= '$startdate' AND DATE(waktu_dibuat) <= '$enddate' GROUP BY no_pesanan ) packing");
        return $hasil->result();
    }

    public function get_sedang_dikirim($id, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as jumlah_sedang_dikirim FROM ( SELECT COUNT(no_pesanan) FROM tbl_order  where status_pesanan = 'Sedang Dikirim' AND DATE(waktu_dibuat) >= '$startdate' AND DATE(waktu_dibuat) <= '$enddate' GROUP BY no_pesanan ) packing");
        return $hasil->result();
    }

    public function get_bahan($id, $startdate, $enddate){
        $this->db->select("bahan.jenis_bahan, sum(kerusakan.jumlah_kerusakan) as jumlah_kerusakan, sum(total_harga) as total_biaya");
        $this->db->from("tbl_kerusakan kerusakan");
        $this->db->join("tbl_bahan bahan", "bahan.id_bahan = kerusakan.id_bahan", "LEFT");
        if($startdate!=""){
            $this->db->where('DATE(kerusakan.created_date) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(kerusakan.created_date) <=', date('Y-m-d',strtotime($enddate)));
        }
        if($id!=""){
            $this->db->where('id_kerusakan =', $id);
        }
        $this->db->group_by("kerusakan.id_bahan");
        $this->db->order_by("kerusakan.id_kerusakan", "desc");
        return $this->db->get()->result();
    }

    public function get_kategori($id, $startdate, $enddate){
        $this->db->select("kategori.nama_kategori, sum(kerusakan.jumlah_kerusakan) as jumlah_kerusakan, sum(total_harga) as total_biaya");
        $this->db->from("tbl_kerusakan kerusakan");
        $this->db->join("tbl_kategori kategori", "kategori.id_kategori = kerusakan.id_kategori", "LEFT");
        if($startdate!=""){
            $this->db->where('DATE(kerusakan.created_date) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(kerusakan.created_date) <=', date('Y-m-d',strtotime($enddate)));
        }
        if($id!=""){
            $this->db->where('id_kerusakan =', $id);
        }
        $this->db->group_by("kerusakan.id_kategori");
        $this->db->order_by("kerusakan.id_kerusakan", "desc");
        return $this->db->get()->result();
    }

    public function get_user(){
        $this->db->select("user.id_user, user.full_name, role.name_role ");
        $this->db->from("tbl_user user");
        $this->db->join("tbl_role role", "role.id_role=user.id_role", "LEFT");
        $this->db->where("role.name_role !=", "USER");
        $this->db->order_by("user.id_user", "desc");
        return $this->db->get()->result_array();
    }
    public function get_user_produksi($id_user, $startdate, $enddate){
        $hasil=$this->db->query(" SELECT COUNT(*) as jumlah_orderan FROM ( SELECT COUNT(no_pesanan) FROM tbl_order where id_user = '$id_user' AND status_pesanan != 'Batal' AND DATE(waktu_dibuat) >= '$startdate' AND DATE(waktu_dibuat) <= '$enddate' GROUP BY no_pesanan ) produksi");
        return $hasil->result_array();
    }
    public function get_user_non_produksi($id_user, $startdate, $enddate){

        $hasil=$this->db->query(" SELECT COUNT(*) as jumlah_orderan_packing FROM ( SELECT COUNT(no_pesanan) FROM tbl_order where id_user_packing = '$id_user' AND status_pesanan != 'Batal' AND DATE(waktu_dibuat) >= '$startdate' AND DATE(waktu_dibuat) <= '$enddate' GROUP BY no_pesanan ) produksi");
        return $hasil->result_array();
    }

    public function get_total_kerusakan_bahan($startdate, $enddate){
        $this->db->select("sum(kerusakan.total_harga) as total");
        $this->db->from("tbl_kerusakan kerusakan");
        if($startdate!=""){
            $this->db->where('DATE(kerusakan.created_date) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(kerusakan.created_date) <=', date('Y-m-d',strtotime($enddate)));
        }
        $this->db->order_by("kerusakan.id_kerusakan", "DESC");
        return $this->db->get()->result_array();
    }

    public function get_total_pemasukan_bahan($startdate, $enddate){
        $this->db->select("sum(pemasukan.harga_total) as total");
        $this->db->from("tbl_pemasukan_bahan pemasukan");
        if($startdate!=""){
            $this->db->where('DATE(pemasukan.tanggal_beli) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(pemasukan.tanggal_beli) <=', date('Y-m-d',strtotime($enddate)));
        }
        $this->db->order_by("pemasukan.id_pemasukan_bahan", "DESC");
        return $this->db->get()->result_array();
    }

    public function get_total_ongkir_kirim($startdate, $enddate){ 
        $this->db->select("DISTINCT(order.no_pesanan), order.perkiraan_ongkir as total"); 
        $this->db->from("tbl_order order"); 
        if($startdate!=""){ 
            $this->db->where('DATE(order.waktu_dibuat) >=', date('Y-m-d',strtotime($startdate))); 
        } 
        if($enddate!=""){ 
            $this->db->where('DATE(order.waktu_dibuat) <=', date('Y-m-d',strtotime($enddate))); 
        } 
        $this->db->where('status_pesanan !=', "Batal"); 
        $this->db->order_by("order.id_orderan", "DESC"); 
        // return $this->db->get()->result_array();
        $list_ongkir = $this->db->get()->result_array(); 
        $total[0]['total'] = array_sum(array_column($list_ongkir, 'total')); 
        return $total; 
    } 

    // public function get_total_ongkir_kirim($startdate, $enddate){
    //     $this->db->select("sum(order.ongkir_pembeli) as total");
    //     $this->db->from("tbl_order order");
    //     if($startdate!=""){
    //         $this->db->where('DATE(order.waktu_dibuat) >=', date('Y-m-d',strtotime($startdate)));
    //     }
    //     if($enddate!=""){
    //         $this->db->where('DATE(order.waktu_dibuat) <=', date('Y-m-d',strtotime($enddate)));
    //     }
    //     $this->db->order_by("order.id_orderan", "DESC");
    //     return $this->db->get()->result_array();
    // }

     public function get_total_harga_barang($startdate, $enddate){ 
        $this->db->select("sum(order.total_harga) as total"); 
        $this->db->from("tbl_order order"); 
        if($startdate!=""){ 
            $this->db->where('DATE(order.waktu_dibuat) >=', date('Y-m-d',strtotime($startdate))); 
        } 
        if($enddate!=""){ 
            $this->db->where('DATE(order.waktu_dibuat) <=', date('Y-m-d',strtotime($enddate))); 
        } 
        $this->db->where('status_pesanan !=', "Batal"); 
        $this->db->order_by("order.id_orderan", "DESC"); 
        return $this->db->get()->result_array(); 
    }
    
    // public function get_total_harga_barang($startdate, $enddate){
    //     $this->db->select("sum(order.total_harga) as total");
    //     $this->db->from("tbl_order order");
    //     if($startdate!=""){
    //         $this->db->where('DATE(order.waktu_dibuat) >=', date('Y-m-d',strtotime($startdate)));
    //     }
    //     if($enddate!=""){
    //         $this->db->where('DATE(order.waktu_dibuat) <=', date('Y-m-d',strtotime($enddate)));
    //     }
    //     $this->db->order_by("order.id_orderan", "DESC");
    //     return $this->db->get()->result_array();
    // }

    public function get_total_pemakaian_bahan($startdate, $enddate){
        $this->db->select("sum(pengeluaran.jumlah_bahan * bahan.harga_kertas) as total");
        $this->db->from("tbl_pengeluaran_bahan pengeluaran");
        $this->db->join("tbl_bahan bahan", "bahan.id_bahan=pengeluaran.id_bahan", "LEFT");
        if($startdate!=""){
            $this->db->where('DATE(pengeluaran.created_date) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(pengeluaran.created_date) <=', date('Y-m-d',strtotime($enddate)));
        }
        $this->db->order_by("pengeluaran.id_pengeluaran_bahan", "DESC");
        return $this->db->get()->result_array();
    }

    public function get_total_biaya_operasional($startdate, $enddate){
        $this->db->select("sum(biaya.total_biaya) as total");
        $this->db->from("tbl_biaya_operasional biaya");
        if($startdate!=""){
            $this->db->where('DATE(biaya.tanggal) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(biaya.tanggal) <=', date('Y-m-d',strtotime($enddate)));
        }
        $this->db->order_by("biaya.id_biaya", "DESC");
        return $this->db->get()->result_array();
    }

    public function get_total_pemasukan($startdate, $enddate){
        $this->db->select("sum(pemasukan.total_pemasukan) as total");
        $this->db->from("tbl_pemasukan pemasukan");
        if($startdate!=""){
            $this->db->where('DATE(pemasukan.created_date) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(pemasukan.created_date) <=', date('Y-m-d',strtotime($enddate)));
        }
        $this->db->order_by("pemasukan.id_pemasukan", "DESC");
        return $this->db->get()->result_array();
    }

    public function get_pemasukan_bahan($startdate, $enddate){
        $this->db->select("pemasukan.*, bahan.jenis_bahan, sum(pemasukan.jumlah) as jumlah, sum(pemasukan.harga_total) as harga_total");
        $this->db->from("tbl_pemasukan_bahan pemasukan");
        $this->db->join("tbl_bahan bahan", "bahan.id_bahan=pemasukan.id_bahan", "LEFT");
        if($startdate!=""){
            $this->db->where('DATE(pemasukan.created_date) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(pemasukan.created_date) <=', date('Y-m-d',strtotime($enddate)));
        }
        $this->db->group_by("pemasukan.id_bahan");
        $this->db->order_by("pemasukan.id_bahan", "DESC");
        return $this->db->get()->result_array();
    }

    public function get_pemakaian_bahan($startdate, $enddate){
        $this->db->select("pengeluaran.*, bahan.jenis_bahan, bahan.harga_cetak, bahan.harga_kertas, sum(pengeluaran.jumlah_bahan) as jumlah, sum(pengeluaran.jumlah_bahan * bahan.harga_kertas) as total_harga");
        $this->db->from("tbl_pengeluaran_bahan pengeluaran");
        $this->db->join("tbl_bahan bahan", "bahan.id_bahan=pengeluaran.id_bahan", "LEFT");
        if($startdate!=""){
            $this->db->where('DATE(pengeluaran.created_date) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(pengeluaran.created_date) <=', date('Y-m-d',strtotime($enddate)));
        }
        $this->db->group_by("pengeluaran.id_bahan");
        // $this->db->group_by("pengeluaran.no_pesanan");
        $this->db->order_by("pengeluaran.id_bahan", "DESC");
        return $this->db->get()->result_array();
    }

    public function get_pengeluaran(){
        $this->db->select("pengeluaran.no_pesanan");
        $this->db->from("tbl_pengeluaran_bahan pengeluaran");
        $this->db->group_by("pengeluaran.no_pesanan");
        $this->db->order_by("pengeluaran.id_pengeluaran_bahan", "desc");
        return $this->db->get()->result_array();
    }

    public function get_no_pesanan($no_pesanan){
        $this->db->select("order.no_pesanan, order.status_pesanan");
        $this->db->from("tbl_order order");
        $this->db->where("order.no_pesanan !=", $no_pesanan);
        $this->db->where("order.status_pesanan ", "Selesai");
        $this->db->group_by("order.no_pesanan");
        $this->db->order_by("order.id_orderan", "desc");
        // return $this->db->get()->result_array();
        $data = $this->db->get();
        if($data->num_rows() > 0){

                return $data->result_array();

            } else {

                return false;

            }
    }



    public function get_orderan_kerusakan($startdate, $enddate){
        $this->db->select("kerusakan.no_pesanan, sum(kerusakan.total_harga) as total_harga");
        $this->db->from("tbl_kerusakan kerusakan");
        if($startdate!=""){
            $this->db->where('DATE(kerusakan.created_date) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(kerusakan.created_date) <=', date('Y-m-d',strtotime($enddate)));
        }
        $this->db->group_by("kerusakan.no_pesanan");
        $this->db->order_by("kerusakan.id_kerusakan", "desc");
        return $this->db->get()->result();
    }

    // public function get_durasi_kerja($user, $startdate, $enddate){
    //     $this->db->select("absensi.tanggal_masuk, sum(timediff(absensi.tanggal_keluar, absensi.tanggal_masuk)) as durasi_kerja");
    //     $this->db->from("tbl_absensi absensi");
    //     if($startdate!=""){
    //         $this->db->where('DATE(absensi.tanggal_masuk) >=', date('Y-m-d',strtotime($startdate)));
    //     }
    //     if($enddate!=""){
    //         $this->db->where('DATE(absensi.tanggal_masuk) <=', date('Y-m-d',strtotime($enddate)));
    //     }
    //     $this->db->where("absensi.id_user", $user);
    //     $this->db->order_by("absensi.id_absensi", "asc");
    //     return $this->db->get()->result_array();
    // }

    public function get_cuti($user, $startdate, $enddate){
        $this->db->select("sum(TIMESTAMPDIFF(DAY,cuti.tanggal_mulai_cuti,cuti.tanggal_akhir_cuti)+1) as cuti");
        $this->db->from("tbl_cuti cuti");
        if($startdate!=""){
            $this->db->where('DATE(cuti.created_date) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(cuti.created_date) <=', date('Y-m-d',strtotime($enddate)));
        }
        $this->db->where("cuti.id_user", $user);
        $this->db->where("cuti.id_jenis_cuti", "1");
        $this->db->order_by("cuti.id_cuti", "asc");
        return $this->db->get()->result();
    }

    public function get_durasi_kerja($user, $startdate, $enddate){
        $this->db->select("SEC_TO_TIME(SUM(time_to_sec(timediff(absensi.tanggal_keluar, absensi.tanggal_masuk)))) as durasi_kerja");
        $this->db->from("tbl_absensi absensi");
        if($startdate!=""){
            $this->db->where('DATE(absensi.tanggal_masuk) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(absensi.tanggal_masuk) <=', date('Y-m-d',strtotime($enddate)));
        }
        $this->db->where("absensi.id_user", $user);
        $this->db->order_by("absensi.id_absensi", "asc");
        return $this->db->get()->result();
    }

    public function get_total_hari_kerja($user, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as total_hari_kerja FROM ( SELECT COUNT(id_absensi) FROM tbl_absensi WHERE DATE(tanggal_masuk) >= '$startdate' AND DATE(tanggal_masuk) <= '$enddate' AND `id_user` = '$user' GROUP BY DATE(tanggal_masuk) ORDER BY `id_absensi` DESC ) hari_kerja");
        return $hasil->result();
    }

    public function get_total_edit_absen($user, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as total_edit_absen FROM ( SELECT COUNT(id_absensi) FROM tbl_absensi WHERE DATE(tanggal_masuk) >= '$startdate' AND DATE(tanggal_masuk) <= '$enddate' AND `id_user` = '$user' AND `edit_by` = '1' GROUP BY DATE(tanggal_masuk) ORDER BY `id_absensi` DESC ) edit_absen");
        return $hasil->result();
    }

    public function get_total_telat($user, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as total_telat FROM ( SELECT COUNT(id_absensi) FROM tbl_absensi WHERE DATE(tanggal_masuk) >= '$startdate' AND DATE(tanggal_masuk) <= '$enddate' AND `id_user` = '$user' AND `status_jadwal` = 'Telat' GROUP BY DATE(tanggal_masuk) ORDER BY `id_absensi` DESC ) telat");
        return $hasil->result();
    }

    public function get_total_on_time($user, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as total_on_time FROM ( SELECT COUNT(id_absensi) FROM tbl_absensi WHERE DATE(tanggal_masuk) >= '$startdate' AND DATE(tanggal_masuk) <= '$enddate' AND `id_user` = '$user' AND `status_jadwal` = 'On Time' GROUP BY DATE(tanggal_masuk) ORDER BY `id_absensi` DESC ) on_time");
        return $hasil->result();
    }

    public function get_jumlah_proses($user, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as jumlah_proses FROM ( SELECT COUNT(no_pesanan) FROM tbl_order  where id_user = '$user' AND status_pesanan != 'Batal' AND DATE(tanggal_dikerjakan) >= '$startdate' AND DATE(tanggal_dikerjakan) <= '$enddate' GROUP BY no_pesanan ) proses");
        return $hasil->result();
    }

    public function get_jumlah_cetak($user, $startdate, $enddate){
        $hasil=$this->db->query("SELECT COUNT(*) as jumlah_cetak FROM ( SELECT COUNT(no_pesanan) FROM tbl_order  where id_user_cetak = '$user' AND status_pesanan != 'Batal' AND DATE(tanggal_antri_cetak) >= '$startdate' AND DATE(tanggal_antri_cetak) <= '$enddate' GROUP BY no_pesanan ) cetak");
        return $hasil->result();
    }

    public function get_jumlah_task($user, $startdate, $enddate){
        $this->db->select("count(task.id_task) as jumlah_task");
        $this->db->from("tbl_task task");
        if($startdate!=""){
            $this->db->where('DATE(task.tanggal_task) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(task.tanggal_task) <=', date('Y-m-d',strtotime($enddate)));
        }
        if($user!=""){
            $this->db->where('task.id_user =', $user);
        }
        $this->db->where('task.status_task', "COMPLETE");
        $this->db->order_by("task.id_task", "desc");
        return $this->db->get()->result();
    }

    public function get_absensi_report($startdate, $enddate, $user){
        $this->db->select("absensi.*, timediff(absensi.tanggal_keluar, absensi.tanggal_masuk) as durasi_kerja");
        $this->db->from("tbl_absensi absensi");
        if($startdate!=""){
            $this->db->where('DATE(absensi.tanggal_masuk) >=', date('Y-m-d',strtotime($startdate)));
        }
        if($enddate!=""){
            $this->db->where('DATE(absensi.tanggal_masuk) <=', date('Y-m-d',strtotime($enddate)));
        }
        $this->db->where('absensi.id_user =', $user);
        $this->db->order_by("absensi.id_absensi", "asc");
        return $this->db->get()->result_array();
    }

    public function get_telat_karyawan($tanggal_masuk, $id_user){
        $this->db->select("count(tanggal_masuk) as jumlah_telat");
        $this->db->from("tbl_absensi absensi");
        $this->db->where('DATE(absensi.tanggal_masuk)', date('Y-m-d',strtotime($tanggal_masuk)));
        $this->db->where('absensi.id_user =', $id_user);
        $this->db->where('absensi.status_jadwal =', "Telat");
        $this->db->group_by("absensi.tanggal_masuk");
        $this->db->order_by("absensi.id_absensi", "asc");
        return $this->db->get()->result_array();
    }

    public function get_ontime_karyawan($tanggal_masuk, $id_user){
        $this->db->select("count(tanggal_masuk) as jumlah_ontime");
        $this->db->from("tbl_absensi absensi");
        $this->db->where('DATE(absensi.tanggal_masuk)', date('Y-m-d',strtotime($tanggal_masuk)));
        $this->db->where('absensi.id_user =', $id_user);
        $this->db->where('absensi.status_jadwal =', "On Time");
        $this->db->group_by("absensi.tanggal_masuk");
        $this->db->order_by("absensi.id_absensi", "asc");
        return $this->db->get()->result_array();
    }

    public function get_dikerjakan_karyawan($tanggal_masuk, $id_user){
        $hasil=$this->db->query(" SELECT COUNT(*) as jumlah_dikerjakan FROM ( SELECT COUNT(no_pesanan) FROM tbl_order where id_user = '$id_user' AND status_pesanan != 'Batal' AND DATE(tanggal_dikerjakan)= '$tanggal_masuk' GROUP BY no_pesanan ) dikerjakan");
        return $hasil->result_array();
    }

    public function get_cetak_karyawan($tanggal_masuk, $id_user){
        $hasil=$this->db->query(" SELECT COUNT(*) as jumlah_cetak FROM ( SELECT COUNT(no_pesanan) FROM tbl_order where id_user = '$id_user' AND status_pesanan != 'Batal' AND DATE(tanggal_antri_cetak)= '$tanggal_masuk' GROUP BY no_pesanan ) cetak");
        return $hasil->result_array();
    }

    public function get_orderan_karyawan($tanggal_masuk){
        $hasil=$this->db->query(" SELECT COUNT(*) as jumlah_orderan FROM ( SELECT COUNT(no_pesanan) FROM tbl_order where status_pesanan != 'Batal' AND DATE(waktu_dibuat)= '$tanggal_masuk' GROUP BY no_pesanan ) orderan");
        return $hasil->result_array();
    }

    public function get_task_karyawan($tanggal_masuk, $user){
        $this->db->select("count(task.id_task) as jumlah_task");
        $this->db->from("tbl_task task");
        if($tanggal_masuk!=""){
            $this->db->where('DATE(task.tanggal_task)', date('Y-m-d',strtotime($tanggal_masuk)));
        }
        $this->db->where("task.id_user", $user);
        $this->db->order_by("task.id_task", "desc");
        return $this->db->get()->result_array();
    }
    // SELECT COUNT(*)
    // FROM
    // (
    //     SELECT COUNT(no_pesanan)
    //     FROM tbl_order 
    //     where status_pesanan = 'Selesai' AND DATE(waktu_dibuat) >= '2021-10-02' AND DATE(waktu_dibuat) <= '2021-11-02'
    //     GROUP BY no_pesanan
    // ) selesai
}

