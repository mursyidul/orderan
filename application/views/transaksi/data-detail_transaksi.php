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

        <h2>Detail Transaksi</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li><a  href="<?php echo base_url('transaksi'); ?>">Transaksi</a></li>

            <li class="active"><strong><a>Detail Transaksi</a></strong></li>

        </ol>

    </div>

</div>

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <?php
                    if($this->session->flashdata('error')){
                ?>   
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Failed!</strong> <?php echo $this->session->flashdata('error'); ?>
                    </div>    
                <?php     
                    }
                ?>
                <?php
                    if($this->session->flashdata('success')){
                ?>   
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                    </div>    
                <?php     
                    }
                ?>   
                <div class="table-responsive">
                <div class="ibox-content">
                    <div class="pull-left">
                        <h3><p><i class="fa fa-clipboard"></i> Invoice : <?php echo $detail_list[0]['no_pesanan']; ?></p></h3>
                        <h3><p><i class="fa fa-user"></i> Kasir : <?php echo $detail_list[0]['full_name']; ?></p></h3>
                    </div>
                    <div class="pull-right">
                        <h3><p>Kepada Yth : <?php echo $detail_list[0]['nama_penerima']; ?></p></h3>
                        <h3><p>Gresik, <?php echo date('d F Y', strtotime($detail_list[0]['waktu_dibuat'])); ?></p></h3>
                    </div>
                    <table class="table table-bordered" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="25%"><center>Nama Produk</center></th>
                            <th width="25%"><center>Nama Variasi</center></th>
                            <th width="10%"><center>Qty</center></th>
                            <th width="15%"><center>Harga</center></th>
                            <th width="20%"><center>Total</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($detail_transaksi as $k) { ?>
                            <tr>
                                <td><center><?php echo $i; ?></center></td>
                                <td><?php echo $k['nama_produk']; ?></td>
                                <td><?php echo $k['nama_variasi']; ?></td>
                                <td><?php echo $k['total_qty']; ?></td>
                                <td><?php echo "Rp ".number_format($k['harga_awal']); ?></td>
                                <td><?php echo "Rp ".number_format($k['total_harga']); ?></td>
                            </tr>
                        <?php $i++; } ?>
                    </tbody>
                    <tfoot align="right">
                        <tr>
                            <th colspan="4"></th>
                            <?php 
                                $total = $detail_list[0]['total_biaya'] - number_format($detail_list[0]['potongan_harga']);
                                $hasil = $total - $detail_list[0]['bayar'][0]['jumlah_pembayaran'];
                                if ($hasil > 0) {
                            ?>
                            <th><span class="pull-right">KURANG</span></th>
                            <th>
                                <?php 
                                    echo "Rp ".number_format($hasil);
                                ?>
                            </th>
                            <?php } else {?>
                            <th><span class="pull-right">Kembali</span></th>
                            <th>
                                <?php 
                                    echo "Rp ".number_format(substr($hasil, 1));
                                ?>
                            </th>
                            <?php } ?>
                            
                        </tr>

                    </tfoot>
                    <tfoot >
                        <tr align="right">
                            <th colspan="4"></th>
                            <th><span class="pull-right">SUBTOTAL</span></th>
                            <th><?php echo "Rp ".number_format($detail_list[0]['total_biaya']); ?></th>
                            
                        </tr>
                    </tfoot>
                    <tfoot align="right">
                        <tr>
                            <th colspan="4"></th>
                            <th><span class="pull-right">DISKON <?php echo $detail_list[0]['diskon']."%"; ?></span></th>
                            <th><?php echo "Rp ".number_format($detail_list[0]['potongan_harga']); ?></th>
                            
                        </tr>
                    </tfoot>
                    <tfoot align="right">
                        <tr>
                            <th colspan="4"></th>
                            <th><span class="pull-right">GRAND TOTAL</span></th>
                            <th>
                                <?php 
                                    $total = $detail_list[0]['total_biaya'] - number_format($detail_list[0]['potongan_harga']);
                                    if ($total >0) {
                                        echo "Rp ".number_format($total);
                                    } else {
                                        echo "Rp 0";
                                    }
                                ?>        
                            </th>
                            
                        </tr>
                    </tfoot>
                    <tfoot align="right" class="pull right">
                        <tr>
                            <th colspan="4"></th>
                            <th><span class="pull-right">DP</span></th>
                            <th><?php echo "Rp ".number_format($detail_list[0]['bayar'][0]['jumlah_pembayaran']); ?></th>
                            
                        </tr>
                    </tfoot>
                    </table>
                    <div class="pull-right">
                        <a style="margin-top: -15px;" href="<?php echo base_url("transaksi/transaksi_edit/".$detail_list[0]['no_pesanan']); ?>" class="btn btn-sm btn-warning" data-toggle="tooltip"><i class="fa fa-edit"></i> Edit</a>
                        <a style="margin-top: -15px;" href="<?php echo base_url("upload_orderan/detail/".$detail_list[0]['no_pesanan']); ?>" class="btn btn-sm btn-primary" data-toggle="tooltip"><i class="fa fa-list"></i> Detail Upload</a>
                        <button style="margin-top: -15px;" data-toggle="modal" data-target="#add_pelunasan" class="btn btn-sm btn-success "><i class="fa fa-thumbs-o-up"></i> Pelunasan</button> 
                        <button style="margin-top: -15px;" data-toggle="modal" data-target="#add_pembayaran" class="btn btn-sm btn-success "><i class="fa fa-money"></i> Pembayaran</button> 
                        <a href="<?php echo base_url('transaksi/cetak_pdf/'.$detail_list[0]['no_pesanan']); ?>" target="_blank" class="btn btn-sm btn-success" style="margin-top: -15px;"><i class="fa fa-print"></i> Invoice</a>
                    </div>
                  </div>
                </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal inmodal fade" id="add_pembayaran" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Add Pembayaran</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('transaksi/tambah_pembayaran') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="no_pesanan" class="form-control" value="<?php echo $detail_list[0]['no_pesanan']; ?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Opsi Pembayaran</label>
                        <div class="col-sm-8">
                            <select class="form-control opsi_select"  name="opsi_pembayaran" required>
                                <option value="">Pilih Opsi Pembayaran</option>
                                <?php
                                    foreach ($opsi_pembayaran as $opsi) {
                                        echo '<option value="'.$opsi->id_opsi_pembayaran.'">'.$opsi->jenis_pembayaran.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jumlah Pembayaran</label>
                        <div class="col-sm-8">
                            <input type="text" name="jumlah_pembayaran" id="rupiah" class="form-control" required>
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

<div class="modal inmodal fade" id="add_pelunasan" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Add Pelunasan</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('transaksi/tambah_pelunasan') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="no_pesanan" class="form-control" value="<?php echo $detail_list[0]['no_pesanan']; ?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Opsi Pembayaran</label>
                        <div class="col-sm-8">
                            <select class="form-control opsi_select"  name="opsi_pembayaran" required>
                                <option value="">Pilih Opsi Pembayaran</option>
                                <?php
                                    foreach ($opsi_pembayaran as $opsi) {
                                        echo '<option value="'.$opsi->id_opsi_pembayaran.'">'.$opsi->jenis_pembayaran.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jumlah Pembayaran</label>
                        <div class="col-sm-8">
                            <input type="text" name="jumlah_pembayaran" value="<?php
                                $total = $detail_list[0]['total_biaya'] - number_format($detail_list[0]['potongan_harga']);
                                $hasil = $total - $detail_list[0]['bayar'][0]['jumlah_pembayaran'];
                                if ($hasil >0){
                                    echo "Rp. ".number_format($hasil);
                                } else {
                                    echo "Rp 0";
                                }
                            ?>" class="form-control" required readonly>
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
        $("#table_tukar").dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": false
        });
    });


    $('.select2').select2({

        width: '100%'

    });


    $('.opsi_select').select2({
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

    var rupiah = document.getElementById("rupiah");
        rupiah.addEventListener("keyup", function(e) {
          // tambahkan 'Rp.' pada saat form di ketik
          // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
          rupiah.value = formatRupiah(this.value, "Rp. ");
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
          var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

          // tambahkan titik jika yang di input sudah menjadi angka ribuan
          if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
          }

          rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
          return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }
</script>