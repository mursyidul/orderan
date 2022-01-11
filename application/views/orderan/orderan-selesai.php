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
    .not-allowed{
     cursor: not-allowed! important;
        
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Orderan Selesai</h2>
        <ol class="breadcrumb">
            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="active"><strong><a>Orderan Selesai</a></strong></li>
        </ol>
    </div>
</div>
<!-- <?php echo "<pre>",print_r($orderan_selesai, 1),"</pre>"; ?> -->
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata("success") ?>"></div>

                <div class="flash-data_error" data-flashdata="<?php echo $this->session->flashdata("error") ?>"></div>                 
                <div class="ibox-content">
                    <div class="table-responsive">
                    <table id="table_orderan" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="10%"><center>Customer</center></th>
                            <th width="40%"><center>Nama Barang</center></th>
                            <th width="23%"><center>Detail</center></th>
                            <!-- <th width="20%"><center>Informasi</center></th> -->
                        <?php if($this->session->userdata('role')=='ADMIN'){?>
                            <th width="15%"><center>Aksi</center></th>
                        <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($orderan_selesai as $k) { ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><center>
                                    <?php echo 
                                        "<strong>".$k['source']."</strong>"."<br>".
                                        $k['no_pesanan']."<br><br>".
                                        $k['opsi_pengiriman']."<br><br>".
                                        "<strong>".$k['username']."</strong>"."<br>".
                                        $k['nama_penerima']."<br>".
                                        $k['kota_kabupaten']."<br>"
                                    ?>
                                    </center>
                                </td>
                               <td>
                                    <div class="row">
                                        <?php for ($a=0; $a <$k['jumlah_order'][0]['jumlah'] ; $a++) { ?>
                                        <div class="col-sm-12">
                                            <div class="col-sm-3">
                                                <?php if ($k['nomor_sku_order'][$a][0][0]['gambar'] != "") { ?>
                                                <img class="img-thumbnail" src="<?php echo base_url() ?>./file/dokumen/<?=$k['nomor_sku_order'][$a][0][0]['gambar'];?>" style="max-width: 80px; width: auto; max-height: 80px;">
                                                <br>
                                                <br>
                                                <?php } else{ ?>
                                                <img class="img-thumbnail" src="<?php echo base_url('assets/images/no_image.jpg')?>" style="max-width: 80px; width: auto; max-height: 80px;">
                                                <br>
                                                <br>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-9">
                                                <?php 
                                                  if ($k['nomor_sku_order'][$a][0][0]['deskripsi'] != "") {
                                                    echo 
                                                    "&#9658; Deskripsi : ".$k['nomor_sku_order'][$a][0][0]['deskripsi']."<br>".
                                                    "&#9658; Variasi : "."<strong>".$k['nomor_sku_order'][$a][0][0]['nama_variasi']."</strong>"."<br>".
                                                    "&#9658; Nomor SKU : "."<strong>".$k['nomor_sku_order'][$a][0][0]['nomor_sku']." (".$k['nomor_sku_order'][$a][0][0]['sku_induk'].")"."</strong>"."<br>".
                                                    "&#9658; Qty : "."<strong>".$k['nomor_sku_order'][$a][0][0]['total_qty']."</strong>"."<br><br>";
                                                    } else {
                                                    echo 
                                                    "&#9658; Deskripsi : ".$k['nomor_sku_order'][$a][0][0]['nama_produk']."<br>".
                                                    "&#9658; Variasi : "."<strong>".$k['nomor_sku_order'][$a][0][0]['nama_variasi']."</strong>"."<br>".
                                                    "&#9658; Nomor SKU : "."<strong>".$k['nomor_sku_order'][$a][0][0]['nomor_sku']." (".$k['nomor_sku_order'][$a][0][0]['sku_induk'].")"."</strong>"."<br>".
                                                    "&#9658; Qty : "."<strong>".$k['nomor_sku_order'][$a][0][0]['total_qty']."</strong>"."<br><br>";

                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td>
                                    <?php echo 
                                        "Proses by : "."<strong>".$k['full_name']."</strong>"."<br><br>".
                                        "Cetak by : "."<strong>".$k['user_cetak']."</strong>"."<br><br>".
                                        "Packing by : "."<strong>".$k['user_packing']."</strong>"."<br><br>".
                                        "Deadline : "."<strong>".$k['waktu_batas']."</strong>"."<br><br>".
                                        "Order : "."<strong>".$k['waktu_dibuat']."</strong>"."<br>".
                                        "Status Pesanan : "."<strong>".strtoupper($k['status_pesanan'])."</strong>"."<br>"
                                    ?>
                                    <!-- <?php if ($k['status_kerjakan'] == "") { ?>
                                        <?php echo "Status Pengerjaan :"."<strong>"."BELUM DI KERJAKAN"."</strong>"; ?>
                                    <?php } else{ ?>
                                        <br>
                                        <center><button class='btn btn-xs btn-primary'> <i class="fa fa-history"></i> History Pengerjaan</button></center>
                                    <?php } ?> -->
                                </td>
                                <?php if ($this->session->userdata('role') == "ADMIN") { ?>
                                <td>
                                    <center>
                                        <?php if ($k['status_point'] == '') { ?>

                                        <button id='btn_approve' data-no_pesanan="<?= $k['no_pesanan']?>" data-username="<?= $k['username']?>" data-harga_total="<?= $k['harga_total']?>" class='btn btn-block btn-xs btn-success'><i class='fa fa-check'></i> Approve</button>
                                        <button  data-toggle="modal" data-target="#orderan_reject" id="id_reject" data-no_pesanan="<?= $k['no_pesanan']?>" class='btn btn-block btn-xs btn-danger'><i class='fa fa-times'></i> Reject</button>

                                        <?php } else if ($k['status_point'] == 'REJECT') { ?>

                                        <button class='btn btn-block btn-xs btn-danger not-allowed'>Status Reject</button>

                                        <?php } else if ($k['status_point'] == 'APPROVE'){ ?>

                                            <button class='btn btn-block btn-xs btn-success not-allowed'> Status Approve</button>

                                        <?php } ?>
                                        <center><button class='btn btn-block btn-xs btn-primary' data-toggle="modal" data-target="#history_pengerjaan<?= $k['no_pesanan']; ?>"> <i class="fa fa-history"></i> History Pengerjaan</button></center>
                                    </center>
                                </td>
                                <?php } ?>
                            </tr>
                        <?php $i++; } ?>
                    </tbody>
                    </table>
                        </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="orderan_reject" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">REJECT ORDERAN</h4>
                </div>
                <div class="modal-body">
                <form action="<?php echo base_url('orderan_selesai/change_status_reject') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <!-- <center><p style="color: red;">Anda Tidak Dapat Mengembalikannya!!</p></center> -->
                    <input type="hidden" name="no_pesanan" id="no_pesanan" class="form-control">
                    <textarea type="text" class="form-control" name="alasan" placeholder="Keterangan" rows="5" required></textarea>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <?php $i=0; foreach ($orderan_selesai as $k) { ?>
    <div class="modal inmodal fade" id="history_pengerjaan<?= $k['no_pesanan'];?>" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">History Pengerajaan</h4>
                </div>
                <div class="modal-body">
                    <p>Tanggal Dikerjakan : <strong><?php echo $k['tanggal_dikerjakan'] ?></strong></p>
                    <p>Tanggal Desain : <strong><?php echo $k['tanggal_desain'] ?></strong></p>
                    <p>Tanggal Antri Cetak : <strong><?php echo $k['tanggal_antri_cetak'] ?></strong></p>
                    <p>Tanggal Cetak Diluar : <strong><?php echo $k['tanggal_cetak_diluar'] ?></strong></p>
                    <p>Tanggal Menunggu Pengiriman : <strong><?php echo $k['tanggal_menunggu_pengiriman'] ?></strong></p>
                    <p>Tanggal Packing : <strong><?php echo $k['tanggal_packing'] ?></strong></p>
                    <p>Tanggal Dikirim : <strong><?php echo $k['tanggal_dikirim'] ?></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#table_orderan").dataTable();
    });

    $(document).on("click", "#btn_reject", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Reject Orderan ?",
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
                    "url": "<?= base_url('orderan_selesai/change_status_reject') ?>",
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

    $(document).on("click", "#btn_approve", function(e){
        var no_pesanan  = $(this).data("no_pesanan");
        var username    = $(this).data("username");
        var harga_total = $(this).data("harga_total");
        swal({
            title: "Approve Orderan ?",
            text: "Anda tidak dapat mengembalikannya.!!",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#0c19c5",
            confirmButtonText: "Ya, lanjutkan!",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm){
            if(isConfirm){
                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "<?= base_url('orderan_selesai/change_status_approve') ?>",
                    "method": "POST",
                    "data": {
                        "no_pesanan": no_pesanan,
                        "username": username,
                        "harga_total": harga_total,
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

    $(document).ready(function(){
        const flashData = $('.flash-data').data('flashdata');
        // alert(flashData);
        if( flashData != "") {
            swal({
                title: '' + flashData,
                // text: 'Permintaan Alat Bahan Berhasil Ditambahkan',
                type: 'success'
            });
        } else{

        }
    });

    $(document).ready(function(){
        const flashData = $('.flash-data_error').data('flashdata');
        // alert(flashData);
        if( flashData != "") {
            swal({
                title: '' + flashData,
                // text: 'Gagal, Tidak Dapat Menyimpan Permintaan Alat Bahan.!!',
                type: 'error'
            });
        } else{

        }
    });

    $(document).on("click", "#id_reject", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        $(".modal-body #no_pesanan").val(no_pesanan);
    });

</script>