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
</style>
<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-10">

        <h2>Task Management</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Task Management</a></strong></li>

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
                    <?php if ($this->session->userdata('role') == 'ADMIN') { ?>
                    <button style="width: 180px;" data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-info" type="button"><i class="fa fa-plus"></i> Add Task Management</button>
                    <br>
                    <br>
                    <?php } ?>
                    <div class="table-responsive">
                    <table id="table_tukar" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="20%"><center>Kepada</center></th>
                            <th width="15%"><center>Judul</center></th>
                            <th width="10%"><center>Priorty</center></th>
                            <th width="20%"><center>Katerangan</center></th>
                            <th width="10%"><center>Tanggal</center></th>
                            <th width="20%"><center>Aksi</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($task as $k) { ?>
                            <tr>
                                <td><center><?php echo $i; ?></center></td>
                                <td><?php echo $k->full_name; ?></td>
                                <td><?php echo $k->judul_task;?></td>
                                <td><?php echo $k->priorty_task;?></td>
                                <td><?php echo $k->deskripsi_task;?></td>
                                <td><?php echo date('d F Y', strtotime($k->tanggal_task)); ?></td>
                                <td>
                                    <center>
                                    <?php if ($k->status_task != "COMPLETE" && $k->status_task != "CANCEL") { ?>
                                    <?php if ($k->status_task == '') { ?>
                                        <?php if ($k->id_user == $this->session->userdata('id_user')) { ?>
                                        <button style="width: 70px;" id="btn_progres" data-id_task ="<?=$k->id_task;?>" class="btn btn-xs btn-success " type="button"><i class="fa fa-check"></i> Progres</button>
                                        <button style="width: 70px;" id="btn_cancel" title="Delete" data-id_task="<?=$k->id_task;?>" class="btn btn-xs btn-danger " type="button"><i class="fa fa-trash-o"></i> Cancel</button>
                                        <?php } ?> 
                                    <?php } else if($k->status_task == 'PROGRES') { ?>
                                        <?php if ($this->session->userdata('role') == 'DESAIN') { ?>
                                        <h4><p style="color: blue;"><?php echo $k->status_task; ?></p></h4>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if ($this->session->userdata('role') == 'ADMIN'){ ?>

                                    <?php if ($k->status_task == '') { ?>
                                        <button style="width: 80px;" id="btn_progres" data-id_task ="<?=$k->id_task;?>" class="btn btn-xs btn-success " type="button"><i class="fa fa-check"></i> Progres</button>
                                        <button style="width: 80px;" id="btn_cancel" title="Delete" data-id_task="<?=$k->id_task;?>" class="btn btn-xs btn-danger " type="button"><i class="fa fa-trash-o"></i> Cancel</button>
                                    <?php } else if ($k->status_task == 'PROGRES'){ ?>
                                        <button style="width: 80px;" id="btn_complete" data-id_task ="<?=$k->id_task;?>" class="btn btn-xs btn-primary " type="button"><i class="fa fa-check"></i> Complete</button>
                                        <button style="width: 80px;" id="btn_cancel"  data-id_task="<?=$k->id_task;?>" class="btn btn-xs btn-danger " type="button"><i class="fa fa-trash-o"></i> Cancel</button>
                                    <?php } ?>
                                        <button style="width: 80px;" data-toggle="modal" data-target="#modalEdit<?php echo $k->id_task; ?>" class="btn btn-xs btn-warning " title="Edit" type="button"><i class="fa fa-edit"></i> Edit</button>&nbsp;
                                        <button style="width: 80px;" id="btn_delete" title="Delete" data-id_task="<?=$k->id_task;?>" class="btn btn-xs btn-danger " type="button"><i class="fa fa-trash-o"></i> Delete</button>
                                    <?php } ?>
                                    <?php } else { ?>
                                        <?php if ($k->status_task == "COMPLETE") { ?>
                                        <h4><p style="color: green;">COMPLETE</p></h4>
                                        <?php } else if($k->status_task == "CANCEL") {?>
                                        <h4><p style="color: red;"> CANCEL</p></h4>
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
                <h6 class="modal-title" id="title-quis"><label id="label_id">Add Task Management</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('task/tambah') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">User</label>
                        <div class="col-sm-8">
                            <select class="form-control selectadd" name="id_user" required>
                                <option value="">Pilih User</option>
                                <?php foreach ($user as $us) {
                                    echo '<option value="'.$us->id_user.'">'.$us->full_name.'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Judul</label>
                        <div class="col-sm-8">
                            <input type="text" name="judul_task" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Priorty</label>
                        <div class="col-sm-8">
                            <select class="form-control selectadd" name="priorty_task" required>
                                <option value="">Pilih Priorty</option>
                                <option value="High">High</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal</label>
                        <div id="tanggal">
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar">
                                    </i></span>
                                <input type="text" value="<?php echo date('d-m-Y')?>" class="form-control" name="tanggal_task" required >
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"> Keterangan</label>
                        <div class="col-sm-8">
                            <textarea type="text" name="deskripsi_task" class="form-control" required rows="3"></textarea>
                        </div>
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

<?php $i=1; foreach ($task as $k) { ?>
<div class="modal inmodal fade" id="modalEdit<?php echo $k->id_task; ?>" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Edit Task Management</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('task/edit') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id_task" class="form-control" value="<?php echo $k->id_task; ?>">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">User</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="id_user" required>
                                    <option value="">Pilih User</option>
                                    <?php 
                                        foreach ($user as $us) {
                                            $selected = "";
                                            if ($us->id_user == $k->id_user) {
                                                $selected = 'selected';
                                            }
                                            echo '<option value="'.$us->id_user.'"'.$selected.'>'.$us->full_name.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Judul</label>
                            <div class="col-sm-8">
                                <input type="text" name="judul_task" class="form-control" value="<?php echo $k->judul_task; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Priorty</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="priorty_task" required>
                                    <option value="">Pilih Priorty</option>
                                    <option value="High" <?php if($k->priorty_task == "High"){echo "selected";} ?>>High</option>
                                    <option value="Low" <?php if($k->priorty_task == "Low"){echo "selected";} ?>> Low</option>
                                    <option value="Medium" <?php if($k->priorty_task == "Medium"){echo "selected";} ?>>Medium</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tanggal</label>
                            <div id="tanggal">
                            <div class="col-sm-8">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar">
                                        </i></span>
                                    <input type="text" value="<?php echo date("d-m-Y", strtotime($k->tanggal_task)); ?>" class="form-control" name="tanggal_task" required >
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Keterangan</label>
                            <div class="col-sm-8">
                                <textarea type="text" name="deskripsi_task" class="form-control" required rows="3"><?php echo $k->deskripsi_task; ?></textarea>
                            </div>
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
    $('.selectadd').select2({
        // dropdownParent: $('#modalAdd .modal-content'),
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
                title: '' + flashData,
                // title: '' + 'Data Gagal Disimpan',
                // text: 'Nama bahan sudah terdaftar',
                type: 'error'
            });
        } else{

        }
    });

    $(document).on("click", "#btn_delete", function(e){
        var id_task = $(this).data("id_task");
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
                    "url": "<?= base_url('task/delete_task') ?>",
                    "method": "POST",
                    "data": {
                        "id_task": id_task
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

    $(document).on("click", "#btn_cancel", function(e){
        var id_task = $(this).data("id_task");
        swal({
            title: "Status diubah menjadi cancel?",
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
                    "url": "<?= base_url('task/cancel_task') ?>",
                    "method": "POST",
                    "data": {
                        "id_task": id_task
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

    $(document).on("click", "#btn_progres", function(e){
        var id_task = $(this).data("id_task");
        swal({
            title: "Status diubah menjadi progres?",
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
                    "url": "<?= base_url('task/progres_task') ?>",
                    "method": "POST",
                    "data": {
                        "id_task": id_task
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

    $(document).on("click", "#btn_complete", function(e){
        var id_task = $(this).data("id_task");
        swal({
            title: "Status diubah menjadi complete?",
            text: "Anda tidak dapat mengembalikannya.!!",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#4eb676",
            confirmButtonText: "Ya, lanjutkan!",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm){
            if(isConfirm){
                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "<?= base_url('task/complete_task') ?>",
                    "method": "POST",
                    "data": {
                        "id_task": id_task
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

    $('#tanggal .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'dd-mm-yyyy'
    });
</script>