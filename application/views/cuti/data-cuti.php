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
<!-- <?php echo "<pre>", print_r($cuti, 1), "</pre>"; ?> -->
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata("success") ?>"></div>

                <div class="flash-data_error" data-flashdata="<?php echo $this->session->flashdata("error") ?>"></div>  
                <div class="ibox-content">
                    <button style="width: 110px;" data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-info" type="button"><i class="fa fa-plus"></i> Add Cuti</button>
                    <br>
                    <br>
                    <div class="table-responsive">
                    <table id="table_tukar" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="10%"><center>Jenis Cuti</center></th>
                            <th width="11%"><center>Tanggal Mulai</center></th>
                            <th width="11%"><center>Tanggal Akhir</center></th>
                            <th width="10%"><center>Jam Masuk</center></th>
                            <th width="10%"><center>Jam Keluar</center></th>
                            <th width="11%"><center>Tanggal Pengajuan</center></th>
                            <th width="12%"><center>Keterangan</center></th>
                            <th width="20%"><center>Aksi</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($cuti as $k) { ?>
                            <tr>
                                <td><center><?php echo $i; ?></center></td>
                                <td><?php echo $k['jenis_cuti']; ?></td>
                                <td><?php echo date('d F Y', strtotime($k['tanggal_mulai_cuti'])); ?></td>
                                <td>
                                    <?php 
                                    $tanggal_akhir = date('d F Y', strtotime($k['tanggal_akhir_cuti']));
                                    if ($tanggal_akhir == "01 January 1970") {
                                        echo "00-00-0000";
                                    } else {
                                    echo date('d F Y', strtotime($k['tanggal_akhir_cuti'])); 
                                    } ?>


                                </td>
                                <td><?php echo $k['jam_masuk_cuti']; ?></td>
                                <td><?php echo $k['jam_keluar_cuti']; ?></td>
                                <td><?php echo date('d F Y', strtotime($k['created_date'])); ?></td>
                                <td><?php echo $k['keterangan_cuti']; ?></td>
                                <td>
                                    <center>
                                    <?php if ($k['status_cuti'] == "") { ?>
                                        <button style="width: 70px;" data-toggle="modal" data-target="#modalEdit<?php echo $k['id_cuti']; ?>" class="btn btn-xs btn-warning " title="Edit" type="button"><i class="fa fa-edit"></i> Edit</button>&nbsp;
                                        <button style="width: 70px;" id="btn_delete" title="Delete" data-id_cuti="<?=$k['id_cuti'];?>" class="btn btn-xs btn-danger " type="button"><i class="fa fa-trash-o"></i> Delete</button>
                                    <?php } ?>
                                    <?php if (isset($k['id_transaksi'][0]['is_seen'])) { ?>
                                        <button id="save" title="Lihat" data-id_cuti="<?=$k['id_cuti'];?>" class="btn btn-sm btn-primary " type="button"><i class="fa fa-eye"></i> Lihat</button>
                                    <?php } else { ?>
                                        <?php if ($k['status_cuti'] == "APPROVE") { ?>
                                            <center><h3 style="color: green;">Status Approve</h3></center>
                                        <?php } else if($k['status_cuti'] == "REJECT") { ?>
                                            <center><h3 style="color: red;">Status Reject</h3></center>
                                        <?php } ?>
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

<div class="modal inmodal fade" id="modalAdd" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Add Cuti</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('cuti/tambah') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jenis Cuti</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_jenis_cuti" id="jenis_cuti" required>
                                <option value="">Pilih Jenis Cuti</option>
                                <?php foreach ($jenis_cuti as $k) {
                                    echo '<option value="'.$k->id_jenis_cuti.'">'.$k->jenis_cuti.'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal Mulai</label>
                        <div id="cuti">
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar">
                                    </i></span>
                                <input type="text" value="<?php echo date('d-m-Y')?>" class="form-control" name="tanggal_mulai_cuti" required >
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="form-group" id="tanggal_akhir">
                        <label class="col-sm-3 control-label">Tanggal Akhir</label>
                        <div id="cuti">
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar">
                                    </i></span>
                                <input type="text" class="form-control" name="tanggal_akhir_cuti" required value="<?php echo date('d-m-Y'); ?>">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="form-group" id="jam_masuk">
                        <label class="col-sm-3 control-label">Jam Masuk</label>
                        <div class="col-sm-8">
                            <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                <input type="text" name="jam_masuk_cuti" class="form-control"   data-readonly onkeydown="return false">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="jam_keluar">
                        <label class="col-sm-3 control-label">Jam Keluar</label>
                        <div class="col-sm-8">
                            <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                <input type="text" name="jam_keluar_cuti" class="form-control"   data-readonly onkeydown="return false">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Keterangan</label>
                        <div class="col-sm-8">
                            <textarea name="keterangan_cuti" class="form-control" required rows="3"></textarea>
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

<?php $i=1; foreach ($cuti as $k) { ?>
<div class="modal inmodal fade" id="modalEdit<?php echo $k['id_cuti']; ?>" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Edit Cuti</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('cuti/edit') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id_cuti" class="form-control" value="<?php echo $k['id_cuti']; ?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jenis Cuti</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_jenis_cuti" id="jenis_cuti<?php echo $k['id_cuti']; ?>" required>
                                <option value="">Pilih Jenis Cuti</option>
                                <?php 
                                    foreach ($jenis_cuti as $je) {
                                        $selected = "";
                                        if ($je->id_jenis_cuti == $k['id_jenis_cuti']) {
                                            $selected = 'selected';
                                        }
                                        echo '<option value="'.$je->id_jenis_cuti.'"'.$selected.'>'.$je->jenis_cuti.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal Mulai</label>
                        <div id="cuti">
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar">
                                    </i></span>
                                <input type="text" value="<?php echo date("d-m-Y", strtotime($k['tanggal_mulai_cuti'])); ?>" class="form-control" name="tanggal_mulai_cuti" required >
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="form-group" id="tanggal_akhir<?php echo $k['id_cuti']; ?>">
                        <label class="col-sm-3 control-label">Tanggal Akhir</label>
                        <div id="cuti">
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar">
                                    </i></span>
                                <input type="text"  class="form-control" name="tanggal_akhir_cuti" required 
                                value="<?php 
                                    $tanggal_akhir = date('d-m-Y', strtotime($k['tanggal_akhir_cuti']));

                                    if ($tanggal_akhir == "01-01-1970") {
                                        echo date('d-m-Y');
                                    } else {
                                        echo date('d-m-Y', strtotime($k['tanggal_akhir_cuti']));
                                    }  ?>">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="form-group" id="jam_masuk<?php echo $k['id_cuti']; ?>">
                        <label class="col-sm-3 control-label">Jam Masuk</label>
                        <div class="col-sm-8">
                            <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                <input type="text" name="jam_masuk_cuti" value="<?php echo $k['jam_masuk_cuti']; ?>" class="form-control"   data-readonly onkeydown="return false">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="jam_keluar<?php echo $k['id_cuti']; ?>">
                        <label class="col-sm-3 control-label">Jam Keluar</label>
                        <div class="col-sm-8">
                            <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                <input type="text" name="jam_keluar_cuti" value="<?php echo $k['jam_keluar_cuti']; ?>" class="form-control"   data-readonly onkeydown="return false">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Keterangan</label>
                        <div class="col-sm-8">
                            <textarea name="keterangan_cuti" class="form-control" required rows="3"><?php echo $k['keterangan_cuti']; ?></textarea>
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

<script type="text/javascript">

    if (<?php echo $k['id_jenis_cuti']; ?> == "3" ) {
        $("#tanggal_akhir<?php echo $k['id_cuti']; ?>").hide();
        $("#jam_masuk<?php echo $k['id_cuti']; ?>").show();
        $("#jam_keluar<?php echo $k['id_cuti']; ?>").show();
        $( "#jenis_cuti<?php echo $k['id_cuti']; ?>" ).change(function() {
           var val = $("#jenis_cuti<?php echo $k['id_cuti']; ?>").val();
            console.log(val);
            if (val != 3) {
                $("#tanggal_akhir<?php echo $k['id_cuti']; ?>").show();
                $("#jam_masuk<?php echo $k['id_cuti']; ?>").hide();
                $("#jam_keluar<?php echo $k['id_cuti']; ?>").hide();
            } else {
                $("#tanggal_akhir<?php echo $k['id_cuti']; ?>").hide();
                $("#jam_masuk<?php echo $k['id_cuti']; ?>").show();
                $("#jam_keluar<?php echo $k['id_cuti']; ?>").show();
            }
        });
    } else {
        $("#tanggal_akhir<?php echo $k->id_cuti; ?>").show();
        $("#jam_masuk<?php echo $k->id_cuti; ?>").hide();
        $("#jam_keluar<?php echo $k->id_cuti; ?>").hide();
        $( "#jenis_cuti<?php echo $k->id_cuti; ?>" ).change(function() {
           var val = $("#jenis_cuti<?php echo $k->id_cuti; ?>").val();
            console.log(val);
            if (val == 3) {
                $("#tanggal_akhir<?php echo $k->id_cuti; ?>").hide();
                $("#jam_masuk<?php echo $k->id_cuti; ?>").show();
                $("#jam_keluar<?php echo $k->id_cuti; ?>").show();
            } else {
                $("#tanggal_akhir<?php echo $k->id_cuti; ?>").show();
                $("#jam_masuk<?php echo $k->id_cuti; ?>").hide();
                $("#jam_keluar<?php echo $k->id_cuti; ?>").hide();
            }
        });
    }
    
</script>
<?php $i++; } ?>
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

    $(document).on("click", "#btn_delete", function(e){
        var id_cuti = $(this).data("id_cuti");
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
                    "url": "<?= base_url('cuti/delete_cuti') ?>",
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
            $("#tanggal_akhir").hide();
            $("#jam_masuk").show();
            $("#jam_keluar").show();
        } else {
            $("#tanggal_akhir").show();
            $("#jam_masuk").hide();
            $("#jam_keluar").hide();
        }
    });

    $(document).ready(function(){
    $("#save").click(function(){
        var id_cuti = $(this).data("id_cuti");
            if(id_cuti != ""){  
              $.ajax({
                
                type:"POST",
                url:"<?php echo base_url();?>cuti/change_is_seen",
                dataType: 'html',
                data:{id_cuti:id_cuti},
                success:function(response){
                    // window.location="<?php echo site_url('requesttools'); ?>";
                            location.reload();  
                },
                error:function(xhr, status, error){
         
                console.log("readyState: " + xhr.readyState);
                console.log("responseText: "+ xhr.responseText);
                console.log("status: " + xhr.status);
                console.log("text status: " + textStatus);
                console.log("error: " + error);
                }  

              });  
           }
           else{
             alert("Field is empty");
           }
      });
  });
</script>