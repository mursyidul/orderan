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

        <h2>Durasi Kerja</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Durasi Kerja</a></strong></li>

        </ol>

    </div>

</div>
<!-- <?php echo "<pre>", print_r($durasi,1), "</pre>"; ?> -->
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata("success") ?>"></div>

                <div class="flash-data_error" data-flashdata="<?php echo $this->session->flashdata("error") ?>"></div>  
                <div class="ibox-content">
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
                                                echo date('d-m-Y', strtotime('-1 month')); 
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
                            <div class="col-md-8">
                                <button style="margin-top: 25px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Search</button>
                            </div>
                            
                        </form>
                    </div>
                    <div class="table-responsive">
                    <table id="table_tukar" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="27%"><center>Nama User</center></th>
                            <th width="17%"><center>Durasi Kerja</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($durasi as $k) { ?>
                            <tr>
                                <td><center><?php echo $i; ?></center></td>
                                <td><?php echo $k['full_name']; ?></td>
                                <td>
                                    <?php 
                                    if ($k['durasi'][0]['durasi_kerja'] != "") {
                                        echo $k['durasi'][0]['durasi_kerja']; 
                                    } else {
                                        echo "00:00:00";
                                    }
                                    ?>
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

<script type="text/javascript">
    $(document).ready(function(){
        $("#table_tukar").dataTable();
    });
    $('.select2').select2({

        width: '100%'

    });

    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'dd-mm-yyyy'
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
                // title: '' + flashData,
                title: '' + 'Data Gagal Disimpan',
                text: 'Nama bahan sudah terdaftar',
                type: 'error'
            });
        } else{

        }
    });

    $(document).on("click", "#btn_delete", function(e){
        var id_bahan = $(this).data("id_bahan");
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
                    "url": "<?= base_url('bahan/delete_bahan') ?>",
                    "method": "POST",
                    "data": {
                        "id_bahan": id_bahan
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