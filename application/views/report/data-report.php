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
<!-- <?php
    $tgl1 = new DateTime("2022-01-01");
    $tgl2 = new DateTime("2022-01-07");
    $d = $tgl2->diff($tgl1)->days + 1;
    echo $d." hari";
?> -->
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata("success") ?>"></div>

                <div class="flash-data_error" data-flashdata="<?php echo $this->session->flashdata("error") ?>"></div>  
                <div class="ibox-title">
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
                                                echo date('01-m-Y'); 
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
                            <div class="col-md-6">
                                <button style="margin-top: 25px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </form>
                    </div>
                </div>

            <?php if($this->session->userdata('role') == "ADMIN"){ ?>
                <div class="row">
                    <div class="col-lg-4" style="margin-top: 20px;">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <!-- <span class="label label-warning pull-right">Data has changed</span> -->
                                <h5><center>Total Harga</center></h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <center>
                                    <div class="col-xs-6">
                                        <small class="stats-label">Penjualan</small>
                                        <h4 style="color: green;"><?php echo "Rp. ".number_format($total_harga_barang[0]['total']); ?></h4>
                                    </div>
                                    <div class="col-xs-6">
                                        <small class="stats-label">Kerusakan Bahan</small>
                                        <h4 style="color: red;"><?php echo "Rp. ".number_format($total_kerusakan_bahan[0]['total']); ?></h4>
                                    </div>
                                    </center>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <center>
                                        <div class="col-xs-6">
                                            <small class="stats-label">Ongkos Kirim</small>
                                            <h4 style="color: orange;"><?php echo "Rp. ".number_format($total_ongkir_kirim[0]['total']); ?></h4>
                                        </div>
                                        <div class="col-xs-6">
                                            <small class="stats-label">Pembelian Bahan</small>
                                            <h4 style="color: blue;"><?php echo "Rp. ".number_format($total_pemasukan_bahan[0]['total']); ?></h4>
                                        </div>
                                    </center>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <center>
                                        <div class="col-xs-6">
                                            <small class="stats-label">Pemakaian Bahan</small>
                                            <h4 style="color: purple;">
                                                <?php if ($pemakaian_bahan[0]['total'] != "") { ?>
                                                    <?php echo "Rp. ".number_format($pemakaian_bahan[0]['total']); ?>
                                                <?php } else { ?>
                                                    <?php echo "0"; ?>
                                                <?php } ?>
                                            </h4>
                                        </div>
                                        <div class="col-xs-6">
                                            <small class="stats-label">Biaya Operasional</small>
                                            <h4 style="color: black;"><?php echo "Rp. ".number_format($biaya_operasional[0]['total']); ?></h4>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8" style="margin-top: 20px;">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <!-- <span class="label label-warning pull-right">Data has changed</span> -->
                                <h5><center>Jumlah Orderan Masuk</center></h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <center>
                                    <div class="col-xs-3">
                                        <small class="stats-label">Perlu Dikirim</small>
                                        <h4 style="color: orange;"><?php echo $perlu_dikirim[0]->jumlah_perlu_dikirim; ?></h4>
                                    </div>
                                    <div class="col-xs-3">
                                        <small class="stats-label">Sedang Dikirim</small>
                                        <h4 style="color: green;"><?php echo $sedang_dikirim[0]->jumlah_sedang_dikirim; ?></h4>
                                    </div>
                                    <div class="col-xs-3">
                                        <small class="stats-label">Selesai</small>
                                        <h4 style="color: blue;"><?php echo $selesai[0]->jumlah_selesai; ?></h4>
                                    </div>
                                    <div class="col-xs-3">
                                        <small class="stats-label">Batal</small>
                                        <h4 style="color: red;"><?php echo $batal[0]->jumlah_batal; ?></h4>
                                    </div>
                                    </center>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <center>
                                    <div class="col-xs-3">
                                        <small class="stats-label">Dikerjakan</small>
                                        <h4 style="color: green;"><?php echo $dikerjakan[0]->jumlah_dikerjakan; ?></h4>
                                    </div>
                                    <div class="col-xs-3">
                                        <small class="stats-label">Antri Cetak</small>
                                        <h4 style="color: orange;"><?php echo $antri_cetak[0]->jumlah_antri_cetak; ?></h4>
                                    </div>
                                    <div class="col-xs-3">
                                        <small class="stats-label">Menunggu Pengiriman</small>
                                        <h4 style="color: purple;"><?php echo $menunggu_pengiriman[0]->jumlah_menunggu_pengiriman; ?></h4>
                                    </div>
                                    <div class="col-xs-3">
                                        <small class="stats-label">Desain</small>
                                        <h4 style="color: blue;"><?php echo $desain[0]->jumlah_desain; ?></h4>
                                    </div>
                                    </center>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <center>
                                    <div class="col-xs-3">
                                        <small class="stats-label">Cetak Diluar</small>
                                        <h4 style="color: purple;"><?php echo $cetak_diluar[0]->jumlah_cetak_diluar; ?></h4>
                                    </div>
                                    <div class="col-xs-3">
                                        <small class="stats-label">Packing</small>
                                        <h4 style="color: green;"><?php echo $packing[0]->jumlah_packing; ?></h4>
                                    </div>
                                    <div class="col-xs-3">
                                        <small class="stats-label">Pemasukan</small>
                                        <h4 style="color: blue;"><?php echo "Rp. ".number_format($pemasukan[0]['total']); ?></h4>
                                    </div>
                                    <div class="col-xs-3">
                                        <small class="stats-label">Laba / Rugi</small>
                                        <?php 
                                            $pemasukan = $total_harga_barang[0]['total'] + $pemasukan[0]['total'];
                                            $pengeluaran = $total_kerusakan_bahan[0]['total'] +     $total_pemasukan_bahan[0]['total'] + $pemakaian_bahan[0]['total'] + $biaya_operasional[0]['total'];
                                        ?>
                                        <h4 style="color: blue;"><?php echo "Rp. ".number_format($pemasukan - $pengeluaran); ?></h4>
                                    </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-lg-12" >
                    <div class="ibox-content">
                        <div >
                            <ul class="nav nav-tabs" style="margin-top: -5px;">
                                <!-- <span class="pull-right small text-muted">1406 Elements</span> -->
                                <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-minus-circle"></i> Total Kerusakan</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-briefcase"></i> Kategori kerusakan</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-3"><i class="fa fa-user"></i> Orderan Peruser</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-4"><i class="fa fa-cubes"></i> Pemasukan Bahan</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-5"><i class="fa fa-cube"></i> Pemakaian Bahan</a></li>
                            </ul>
                            <!-- <?php echo "<pre>", print_r($bahan, 1), "</pre>"; ?> -->
                            <div class="tab-content" style="height:275px;">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive" style="height:275px;">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th width="40%">Nama Barang</th>
                                                    <th width="30%">Jumlah Kerusakan</th>
                                                    <th width="30%">Total Biaya</th>
                                                </tr>    
                                                </thead>
                                                <tbody>
                                                <?php $i=1; foreach ($bahan as $k) { ?>
                                                    <tr>
                                                        <td><?php echo $k->jenis_bahan; ?></td>
                                                        <td><?php echo $k->jumlah_kerusakan; ?></td>
                                                        <td><?php echo "Rp " . number_format($k->total_biaya); ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-2" class="tab-pane" >
                                    <div class="full-height-scroll">
                                        <div class="table-responsive" style="height:275px;">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th width="40%">Nama Kategori</th>
                                                    <th width="30%">Jumlah Kerusakan</th>
                                                    <th width="30%">Total Biaya</th>
                                                </tr>    
                                                </thead>
                                                <tbody>
                                                <?php foreach ($kategori as $ka) { ?>
                                                    <tr>
                                                        <td><?php echo $ka->nama_kategori; ?></td>
                                                        <td><?php echo $ka->jumlah_kerusakan; ?></td>
                                                        <td><?php echo "Rp " . number_format($ka->total_biaya); ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-3" class="tab-pane" >
                                    <div class="full-height-scroll">
                                        <div class="table-responsive" style="height:275px;">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th width="40%">Nama User</th>
                                                    <th width="30%">Jumlah Orderan</th>
                                                    <th width="30%">Jumlah Packing</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($orderan as $or) { ?>
                                                    <tr>
                                                        <td><?php echo $or['full_name']; ?></td>
                                                        <td>
                                                            <?php echo $or['user_produksi'][0]['jumlah_orderan'];
                                                            ?>          
                                                        </td>
                                                        <td>
                                                            <?php echo $or['user_non_produksi'][0]['jumlah_orderan_packing'] ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-4" class="tab-pane" >
                                    <div class="full-height-scroll">
                                        <div class="table-responsive" style="height:275px;">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th width="40%">Jenis Bahan</th>
                                                    <th width="30%">Jumlah Bahan</th>
                                                    <th width="30%">Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($pemasukan_bahan as $ba) { ?>
                                                    <tr>
                                                        <td><?php echo $ba['jenis_bahan']; ?></td>
                                                        <td>
                                                            <?php echo $ba['jumlah'];
                                                            ?>          
                                                        </td>
                                                        <td>
                                                            <?php echo "Rp. ".number_format($ba['harga_total']);?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-5" class="tab-pane" >
                                    <div class="full-height-scroll">
                                        <div class="table-responsive" style="height:275px;">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th width="40%">Jenis Bahan</th>
                                                    <th width="20%">Jumlah Bahan</th>
                                                    <th width="20%">Harga Bahan</th>
                                                    <th width="20%">Total Harga</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($list_pemakaian_bahan as $ba) { ?>
                                                    <tr>
                                                        <td><?php echo $ba['jenis_bahan']; ?></td>
                                                        <td><?php echo number_format($ba['jumlah']);?></td>
                                                        <td><?php echo "Rp. ".number_format($ba['harga_kertas']) ;?></td>
                                                        <td><?php echo "Rp. ".number_format($ba['total_harga']);?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            <?php } ?>
            </div>
            <div class="row">
                <div class="col-lg-12" >
                    <div class="ibox-content">
                        <div>
                            <ul class="nav nav-tabs" style="margin-top: -5px;">
                                <li class="active"><a data-toggle="tab" href="#tab-6"><i class="fa fa-frown-o"></i> Orderan Tanpa Pengeluaran</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-7"><i class="fa fa-frown-o"></i> Orderan Rusak</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-8"><i class="fa fa-frown-o"></i> Rapot Karyawan</a></li>
                            </ul>
                            <!-- <?php echo "<pre>", print_r($pengeluaran_bahan, 1), "</pre>"; ?> -->
                            <div class="tab-content" style="height:275px;">
                             <div id="tab-6" class="tab-pane active" >
                               <div class="full-height-scroll">
                                <div class="table-responsive" style="height:275px;">
                                 <table class="table table-striped table-hover">
                                   <thead>
                                    <tr>
                                      <th width="30%">No Pesanan</th>
                                      <th width="35%">Di Kerjakan Oleh</th>
                                      <th width="35%">Di Cetak Oleh</th>
                                      </tr>
                                   </thead>
                                   <tbody>
                                    <?php foreach ($pengeluaran_bahan as $pe) { ?>
                                     <tr>
                                      <td><a href="<?php echo base_url("upload_orderan/detail/".$pe->no_pesanan); ?>"><?php echo $pe->no_pesanan; ?></a></td>
                                       <td>
                                         <?php if ($pe->user_pekerja == "") {
                                            echo "Kosong";
                                            } else { 
                                            echo $pe->user_pekerja;
                                         }?>
                                       </td>
                                       <td>
                                         <?php if ($pe->user_cetak == "") {
                                             echo "Kosong";
                                          } else { 
                                              echo $pe->user_cetak;
                                           }?>
                                       </td>
                                      </tr>
                                    <?php } ?>
                                   </tbody>
                                  </table>
                                </div>
                              </div>
                             </div>
                             <div id="tab-7" class="tab-pane" >
                              <div class="full-height-scroll">
                               <div class="table-responsive" style="height:275px;">
                                <table class="table table-striped table-hover">
                                 <thead>
                                  <tr>
                                   <th width="40%">No Pesanan</th>
                                   <th width="60%">Total Kerusakan</th>
                                  </tr>
                                 </thead>
                                 <tbody>
                                  <?php foreach ($orderan_rusak as $pe) { ?>
                                   <tr>
                                    <td><a href="<?php echo base_url("upload_orderan/detail/".$pe->no_pesanan); ?>"><?php echo $pe->no_pesanan; ?></a></td>
                                    <td><?php echo "Rp ".number_format($pe->total_harga);?></td>
                                   </tr>
                                   <?php } ?>
                                  </tbody>
                                </table>
                               </div>
                              </div>
                             </div>
                             <div id="tab-8" class="tab-pane" >
                              <div class="full-height-scroll">
                               <div class="table-responsive" style="height:275px;">
                                <table class="table table-striped table-hover">
                                 <thead>
                                  <tr>
                                   <th width="12%">Nama</th>
                                   <th><center>Total Hari Bekerja</center></th>
                                   <th><center>Total Durasi Kerja</center></th>
                                   <th><center>Jumlah Cuti</center></th>
                                   <th><center>Jumlah Proses</center></th>
                                   <th><center>Jumlah Cetak</center></th>
                                   <th><center>Jumlah Task</center></th>
                                   <th><center>KPI</center></th>
                                   <th><center>Total Edit Absen</center></th>
                                   <th><center>Total Telat</center></th>
                                   <th><center>Total On Time</center></th>
                                   <th width="5%"><center>Detail</center></th>
                                  </tr>
                                 </thead>
                                 <tbody>
                                  <?php foreach ($per_user as $pe) { ?>
                                   <tr>
                                    <td><?php echo $pe['full_name']; ?></td>
                                    <td><center><?php echo $pe['hari_kerja'][0]->total_hari_kerja; ?></center></td>
                                    <td><center><?php echo $pe['durasi_kerja'][0]->durasi_kerja; ?></center></td>
                                    <td><center><?php if ($pe['cuti'][0]->cuti != "") {
                                        echo $pe['cuti'][0]->cuti;
                                        } else {
                                            echo "0";
                                        } ?></center></td>
                                    <td><center><?php echo $pe['proses'][0]->jumlah_proses; ?></center></td>
                                    <td><center><?php echo $pe['cetak'][0]->jumlah_cetak; ?></center></td>
                                    <td><center><?php echo $pe['task'][0]->jumlah_task; ?></center></td>
                                    <td><center>
                                      <?php
                                        if (!empty($pe['proses'][0]->jumlah_proses) && !empty($pe['cetak'][0]->jumlah_cetak)) {
                                         $kpi_cetak = round($pe['proses'][0]->jumlah_proses/$pe['cetak'][0]->jumlah_cetak * 100,2);
                                        } else {
                                         $kpi_cetak = "0";
                                        }
                                         echo $kpi_cetak."%"; 
                                      ?></center></td>
                                    <td><center><?php echo $pe['edit_absen'][0]->total_edit_absen; ?></center></td>
                                    <td><center><?php echo $pe['telat'][0]->total_telat; ?></center></td>
                                    <td><center><?php echo $pe['on_time'][0]->total_on_time; ?></center></td>
                                    <td><center>
                                      <a  href="<?php
                                        $startdate  ="";
                                        $enddate    ="";
                                        $user       ="";
                                        if(isset($_GET['startdate']) && ! empty($_GET['startdate'])){ 
                                            $startdate     = $_GET['startdate'];
                                        } else{
                                            $startdate     = date('01-m-Y'); 
                                        }
                                        if(isset($_GET['enddate']) && ! empty($_GET['enddate'])){ 
                                                $enddate     = $_GET['enddate'];
                                        } else{
                                            $enddate     = date('d-m-Y'); 
                                        }
                                        if(isset($_GET['user']) && ! empty($_GET['user'])){ 
                                            $user     = $_GET['user'];
                                        }
                                        echo base_url("report/cetak_kerja_karyawan/".$startdate."/".$enddate."/".$pe['id_user']."");?>" class="btn btn-sm btn-primary" target="_blank" data-toggle="tooltip"><i class="fa fa-print"></i> Cetak</a></center>
                                    </td>
                                   </tr>
                                  <?php } ?>
                                 </tbody>
                                </table>
                               </div>
                              </div>
                             </div>
                            </div>
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