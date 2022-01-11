<style type="text/css">
    .not-allowed{
     cursor: not-allowed! important;
        
    }
</style>
<div class="wrapper wrapper-content animated fadeIn">

    <div class="row">

        <div class="col-lg-12">
            <!-- <?php echo "<pre>", print_r($tukar,1), "<?pre>"; ?> -->
            <div class="ibox float-e-margins">     
                <center><h2><strong>POINT ANDA : <?php echo $point->jumlah_point; ?></strong></h2></center>
                <br>
                <div class="row">
                <?php $i=1; foreach ($tukar as $k) { ?>
                    <?php if ($point->jumlah_point > $k->tukar_point) { ?>
                        <a id="btn_tukar" data-username ="<?= $point->username; ?>" data-tukar_point="<?=$k->tukar_point;?>" data-barang_point ="<?= $k->barang_point;?>" data-keterangan ="<?= $k->keterangan; ?>">
                        <div class="col-md-4">
                            <div class="ibox">
                                <div class="ibox-content product-box">
                                        <img class="img-thumbnail" src="<?php echo base_url() ?>./file/dokumen/<?=$k->gambar_point;?>" style="max-width: 100%; height: auto;">
                                    <div class="product-desc">
                                        <span class="product-price">
                                            <?php echo $k->tukar_point; ?> Point
                                        </span>
                                        <small class="text-muted">Category</small>
                                        <a id="btn_tukar" data-username ="<?= $point->username; ?>" data-tukar_point="<?=$k->tukar_point;?>" data-barang_point ="<?= $k->barang_point;?>" data-keterangan ="<?= $k->keterangan; ?>" class="product-name"> <?php echo $k->barang_point;?></a>
                                        <div class="small m-t-xs">
                                            <?php echo $k->keterangan; ?>
                                        </div>
                                        <div class="m-t text-center">

                                            <a id="btn_tukar" data-username ="<?= $point->username; ?>" data-tukar_point="<?=$k->tukar_point;?>" data-barang_point ="<?= $k->barang_point;?>" data-keterangan ="<?= $k->keterangan; ?>" class="btn btn-xs btn-outline btn-primary">Tukarkan </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                    <?php } else { ?>
                        <div class="col-md-4">
                            <a class="not-allowed">
                            <div class="ibox">
                                <div class="ibox-content product-box">
                                        <img class="img-thumbnail" src="<?php echo base_url() ?>./file/dokumen/<?=$k->gambar_point;?>" style="max-width: 100%; height: auto;">
                                    <div class="product-desc">
                                        <span class="product-price">
                                            <?php echo $k->tukar_point; ?> Point
                                        </span>
                                        <small class="text-muted">Category</small>
                                        <a class="product-name not-allowed"> <?php echo $k->barang_point; ?></a>
                                        <div class="small m-t-xs">
                                            <?php echo $k->keterangan; ?>
                                        </div>
                                        <div class="m-t text-center">

                                            <a class="btn btn-xs btn-outline btn-danger not-allowed">Tukarkan </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    <?php } ?>
                <?php $i++; } ?>
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
                <h6 class="modal-title" id="title-quis"><label>Pilih Hadiah</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('tukar_point/tambah_detail') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Point</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="barang_point" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Hadiah</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="barang_point" required>
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

<script type="text/javascript">
    $(document).ready(function(){
        $("#table_hadiah").dataTable();
    });

    $(document).on("click", "#btn_tukar", function(e){
        var username     = $(this).data("username");
        var tukar_point  = $(this).data("tukar_point");
        var barang_point = $(this).data("barang_point");
        var keterangan   = $(this).data("keterangan");
        swal({
            title: "Apakah anda yakin ingin menukarnya ?",
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
                    "url": "<?= base_url('tukar_hadiah/approve_hadiah') ?>",
                    "method": "POST",
                    "data": {
                        "username": username,
                        "tukar_point": tukar_point,
                        "barang_point": barang_point,
                        "keterangan": keterangan
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