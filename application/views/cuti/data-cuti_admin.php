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
    .not-allowed{
     cursor: not-allowed! important;
       }
</style>
<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-10">

        <h2>Cuti</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Cuti</a></strong></li>

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
                                                echo date('d-m-Y', strtotime('-1 month')); 
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
                            <div class="col-md-2">
                                <label> Jenis Pengajuan</label>
                                <div class="form-group">
                                    <div>
                                        <select class="form-control select2" name="jenis_cuti">
                                            <option value="">Pilih Jenis Cuti</option>
                                            <?php foreach ($jenis_cuti as $k) {
                                                echo '<option value="'.$k->id_jenis_cuti.'">'.$k->jenis_cuti.'</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button style="margin-top: 25px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Search</button>
                            </div>
                            
                        </form>
                    </div>
                    <div class="table-responsive">
                    <table id="table_tukar" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="15%"><center>Nama User</center></th>
                            <th width="10%"><center>Jenis Cuti</center></th>
                            <th width="10%"><center>Tanggal Mulai</center></th>
                            <th width="10%"><center>Tanggal Akhir</center></th>
                            <th width="5%"><center>Jam Masuk</center></th>
                            <th width="5%"><center>Jam Keluar</center></th>
                            <th width="10%"><center>Tanggal Pengajuan</center></th>
                            <th width="15%"><center>Keterangan</center></th>
                            <?php if($this->session->userdata('role') == "ADMIN"){ ?>
                            <th width="15%"><center>Aksi</center></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($cuti as $k) { ?>
                            <tr>
                                <td><center><?php echo $i; ?></center></td>
                                <td><?php echo $k->full_name; ?></td>
                                <td><?php echo $k->jenis_cuti; ?></td>
                                <td><?php echo date('d F Y', strtotime($k->tanggal_mulai_cuti
                                    )); ?></td>
                                <td><?php echo date('d F Y', strtotime($k->tanggal_akhir_cuti)); ?></td>
                                <td><?php echo $k->jam_masuk_cuti; ?></td>
                                <td><?php echo $k->jam_keluar_cuti; ?></td>
                                <td><?php echo date('d F Y', strtotime($k->created_date)); ?></td>
                                <td><?php echo $k->keterangan_cuti; ?></td>
                                <td>
                                    <center>
                                    <?php if ($k->status_cuti == "") { ?>
                                        <button style="width: 25px;" id="btn_approve" title="APPROVE" data-id_cuti ="<?=$k->id_cuti;?>" class="btn btn-xs btn-primary" type="button"><i class="fa fa-check"></i></button>
                                        <button style="width: 25px;" id="btn_reject" title="REJECT"  data-id_cuti="<?=$k->id_cuti;?>" class="btn btn-xs btn-danger " type="button"><i class="fa fa-times"></i></button>
                                    <?php } else if ($k->status_cuti == "APPROVE") { ?>
                                        <center><h3 style="color: green;">Status Approve</h3></center>
                                    <?php } else if ($k->status_cuti == "REJECT"){ ?>
                                        <center><h3 style="color: red;">Status Reject</h3></center>
                                    <?php } ?>
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

<script type="text/javascript">
    $(document).ready(function(){
        $("#table_tukar").dataTable();
    });

    $('#cuti .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'dd-mm-yyyy'
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
    $('.select2').select2({

        width: '100%'

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
                // title: '' + flashData,
                title: '' + 'Data Gagal Disimpan',
                text: 'Nama bahan sudah terdaftar',
                type: 'error'
            });
        } else{

        }
    });

    $(document).on("click", "#btn_reject", function(e){
        var id_cuti = $(this).data("id_cuti");
        swal({
            title: "Reject pengajuan ?",
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
                    "url": "<?= base_url('cuti/reject_cuti') ?>",
                    "method": "POST",
                    "data": {
                        "id_cuti": id_cuti
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
        var id_cuti = $(this).data("id_cuti");
        swal({
            title: "Approve pengajuan ?",
            text: "Anda tidak dapat mengembalikannya.!!",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#17bf5e",
            confirmButtonText: "Ya, lanjutkan!",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm){
            if(isConfirm){
                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "<?= base_url('cuti/approve_cuti') ?>",
                    "method": "POST",
                    "data": {
                        "id_cuti": id_cuti
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

    $("#jam_masuk").hide();
    $("#jam_keluar").hide();
    $( "#jenis_cuti" ).change(function() {
       var val = $("#jenis_cuti").val();
        console.log(val);
        if (val == 3) {
            $("#jam_masuk").show();
            $("#jam_keluar").show();
        } else {
            $("#jam_masuk").hide();
            $("#jam_keluar").hide();
        }
    });
</script>