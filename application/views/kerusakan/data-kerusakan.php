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

        <h2>Kerusakan</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Kerusakan</a></strong></li>

        </ol>

    </div>

</div>
<!-- <?php echo "<pre>", print_r($bahan, 1), "</pre>"; ?> -->
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata("success") ?>"></div>
                <div class="flash-data_edit" data-flashdata="<?php echo $this->session->flashdata("success") ?>"></div>

                <div class="flash-data_error" data-flashdata="<?php echo $this->session->flashdata("error") ?>"></div>  
                <div class="ibox-content">
                    <button data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-info " type="button"><i class="fa fa-plus"></i> Add Kerusakan</button>
                    <br>
                    <br>    
                    <div class="table-responsive">
                    <table id="table_tukar" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="20%"><center>Nama Pembuat</center></th>
                            <th width="20%"><center>Nama Bahan</center></th>
                            <th width="20%"><center>Kerusakan</center></th>
                            <th width="15%"><center>Keterangan</center></th>
                            <!-- <th width="10%"><center>Tanggal</center></th> -->
                            <?php if($this->session->userdata('role') == 'ADMIN'){?>
                            <th width="10%"><center>Aksi</center></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($kerusakan as $k) { ?>
                            <tr>
                                <td><center><?php echo $i; ?></center></td>
                                <td><center>
                                    <?php echo 
                                    "<strong>".$k->full_name."</strong>"."<br><br>".
                                        $k->no_pesanan."<br><br>"; 
                                    ?>
                                    </center>
                                </td>
                                <td>
                                    <p style='text-align: left;'> <?php echo "Jenis : ".$k->jenis_bahan; ?></p> 
                                    <p style='text-align: left;'> <?php echo "Kategori : ".$k->nama_kategori; ?></p>
                                </td>
                                <td>
                                    <p style='text-align: left;'> <?php echo "Jumlah : ".$k->jumlah_kerusakan; ?></p>
                                    <p style='text-align: left;'> <?php echo "Total : "."Rp ".number_format($k->total_harga); ?></p>
                                    <p style='text-align: left;'> <?php echo "Status : ".$k->status_bahan; ?></p>
                                </td>
                                <td>
                                    <p style='text-align: left;'> <?php echo "Keterangan : "."<strong>".$k->sebab_kerusakan."</strong>"; ?></p>
                                    <p style='text-align: left;'> <?php echo "Tanggal : ".date('d F Y', strtotime($k->created_date)); ?></p>
                                </td>
                                <!-- <td><?php echo date('d F Y', strtotime($k->created_date)); ?></td> -->
                                <td>
                                    <center>
                                        <!-- <button data-toggle="modal" data-target="#modalEdit<?php echo $k->id_kerusakan; ?>" class="btn btn-xs btn-warning " title="Edit" type="button"><i class="fa fa-edit"></i> Edit</button>&nbsp; -->
                                        <button id="btn_delete" title="Delete" data-id_kerusakan="<?=$k->id_kerusakan;?>" data-id_bahan="<?=$k->id_bahan;?>" data-jumlah_kerusakan="<?=$k->jumlah_kerusakan;?>" class="btn btn-xs btn-danger " type="button"><i class="fa fa-trash-o"> Delete</i> </button>
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
                <h6 class="modal-title" id="title-quis"><label>Add Kerusakan</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('kerusakan/tambah') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <!-- <input type="hidden" name="id_user" class="form-control" value="<?php echo $this->session->userdata('id_user'); ?>"> -->
                        <input type="hidden" name="no_pesanan" class="form-control" id="no_pesanan">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> User</label>
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
                            <label class="col-sm-3 control-label"> No Pesanan</label>
                            <div class="col-sm-8">
                                <select class="form-control selectadd" name="no_pesanan" required>
                                    <option value="">Pilih No Pesanan</option>
                                    <?php foreach ($no_pesanan as $no) {
                                        echo '<option value="'.$no->no_pesanan.'">'.$no->no_pesanan.'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kategori</label>
                            <div class="col-sm-8">
                                <select name="id_kategori" class="form-control selectadd" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($kategori as $k) {
                                        echo '<option value="'.$k->id_kategori.'">'.$k->nama_kategori.'</option>';
                                    } ?>
                                </select>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jenis Bahan</label>
                            <div class="col-sm-8">
                                <select name="id_bahan" class="form-control selectadd" required>
                                    <option value="">Pilih Jenis Bahan</option>
                                    <?php foreach ($bahan as $k) {
                                        echo '<option value="'.$k->id_bahan.'">'.$k->jenis_bahan.'</option>';
                                    } ?>
                                </select>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Status Bahan</label>
                            <div class="col-sm-8">
                                <div class="col-sm-12">
                                    <div class="col-sm-6">
                                        <div class="form-check" align="center">
                                            <input type="radio" name="status_bahan" value="belum cetak" >
                                            <label>Belum Cetak</label>
                                        </div> 
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check" align="center">
                                            <input type="radio" name="status_bahan" value="cetak">
                                            <label>Cetak</label>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jumlah Kerusakan</label>
                            <div class="col-sm-8">
                                <input type="number" name="jumlah_kerusakan" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Deskripsi</label>
                            <div class="col-sm-8">
                                <textarea type="text" name="sebab_kerusakan" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-11">
                            <button style="width: 106px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>&nbsp;
                            <button style="width: 106px;" type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $q=1; foreach ($kerusakan as $k) { ?>
<div class="modal inmodal fade" id="modalEdit<?php echo $k->id_kerusakan; ?>" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Edit Kerusakan</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('kerusakan/edit') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="id_user" class="form-control" value="<?php echo $k->id_user; ?>">
                        <input type="hidden" name="id_kerusakan" class="form-control" value="<?php echo $k->id_kerusakan; ?>">
                        <input type="hidden" name="no_pesanan" class="form-control" id="no_pesanan">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kategori</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="id_kategori" required>
                                    <option value="">Pilih Kategori</option>
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
                            <label class="col-sm-3 control-label">Jenis Bahan</label>
                            <div class="col-sm-8">
                                <select class="form-control select2"  name="id_bahan" required >
                                    <option value="">Pilih Jenis Bahan</option>
                                    <?php 
                                        foreach ($bahan as $ba) {
                                            $selected = "";
                                            if ($ba->id_bahan == $k->id_bahan) {
                                                $selected = 'selected';
                                            }
                                            echo '<option value="'.$ba->id_bahan.'"'.$selected.'>'.$ba->jenis_bahan.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Status Bahan</label>
                            <div class="col-sm-8">
                                <div class="col-sm-12">
                                    <div class="col-sm-6">
                                        <div class="form-check" align="center">
                                            <input type="radio" <?php echo ($k->status_bahan == 'belum cetak' ? ' checked' : ''); ?>  name="status_bahan" value="belum cetak">
                                        <label> Belum Cetak </label> 
                                        </div> 
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check" align="center">
                                            <input type="radio" <?php echo ($k->status_bahan == 'cetak' ? ' checked' : ''); ?>  name="status_bahan" value="cetak">
                                        <label> Cetak </label> 
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jumlah Kerusakan</label>
                            <div class="col-sm-8">
                                <input type="number" name="jumlah_kerusakan" class="form-control" value="<?php echo $k->jumlah_kerusakan ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Deskripsi</label>
                            <div class="col-sm-8">
                                <textarea type="text" name="sebab_kerusakan" class="form-control" rows="5"><?php echo $k->sebab_kerusakan; ?></textarea>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-11">
                            <button style="width: 106px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                            <button style="width: 106px;" type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    
</script>
<?php $q++; } ?>
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
                // text: 'Berhasil Ditambahkan',
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
                // text: 'Gagal, Tidak Dapat Menyimpan',
                type: 'error'
            });
        } else{

        }
    });

    $(document).on("click", "#btn_delete", function(e){
        var id_kerusakan = $(this).data("id_kerusakan");
        var id_bahan     = $(this).data("id_bahan");
        var jumlah_kerusakan     = $(this).data("jumlah_kerusakan");
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
                    "url": "<?= base_url('kerusakan/delete_kerusakan') ?>",
                    "method": "POST",
                    "data": {
                        "id_kerusakan": id_kerusakan,
                        "id_bahan": id_bahan,
                        "jumlah_kerusakan": jumlah_kerusakan
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