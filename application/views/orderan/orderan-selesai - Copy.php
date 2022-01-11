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
        <h2>Master Orderan Selesai</h2>
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
                                        "<strong>SHOPEE</strong>"."<br>".
                                        $k['no_pesanan']."<br><br>".
                                        $k['opsi_pengiriman']."<br><br>".
                                        $k['username']."<br>".
                                        "<strong>".$k['nama_penerima']."</strong>"."<br>".
                                        $k['kota_kabupaten']."<br>"
                                    ?>
                                    </center>
                                </td>
                                <td>
                                    <?php echo "&#9658; ".str_replace("@$@", "<br>&#9658; ", $k['list_produk']); ?>
                                </td>
                                <td>
                                    <?php echo 
                                        "Harga Total : "."<strong>"."Rp " . number_format($k['harga_total'])."</strong>"."<br><br>".
                                        "Order : "."<strong>".$k['waktu_dibuat']."</strong>"."<br>".  
                                        "Dikerjakan : "."<strong>".$k['tanggal_dikerjakan']."</strong>"."<br><br>"; 
                                    ?>
                                    <?php 
                                        if ($k['tanggal_desain'] != '0000-00-00 00:00:00') {
                                            echo "Desain : "."<strong>".$k['tanggal_desain']."</strong>"."<br><br>";
                                        } else {
                                            echo "Desain : <strong>Sudah Ada</strong><br><br>";
                                        }
                                        if ($k['tanggal_antri_cetak'] != '0000-00-00 00:00:00') {
                                            echo "Antri Cetak : "."<strong>".$k['tanggal_antri_cetak']."</strong>"."<br><br>";
                                        } else {
                                            echo "";
                                        }
                                        if ($k['tanggal_cetak_diluar'] != '0000-00-00 00:00:00') {
                                            echo "Cetak Diluar : "."<strong>".$k['tanggal_cetak_diluar']."</strong>"."<br><br>";
                                        } else {
                                            echo "";
                                        }
                                        if ($k['tanggal_menunggu_pengiriman'] != '0000-00-00 00:00:00') {
                                            echo "Menunggu Pengiriman : "."<strong>".$k['tanggal_menunggu_pengiriman']."</strong>"."<br><br>";
                                        } else {
                                            echo "";
                                        }
                                    ?>
                                    <?php echo
                                        "Packing : "."<strong>".$k['tanggal_packing']."</strong>"."<br><br>".
                                        "Dikirim : "."<strong>".$k['tanggal_dikirim']."</strong>"."<br><br>".
                                        "Deadline : "."<strong>".$k['waktu_batas']."</strong>"."<br>".
                                        "Status Pesanan : "."<strong>".strtoupper($k['status_pesanan'])."</strong>";
                                    ?>
                                </td>
                                <?php if ($this->session->userdata('role') == "ADMIN") { ?>
                                <td>
                                    <center>
                                        <?php if ($k['status_point'] == '') { ?>

                                        <button id='btn_approve' data-no_pesanan="<?= $k['no_pesanan']?>" data-username="<?= $k['username']?>" data-harga_total="<?= $k['harga_total']?>" class='btn btn-xs btn-success'><i class='fa fa-check'></i> Approve</button>
                                        <button  data-toggle="modal" data-target="#orderan_reject" id="id_reject" data-no_pesanan="<?= $k['no_pesanan']?>" class='btn btn-xs btn-danger'><i class='fa fa-times'></i> Reject</button>

                                        <?php } else if ($k['status_point'] == 'REJECT') { ?>

                                        <button class='btn btn-xs btn-danger not-allowed'>Status Reject</button>

                                        <?php } else if ($k['status_point'] == 'APPROVE'){ ?>

                                            <button class='btn btn-xs btn-success not-allowed'> Status Approve</button>

                                        <?php } ?>
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
                    <h4 class="modal-title">REJECT ORDERAN ?</h4>
                </div>
                <div class="modal-body">
                <form action="<?php echo base_url('orderan_selesai/change_status_reject') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <center><p style="color: red;">Anda Tidak Dapat Mengembalikannya!!</p></center>
                    <input type="hidden" name="no_pesanan" id="no_pesanan" class="form-control">
                    <textarea type="text" class="form-control" name="alasan" placeholder="Keterangan" rows="5" required></textarea>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Lanjukan!</button>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>

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
        // $(document).on("submit", "#from_reject", function(e){
        // e.preventDefault();
        //     var url = (no_pesanan == "" ? "add_reject" : "edit_reject");
        //     $.ajax({
        //         "async": true,
        //         "crossDomain": true,
        //         "url": "<?= base_url('orderan_selesai') ?>/"+url,
        //         "method": "POST",
        //         "data": $(this).serialize(),
        //     }).done(function (response) {
        //         var data = JSON.parse(response)
        //         var message = data.message;
        //         console.log(data);
        //         if(data.status == "success"){
        //             $("#orderan_reject").modal("hide");
        //             swal({
        //                 title: "Success",
        //                 text: message,
        //                 type: "success",
        //                 confirmButtonColor: "#a5dc86",
        //                 confirmButtonText: "Close",
        //             }, function(isConfirm){
        //                 location.reload();
        //             });
        //         } else {
        //             swal("Failed", message, "warning");
        //         }
        //     });
        // }); 
        // console.log(bulan);
    });

</script>