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

        <h2>Customer</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Customer</a></strong></li>

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
                    <button style="width: 110px;" data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-info" type="button"><i class="fa fa-plus"></i> Add Customer</button>
                    <br>
                    <br>
                    <div class="table-responsive">
                    <table id="table_tukar" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="25%"><center>Nama Customer</center></th>
                            <th width="15%"><center>Telp / WA</center></th>
                            <th width="35%"><center>Alamat</center></th>
                            <?php if($this->session->userdata('role') == 'ADMIN'){?>
                            <th width="20%"><center>Aksi</center></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($customer as $k) { ?>
                            <tr>
                                <td><center><?php echo $i; ?></center></td>
                                <td><?php echo $k->nama_customer; ?></td>
                                <td><a href="https://api.whatsapp.com/send?phone=<?php echo $k->wa_customer; ?>&text=Hai%20kak%20<?php echo $k->nama_customer; ?>, perkenalkan kami customer service dari *Emcorp Studio (Studio Print)*  ." target="_blank"><?php echo $k->wa_customer; ?></a></td>
                                <td><?php echo $k->alamat_customer; ?></td>
                                <td>
                                    <center>
                                        <button style="width: 70px;" data-toggle="modal" data-target="#modalEdit<?php echo $k->id_customer; ?>" class="btn btn-xs btn-warning " title="Edit" type="button"><i class="fa fa-edit"></i> Edit</button>&nbsp;
                                        <button style="width: 70px;" id="btn_delete" title="Delete" data-id_customer="<?=$k->id_customer;?>" class="btn btn-xs btn-danger " type="button"><i class="fa fa-trash-o"></i> Delete</button>
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
                <h6 class="modal-title" id="title-quis"><label id="label_id">Add Customer</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('customer/tambah') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Customer</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_customer" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Telp / WA</label>
                        <div class="col-sm-8">
                            <input type="number" name="wa_customer" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kabupaten</label>
                        <div class="col-sm-8">
                            <input type="text" name="kabupaten_customer" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Provinsi</label>
                        <div class="col-sm-8">
                            <input type="text" name="provinsi_customer" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Alamat</label>
                        <div class="col-sm-8">
                            <textarea type="text" name="alamat_customer" class="form-control" rows="3" required=""></textarea>
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

<?php $i=1; foreach ($customer as $k) { ?>
<div class="modal inmodal fade" id="modalEdit<?php echo $k->id_customer; ?>" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Edit Customer</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('customer/edit') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id_customer" class="form-control" value="<?php echo $k->id_customer; ?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Customer</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_customer" value="<?php echo $k->nama_customer; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Telp / WA</label>
                        <div class="col-sm-8">
                            <input type="number" name="wa_customer" class="form-control" value="<?php echo $k->wa_customer; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kabupaten</label>
                        <div class="col-sm-8">
                            <input type="text" name="kabupaten_customer" class="form-control" value="<?php echo $k->kabupaten_customer; ?>"required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Provinsi</label>
                        <div class="col-sm-8">
                            <input type="text" name="provinsi_customer" class="form-control" value="<?php echo $k->provinsi_customer; ?>"required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Alamat</label>
                        <div class="col-sm-8">
                            <textarea type="text" name="alamat_customer" class="form-control" rows="3" required=""><?php echo $k->alamat_customer;?></textarea>
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
        var id_customer = $(this).data("id_customer");
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
                    "url": "<?= base_url('customer/delete_customer') ?>",
                    "method": "POST",
                    "data": {
                        "id_customer": id_customer
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