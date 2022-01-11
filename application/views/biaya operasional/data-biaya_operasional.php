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

        <h2>Biaya Operasional</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Biaya Operasional</a></strong></li>

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
                    <div class="table-responsive">
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
                            <div class="col-md-6">
                                <button style="margin-top: 25px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Search</button>
                                <button style="width: 180px; margin-top: 25px;"data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-info" type="button"><i class="fa fa-plus"></i> Add Biaya Operasional</button>
                            </div>
                            
                        </form>
                    </div>
                    <table id="table_tukar" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="25%"><center>Nama Kategori</center></th>
                            <th width="10%"><center>Harga Satuan</center></th>
                            <th width="10%"><center>Total Biaya</center></th>
                            <th width="20%"><center>Katerangan</center></th>
                            <th width="10%"><center>Tanggal</center></th>
                            <?php if($this->session->userdata('role') == 'ADMIN'){?>
                            <th width="20%"><center>Aksi</center></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($biaya as $k) { ?>
                            <tr>
                                <td><center><?php echo $i; ?></center></td>
                                <td><?php echo $k->nama_kategori; ?></td>
                                <td><?php echo "Rp".number_format($k->satuan_biaya);?></td>
                                <td><?php echo "Rp".number_format($k->total_biaya);?></td>
                                <td><?php echo $k->keterangan;?></td>
                                <td><?php echo date('d F Y', strtotime($k->tanggal)); ?></td>
                                <td>
                                    <center>
                                        <button style="width: 70px;" data-toggle="modal" data-target="#modalEdit<?php echo $k->id_biaya; ?>" class="btn btn-xs btn-warning " title="Edit" type="button"><i class="fa fa-edit"></i> Edit</button>&nbsp;
                                        <button style="width: 70px;" id="btn_delete" title="Delete" data-id_biaya="<?=$k->id_biaya;?>" class="btn btn-xs btn-danger " type="button"><i class="fa fa-trash-o"></i> Delete</button>
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
                <h6 class="modal-title" id="title-quis"><label id="label_id">Add Biaya Operasional</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('biaya_operasional/tambah') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kategori</label>
                        <div class="col-sm-8">
                            <select class="form-control selectadd" name="id_operasional" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategori as $ka) {
                                    echo '<option value="'.$ka->id_operasional.'">'.$ka->nama_kategori.'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Harga Satuan</label>
                        <div class="col-sm-8">
                            <input type="number" name="satuan_biaya" class="form-control" min="1" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Total Biaya</label>
                        <div class="col-sm-8">
                            <input type="number" name="total_biaya" class="form-control" min="1" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal</label>
                        <div id="tanggal">
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar">
                                    </i></span>
                                <input type="text" value="<?php echo date('d-m-Y')?>" class="form-control" name="tanggal" required >
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"> Keterangan</label>
                        <div class="col-sm-8">
                            <textarea type="text" name="keterangan" class="form-control" required rows="3"></textarea>
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

<?php $i=1; foreach ($biaya as $k) { ?>
<div class="modal inmodal fade" id="modalEdit<?php echo $k->id_biaya; ?>" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Edit Biaya Operasional</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('biaya_operasional/edit') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id_biaya" class="form-control" value="<?php echo $k->id_biaya; ?>">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kategori</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="id_operasional" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php 
                                        foreach ($kategori as $ka) {
                                            $selected = "";
                                            if ($ka->id_operasional == $k->id_operasional) {
                                                $selected = 'selected';
                                            }
                                            echo '<option value="'.$ka->id_operasional.'"'.$selected.'>'.$ka->nama_kategori.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Harga Satuan</label>
                            <div class="col-sm-8">
                                <input type="number" name="satuan_biaya" class="form-control" min="1" value="<?php echo $k->satuan_biaya; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Total Biaya</label>
                            <div class="col-sm-8">
                                <input type="number" name="total_biaya" class="form-control" min="1" value="<?php echo $k->total_biaya; ?>" required>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tanggal</label>
                            <div id="tanggal">
                            <div class="col-sm-8">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar">
                                        </i></span>
                                    <input type="text" value="<?php echo date("d-m-Y", strtotime($k->tanggal)); ?>" class="form-control" name="tanggal" required >
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Keterangan</label>
                            <div class="col-sm-8">
                                <textarea type="text" name="keterangan" class="form-control" required rows="3"><?php echo $k->keterangan; ?></textarea>
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
        var id_biaya = $(this).data("id_biaya");
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
                    "url": "<?= base_url('biaya_operasional/delete_biaya') ?>",
                    "method": "POST",
                    "data": {
                        "id_biaya": id_biaya
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
    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'dd-mm-yyyy'
    });
</script>