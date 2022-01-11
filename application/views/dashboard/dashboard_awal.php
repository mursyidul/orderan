<style type="text/css">
    
    .not-allowed{
     cursor: not-allowed! important;
       }
</style>
<?php if($this->session->flashdata('error')){ ?>   
    <div class="alert alert-danger hide-it">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Failed!</strong> <?php echo $this->session->flashdata('error'); ?>
    </div>    
<?php } ?>
<?php if($this->session->flashdata('success')){ ?>   
    <div class="alert alert-success hide-it">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
    </div>    
<?php } ?>
<?php if ($this->session->userdata("role") == "ADMIN") { ?>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <!-- fa fa-picture-o
            fa fa-suitcase   -->
            <div class="col-lg-3">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-check fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> SELESAI </span>
                            <h2 class="font-bold"><?php echo $selesai; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-cubes fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> PACKING </span>
                            <h2 class="font-bold"><?php echo $packing; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 yellow-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-print fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> ANTRI CETAK </span>
                            <h2 class="font-bold"><?php echo $antri_cetak; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 red-bg">
                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <i class="fa fa-exclamation-triangle fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> BATAL </span>
                                <h2 class="font-bold"><?php echo $batal; ?></h2>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- fa fa-picture-o
            fa fa-suitcase   -->
            
            <div class="col-lg-3">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-bullhorn fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> KOMPLAIN </span>
                            <h2 class="font-bold"><?php echo $komplain->jumlah_komplain; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 red-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-exclamation fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> TELAT </span>
                            <h2 class="font-bold"><?php echo $telat->jumlah_telat; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 yellow-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-calendar fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>TOTAL CUTI</span>
                            <h2 class="font-bold"><?php echo $cuti->jumlah_cuti; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 red-bg">
                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <i class="fa fa-times fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> SALAH ABSEN </span>
                                <h2 class="font-bold"><?php echo $absensi->jumlah_salah; ?></h2>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($this->session->userdata("role") == "DESAIN" || $this->session->userdata("role") == "PRODUKSI" ) { ?>
    <!-- <?php echo $status; ?> -->
    <!-- <?php echo "<pre>", print_r($tampilan_absensi, 1), "</pre>"; ?> -->
<div class="row" style="margin-top: 20px;" >
    <?php if ($status  == "BELUM MASUK HARI INI") { ?>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">Day</span>
                <center><h5>ABSENSI MASUK</h5></center>
            </div>
            <div class="ibox-content">
                <form action="<?php echo base_url('absensi/tambah') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <button class="btn btn-block btn-xs btn-success" type="submit"><i class="fa fa-sign-in"></i> Klik Disini</button>
                </form>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if ($status  == "SUDAH ABSEN MASUK HARI INI") { ?>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-primary pull-right">Day</span>
                <center><h5>SUDAH ABSENSI</h5></center>
            </div>
            <div class="ibox-content">
                <center><h3 style="color: green;"><p style="margin-bottom: -10px;">HATI- HATI DIJALAN</p><br>TERIMA KASIH</h3></center>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if ($status  == "BELUM ABSEN PULANG") { ?>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-primary pull-right">Day</span>
                <center><h5>ABSENSI KELUAR</h5></center>
            </div>
            <div class="ibox-content">
                <form action="<?php echo base_url('absensi/edit') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id_absensi" class="form-control" value="<?php echo $tampilan_absensi->id_absensi;?>">
                    <button class="btn btn-block btn-xs btn-primary" type="submit"><i class="fa fa-sign-out"></i> Klik Disini</button>
                    <center><h4 class="no-margins"><?php echo "Masuk : ".date('H:i:s', strtotime($tampilan_absensi->tanggal_masuk));?></h4></center>
                </form>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if ($status  == "BELUM BISA ABSEN PULANG") { ?>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-primary pull-right">Day</span>
                <center><h5>ABSENSI KELUAR</h5></center>
            </div>
            <div class="ibox-content">
                <button class="btn btn-block btn-xs btn-primary not-allowed" type="button"><i class="fa fa-sign-out"></i> Klik Disini</button>
                <center><h4 class="no-margins"><?php echo "Masuk : ".date('H:i:s', strtotime($tampilan_absensi->tanggal_masuk));?></h4></center>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if ($status  =="LUPA MASUK DAN PULANG") { ?>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-danger pull-right">Day</span>
                <center><h5>LUPA ABSEN PULANG</h5></center>
            </div>
            <div class="ibox-content">
                <center><h3 style="color: red;"><p>HUBUNGI ADMIN</p></h3></center>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php } ?>
<br>
    <div class="wrapper wrapper-content animated fadeIn" style="margin-top: -45px;" >
        <div class="row">
            <center><h2><strong>Syarat dan Ketentuan Mendapatkan Point</strong></h2></center><br>
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <?php $i=1; foreach ($syarat as $k) { ?>
                            <?php if ($i == 1) {?>
                                <li class="active"><a data-toggle="tab" href="#tab-<?php echo $i; ?>"> <?php echo $k->judul_ketentuan; ?></a></li>
                            <?php } else { ?>
                                <li class=""><a data-toggle="tab" href="#tab-<?php echo $i; ?>"> <?php echo $k->judul_ketentuan ?></a></li>
                            <?php } ?>
                        <?php $i++; } ?>
                    </ul>
                    <div class="tab-content">
                        <?php $a=1; foreach ($syarat as $v) { ?>
                            <?php if ($a == 1) {?>
                                <div id="tab-<?php echo $a; ?>" class="tab-pane active">
                                    <div class="panel-body">
                                        <?php echo $v->syarat_ketentuan; ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div id="tab-<?php echo $a; ?>" class="tab-pane">
                                    <div class="panel-body">
                                        <?php echo $v->syarat_ketentuan; ?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php $a++; } ?>
                    </div>


                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(function() {
        $(".hide-it").hide(2000);
    });
</script>
