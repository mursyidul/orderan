    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to <?php echo $this->config->item('site_name'); ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/bintang.png') ?>" />
    <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/font-awesome.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/animate.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/datepicker/datepicker3.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/ico.png" />
    <!-- Mainly scripts -->
    <script src="<?php echo base_url('assets/js/jquery-2.1.1.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/metisMenu/jquery.metisMenu.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url('assets/js/inspinia.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/pace/pace.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/morris.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/morris.js');?>"></script>
    <script src="<?php echo base_url('assets/js/raphael-min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/rickshaw/vendor/d3.v3.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/rickshaw/rickshaw.min.js');?>"></script>

    <!-- cek editor -->
    <link href="<?php echo base_url('assets/css/summernote.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/summernote-bs3.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/js/summernote.min.js');?>"></script>

    <!-- Notifikasi -->
    <link href="<?php echo base_url('assets/css/plugins/toastr/toastr.min.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/js/plugins/toastr/toastr.min.js');?>"></script>

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="<?= base_url('assets/sweetalert/sweetalert.css'); ?>">
    <script src="<?php echo base_url('assets/sweetalert/sweetalert.min.js') ?>"></script>

    <!-- webcamb -->

    <script src="<?php echo base_url('assets/js/webcam.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/webcam.js');?>"></script>

    <!-- sokcet.io -->
    <!-- <script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script> -->
    <!-- Datatables -->
    <link href="<?php echo base_url('assets/js/morris.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/dataTables/datatables.min.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/js/plugins/dataTables/datatables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/dataTables/dataTables.fixedColumns.min.js') ?>"></script>

    <!-- Highchart -->
    <!-- <script src="<?php echo base_url('assets/Highcharts-7.1.1/code/highcharts.js');?>"></script> -->
    
    <!-- Datepicker -->
    <script src="<?php echo base_url('assets/js/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
    <link href="<?php echo base_url('assets/css/plugins/clockpicker/clockpicker.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/js/plugins/clockpicker/clockpicker.js') ?>"></script>

    <!-- Select2 -->
    <link href="<?php echo base_url('assets/css/plugins/select2/select2.min.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/js/plugins/select2/select2.full.min.js') ?>"></script>

    <!-- Icheck -->
    <link href="<?php echo base_url('assets/css/plugins/iCheck/custom.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/js/plugins/iCheck/icheck.min.js') ?>"></script>
  <!--   <script src="<?php echo base_url('assets/jquery-ui/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/jquery-ui/jquery-ui.min.css') ?>"></script> -->


    <!-- Progress Wizard -->
    <link href="<?php echo base_url('assets/css/progress-wizard.min.css') ?>" rel="stylesheet">

    <!-- fullcalender -->
    <link href="<?php echo base_url('assets/css/plugins/fullcalendar/fullcalendar.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/fullcalendar/fullcalendar.print.css') ?>" rel="stylesheet"  media="print">
    <script src="<?php echo base_url('assets/js/plugins/fullcalendar/moment.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/fullcalendar/fullcalendar.min.js') ?>"></script>

    <!-- Input Mask-->
    <!-- <script src="<?php echo base_url('assets/js/plugins/Inputmask-2.x/dist/jquery.inputmask.bundle.min.js') ?>"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
