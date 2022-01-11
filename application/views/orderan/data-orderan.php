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
<style>
    tr, th, td {
      border: 1px solid black;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Orderan</h2>
        <ol class="breadcrumb">
            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="active"><strong><a>List Orderan</a></strong></li>
        </ol>
    </div>
</div>
<!-- <?php echo "<pre>", print_r($orderan, 1), "</pre>"; ?> -->
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <?php
                    if($this->session->flashdata('error')){
                ?>   
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Failed!</strong> <?php echo $this->session->flashdata('error'); ?>
                    </div>    
                <?php     
                    }
                ?>
                <?php
                    if($this->session->flashdata('success')){
                ?>   
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                    </div>    
                <?php     
                    }
                ?>                   
                <div class="ibox-content">
                    <button data-toggle="modal" data-target="#add_orderan" class="btn btn-sm btn-info" type="button"><i class="fa fa-upload"></i> Upload Orderan</button>
                    <br>
                    <br>
                    <div class="table-responsive">
                    <table id="table_orderan" class="table table-striped table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th width="5%" ><center>No</center></th>
                            <th width="10%"><center>Customer</center></th>
                            <th width="40%"><center>Nama Barang</center></th>
                            <th width="15%"><center>Detail</center></th>
                           <!--  <th width="20%"><center>Informasi</center></th>-->
                            <!-- <?php if ($this->session->userdata('role') == 'DESAIN' || $this->session->userdata('role') == 'ADMIN'){ ?> -->
                            <!-- <?php } ?> -->
                            <th width="15%"><center>Aksi</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($orderan as $k) { ?>
                            <tr>
                                <td><b><?php echo $i; ?></b></td>
                                <td>
                                    <center>
                                        <strong><?php echo $k['source']; ?></strong></br>
                                        <?php echo $k['no_pesanan']; ?></br></br>
                                        <i><?php echo $k['opsi_pengiriman']; ?></i></br></br>
                                        <strong><?php echo $k['username']; ?></strong></br>
                                        <?php echo $k['nama_penerima']; ?></br></br>
                                        <i><a href="https://api.whatsapp.com/send?phone=<?php echo $k['no_telepon']; ?>&text=Hai%20kak%20<?php echo $k['nama_penerima']; ?>, perkenalkan kami customer service dari *Emcorp Studio (Studio Print)*  ." target="_blank"><?php echo $k['no_telepon']; ?></a></i></br>
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
                                    <?php if ($k['status_kerjakan'] == "") { ?>
                                        <?php echo "Status Pengerjaan :"."<strong>"."BELUM DI KERJAKAN"."</strong>"; ?>
                                    <?php } else{ ?>
                                        <?php echo "Status Pengerjaan : "."<strong>".strtoupper($k['status_kerjakan'])."</strong>"?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <center>

                                        <?php if ($k['status_kerjakan'] == '') { ?>

                                            <button id="btn_kerjakan" data-no_pesanan ="<?=$k['no_pesanan'];?>" data-id_user ="<?=$this->session->userdata('id_user');?>" class="btn btn-block btn-xs btn-success " type="button"><i class="fa fa-check"></i> Kerjakan</button>

                                        <?php } else if($k['status_kerjakan'] == 'DIKERJAKAN') {?>

                                            <button id="btn_desain" data-no_pesanan ="<?=$k['no_pesanan'];?>" class="btn btn-block btn-xs btn-success " type="button"><i class="fa fa-picture-o"></i> Desain</button>
                                            <button id="btn_antri_cetak" data-no_pesanan ="<?=$k['no_pesanan'];?>" class="btn btn-block btn-xs btn-primary " type="button"><i class="fa fa-eye"></i> Antri Cetak</button>
                                            <button id="btn_cetak_diluar" data-no_pesanan ="<?=$k['no_pesanan'];?>" class="btn btn-block btn-xs btn-info " type="button"><i class="fa fa-sign-out"></i> Cetak Diluar</button>

                                        <?php } else if($k['status_kerjakan'] == 'DESAIN'){ ?>

                                            <button id="btn_desain_selesai" data-no_pesanan ="<?= $k['no_pesanan']?>" class="btn btn-block btn-xs btn-success" type="button"><i class="fa fa-picture-o"></i> Desain Selesai</button>

                                        <?php } else if($k['status_kerjakan'] == 'CETAK DILUAR'){ ?>

                                            <button id="btn_sudah_order" data-no_pesanan ="<?= $k['no_pesanan']?>" class="btn btn-block btn-xs btn-info" type="button"><i class="fa fa-sign-out"></i> Sudah Order</button>

                                        <?php } else if ($k['status_kerjakan'] == 'MENUNGGU PENGIRIMAN') { ?>

                                            <button id="btn_packing" data-no_pesanan ="<?= $k['no_pesanan']?>" class="btn btn-block btn-xs btn-primary" type="button"><i class="fa fa-cube"></i> Barang Diterima</button>

                                        <?php } else if ($k['status_kerjakan'] == 'DIKIRIM'){ ?>
                                            <button class="btn btn-block btn-xs btn-primary not-allowed" type="button"><i class="fa fa-car"></i> Dikirim</button>
                                        <?php } ?> 

                                        <?php if($k['status_kerjakan'] != ""){?>
                                            <a href="<?php echo base_url('upload_orderan/detail/'.$k['no_pesanan']); ?>" class='btn btn-block btn-xs btn-warning'><i class="fa fa-book"></i> Detail</a>
                                           <!--  <button  data-toggle="modal" data-target="#kerusakan" id="id_kerusakan" data-no_pesanan="<?=$k['no_pesanan'];?>" class='btn btn-block btn-xs btn-warning'><i class="fa fa-book"></i> Detail</button> -->
                                        <?php } ?>

                                    </center>
                                <?php if($this->session->userdata('role') == 'ADMIN'){ ?>
                                    <?php if ($k['status_kerjakan'] !=''){ ?>
                                        <button data-toggle="modal" data-target="#modal_delete<?php echo $k['no_pesanan']; ?>" class="btn btn-block btn-xs btn-danger" type="button"><i class="fa fa-trash"></i> Delete</button>
                                        <!-- <a href="<?php echo base_url('upload_orderan/detail/'.$k['no_pesanan']); ?>" class='btn btn-block btn-xs btn-warning'><i class="fa fa-book"></i> Detail</a> -->
                                    <?php } else { ?>
                                       <!--  <button class='btn btn-block btn-xs btn-info not-allowed'><i class="fa fa-exclamation"></i> Menunggu Dikerjakan </button> -->
                                    <?php } ?>
                                <?php } ?>
                                </td>
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
<div class="modal inmodal fade" id="kerusakan" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label>Add Kerusakan</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('upload_orderan/tambah_kerusakan') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="id_user" class="form-control" value="<?php echo $this->session->userdata('id_user'); ?>">
                        <input type="hidden" name="no_pesanan" class="form-control" id="no_pesanan">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kategori</label>
                            <div class="col-sm-8">
                                <select name="id_kategori" class="form-control select2" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($kategori as $k) {
                                        echo '<option value="'.$k->id_kategori.'">'.$k->nama_kategori.'</option>';
                                    } ?>
                                </select>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jenis Bahan</label>
                            <div class="col-sm-8">
                                <select name="id_bahan" class="form-control select2" required>
                                    <option value="">Pilih Jenis Bahan</option>
                                    <?php foreach ($bahan as $k) {
                                        echo '<option value="'.$k->id_bahan.'">'.$k->jenis_bahan.'</option>';
                                    } ?>
                                </select>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Status Bahan</label>
                            <div class="col-sm-8">
                                <div class="col-sm-12">
                                    <div class="col-sm-6">
                                        <div class="form-check" align="center">
                                            <input type="radio" name="status_bahan" value="belum cetak" >
                                            <label>Belum Cetak</label>
                                        </div> 
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check" align="center">
                                            <input type="radio" name="status_bahan" value="cetak">
                                            <label>Cetak</label>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jumlah Kerusakan</label>
                            <div class="col-sm-8">
                                <input type="number" name="jumlah_kerusakan" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Deskripsi</label>
                            <div class="col-sm-8">
                                <textarea type="text" name="sebab_kerusakan" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-11">
                            <button style="width: 107px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>&nbsp;
                            <button style="width: 107px;" type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="add_orderan" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header gradient">

                <button type="button" class="close" data-dismiss="modal">

                    <span aria-hidden="true">&times;</span>

                    <span class="sr-only">Close</span>

                </button>

                <h6 class="modal-title" id="title-quis"><label >Upload Orderan</label></h6>

            </div>

            <div class="modal-body">

                <form action="<?php echo base_url('upload_orderan/upload_orderan') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="full_name" class="form-control" value="<?php echo $this->session->userdata('full_name'); ?>">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama E-Commerce</label>
                        <div class="col-sm-8">
                            <select name="source" class="form-control select2" required>
                                <option value="">Pilih E-Commerce</option>
                                <?php
                                    echo '<option value="SHOPEE">Shopee</option>';
                                    // echo '<option value="TOKOPEDIA">Tokopedia</option>';
                                    // echo '<option value="TOKOTALK">Tokotalk</option>';
                                    // echo '<option value="WHATSAPP">Whatsapp</option>';
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">File Excel</label>
                        <div class="col-sm-8">
                            <input type="file" name="fileExcel" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4"></label>
                        <div class="col-sm-8">
                            <button style="width:100px;" type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Upload</button>&nbsp;
                            <button style="width:100px;" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>

</div>

<?php $i=1; foreach ($orderan as $k) { ?>
<div class="modal inmodal fade" id="modal_delete<?php echo $k['no_pesanan']; ?>" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Delete Orderan</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('upload_orderan/change_status_batal_orderan') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="no_pesanan" class="form-control" value="<?php echo $k['no_pesanan']; ?>">
                    <div class="col-md-12">
                        <textarea class="form-control" name="alasan_pembatalan" type="text" rows="5" placeholder="Alasan Pembatalan"></textarea>
                    </div>
                    
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-12">
                            <br>
                            <button style="width: 100px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>&nbsp;
                            <button style="width: 100px;" type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $i++; } ?>

<script type="text/javascript">
    $(document).on("click", "#id_kerusakan", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        $(".modal-body #no_pesanan").val(no_pesanan);
    });
    $('.select2').select2({

        width: '100%'

    });
    $(document).ready(function(){
        $("#table_orderan").dataTable();
    });

    $(document).on("click", "#btn_kerjakan", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        var id_user    = $(this).data("id_user");
        swal({
            title: "Apakah anda yakin untuk mengerjakanya ?",
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
                    "url": "<?= base_url('upload_orderan/change_status_kerjakan') ?>",
                    "method": "POST",
                    "data": {
                        "no_pesanan": no_pesanan,
                        "id_user"   : id_user
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

    $(document).on("click", "#btn_desain", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Apakah anda yakin untuk medesain orderan ?",
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
                    "url": "<?= base_url('upload_orderan/change_status_desain') ?>",
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

    $(document).on("click", "#btn_antri_cetak", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Apakah anda yakin untuk antri cetak ?",
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
                    "url": "<?= base_url('upload_orderan/change_status_antri_cetak') ?>",
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

    $(document).on("click", "#btn_cetak_diluar", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Apakah anda yakin untuk mencetak diluar ?",
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
                    "url": "<?= base_url('upload_orderan/change_status_cetak_diluar') ?>",
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

    $(document).on("click", "#btn_desain_selesai", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Apakah anda yakin desainya selesai ?",
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
                    "url": "<?= base_url('upload_orderan/change_status_desain_selesai') ?>",
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

    $(document).on("click", "#btn_cetak_selesai", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Apakah anda yakin desainya selesai ?",
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
                    "url": "<?= base_url('upload_orderan/change_status_cetak_selesai') ?>",
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

    $(document).on("click", "#btn_sudah_order", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Apakah anda yakin sudah order ?",
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
                    "url": "<?= base_url('upload_orderan/change_status_sudah_order') ?>",
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

    $(document).on("click", "#btn_packing", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Apakah anda yakin ingin packing orderan ?",
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
                    "url": "<?= base_url('upload_orderan/change_status_packing') ?>",
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

    $(document).on("click", "#btn_siap_kirim", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Apakah anda yakin ingin orderan siap kirim?",
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
                    "url": "<?= base_url('upload_orderan/change_status_siap_kirim') ?>",
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

    $(document).on("click", "#batal_orderan", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Apakah anda yakin ingin membatalkan orderan?",
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
                    "url": "<?= base_url('upload_orderan/change_status_batal_orderan') ?>",
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