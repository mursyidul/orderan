<style type="text/css">
    .select2-close-mask{
    z-index: 99999;
    }
    .select2-dropdown{
        z-index: 99999;
    }
</style>
<style>
    .select2-container .select2-selection--single{
        height:34px !important;
    }
    .select2-container--default .select2-selection--single{
       border: 1px solid #ccc !important; 
       border-radius: 0px !important; 
   }
   .ui-datepicker-year
    {
     display:none;   
    }
    .chart-container {
        width: 450px;
        height:220px
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Transaksi</h2>
        <ol class="breadcrumb">
            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li><a  href="<?php echo base_url('transaksi'); ?>">Transaksi</a></li>
            <li class="active"><strong><a>List Transaksi</a></strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata("success") ?>"></div>
                <div class="flash-data_error" data-flashdata="<?php echo $this->session->flashdata("error") ?>"></div>  
                <div class="ibox-content">
                    <div class="row"> 
                        <form method="get" action="">
                            <div class="col-md-2">
                                <label> Start Date</label>
                                <div class="form-group" id="data_1">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar">
                                            </i></span>
                                        <input type="text" class="form-control" name="startdate" required="" value="<?php 
                                            if(isset($_GET['startdate']) && ! empty($_GET['startdate'])){
                                                echo date('d-m-Y', strtotime($_GET['startdate'])); 
                                            }else{
                                                echo date('d-m-Y', strtotime('-0 Day')); 
                                            }
                                        ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label> End Date</label>
                                <div class="form-group" id="data_1">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar">
                                            </i></span>
                                        <input type="text" class="form-control" name="enddate" required="" value="<?php 
                                            if(isset($_GET['enddate']) && ! empty($_GET['enddate'])){
                                                echo date('d-m-Y', strtotime($_GET['enddate'])); 
                                            }else{
                                                echo date('d-m-Y'); 
                                            }
                                        ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label> Nama Customer</label>
                                <div class="form-group">
                                    <div>
                                        <select class="form-control select2" name="customer">
                                            <option value="">Pilih Customer</option>
                                            <?php foreach ($customer as $k) {
                                                echo '<option value="'.$k->nama_customer.'">'.$k->nama_customer.'</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button style="margin-top: 25px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Search</button>
                                <a style="margin-top: 25px;" href="<?php
                                    $customer    ="";
                                    $startdate      ="";
                                    $enddate        ="";
                                    if(isset($_GET['startdate']) && ! empty($_GET['startdate'])){ 
                                            $startdate     = $_GET['startdate'];
                                    }
                                    if(isset($_GET['enddate']) && ! empty($_GET['enddate'])){ 
                                            $enddate     = $_GET['enddate'];
                                    }
                                    if(isset($_GET['customer']) && ! empty($_GET['customer'])){ 
                                                $customer     = $_GET['customer'];
                                        }
                                        echo base_url("transaksi/export?startdate=".$startdate."&enddate=".$enddate."&customer=".$customer."");
                                    ?>" class="btn btn-sm btn-primary" data-toggle="tooltip"><i class="fa fa-file-excel-o"></i> Export</a>
                                    <a style="margin-top: 25px;" href="<?php echo base_url("transaksi"); ?>" class="btn btn-sm btn-info" data-toggle="tooltip"><i class="fa fa-plus"></i> Tambah Transaksi</a>
                            </div>
                            
                        </form>
                    </div>
                    <!-- <?php echo "<pre>", print_r($list_transaksi, 1), "</pre>"; ?> -->
                    <div class="table-responsive">
                    <table id="table_tukar" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="10%"><center>Aksi</center></th>
                            <th width="10%"><center>Invoice</center></th>
                            <th width="20%"><center>Customer</center></th>
                            <th width="10%"><center>Total</center></th>
                            <th width="10%"><center>Pembayaran</center></th>
                            <th width="10%"><center>Diskon</center></th>
                            <th width="10%"><center>Kurang</center></th>
                            <th width="15%"><center>Keterangan</center></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($list_transaksi)) { ?>
                        <?php $i=1; foreach ($list_transaksi as $k) { ?>
                            <tr>
                                <td><center><?php echo $i; ?></center></td>
                                <td>
                                    <div class="btn-group">
                                        <button style="width: 70px;" data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">Action <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                          <?php if ($k['status_pesanan'] == "Perlu Dikirim") {?>
                                            <li><a id="btn_batal" title="Batal" data-no_pesanan="<?=$k['no_pesanan'];?>" >Batal</a></li>
                                            <li><a href="<?php echo base_url("transaksi/detail_transaksi/".$k['no_pesanan']); ?>">Detail</a></li>
                                            <li><a id="btn_sedang" title="Sedang Dikirim" data-no_pesanan="<?=$k['no_pesanan'];?>">Sedang Dikirim</a></li>
                                            <li><a id="btn_selesai" title="Selesai" data-no_pesanan="<?=$k['no_pesanan'];?>">Selesai</a></li>
                                          <?php } else if ($k['status_pesanan'] == "Sedang Dikirim") {?>
                                            <li><a id="btn_batal" title="Batal" data-no_pesanan="<?=$k['no_pesanan'];?>" >Batal</a></li>
                                            <li><a href="<?php echo base_url("transaksi/detail_transaksi/".$k['no_pesanan']); ?>">Detail</a></li>
                                            <li><a id="btn_selesai" title="Selesai" data-no_pesanan="<?=$k['no_pesanan'];?>">Selesai</a></li>
                                          <?php } else { ?>
                                            <li><a href="<?php echo base_url("transaksi/detail_transaksi/".$k['no_pesanan']); ?>">Detail</a></li>
                                          <?php } ?>
                                        </ul>
                                    </div>
                                </td>
                                <td><?php echo $k['no_pesanan']; ?></td>
                                <td><?php echo $k['nama_penerima']; ?></td>
                                <td><?php echo "Rp ".number_format($k['total_biaya']); ?></td>
                                <td><?php echo "Rp ".number_format($k['bayar'][0]['jumlah_pembayaran']); ?></td>
                                <td><?php echo "Rp ".number_format($k['potongan_harga']); ?></td>
                                <td>
                                    <?php 
                                    $total = $k['total_biaya'] - number_format($k['potongan_harga']);
                                    $kurang = $total - $k['bayar'][0]['jumlah_pembayaran'];

                                    if ($kurang < 0) {
                                        echo "<p style='color : red;'>Rp 0</p>";
                                    } else {
                                        echo "<p style='color : red;'> Rp ".number_format($kurang)."</p>"; 
                                    }
                                    ?>
                                </td>
                                <td><center><?php echo "Status Pesanan : ".$k['status_pesanan']."<br>".date('d F Y', strtotime($k['waktu_dibuat'])); ?></center></td>
                            </tr>
                        <?php $i++; } ?>
                    <?php } ?>
                    </tbody>
                    </table>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#table_tukar").dataTable();
    });

    $('.select2').select2({
        width: '100%'
    });

    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'dd-mm-yyyy'
    });

    $(document).on("click", "#btn_batal", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Apakah anda yakin ingin ubah status ke batal ?",
            text: "Anda tidak dapat mengembalikannya.!!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, lanjutkan!",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm){
            if(isConfirm){
                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "<?= base_url('transaksi/batal_transaksi') ?>",
                    "method": "POST",
                    "data": {
                        "no_pesanan": no_pesanan
                    }
                }
                $.ajax(settings).done(function (response) {
                    var data = JSON.parse(response)
                    var message = data.message;
                    if(data.status == "success"){
                        swal({
                            title: "Success",
                            text: message,
                            type: "success",
                            confirmButtonColor: "#a5dc86",
                            confirmButtonText: "Close",
                        }, function(isConfirm){
                            location.reload();
                        });
                    } else {
                        swal("Gagal menghapus data.", message.toUpperCase(), "warning");
                    }
                });   
            }
        });
    });

    $(document).on("click", "#btn_sedang", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Apakah anda yakin ingin ubah status ke sedang dikirim ?",
            text: "Anda tidak dapat mengembalikannya.!!",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#2986cc",
            confirmButtonText: "Ya, lanjutkan!",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm){
            if(isConfirm){
                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "<?= base_url('transaksi/sedang_transaksi') ?>",
                    "method": "POST",
                    "data": {
                        "no_pesanan": no_pesanan
                    }
                }
                $.ajax(settings).done(function (response) {
                    var data = JSON.parse(response)
                    var message = data.message;
                    if(data.status == "success"){
                        swal({
                            title: "Success",
                            text: message,
                            type: "success",
                            confirmButtonColor: "#a5dc86",
                            confirmButtonText: "Close",
                        }, function(isConfirm){
                            location.reload();
                        });
                    } else {
                        swal("Gagal menghapus data.", message.toUpperCase(), "warning");
                    }
                });   
            }
        });
    });

    $(document).on("click", "#btn_selesai", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Apakah anda yakin ingin ubah status ke selesai ?",
            text: "Anda tidak dapat mengembalikannya.!!",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#2986cc",
            confirmButtonText: "Ya, lanjutkan!",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm){
            if(isConfirm){
                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "<?= base_url('transaksi/selesai_transaksi') ?>",
                    "method": "POST",
                    "data": {
                        "no_pesanan": no_pesanan
                    }
                }
                $.ajax(settings).done(function (response) {
                    var data = JSON.parse(response)
                    var message = data.message;
                    if(data.status == "success"){
                        swal({
                            title: "Success",
                            text: message,
                            type: "success",
                            confirmButtonColor: "#a5dc86",
                            confirmButtonText: "Close",
                        }, function(isConfirm){
                            location.reload();
                        });
                    } else {
                        swal("Gagal menghapus data.", message.toUpperCase(), "warning");
                    }
                });   
            }
        });
    });
</script>