</head>
<body class="">
    <div id="wrapper" style="background: linear-gradient(to right, #627699 0%, #0323ec 100%);">
    <nav class="navbar-default navbar-static-side" role="navigation" >
        <div class="sidebar-collapse" >
            <ul class="nav metismenu" id="side-menu" >
                <li class="nav-header" style="background: linear-gradient(to right, #627699 0%, #0e347c 100%);">
                    <div class="dropdown profile-element"><span><center>
                            <img alt="image" class="img-circle" src="<?php echo base_url('assets/images/avatar.png')?>" />
                             </span></center> 
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <center><strong class="font-bold"><?php echo $this->session->userdata("nama_user"); ?></strong></center>
                            </span> <center><span class="text-muted text-xs block"><?php echo strtoupper($this->session->userdata("full_name")); ?></span></center> 
                            <?php if ($this->session->userdata("role") != "ADMIN") { ?>
                                <center>
                                    <span class="text-muted text-xs block">
                                        <b class="caret"></b>
                                    </span>
                                </center>
                            <?php } ?>

                            </span> 
                        </a>
                        <?php if ($this->session->userdata("role") != "ADMIN") { ?>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="<?php echo base_url("profile"); ?>">Setting</a></li>
                            </ul>
                        <?php } ?>
                    </div>
                    <div class="logo-element">
                        ORDER
                    </div>
                </li>
                <?php if($this->session->userdata('role') == 'ADMIN'){ ?>
                <?php $menu = $this->uri->segment('1'); $submenu = $this->uri->segment('2');?>
                <li <?php if($menu == "dashboard"){ echo "class='active'";} ?>>
                    <a href="<?php echo base_url("dashboard"); ?>"><i class="fa fa-th-large" style="width: 15px;"></i><span class="nav-label">Dashboard</span></a>
                </li>
                
                <li <?php if($menu == "biaya_operasional" || $menu == "pemasukan" || $menu == "report"){ echo "class='active'"; } ?>>
                    <a href="#"><i class="fa fa-money" style="width: 15px;" ></i><span class="nav-label">Keuangan</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li <?php if($menu == "biaya_operasional"){ echo "class='active'";} ?>><a href="<?php echo base_url('biaya_operasional') ?>"> Biaya Operasional</a></li>
                        <li <?php if($menu == "report"){ echo "class='active'";} ?>><a href="<?php echo base_url('report') ?>"> Laporan</a></li>
                        <li <?php if($menu == "pemasukan"){ echo "class='active'";} ?>><a href="<?php echo base_url('pemasukan') ?>"> Pemasukan</a></li>
                    </ul>
                </li>
                
                <li <?php if($menu == "bahan" || $menu == "kerusakan" || $menu == "pemasukan_bahan"|| $menu == "stock"){ echo "class='active'"; } ?>>
                    <a href="#"><i class="fa fa-cubes" style="width: 15px;" ></i><span class="nav-label">Manajemen Bahan</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li <?php if($menu == "bahan"){ echo "class='active'";} ?>><a href="<?php echo base_url('bahan') ?>"> Bahan</a></li>
                        <li <?php if($menu == "kerusakan"){ echo "class='active'";} ?>><a href="<?php echo base_url('kerusakan') ?>"> Kerusakan</a></li>
                        <li <?php if($menu == "pemasukan_bahan"){ echo "class='active'";} ?>><a href="<?php echo base_url('pemasukan_bahan') ?>"> Pembelian Bahan</a></li>
                        <li <?php if($menu == "stock"){ echo "class='active'";} ?>><a href="<?php echo base_url('stock') ?>"> Stok</a></li>
                    </ul>
                </li>

                <li <?php if($menu == "history_upload" ||$menu == "art_paper" || $menu == "tukar_point" || $menu == "kategori" || $menu == "roll_e" || $menu == "supplier" || $menu == "product" || $menu == "kategori_operasional" || $menu == "product" || $menu == "customer" || $menu == "variasi" || $menu == "opsi_pembayaran"){ echo "class='active'"; } ?>>

                    <a href="#"><i class="fa fa-database" style="width: 15px;"></i><span class="nav-label">Manajemen Data</span><span class="fa arrow"></span></a>

                    <ul class="nav nav-second-level">
                        <li <?php if($menu == "customer"){ echo "class='active'";} ?>><a href="<?php echo base_url('customer') ?>"> Customer</a></li>
                        <li <?php if($menu == "history_upload"){ echo "class='active'";} ?>><a href="<?php echo base_url('history_upload') ?>"> History Upload</a></li>
                        <li <?php if($menu == "kategori"){ echo "class='active'";} ?>><a href="<?php echo base_url('kategori') ?>"> Kategori Kerusakan</a></li>
                        <li <?php if($menu == "kategori_operasional"){ echo "class='active'";} ?>><a href="<?php echo base_url('kategori_operasional') ?>"> Kategori Operasional</a></li>
                        <li <?php if($menu == "opsi_pembayaran"){ echo "class='active'";} ?>><a href="<?php echo base_url('opsi_pembayaran') ?>"> Opsi Pembayaran</a></li>
                        <li <?php if($menu == "product"){ echo "class='active'";} ?>><a href="<?php echo base_url('product') ?>"> Produk</a></li>
                        <li <?php if($menu == "tukar_point"){ echo "class='active'";} ?>><a href="<?php echo base_url('tukar_point') ?>"> Reward Point</a></li>
                        <li <?php if($menu == "supplier"){ echo "class='active'";} ?>><a href="<?php echo base_url('supplier') ?>"> Supplier</a></li>
                        <li <?php if($menu == "variasi"){ echo "class='active'";} ?>><a href="<?php echo base_url('variasi') ?>"> Variasi</a></li>
                    </ul>
                </li>
                
                <li <?php if($menu == "absensi" || $menu == "cuti" || $menu == "durasi_peruser" || $menu == "schedule" || $menu == "user" || $menu == "shift" || $menu == "task" || $menu == "laporan_karyawan"){ echo "class='active'"; } ?>>
                    <a href="#"><i class="fa fa-calendar" style="width: 15px;" ></i><span class="nav-label">Manajemen Karyawan</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li <?php if($menu == "absensi"){ echo "class='active'";} ?>><a href="<?php echo base_url('absensi') ?>"> Absensi</a></li>
                        <li <?php if($menu == "cuti"){ echo "class='active'";} ?>><a href="<?php echo base_url('cuti') ?>"> Cuti</a></li>
                        <li <?php if($menu == "durasi_peruser"){ echo "class='active'";} ?>><a href="<?php echo base_url('durasi_peruser') ?>"> Durasi Kerja</a></li>
                        <li <?php if($menu == "user"){ echo "class='active'";} ?>><a href="<?php echo base_url('user') ?>"> Karyawan</a></li>
                        <li <?php if($menu == "schedule"){ echo "class='active'";} ?>><a href="<?php echo base_url('schedule') ?>"> Schedule</a></li>
                        <li <?php if($menu == "shift"){ echo "class='active'";} ?>><a href="<?php echo base_url('shift') ?>"> Shift</a></li>
                        <li <?php if($menu == "task"){ echo "class='active'";} ?>><a href="<?php echo base_url('task') ?>"> Task</a></li>
                    </ul>
                </li>


                <li <?php if($menu == "upload_orderan" || $menu == "orderan_siap" || $menu == "orderan_selesai" || $menu == "orderan_batal" || $menu == "orderan_sedang"){ echo "class='active'"; } ?>>

                    <a href="#"><i class="fa fa-shopping-cart" style="width: 15px;"></i><span class="nav-label">Manajemen Orderan</span><span class="fa arrow"></span></a>

                    <ul class="nav nav-second-level">

                        <li <?php if($menu == "upload_orderan"){ echo "class='active'";} ?>><a href="<?php echo base_url('upload_orderan') ?>"> Perlu Dikirim</a></li>

                        <li <?php if($menu == "orderan_siap"){ echo "class='active'";} ?>><a href="<?php echo base_url('orderan_siap') ?>"> Siap Kirim</a></li>

                        <li <?php if($menu == "orderan_sedang"){ echo "class='active'";} ?>><a href="<?php echo base_url('orderan_sedang') ?>"> Sedang Dikirim</a></li>

                        <li <?php if($menu == "orderan_selesai"){ echo "class='active'";} ?>><a href="<?php echo base_url('orderan_selesai') ?>"> Selesai</a></li>

                        <li <?php if($menu == "orderan_batal"){ echo "class='active'";} ?>><a href="<?php echo base_url('orderan_batal') ?>"> Batal</a></li>

                    </ul>

                </li>

                <li <?php if($menu == "point" || $menu == "setting_point" || $menu == "syarat_ketentuan" || $menu == "komplain"){ echo "class='active'"; } ?>>
                    <a href="#"><i class="fa fa-cogs" style="width: 15px;" ></i><span class="nav-label">Manajemen Customer</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li <?php if($menu == "komplain"){ echo "class='active'";} ?>><a href="<?php echo base_url('komplain') ?>"> Komplain</a></li>
                        <li <?php if($menu == "point"){ echo "class='active'";} ?>><a href="<?php echo base_url('point') ?>"> Poin</a></li>
                        <li <?php if($menu == "setting_point"){ echo "class='active'";} ?>><a href="<?php echo base_url('setting_point') ?>"> Pengaturan Poin</a></li>
                        <li <?php if($menu == "syarat_ketentuan"){ echo "class='active'";} ?>><a href="<?php echo base_url('syarat_ketentuan') ?>"> Syarat & Ketentuan</a></li>
                    </ul>
                </li>
                <?php } else if($this->session->userdata('role') == 'USER'){ ?>
                <?php $menu = $this->uri->segment('1'); $submenu = $this->uri->segment('2');?>
                <li <?php if($menu == "dashboard"){ echo "class='active'";} ?>>
                    <a href="<?php echo base_url("dashboard"); ?>"><i class="fa fa-th-large" style="width: 15px;"></i><span class="nav-label">Dashboard</span></a>
                </li> 

                <li <?php if($menu == "tukar_hadiah"){ echo "class='active'";} ?>><a href="<?php echo base_url("tukar_hadiah"); ?>"><i class="fa fa-gift" style="width: 15px;"></i><span class="nav-label">Tukar Hadiah</span></a>

                </li><?php } else if($this->session->userdata('role') == 'DESAIN'){ ?><?php $menu = $this->uri->segment('1'); $submenu = $this->uri->segment('2');?>
                    <li <?php if($menu == "dashboard"){ echo "class='active'";} ?>>
                        <a href="<?php echo base_url("dashboard"); ?>"><i class="fa fa-th-large" style="width: 15px;"></i><span class="nav-label">Dashboard</span></a>
                    </li>
                    <li <?php if($menu == "komplain"){ echo "class='active'";} ?>><a href="<?php echo base_url("komplain"); ?>"><i class="fa fa-bullhorn" style="width: 15px;"></i><span class="nav-label">Komplain</span></a>
                    </li>

                    <li <?php if($menu == "absensi" || $menu == "cuti" || $menu == "durasi_peruser" || $menu == "schedule" || $menu == "user" || $menu == "shift" || $menu == "task" || $menu == "report"){ echo "class='active'"; } ?>>
                        <a href="#"><i class="fa fa-calendar" style="width: 15px;" ></i><span class="nav-label">Manajemen Karyawan</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li <?php if($menu == "absensi"){ echo "class='active'";} ?>><a href="<?php echo base_url('absensi') ?>"> Absensi</a></li>
                            <li <?php if($menu == "cuti"){ echo "class='active'";} ?>><a href="<?php echo base_url('cuti') ?>"> Cuti</a></li>
                            <li <?php if($menu == "schedule"){ echo "class='active'";} ?>><a href="<?php echo base_url('schedule') ?>"> Schedule</a></li>
                            <li <?php if($menu == "report"){ echo "class='active'";} ?>><a href="<?php echo base_url('report') ?>"> Report</a></li>
                            <li <?php if($menu == "task"){ echo "class='active'";} ?>><a href="<?php echo base_url('task') ?>"> Task</a></li>
                        </ul>
                    </li>

                    <li <?php if($menu == "upload_orderan" || $menu == "orderan_siap" || $menu == "orderan_selesai" || $menu == "orderan_batal" || $menu == "transaksi" || $menu == "orderan_sedang"){ echo "class='active'"; } ?>>

                        <a href="#"><i class="fa fa-shopping-cart" style="width: 15px;"></i><span class="nav-label">Orderan</span><span class="fa arrow"></span></a>

                        <ul class="nav nav-second-level">

                            <li <?php if($menu == "transaksi"){ echo "class='active'";} ?>><a href="<?php echo base_url('transaksi/list_transaksi') ?>">List Transaksi</a></li>

                            <li <?php if($menu == "upload_orderan"){ echo "class='active'";} ?>><a href="<?php echo base_url('upload_orderan') ?>"> Perlu Dikirim</a></li>

                            <li <?php if($menu == "orderan_siap"){ echo "class='active'";} ?>><a href="<?php echo base_url('orderan_siap') ?>"> Siap Kirim</a></li>

                            <li <?php if($menu == "orderan_sedang"){ echo "class='active'";} ?>><a href="<?php echo base_url('orderan_sedang') ?>"> Sedang Dikirim</a></li>

                            <li <?php if($menu == "orderan_selesai"){ echo "class='active'";} ?>><a href="<?php echo base_url('orderan_selesai') ?>"> Selesai</a></li>

                            <li <?php if($menu == "orderan_batal"){ echo "class='active'";} ?>><a href="<?php echo base_url('orderan_batal') ?>"> Batal</a></li>
                        </ul>

                    </li>
                <?php } else if($this->session->userdata('role') == 'PRODUKSI'){ ?><?php $menu = $this->uri->segment('1'); $submenu = $this->uri->segment('2');?>
                    <li <?php if($menu == "dashboard"){ echo "class='active'";} ?>>
                        <a href="<?php echo base_url("dashboard"); ?>"><i class="fa fa-th-large" style="width: 15px;"></i><span class="nav-label">Dashboard</span></a>
                    </li>
                    
                    <li <?php if($menu == "cuti"){ echo "class='active'";} ?>><a href="<?php echo base_url("cuti"); ?>"><i class="fa fa-cut" style="width: 15px;"></i><span class="nav-label">Cuti</span></a>
                    </li>
                    <li <?php if($menu == "upload_orderan" || $menu == "orderan_siap" || $menu == "orderan_selesai" || $menu == "orderan_batal" || $menu == "orderan_sedang"){ echo "class='active'"; } ?>>

                    <a href="#"><i class="fa fa-shopping-cart" style="width: 15px;" ></i><span class="nav-label">Orderan</span><span class="fa arrow"></span></a>

                    <ul class="nav nav-second-level">

                        <!-- <li <?php if($menu == "upload_orderan"){ echo "class='active'";} ?>><a href="<?php echo base_url('upload_orderan') ?>"> List Orderan</a></li> -->

                        <li <?php if($menu == "orderan_siap"){ echo "class='active'";} ?>><a href="<?php echo base_url('orderan_siap') ?>"> Orderan Siap Kirim</a></li>

                        <li <?php if($menu == "orderan_sedang"){ echo "class='active'";} ?>><a href="<?php echo base_url('orderan_sedang') ?>"> Orderan Sedang Dikirim</a></li>

                        <li <?php if($menu == "orderan_selesai"){ echo "class='active'";} ?>><a href="<?php echo base_url('orderan_selesai') ?>"> Orderan Selesai</a></li>

                        <li <?php if($menu == "orderan_batal"){ echo "class='active'";} ?>><a href="<?php echo base_url('orderan_batal') ?>"> Orderan Batal</a></li>

                    </ul>

                </li>
                <?php } ?>
            </ul>
        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <!-- <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0;"> -->
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0;background: linear-gradient(to right, #627699 0%, #0e347c 100%);color:black;">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-success dim " href="#"><i class="fa fa-bars"></i> </a>
            <!-- <div>
                <center><h3>TATA RUANG DAN PERUMAHAN RAKYAT</h3></center>
            </div> -->
        </div>
            <!-- <ul>
                <div>
                    <center><h3>TATA RUANG DAN PERUMAHAN RAKYAT</h3></center>
                </div>
            </ul> -->
            <?php  
                $query   = $this->db->query("SELECT count(kategori) as jml_hrd FROM tbl_notifikasi WHERE is_seen ='0' AND ke LIKE '%".$this->session->userdata('id_user').",%'"); 
                $total_admin = $query->result_array(); 
            ?>
            <?php 
                $this->db->select('count(kategori) as jml_karyawan');
                $this->db->from('tbl_notifikasi');
                $this->db->where('is_seen', "0");
                $this->db->like('ke', $this->session->userdata('id_user'));
                $total_karyawan = $this->db->get()->row();
            ?>
            <!-- <?php echo $total_admin; ?> -->
            <ul class="nav navbar-top-links navbar-right">
                <?php if ($this->session->userdata('role') == 'USER') { ?>
                <li>
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="<?php echo base_url("#"); ?>">
                        <i class="fa fa-envelope"></i> <span class="label label-warning">16</span>
                    </a>
                </li>
                <?php } ?>
                <li>
                    <a class="dropdown-toggle count-info" href="<?php echo base_url("cuti") ?>">
                        <i class="fa fa-bell"></i>  
                        <span class="label label-primary">
                            <?php if($this->session->userdata("role") == "ADMIN"){ ?>
                                <?php echo $total_admin[0]['jml_hrd']; ?>
                            <?php } else if($this->session->userdata("role") != "ADMIN"){ ?>
                                <?php echo $total_karyawan->jml_karyawan; ?>
                            <?php } ?>    
                        </span>
                    </a>
                    <!-- <ul class="dropdown-menu dropdown-alerts"> -->
                        <!--<li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-cut fa-fw"></i> Pengajuan 16 messages
                                     <span class="pull-right text-muted small">4 minutes ago</span> 
                                </div>
                            </a>
                        </li>-->
                        <!--<li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                     <span class="pull-right text-muted small">12 minutes ago</span> 
                                </div>
                            </a>
                        </li>-->
                        <!--<li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                     <span class="pull-right text-muted small">4 minutes ago</span> 
                                </div>
                            </a>
                        </li>-->
                        <!-- <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li> -->
                    <!-- </ul> -->
                </li>

                <li>
                    <a href="<?php echo base_url("login/doLogout"); ?>">
                        <i class="fa fa-sign-out"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
        </div>
            <!-- content in here -->
            <?= $contents; ?>
            <!-- /content in here -->

            <div class="footer">
                <div class="pull-right">
                    <strong>Order Management &copy; <?php echo date('Y'); ?></strong>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
