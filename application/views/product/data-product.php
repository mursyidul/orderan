<style type="text/css">
    .icon_gambar {
        position:absolute;
        left: 0px;
        width: auto; 
        height: 90%;
        width: 100%;
        opacity: 0;
        /*background: #00f;*/
        z-index:999;
    }
    .edit_gambar {
        position:absolute;
        left: 0px;
        width: auto; 
        height: 90%;
        width: 100%;
        opacity: 0;
        /*background: #00f;*/
        z-index:999;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-10">

        <h2>Produk</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Produk</a></strong></li>

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
                    <button data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-info " type="button"><i class="fa fa-plus"></i> Add Produk</button>
                    <br>
                    <br>
                    <div class="table-responsive">
                    <table id="table_product" class="table table-striped table-bordered table-hover dataTables-example" >

                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="15%"><center>SKU Induk</center></th>
                            <th width="15%"><center>Harga</center></th>
                            <th width="20%"><center>Deskripsi</center></th>
                            <th width="25%"><center>Gambar</center></th>
                            <th width="20%"><center>Aksi</center></th>
                        </tr>
                   </thead>

                    <tbody>
                        <?php $i=1; foreach ($product as $k) { ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $k->nmr_sku;?></td>
                                <td><?php echo "Rp.".number_format($k->harga_produk);?></td>
                                <td><?php echo $k->deskripsi;?></td>
                                <td>
                                    <center>
                                        <img class="img-thumbnail" src="<?php echo base_url() ?>./file/dokumen/<?=$k->gambar;?>" style="max-width: 120px; width: auto; max-height: 120px;">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <button style="width: 70px;" data-toggle="modal" data-target="#modalEdit<?php echo $k->id_product; ?>" class="btn btn-xs btn-warning " title="Edit" type="button"><i class="fa fa-edit"></i> Edit</button>&nbsp;
                                        <button style="width: 70px;" id="btn_delete" title="Delete" data-id_product  ="<?=$k->id_product;?>" class="btn btn-xs btn-danger " type="button"><i class="fa fa-trash-o"> Delete</i> </button>
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
                <h6 class="modal-title" id="title-quis"><label>Add Produk</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('product/tambah_product') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <center><label><h3>Gambar</h3></label></center> -->
                            <input type='file' id='gambar' name="gambar" accept=".jpg, .png, .jpeg" class="icon_gambar" onchange="showGambar(event)">
                            <center><img class="img-thumbnail" id="show_gambar1" src="<?php echo base_url() ?>./assets/images/no_image.jpg" style="max-width: 280px; width: auto; max-height: 230px;"><br>
                        <br>
                        <p style="color: red;">*Masukkan gambar dengan ukuran 800 x 600 supaya hasil maksimal</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"> SKU Induk</label>
                        <div class="col-sm-8">
                            <input type="text" name="nmr_sku" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"> Harga</label>
                        <div class="col-sm-8">
                            <input type="text" name="harga_produk" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"> Deskripsi</label>
                        <div class="col-sm-8">
                            <textarea type="text" name="deskripsi" class="form-control" rows="5" required></textarea>
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

<?php $i=0; foreach ($product as $k) { ?>
<div class="modal inmodal fade" id="modalEdit<?php echo $k->id_product ?>" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label>Edit Produk</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('product/edit_product') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <center><label><h3>Gambar</h3></label></center> -->
                            <input type='file' id='gambar' name="gambar" accept=".jpg, .png, .jpeg" class="edit_gambar" onchange="showGambar_edit(<?= $k->id_product ?>)">
                            <center><img class="img-thumbnail" id="show_gambar_edit<?= $k->id_product ?>" src="<?php echo base_url() ?>./file/dokumen/<?= $k->gambar; ?>" style="max-width: 280px; width: auto; max-height: 230px;"><br>
                        <br>
                        <p style="color: red;">*Masukkan gambar dengan ukuran 800 x 600 supaya hasil maksimal</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">SKU Induk</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="id_product" class="form-control" value="<?php echo $k->id_product; ?>">
                            <input type="text" name="nmr_sku" class="form-control" value="<?php echo $k->nmr_sku; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Harga</label>
                        <div class="col-sm-8">
                            <input type="text" name="harga_produk" class="form-control" value="<?php echo $k->harga_produk; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"> Deskripsi</label>
                        <div class="col-sm-8">
                            <textarea type="text" name="deskripsi" class="form-control" rows="5" required><?php echo $k->deskripsi; ?></textarea>
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
        $("#table_product").dataTable();
    });



    var showGambar = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
          var output = document.getElementById('show_gambar1');
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

    showGambar_edit = function($id) {
        var input = event.target;

        var reader = new FileReader();
        reader.onload = function(){
          var dataURL = reader.result;
          var output = document.getElementById('show_gambar_edit'+$id);
          output.src = reader.result;
        };
        reader.readAsDataURL(input.files[0]);
    };


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
        var id_product = $(this).data("id_product");
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
                    "url": "<?= base_url('product/delete_product') ?>",
                    "method": "POST",
                    "data": {
                        "id_product": id_product
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