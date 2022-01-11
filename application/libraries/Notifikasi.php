<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Notifikasi {
    public function config(){
    	$notifikasi = array();
        $notifikasi['submit_success'] = "Berhasil Menyimpan";
        $notifikasi['delete_title'] = "Anda yakin ingin menghapus data ini?";
        $notifikasi['delete_text'] = "Data tidak dapat dikembalikan!";
        $notifikasi['delete_confirmButtonText'] = "Ya, hapus!";
        $notifikasi['delete_cancelButtonText'] = "Tidak, batalkan!";
        $notifikasi['delete_success_title'] = "Berhasil Menghapus";
        return $notifikasi;
    }
}


