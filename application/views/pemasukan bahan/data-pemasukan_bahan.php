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
    body.modal-open .datepicker {
      z-index: 99999999 !important;
     /* width: 20%;
      height: 85%;*/
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-10">

        <h2>Pembelian Bahan</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Pembelian Bahan</a></strong></li>

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
                    <button data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-info " type="button"><i class="fa fa-plus"></i> Add Pembelian Bahan</button>
                    <br>
                    <br>    
                    <div class="table-responsive">
                    <table id="table_tukar" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="20%"><center>Nama Bahan</center></th>
                            <th width="18%"><center>Nama Supplier</center></th>
                            <th width="7%"><center>Jumlah</center></th>
                            <th width="10%"><center>Harga Satuan</center></th>
                            <th width="10%"><center>Harga Total</center></th>
                            <th width="15%"><center>Tanggal Beli</center></th>
                            <th width="15%"><center>Deskripsi</center></th>
                            <!-- <?php if($this->session->userdata('role') == 'ADMIN'){?>
                            <th width="20%"><center>Aksi</center></th>
                            <?php } ?> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($pemasukan_bahan as $k) { ?>
                            <tr>
                                <td><center><?php echo $i; ?></center></td>
                                <td><?php echo $k->jenis_bahan; ?></td>
                                <td><?php echo $k->nama_supplier ?></td>
                                <td><?php echo $k->jumlah ?></td>
                                <td><?php echo "Rp".number_format($k->harga_satuan);?></td>
                                <td><?php echo "Rp".number_format($k->harga_total);?></td>
                                <td><?php echo date('d F Y', strtotime($k->tanggal_beli)); ?></td>
                                <td><?php echo $k->deskripsi; ?></td>
                                <!-- <td>
                                    <center>
                                        <button style="width: 70px;" data-toggle="modal" data-target="#modalEdit<?php echo $k->id_pemasukan_bahan; ?>" class="btn btn-xs btn-warning " title="Edit" type="button"><i class="fa fa-edit"></i> Edit</button>&nbsp;
                                        <button style="width: 70px;" id="btn_delete" title="Delete" data-id_pemasukan_bahan="<?=$k->id_pemasukan_bahan;?>" data-id_bahan="<?=$k->id_bahan;?>" data-jumlah="<?=$k->jumlah;?>" class="btn btn-xs btn-danger " type="button"><i class="fa fa-trash-o"> Delete</i> </button>
                                    </center>
                                </td> -->
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
    <!-- <div class="modal inmodal" id="modalAdd" role="dialog" aria-hidden="true"> -->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label>Add Pembelian Bahan</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('pemasukan_bahan/tambah') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <!-- <input type="hidden" name="id_user" class="form-control" value="<?php echo $this->session->userdata('id_user'); ?>"> -->
                        <input type="hidden" name="no_pesanan" class="form-control" id="no_pesanan">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Bahan</label>
                            <div class="col-sm-8">
                                <select class="form-control selectadd" name="id_bahan" required>
                                    <option value="">Pilih Bahan</option>
                                    <?php foreach ($bahan as $ba) {
                                        echo '<option value="'.$ba->id_bahan.'">'.$ba->jenis_bahan.'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Supplier</label>
                            <div class="col-sm-8">
                                <select class="form-control selectadd" name="id_supplier" required>
                                    <option value="">Pilih Supplier</option>
                                    <?php foreach ($supplier as $su) {
                                        echo '<option value="'.$su->id_supplier.'">'.$su->nama_supplier.'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jumlah</label>
                            <div class="col-sm-8">
                                <input type="number" name="jumlah" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Harga Satuan</label>
                            <div class="col-sm-8">
                                <input type="number" name="harga_satuan" class="form-control" min="0" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Harga Total</label>
                            <div class="col-sm-8">
                                <input type="number" name="harga_total" class="form-control" min="0" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tanggal Beli</label>
                            <div id="bahan">
                            <div class="col-sm-8">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar">
                                        </i></span>
                                    <input type="text" value="<?php echo date('d-m-Y')?>" class="form-control" name="tanggal_beli" required >
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Deskripsi</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" type="text" name="deskripsi" required rows="3"></textarea>
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

<?php $q=1; foreach ($pemasukan_bahan as $k) { ?>
<div class="modal inmodal fade" id="modalEdit<?php echo $k->id_pemasukan_bahan; ?>" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                <form action="<?php echo base_url('pemasukan_bahan/edit') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="id_pemasukan_bahan" class="form-control" value="<?php echo $k->id_pemasukan_bahan; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Bahan</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="id_bahan" required>
                                    <option value="">Pilih Bahan</option>
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
                            <label class="col-sm-3 control-label">Supplier</label>
                            <div class="col-sm-8">
                                <select class="form-control select2"  name="id_supplier" required >
                                    <option value="">Pilih Supplier</option>
                                    <?php 
                                        foreach ($supplier as $su) {
                                            $selected = "";
                                            if ($su->id_supplier == $k->id_supplier) {
                                                $selected = 'selected';
                                            }
                                            echo '<option value="'.$su->id_supplier.'"'.$selected.'>'.$su->nama_supplier.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jumlah</label>
                            <div class="col-sm-8">
                                <input type="number" name="jumlah" class="form-control" value="<?php echo $k->jumlah ?>" min="1" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Harga Satuan</label>
                            <div class="col-sm-8">
                                <input type="number" name="harga_satuan" class="form-control" value="<?php echo $k->harga_satuan ?>" min="1" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Harga Total</label>
                            <div class="col-sm-8">
                                <input type="number" name="harga_total" class="form-control" value="<?php echo $k->harga_total ?>" min="1" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tanggal Beli</label>
                            <div class="col-sm-8" id="data_add">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar">
                                        </i></span>
                                    <input type="text" class="form-control" name="tanggal_beli" required="" value="<?php echo date("d-m-Y", strtotime($k->tanggal_beli)); ?>">
                                </div>
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

        $('#bahan .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format:'dd-mm-yyyy'
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
        var id_pemasukan_bahan = $(this).data("id_pemasukan_bahan");
        var id_bahan    = $(this).data("id_bahan");
        var jumlah      = $(this).data("jumlah");
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
                    "url": "<?= base_url('pemasukan_bahan/delete_pemasukan_bahan') ?>",
                    "method": "POST",
                    "data": {
                        "id_pemasukan_bahan": id_pemasukan_bahan,
                        "id_bahan": id_bahan,
                        "jumlah": jumlah
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
<!-- 
<script type="text/javascript">
    $(document).ready(function(){
        $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format:'dd-mm-yyyy'
        });
    });
</script> -->