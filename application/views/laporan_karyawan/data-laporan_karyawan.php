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

        <h2>Report</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Report</a></strong></li>

        </ol>

    </div>

</div>
<!-- <?php echo "<pre>", print_r($total_pemasukan_bahan[0]['total'], 1), "</pre>"; ?> -->
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata("success") ?>"></div>

                <div class="flash-data_error" data-flashdata="<?php echo $this->session->flashdata("error") ?>"></div>  
                <div class="ibox-title">
                    <div class="row">
                        <form method="get" action="" id="outlet_loss">
                            <div class="col-md-3">
                                <label>Bulan & Tahun</label>
                                    <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input class="form-control" type="text" name="startdate" id="bulan"value="<?php 
                                        if(isset($_GET['startdate']) && ! empty($_GET['startdate'])){
                                                echo date('F Y', strtotime($_GET['startdate'])); 
                                            }else{
                                                echo date('F Y');  
                                            }
                                            ?>">
                                    </div>
                            </div>
                            <div class="col-md-3">
                                <label> Nama User</label>
                                <div class="form-group">
                                    <div>
                                        <select class="form-control select2" name="user">
                                            <option value="">Pilih User</option>
                                            <?php foreach ($user as $k) {
                                                echo '<option value="'.$k->id_user.'">'.$k->full_name.'</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button style="margin-top: 23px" type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Filter</button>
                                    <a style="margin-top: 23px;" href="<?php
                                    $startdate  ="";
                                    $user       ="";
                                    if(isset($_GET['startdate']) && ! empty($_GET['startdate'])){ 
                                        $startdate     = $_GET['startdate'];
                                    }
                                    if(isset($_GET['user']) && ! empty($_GET['user'])){ 
                                        $user     = $_GET['user'];
                                    }
                                        echo base_url("laporan_karyawan/cetak_kerja_karyawan/"."?startdate="."");
                                    ?>" class="btn btn-sm btn-primary" target="_blank" data-toggle="tooltip"><i class="fa fa-print"></i> Cetak</a>
                                </div>
                            </div>
                        </form>
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
    $('#bulan').datepicker({

        minViewMode: 1,

        format: 'MM yyyy',

        endDate: 'y'

    });
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
</script>