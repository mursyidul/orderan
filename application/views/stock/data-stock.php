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

        <h2>Stok</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Stok</a></strong></li>

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
                    <!-- <button style="width: 110px;" data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-info" type="button"><i class="fa fa-plus"></i> Add Stock</button>
                    <br>
                    <br> -->
                    <div class="table-responsive">
                    <table id="table_tukar" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="60%"><center>Jenis Bahan</center></th>
                            <th width="35%"><center>Jumlah Stok</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($stock as $k) { ?>
                            <tr>
                                <td><center><?php echo $i; ?></center></td>
                                <td><?php echo $k->jenis_bahan; ?></td>
                                <td><?php echo round($k->jumlah_stock,1)." Lembar"; ?></td>
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
<script type="text/javascript">
    $(document).ready(function(){
        $("#table_tukar").dataTable({
            // "bPaginate": false,
            // // "bLengthChange": false,
            // "bFilter": false,
            // "bInfo": false
        });
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
                // text: 'Gagal, Tidak Dapat Menyimpan Permintaan Alat Bahan.!!',
                type: 'error'
            });
        } else{

        }
    });

    // $(document).on("click", "#btn_delete", function(e){
    //     var id_roll_e = $(this).data("id_roll_e");
    //     swal({
    //         title: "Apakah anda yakin ingin menghapus ?",
    //         text: "Anda tidak dapat mengembalikannya.!!",
    //         type: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#DD6B55",
    //         confirmButtonText: "Ya, lanjutkan!",
    //         cancelButtonText: "Batal",
    //         closeOnConfirm: false,
    //         closeOnCancel: true
    //     }, function(isConfirm){
    //         if(isConfirm){
    //             var settings = {
    //                 "async": true,
    //                 "crossDomain": true,
    //                 "url": "<?= base_url('roll_e/delete_roll_e') ?>",
    //                 "method": "POST",
    //                 "data": {
    //                     "id_roll_e": id_roll_e
    //                 }
    //             }
    //             $.ajax(settings).done(function (response) {
    //                 var data = JSON.parse(response)
    //                 var message = data.message;
    //                 if(data.status == "success"){
    //                     swal({
    //                         title: "Success",
    //                         text: message,
    //                         type: "success",
    //                         confirmButtonColor: "#a5dc86",
    //                         confirmButtonText: "Close",
    //                     }, function(isConfirm){
    //                         location.reload();
    //                     });
    //                 } else {
    //                     swal("Gagal menghapus data.", message.toUpperCase(), "warning");
    //                 }
    //             });   
    //         }
    //     });
    // });
</script>