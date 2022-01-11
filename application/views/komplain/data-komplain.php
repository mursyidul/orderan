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

    .gambar_komplain {
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

        <h2>Komplain</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Komplain</a></strong></li>

        </ol>

    </div>

</div>
<!-- <?php echo "<pre>", print_r($pemasukan, 1), "</pre>"; ?> -->
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata("success") ?>"></div>

                <div class="flash-data_error" data-flashdata="<?php echo $this->session->flashdata("error") ?>"></div>  
                <div class="ibox-content">
                    <button style="width: 110px;" data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-info" type="button"><i class="fa fa-plus"></i> Add Komplain</button>
                    <br>
                    <br>
                    <div class="table-responsive">
                    <table id="table_tukar" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="15%"><center>Penanggung Jawab</center></th>
                            <th width="10%"><center>Nama Produk</center></th>
                            <th width="12%"><center>Harga</center></th>
                            <th width="8%"><center>Status</center></th>
                            <th width="12%"><center>Katerangan</center></th>
                            <th width="20%"><center>Detail</center></th>
                            <th width="18%"><center>Aksi</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($komplain as $k) { ?>
                            <tr>
                                <td><center><?php echo $i; ?></center></td>
                                <td>
                                    <center>
                                        <?php if($k->upload_gambar != ""){ ?>
                                            <img class="img-thumbnail" src="<?php echo base_url() ?>./file/komplain/<?=$k->upload_gambar;?>" style="max-width: 120px; width: auto; max-height: 120px;">
                                        <?php } else { ?>
                                            <img class="img-thumbnail" src="<?php echo base_url() ?>./assets/images/no_image.jpg" style="max-width: 120px; width: auto; max-height: 120px;">
                                        <?php } ?>
                                        <br>
                                        <br>
                                        <?php echo $k->full_name."<br>".$k->no_pesanan; ?>
                                    </center>
                                </td>
                                <td><?php echo $k->deskripsi;?></td>
                                <!-- <td><?php echo $k->nama_kategori;?></td> -->
                                <td>
                                    <p style='text-align: left;'> <?php echo "Nominal : "."Rp.".number_format($k->nominal); ?></p>
                                    <p style='text-align: left;'> <?php echo "Ongkos Kirim : "."Rp.".number_format($k->ongkos_kirim); ?></p>
                                </td>
                                <td><?php echo $k->status; ?></td>
                                <td><?php echo $k->keterangan;?></td>
                                <td>
                                    <p style='text-align: left;'> <?php echo "Permintaan Komplain : "."<strong>".$k->permintaan_komplain."</strong>"; ?></p>
                                    <p style='text-align: left;'> <?php echo "Tanggapan Komplain : "."<strong>".$k->tanggapan_atas_komplain."</strong>"; ?></p>
                                    <p style='text-align: left;'> <?php echo "Kerusakan : "."<strong>".$k->nama_kategori."</strong>"; ?></p>
                                    <p style='text-align: left;'><?php echo "Tanggal : "."<strong>".date('d F Y', strtotime($k->created_date))."</strong>"; ?></p>
                                </td>
                                <td>
                                    <center>
                                        <button style="width: 70px;" data-toggle="modal" data-target="#modalEdit<?php echo $k->id_komplain; ?>" class="btn btn-xs btn-warning " title="Edit" type="button"><i class="fa fa-edit"></i> Edit</button>&nbsp;
                                        <button style="width: 70px;" id="btn_delete" title="Delete" data-id_komplain="<?=$k->id_komplain;?>" class="btn btn-xs btn-danger " type="button"><i class="fa fa-trash-o"></i> Delete</button>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Add Komplain</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('komplain/tambah') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <center><label><h3>Gambar</h3></label></center> -->
                            <input type='file' id='gambar' name="gambar" accept=".jpg, .png, .jpeg" class="gambar_komplain" onchange="showGambar(event)" required>
                            <center><img class="img-thumbnail" id="show_gambar1" src="<?php echo base_url() ?>./assets/images/no_image.jpg" style="max-width: 280px; width: auto; max-height: 230px;"></center>
                        <br>
                        <!-- <p style="color: red;">*Masukkan gambar dengan ukuran 800 x 600 supaya hasil maksimal</p> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Produk</label>
                        <div class="col-sm-8">
                            <select class="form-control selectadd" name="id_product" required>
                                <option value="">Pilih Nama Produk</option>
                                <?php foreach ($produk as $pro) {
                                    echo '<option value="'.$pro->id_product.'">'.$pro->deskripsi.'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Penanggung Jawab</label>
                        <div class="col-sm-8">
                            <select class="form-control selectadd" name="id_user" required>
                                <option value="">Pilih Penanggung Jawab</option>
                                <?php foreach ($user as $u) {
                                    echo '<option value="'.$u->id_user.'">'.$u->full_name.'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kategori Kerusakan</label>
                        <div class="col-sm-8">
                            <select class="form-control selectadd" name="id_kategori" required>
                                <option value="">Pilih Kategori Kerusakan</option>
                                <?php foreach ($kategori as $ka) {
                                    echo '<option value="'.$ka->id_kategori.'">'.$ka->nama_kategori.'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Permintaan Komplain</label>
                        <div class="col-sm-8">
                            <select class="form-control selectadd" name="permintaan_komplain" required>
                                <option value="">Pilih Permintaan Komplain</option>
                                <option value="Kirim Ulang">Kirim Ulang</option>
                                <option value="Konfirmasi">Konfirmasi</option>
                                <option value="Refund">Refund</option>
                                <option value="Return">Return</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggapan Atas Komplain</label>
                        <div class="col-sm-8">
                            <select class="form-control selectadd" name="tanggapan_atas_komplain" required>
                                <option value="">Pilih Tanggapan Atas Komplain</option>
                                <option value="Mendiskusikan">Mendiskusikan</option>
                                <option value="Mengirim Ulang Paket">Mengirim Ulang Paket</option>
                                <option value="Refund">Refund</option>
                                <option value="Return">Return</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No Pesanan</label>
                        <div class="col-sm-8">
                            <input type="text" name="no_pesanan" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nominal</label>
                        <div class="col-sm-8">
                            <input type="number" name="nominal" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Ongkos Kirim</label>
                        <div class="col-sm-8">
                            <input type="number" name="ongkos_kirim" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-8">
                            <select class="form-control selectadd" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Abaikan">Abaikan</option>
                                <option value="Belum">Belum</option>
                                <option value="Clear">Clear</option>
                                <option value="Sudah Dikirim">Sudah Dikirim</option>
                            </select>
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

<?php $i=1; foreach ($komplain as $k) { ?>
<div class="modal inmodal fade" id="modalEdit<?php echo $k->id_komplain; ?>" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Edit Komplain</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('komplain/edit') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id_komplain" class="form-control" value="<?php echo $k->id_komplain; ?>">
                    <div class="row">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <center><label><h3>Gambar</h3></label></center> -->
                            <input type='file' id='gambar' name="gambar" accept=".jpg, .png, .jpeg" class="edit_gambar" onchange="showGambar_edit(<?= $k->id_komplain ?>)">
                            <?php if($k->upload_gambar != ""){ ?>
                            <center><img class="img-thumbnail" id="show_gambar_edit<?= $k->id_komplain ?>" src="<?php echo base_url() ?>./file/komplain/<?= $k->upload_gambar; ?>" style="max-width: 280px; width: auto; max-height: 230px;">
                            <?php } else { ?>
                            <center><img class="img-thumbnail" id="show_gambar_edit<?= $k->id_komplain ?>" src="<?php echo base_url() ?>./assets/images/no_image.jpg" style="max-width: 280px; width: auto; max-height: 230px;">
                            <?php } ?>
                        <br>
                        <br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Produk</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_product" required>
                                <option value="">Pilih Nama Produk</option>
                                <?php 
                                    foreach ($produk as $ka) {
                                        $selected = "";
                                        if ($ka->id_product == $k->id_product) {
                                            $selected = 'selected';
                                        }
                                        echo '<option value="'.$ka->id_product.'"'.$selected.'>'.$ka->deskripsi.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Penanggung Jawab</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_user" required>
                                <option value="">Pilih Penanggung Jawab</option>
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
                        <label class="col-sm-3 control-label">Kategori Kerusakan</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_kategori" required>
                                <option value="">Pilih Kategori Kerusakan</option>
                                <?php 
                                    foreach ($kategori as $ka) {
                                        $selected = "";
                                        if ($ka->id_kategori == $k->id_kategori) {
                                            $selected = 'selected';
                                        }
                                        echo '<option value="'.$ka->id_kategori.'"'.$selected.'>'.$ka->nama_kategori.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Permintaan Komplain</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="permintaan_komplain" required>
                                <option value="">Pilih Permintaan Komplain</option>
                                <option value="Kirim Ulang" <?php if($k->permintaan_komplain == "Kirim Ulang"){echo "selected";} ?>>Kirim Ulang</option>
                                <option value="Konfirmasi" <?php if($k->permintaan_komplain == "Konfirmasi"){echo "selected";} ?>> Konfirmasi</option>
                                <option value="Refund" <?php if($k->permintaan_komplain == "Refund"){echo "selected";} ?>>Refund</option>
                                <option value="Return" <?php if($k->permintaan_komplain == "Return"){echo "selected";} ?>>Return</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggapan Atas Komplain</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="tanggapan_atas_komplain" required>
                                <option value="">Pilih Tanggapan Atas Komplain</option>
                                <option value="Mendiskusikan" <?php if($k->tanggapan_atas_komplain == "Mendiskusikan"){echo "selected";} ?>>Mendiskusikan</option>
                                <option value="Mengirim Ulang Paket" <?php if($k->tanggapan_atas_komplain == "Mengirim Ulang Paket"){echo "selected";} ?>> Mengirim Ulang Paket</option>
                                <option value="Refund" <?php if($k->tanggapan_atas_komplain == "Refund"){echo "selected";} ?>>Refund</option>
                                <option value="Return" <?php if($k->tanggapan_atas_komplain == "Return"){echo "selected";} ?>>Return</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">No Pesanan</label>
                        <div class="col-sm-8">
                            <input type="text" name="no_pesanan" class="form-control" value="<?php echo $k->no_pesanan; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nominal</label>
                        <div class="col-sm-8">
                            <input type="number" name="nominal" class="form-control" value="<?php echo $k->nominal; ?>" min="0" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Ongkos Kirim</label>
                        <div class="col-sm-8">
                            <input type="number" name="ongkos_kirim" class="form-control" value="<?php echo $k->ongkos_kirim; ?>" min="0" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Abaikan" <?php if($k->status == "Abaikan"){echo "selected";} ?>>Abaikan</option>
                                <option value="Belum" <?php if($k->status == "Belum"){echo "selected";} ?>> Belum</option>
                                <option value="Clear" <?php if($k->status == "Clear"){echo "selected";} ?>>Clear</option>
                                <option value="Sudah Dikirim" <?php if($k->status == "Sudah Dikirim"){echo "selected";} ?>>Sudah Dikirim</option>
                            </select>
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
        var id_komplain = $(this).data("id_komplain");
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
                    "url": "<?= base_url('komplain/delete_komplain') ?>",
                    "method": "POST",
                    "data": {
                        "id_komplain": id_komplain
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
</script>