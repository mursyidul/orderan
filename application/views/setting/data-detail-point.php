<style type="text/css">
    .hadiah_class {
        position:absolute;
        left: 0px;
        width: auto; 
        height: 90%;
        width: 100%;
        opacity: 0;
        /*background: #00f;*/
        z-index:999;
    }
    .hadiah_edit {
        position:absolute;
        left: 0px;
        height: 90%;
        width: 90%;
        opacity: 0;
        /*background: #00f;*/
        z-index:999;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Hadiah</h2>
        <ol class="breadcrumb">
            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="active"><strong><a href="<?php echo base_url('tukar_point'); ?>">List Point</a></strong></li>
            <li class="active"><strong><a>Detail Hadiah</a></strong></li>
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
                    <center><h2><strong><?php echo $point->tukar_point." POINT"; ?></strong></h2></center>
                    <button data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-info " type="button"><i class="fa fa-plus"></i> Add hadiah</button>
                    <div class="table-responsive">
                    <table id="table_detail" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                        <th width="5%">No</th>
                        <th width="30%"><center>Gambar</center></th>
                        <th width="20%"><center>Hadiah</center></th>
                        <th width="25%"><center>Keterangan</center></th>
                        <?php if($this->session->userdata('role')=='ADMIN'){?>
                        <th width="20%"><center>Aksi</center></th>
                        <?php } ?>
                    </tr>
                   </thead>
                    <tbody>
                        <?php $i=1; foreach ($detail_hadiah as $k) { ?>
                            <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <center>
                                    <img class="img-thumbnail" src="<?php echo base_url() ?>./file/dokumen/<?=$k->gambar_point;?>" style="max-width: 120px; width: auto; max-height: 120px;">
                                </center>
                            </td>
                            <td><?php echo $k->barang_point; ?></td>
                            <td><?php echo $k->keterangan; ?></td>
                            <td>
                                <center>
                                    <button style="width: 70px;" data-toggle="modal" data-target="#modalEdit<?php echo $k->id_detail_point; ?>" class="btn btn-xs btn-warning " title="Edit" type="button"><i class="fa fa-edit"></i> Edit</button>&nbsp;
                                    <button style="width: 70px;" id="btn_delete" title="Delete" data-id_detail_point="<?=$k->id_detail_point;?>" class="btn btn-xs btn-danger " type="button"><i class="fa fa-trash-o"></i> Delete</button>
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
                <h6 class="modal-title" id="title-quis"><label>Add Hadiah</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('tukar_point/tambah_detail') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <center><label><h3>Gambar</h3></label></center> -->
                            <input type='file' id='gambar_bogie' name="gambar_detail" accept=".jpg, .png, .jpeg" class="hadiah_class" onchange="showHadiah(event)">
                            <center><img class="img-thumbnail" id="show_hadiah" src="<?php echo base_url() ?>./assets/images/no_image.jpg" style="max-width: 280px; width: auto; max-height: 230px;"><br>
                        <br>
                        <p style="color: red;">*Masukkan gambar dengan ukuran 800 x 600 supaya hasil maksimal</p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Hadiah</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="barang_point" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="keterangan" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_tukar_point" value="<?php echo $point->id_tukar_point; ?>">
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

<?php $i=1; foreach ($detail_hadiah as $k) { ?>
<div class="modal inmodal fade" id="modalEdit<?php echo $k->id_detail_point; ?>" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label>Edit Hadiah</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('tukar_point/edit_detail') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="id_detail_point" class="form-control" value="<?php echo $k->id_detail_point; ?>">
                        <div class="col-md-12">
                            <!-- <center><label><h3>Icon</h3></label></center> -->
                            <input type='file' id='gambar_bogie' name="gambar_detail" accept=".jpg, .png, .jpeg" class="hadiah_edit" onchange="showHadiah_edit(<?=$k->id_detail_point;?>)">
                            <center><img class="img-thumbnail" id="showHadiah_edit<?=$k->id_detail_point; ?>" src="<?php echo base_url() ?>./file/dokumen/<?= $k->gambar_point; ?>" style="max-width: 280px; width: auto; max-height: 230px;">

                        <br>
                        <br>
                        <p style="color: red;">*Masukkan gambar dengan ukuran 800 x 600 supaya hasil maksimal</p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Hadiah</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="barang_point" value="<?php echo $k->barang_point; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="keterangan" rows="4"> <?php echo $k->keterangan; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_tukar_point" value="<?php echo $point->id_tukar_point; ?>">
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>&nbsp;
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>   
<?php } ?>


<script>
    $(document).ready(function(){
        $("#table_detail").dataTable();
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

    $(document).on("click", "#btn_delete", function(e){
        var id_detail_point = $(this).data("id_detail_point");
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
                    "url": "<?= base_url('tukar_point/detele_detail_point') ?>",
                    "method": "POST",
                    "data": {
                        "id_detail_point": id_detail_point
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

    var showHadiah = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
          var output = document.getElementById('show_hadiah');
          var image_size = event.target.files[0].size;
          // if (image_size <= 2000000) {
            output.src = reader.result;
          // } else {
          //   $('.company_class').val("");
          //   $('#show_image').attr('src', '../assets/images/no_image.jpg');
          //   alert('Image size maksimal 2 MB!');
          // }
        };
        reader.readAsDataURL(event.target.files[0]);
    };

    showHadiah_edit = function($id) {
        var input = event.target;

        var reader = new FileReader();
        reader.onload = function(){
          var dataURL = reader.result;
          var output = document.getElementById('showHadiah_edit'+$id);
          output.src = reader.result;
        };
        reader.readAsDataURL(input.files[0]);
    };

</script>