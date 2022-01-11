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
    body.modal-open .datepicker {
      z-index: 99999999 !important;
     /* width: 20%;
      height: 85%;*/
    }
    .clockpicker-popover {
        z-index: 999999;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-10">

        <h2>Absensi</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Absensi</a></strong></li>

        </ol>

    </div>

</div>
<!-- <?php echo "<pre>", print_r($absensi,1), "</pre>"; ?> -->
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="flash-data hide-it" data-flashdata="<?php echo $this->session->flashdata("success") ?>"></div>

                <div class="flash-data_error hide-it" data-flashdata="<?php echo $this->session->flashdata("error") ?>"></div>  
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
                                <label> Nama User</label>
                                <div class="form-group">
                                    <div>
                                        <select class="form-control select2" name="user">
                                            <option value="">Pilih User</option>
                                            <?php foreach ($user as $k) {
                                                echo '<option value="'.$k->id_user.'">'.$k->full_name.'</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button style="margin-top: 25px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Search</button>
                                <a style="margin-top: 25px;" href="<?php
                                    $id_user      ="";
                                    $startdate        ="";
                                    $enddate        ="";
                                    if(isset($_GET['startdate']) && ! empty($_GET['startdate'])){ 
                                            $startdate     = $_GET['startdate'];
                                    }
                                    if(isset($_GET['enddate']) && ! empty($_GET['enddate'])){ 
                                            $enddate     = $_GET['enddate'];
                                    }
                                    if(isset($_GET['id_user']) && ! empty($_GET['id_user'])){ 
                                                $id_user     = $_GET['id_user'];
                                        }
                                        echo base_url("absensi/export?startdate=".$startdate."&enddate=".$enddate."&id_user=".$id_user."");
                                    ?>" class="btn btn-sm btn-primary" data-toggle="tooltip"><i class="fa fa-file-excel-o"></i> Export</a>
                                <button style="margin-top: 25px; width: 110px;" data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-info" type="button"><i class="fa fa-plus"></i> Add Absensi</button>
                            </div>
                            
                        </form>
                    </div>
                    <div class="table-responsive">
                    <table id="table_tukar" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="20%"><center>Nama User</center></th>
                            <th width="14%"><center>Jam Masuk</center></th>
                            <th width="14%"><center>Jam Keluar</center></th>
                            <th width="13%"><center>Durasi Kerja</center></th>
                            <th width="10%"><center>Status</center></th>
                            <th width="14%"><center>Tanggal</center></th>
                            <th width="10%"><center>Aksi</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($absensi as $k) { ?>
                            <tr>
                                <td><center><?php echo $i; ?></center></td>
                                <td><?php echo $k->full_name; ?></td>
                                <td><?php echo date('H:i:s', strtotime($k->tanggal_masuk)); ?></td>
                                <td>
                                <?php 
                                    if ($k->tanggal_keluar == "0000-00-00 00:00:00") {
                                        echo "00:00:00";
                                    } else {
                                        echo date('H:i:s', strtotime($k->tanggal_keluar));
                                    }
                                ?>
                                </td>
                                <td>
                                <?php 
                                    if ($k->tanggal_keluar == "0000-00-00 00:00:00") {
                                        echo "00:00:00";
                                    } else {
                                        echo str_replace("-","",$k->durasi_kerja);
                                    }
                                ?>
                                </td>
                                <td><?php echo $k->status_jadwal; ?></td>
                                <td><?php echo date('d F Y', strtotime($k->created_date)); ?></td>
                                <td>
                                    <center>
                                        <button style="width: 70px;" data-toggle="modal" data-target="#modalEdit<?php echo $k->id_absensi; ?>" class="btn btn-xs btn-warning " title="Edit" type="button"><i class="fa fa-edit"></i> Edit</button>
                                    </center>
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

<div class="modal inmodal fade" id="modalAdd" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Add Absensi</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('absensi/tambah_admin') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama User</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_user" id="jenis_cuti" required>
                                <option value="">Pilih User</option>
                                <?php foreach ($user as $k) {
                                    echo '<option value="'.$k->id_user.'">'.$k->full_name.'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal Masuk</label>
                        <div id="data_1">
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar">
                                    </i></span>
                                <input type="text" value="<?php echo date('d-m-Y')?>" class="form-control" name="tanggal_masuk" required >
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal Keluar</label>
                        <div id="data_1">
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar">
                                    </i></span>
                                <input type="text" class="form-control" name="tanggal_keluar" required value="<?php echo date('d-m-Y'); ?>">
                            </div>
                        </div>
                        </div>
                    </div> -->
                    <div class="form-group" >
                        <label class="col-sm-3 control-label">Jam Masuk</label>
                        <div class="col-sm-8">
                            <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                <input type="text" name="jam_masuk" class="form-control" value="<?php echo date("H:i");?>" data-readonly onkeydown="return false">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group" >
                        <label class="col-sm-3 control-label">Jam Keluar</label>
                        <div class="col-sm-8">
                            <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                <input type="text" name="jam_keluar" class="form-control"   data-readonly onkeydown="return false">
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-11">
                            <button style="width: 100px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>&nbsp;
                            <button style="width: 100px;" type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $i=1; foreach ($absensi as $k) { ?>
<div class="modal inmodal fade" id="modalEdit<?php echo $k->id_absensi; ?>" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Edit Absensi</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('absensi/edit_admin') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id_absensi" class="form-control" value="<?php echo $k->id_absensi; ?>">
                    <input type="hidden" name="id_user" class="form-control" value="<?php echo $k->id_user; ?>">
                    <input type="hidden" name="tanggal_masuk" class="form-control" value="<?php echo date('Y-m-d', strtotime($k->tanggal_masuk)); ?>">
                    <input type="hidden" name="tanggal_keluar" class="form-control" value="<?php if(date('Y-m-d', strtotime($k->tanggal_keluar)) != "date('Y-m-d', strtotime($k->tanggal_masuk)"){echo date('Y-m-d', strtotime($k->tanggal_masuk));}else{echo date('Y-m-d', strtotime($k->tanggal_keluar));} ?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama User</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_user" placeholder="Nama User" value="<?php echo $k->full_name; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jam Masuk</label>
                        <div class="col-sm-8">
                            <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                <input type="text" name="jam_masuk" value="<?php echo date("H:i:s", strtotime($k->tanggal_masuk)); ?>" class="form-control"   data-readonly onkeydown="return false">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jam Keluar</label>
                        <div class="col-sm-8">
                            <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                <input type="text" required name="jam_keluar" 
                                    value="<?php 
                                                if($k->tanggal_keluar == '0000-00-00 00:00:00'){
                                                    echo "00:00:00";
                                                } else {
                                                    echo date("H:i:s", strtotime($k->tanggal_keluar)); 
                                                }    
                                            ?>" 
                                    class="form-control" data-readonly onkeydown="return false">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="status_jadwal" required>
                                <option value="">Pilih Status</option>
                                <option value="Telat" <?php if($k->status_jadwal == "Telat"){echo "selected";} ?>>Telat</option>
                                <option value="On Time" <?php if($k->status_jadwal == "On Time"){echo "selected";} ?>>On Time</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-11">
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

    $('.clockpicker').clockpicker({
        autoclose: true
    });
    $(document).ready(function(){
        const flashData = $('.flash-data').data('flashdata');
        // $(".hide-it").hide(5000);
        // alert(flashData);
        if( flashData != "") {
            swal({
                timer: 3000,
                title: '' + flashData,
                // text: 'Permintaan Alat Bahan Berhasil Ditambahkan',
                type: 'success'
            });
        } else{

        }
    });

    $(document).ready(function(){
        const flashData = $('.flash-data_error').data('flashdata');
        // $(".hide-it").hide(5000);
        // alert(flashData);
        if( flashData != "") {
            swal({
                title: '' + flashData,
                // title: '' + 'Data Gagal Disimpan',
                // text: 'Nama bahan sudah terdaftar',
                type: 'error'
            });
        } else{

        }
    });

    $(document).on("click", "#btn_delete", function(e){
        var id_bahan = $(this).data("id_bahan");
        swal({
            title: "Apakah anda yakin ingin menghapus ?",
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
                    "url": "<?= base_url('bahan/delete_bahan') ?>",
                    "method": "POST",
                    "data": {
                        "id_bahan": id_bahan
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