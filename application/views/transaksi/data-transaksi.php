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

        <h2>Transaksi</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Transaksi</a></strong></li>

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
                <div id="notif" ></div>
                
                <!-- <?php
                    if($this->session->flashdata('success')){
                ?> -->   
                    <!-- <div class="alert alert-success" id="notif">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong>
                    </div>  -->   
                <!-- <?php     
                    }
                ?> -->   
                <div class="ibox-title">
                    <h3><i class="fa fa-edit"></i> Input Pesanan</h3>
                    <a style="margin-top: -35px;" href="<?php echo base_url("transaksi/list_transaksi"); ?>" class="btn btn-sm btn-primary pull-right" data-toggle="tooltip"><i class="fa fa-list"></i> List Transaksi</a>
                </div>
                <div class="ibox-content">
                    <div class="row"  style="margin-top: 15px;">
                        <form id="form_tambah" class="form-horizontal" enctype="multipart/form-data">
                        <?php
                          $tes = $this->db->query("SELECT max(no_pesanan) as last FROM tbl_order WHERE source = 'STORE' AND status_pesanan = 'Draft'");
                          foreach ($tes->result_array() as $value) {
                            $lastnotransaksi = $value['last'];
                            $lastnourut = substr($lastnotransaksi, 8,9);
                            if ($lastnourut != "") {
                                // echo "tidak di tambah 1";
                                $nextnourut = $lastnourut;
                            } else {
                                $lastnourut = substr($draft_pesanan[0]->last, 8,9);
                                // echo "ditambah 1";
                                $nextnourut = $lastnourut + 1;
                            }
                            $tanggal = date('ym');
                            // echo $tanggal;
                            $nextno = "INV-".$tanggal.sprintf('%04s', $nextnourut); ?> 
                        <input type="hidden" class="form-control" name="no_pesanan" id="no_pesanan" value="<?php echo $nextno; ?>" required>
                        <center><h3 style="margin-top: -20px;"><?php echo "No Pesanan / Nama Produk : ".$nextno." / <span class='sub_nama_produk'></span>"; ?></h3></center>
                        <br>
                        <?php } ?>

                        <input type="hidden" class="form-control" name="id_orderan" id="id_orderan">
                        <input type="hidden" class="produk_nama form-control" name="nama_produk" id="nama_produk" required>
                        <input type="hidden" class="sku_induk form-control" name="sku_induk" id="sku_induk" required>
                        <input type="hidden" class="nama_variasi form-control" name="nama_variasi" id="nama_variasi" required>
                        <input type="hidden" class="variasi_harga form-control" name="harga_variasi" id="harga_variasi" required>

                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Produk</label>
                                    <div class="col-sm-8">
                                            <select class="form-control select2" id="id_produk" name="id_produk" required>
                                            <option value="">Pilih Produk</option>
                                            <?php
                                                foreach ($produk as $pro) {
                                                    echo '<option value="'.$pro->id_product.'">'.$pro->deskripsi.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Variasi</label>
                                    <div class="col-sm-8">
                                        <select class="sub_variasi form-control" id="select_variasi" name="id_variasi" required>
                                            <option value="">Pilih Variasi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Qty</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" name="qty" id="qty" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="ibox float-e-margins" >
                                    <textarea type="text" name="catatan_pembeli" id="catatan_pembeli" class="form-control" rows="6" required="" placeholder="Keteragan"> </textarea>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="ibox-content" style="height: 60px;"> 
                    <div class="form-group pull-right">
                        <button style="width: 100px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>&nbsp;
                        <button style="width: 100px; margin-right: 15px;" type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                    </div>
                </div>
                </form>
                <br>
                <div class="ibox-title">
                    <h3><i class="fa fa-bars"></i> Detail Transaksi</h3>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive"  style="margin-top: 10px;">
                    <table id="table_transaksi" class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="15%"><center>No Pesanan</center></th>
                            <th width="15%"><center>Nama Produk</center></th>
                            <th width="15%"><center>Nama Variasi</center></th>
                            <th width="10%"><center>Harga</center></th>
                            <th width="5%"><center>Qty</center></th>
                            <th width="10%"><center>Total</center></th>
                            <th width="15%"><center>Keterangan</center></th>
                            <th width="10%"><center>Aksi</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    </table>
                    </div>
                  </div>
                </div>
                <div class="ibox-title">
                <?php
                  $tes = $this->db->query("SELECT max(no_pesanan) as last FROM tbl_order WHERE source = 'STORE' AND status_pesanan = 'Draft'");
                  foreach ($tes->result_array() as $value) {
                    $lastnotransaksi = $value['last'];
                    $lastnourut = substr($lastnotransaksi, 8,9);
                    if ($lastnourut != "") {
                        // echo "tidak di tambah 1";
                        $nextnourut = $lastnourut;
                    } else {
                        $lastnourut = substr($draft_pesanan[0]->last, 8,9);
                        // echo "ditambah 1";
                        $nextnourut = $lastnourut + 1;
                    }
                    $tanggal = date('ym');
                    $nextno = "INV-".$tanggal.sprintf('%04s', $nextnourut); ?> 
                <?php } ?>
                 <h3><i class="fa fa-credit-card"></i> Pemabayaran Transaksi : <?php echo $nextno; ?></h3> 
                </div>
                <div class="ibox-content">
                    <div class="row"  style="margin-top: 15px;">
                        <form action="<?php echo base_url('transaksi/tambah_transaksi') ?>" method="post" role="form" class="form-horizontal" enctype="multipart/form-data" id="transaksi_persen">
                        <div class="col-md-12">
                            <input type="hidden" name="no_pesanan" class="form-control" value="<?php echo $nextno; ?>">
                            <div class="col-md-6">
                                <div id="plus">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Cari Customer</label>
                                    <div class="col-sm-6">
                                        <select class="form-control customer_select"  name="id_customer" required>
                                            <option value="">Pilih Customer</option>
                                            <?php
                                                foreach ($customer as $cus) {
                                                    echo '<option value="'.$cus->id_customer.'">'.$cus->nama_customer.' - '.$cus->wa_customer.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <button style="margin-top: 2px;" class="btn btn-block btn-sm btn-success btn-lg" onclick="plus()" type="button"><i class="fa fa-plus"></i></button>
                                    </div>
                                    </div>
                                </div>
                                <div id="minus">
                                    
                                </div>
                                <!-- <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-8" id="nama_customer">
                                    </div>
                                </div> -->
                                <div class="form-group" >
                                    <label class="col-sm-4 control-label">Diskon</label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" name="persentase" id="diskon_persen" min="0" step="any" placeholder="%" required>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="harga_persen" id="diskon_total" min="0" required>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Tanggal Deadline</label>
                                    <div id="data_1">
                                    <div class="col-sm-8">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar">
                                                </i></span>
                                            <input type="text" value="<?php echo date('d-m-Y')?>" class="form-control" name="tanggal_deadline" required >
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Opsi Pembayaran</label>
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
                                    <label class="col-sm-4 control-label">Total Tagihan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="total_tagihan_rupiah" id="total_harga_rupiah"  readonly>
                                        <input type="hidden" class="form-control" name="total_tagihan" id="total_harga_ajax"  readonly>
                                        <input type="hidden" class="form-control" name="jumlah_produk" id="total_qty_ajax" readonly>
                                        <input type="hidden" class="form-control" name="total_harga" id="diskon_total1" readonly>
                                        <input type="hidden" class="form-control" name="total_all" id="total_all" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Jumlah Pembayaran</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="jumlah_pembayaran" class="form-control" id="rupiah" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Keterangan</label>
                                    <div class="col-sm-8">
                                        <textarea type="text" class="form-control" name="keterangan" rows="3" required=""></textarea>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="ibox-content" style="height: 60px;"> 
                    <div class="form-group pull-right">
                        <button style="margin-right: 15px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-shopping-cart"></i> Proses Transaksi</button>
                    </div>
                </div>
                </form>
                <br>
            </div>
        </div>
    </div>

<script type="text/javascript">
    $("document").ready(function(){
        var table_transaksi = $("#table_transaksi").dataTable({
            processing: true,
            select: false,
            ajax: {
                url : "<?= base_url('transaksi/get_transaksi') ?>",
                dataType : "JSON",
                type : "GET",
                dataSrc : function (data){
                    var returnData_transaksi = new Array();
                    // console.log(data);
                    if(data.status == "success"){
                        $.each(data["data"], function(i, item){
                            console.log(data);
                            // console.log(item["total_tagihan"][0]["total_harga"]);
                            // $('#total_harga_ajax').trigger("reset");
                            $("#total_harga_rupiah").val("Rp. "+number_format(item["total_tagihan"][0]["total_harga"]));
                            $("#total_harga_ajax").val(item["total_tagihan"][0]["total_harga"]);
                            $("#total_qty_ajax").val(item["total_tagihan"][0]["total_qty"]);
                            var total_harga = "Rp. "+number_format(item['total_harga']);
                            var harga_awal = "Rp. "+number_format(item['harga_awal']);
                            returnData_transaksi.push({
                                "no" : (i+1),
                                "no_pesanan" : item["no_pesanan"],
                                "nama_produk" : item["nama_produk"],
                                "nama_variasi" : item["nama_variasi"],
                                "harga_awal" : harga_awal,
                                "qty" : item["total_qty"],
                                "total" : total_harga,
                                "keterangan" : item["catatan_pembeli"],
                                "action" : "<center><button id='btn_edit' data-id_orderan='"+item["id_orderan"]+"' class='btn btn-xs btn-warning'><i class='fa fa-edit'></i> </button>&nbsp;"+
                                            "<button id='btn_delete' data-id_orderan='"+item["id_orderan"]+"' data-total_harga='"+item["total_tagihan"][0]["total_harga"]+"' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i> </button></center>"
                            });
                        });
                    }
                    return returnData_transaksi;
                }
            },
            columns : [
                {data : "no"},
                {data : "no_pesanan"},
                {data : "nama_produk"},
                {data : "nama_variasi"},
                {data : "harga_awal"},
                {data : "qty"},
                {data : "total"},
                {data : "keterangan"},
                {data : "action"}
            ]
        });
    });

    function number_format(number, decimals, decPoint, thousandsSep){
        decimals = decimals || 0;
        number = parseFloat(number);

        if(!decPoint || !thousandsSep){
            decPoint = '.';
            thousandsSep = ',';
        }

        var roundedNumber = Math.round( Math.abs( number ) * ('1e' + decimals) ) + '';
        var numbersString = decimals ? roundedNumber.slice(0, decimals * -1) : roundedNumber;
        var decimalsString = decimals ? roundedNumber.slice(decimals * -1) : '';
        var formattedNumber = "";

        while(numbersString.length > 3){
            formattedNumber += thousandsSep + numbersString.slice(-3)
            numbersString = numbersString.slice(0,-3);
        }

        return (number < 0 ? '-' : '') + numbersString + formattedNumber + (decimalsString ? (decPoint + decimalsString) : '');
    }

    function plus(){
        $( "#plus" ).hide();
        $( ".customer_select" ).hide().prop('required',false);
        $( ".customer_select" ).hide().val('');
        $( "#minus" ).show();
        document.getElementById("minus").innerHTML = "<div class='form-group'><label class='col-sm-4 control-label'>Cari Customer</label><div class='col-sm-6'><input type='' class='form-control' value='Pilih Customer' readonly><input type='hidden' class='form-control' value='0'></div><div class='col-sm-2'><button style='margin-top: 2px;' class='btn btn-block btn-sm btn-success btn-lg' onclick='minus()' type='button'><i class='fa fa-minus'></i></button></div></div><div class='form-group'><label class='col-sm-4 control-label'>Nama / Telp Cutomer</label><div class='col-sm-4'><input type='text' name='nama_customer' class='form-control nama_customer' required placeholder='Nama Customer'></div><div class='col-sm-4'><input type='number' name='telp_customer' class='form-control telp_customer' required placeholder='Telp Customer'></div></div><div class='form-group'><label class='col-sm-4 control-label'>Kabupaten / Provinsi</label><div class='col-sm-4'><input type='text' name='kabupaten_customer' class='form-control kabupaten_customer' required placeholder='Kabupaten'></div><div class='col-sm-4'><input type='text' name='provinsi_customer' class='form-control provinsi_customer' required placeholder='Provinsi'></div></div><div class='form-group'><label class='col-sm-4 control-label'>Alamat Customer</label><div class='col-sm-8'><textarea type='text' class='form-control alamat_customer' name='alamat_customer' rows='3' required></textarea></div></div>";
    }

    function minus(){
        $( ".nama_customer" ).hide().prop('required',false);
        $( ".telp_customer" ).hide().prop('required',false);
        $( ".kabupaten_customer" ).hide().prop('required',false);
        $( ".provinsi_customer" ).hide().prop('required',false);
        $( ".alamat_customer" ).hide().prop('required',false);
        $( ".nama_customer" ).hide().prop('',false);
        $( ".telp_customer" ).hide().val('');
        $( ".kabupaten_customer" ).hide().val('');
        $( ".provinsi_customer" ).hide().val('');
        $( ".alamat_customer" ).hide().val('');
        $( "#minus" ).hide(); 
        $( "#plus" ).show(); 
    }

    $(document).on("click", "#btn_edit", function(e){
        e.preventDefault();
        $('#form_tambah')[0].reset();
        var id_orderan = $(this).data("id_orderan");
        $.ajax({
            "async": true,
            "crossDomain": true,
            "url": "<?= base_url('transaksi/get_transaksi') ?>/"+id_orderan,
            "method": "GET",
        }).done(function (response) {
            var data = JSON.parse(response);
            // console.log(data);
            $("#id_orderan").val(data.data[0].id_orderan);
            $("#qty").val(data.data[0].total_qty);
            $("#id_produk").val(data.data[0].id_produk).change();
            $("#sku_induk").val(data.data[0].sku_induk);
            $(".sub_variasi").val(data.data[0].id_variasi).change();
            $("#harga_variasi").val(data.data[0].harga_variasi);
            $("#catatan_pembeli").val(data.data[0].catatan_pembeli);
        });
    });


    $(document).on("submit", "#form_tambah", function(e){
        e.preventDefault();
        var id_orderan = $("#id_orderan").val();
        var url = (id_orderan == "" ? "action_tambah" : "action_ubah");
        $.ajax({
            "async": true,
            "crossDomain": true,
            "url": "<?= base_url('transaksi') ?>/"+url,
            "method": "POST",
            "data": $(this).serialize(),
        }).done(function (response) {
            var data = JSON.parse(response)
            var message = data.message;
            // console.log(data);
            if(data.status == "success"){
                // $("#modalAdd").modal("hide");

                $("#table_transaksi").DataTable().ajax.reload();
                $('#form_tambah')[0].reset();
                reset_select();
                $("#notif").html('<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert">&times;</a>'+message+'</div>');
            } else {
                $("#notif").html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert">&times;</a>'+message+'</div>');
                // swal("Failed.", message, "warning");
            }
        });
    });

    function reset_select(){
        $('#select_variasi').select2('val', '#select_variasi');
        $('.select2').select2('val', '.select2');
    }

    $('.select2').select2({
        placeholder: 'Pilih Produk',
        width: '100%'

    });

    $('.customer_select').select2({
        width: '100%'

    });

    $('.opsi_select').select2({
        width: '100%'

    });
    $('#select_variasi').select2({
        placeholder: 'Pilih Variasi',
        width: '100%'

    });

    $(document).on("click", "#btn_delete", function(e){
        var total_harga = $(this).data("total_harga");
        // console.log(total_harga);
        var id_orderan = $(this).data("id_orderan");
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
                    "url": "<?= base_url('transaksi/delete_transaksi') ?>",
                    "method": "POST",
                    "data": {
                        "id_orderan": id_orderan
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
                            $("#table_transaksi").DataTable().ajax.reload();
                            $("#total_harga_ajax").val(0);
                            $("#total_qty_ajax").val(0);
                            $("#total_all").val(0);
                            $("#diskon_persen").val(0);
                            $("#diskon_total").val(0);
                            $("#diskon_total1").val(0);
                        });
                    } else {
                        swal("Gagal menghapus data.", message.toUpperCase(), "warning");
                    }
                });   
            }
        });
    });

    $(document).ready(function(){
            $('#id_produk').change(function(){
            var id=$(this).val();
            $.ajax({
                url : "<?php echo base_url();?>transaksi/get_sub_variasi",
                method : "POST",
                data : {id: id},
                async : false,
                dataType : 'json',
                success: function(data){
                    var html = '';
                    var i;
                    html += '<option value="">Pilih Variasi</option>';
                    for(i=0; i<data.length; i++){
                            html += '<option value="'+data[i].id_variasi+'">'+data[i].nama_variasi+'</option>';
                    }
                    $('.sub_variasi').html(html);
                    
                }
            });
        });
            
     });

    $(document).ready(function(){
            $('#id_produk').change(function(){
            var id=$(this).val();
            $.ajax({
                url : "<?php echo base_url();?>transaksi/get_nama_produk",
                method : "POST",
                data : {id: id},
                async : false,
                dataType : 'json',
                success: function(data){
                    // console.log(data);
                    var html = '';
                    var produk_nama = '';
                    var sku_induk = '';
                    html += data[0].deskripsi;
                    produk_nama += data[0].deskripsi;
                    sku_induk += data[0].nmr_sku;
                    $('.produk_nama').val(produk_nama);
                    $('.sku_induk').val(sku_induk);
                    $('.sub_nama_produk').html(html);
                    
                }
            });
        });
            
     });

    $(document).ready(function(){
            $('.sub_variasi').change(function(){
            var id=$(this).val();
            $.ajax({
                url : "<?php echo base_url();?>transaksi/get_nama_variasi",
                method : "POST",
                data : {id: id},
                async : false,
                dataType : 'json',
                success: function(data){
                    // console.log(data);
                    var nama_variasi = '';
                    var harga_variasi = '';
                    nama_variasi += data[0].nama_variasi;
                    harga_variasi += data[0].harga_variasi;
                    $('.nama_variasi').val(nama_variasi);
                    $('.variasi_harga').val(harga_variasi);
                    
                }
            });
        });
            
     });

    $(document).ready(function(){
        $('.note').summernote();
    });
    $('#data_1 .input-group.date').datepicker({

        todayBtn: "linked",

        keyboardNavigation: false,

        forceParse: false,

        calendarWeeks: true,

        autoclose: true,

        format:'dd/mm/yyyy'

    });

    $('#diskon_persen').on('input', function() { 
        var input = $(this).val();
        console.log(input);
    }); 
    $('#diskon_persen').keypress(function() {
        $('#diskon_persen').on('input', function() { 
            var diskon_persen = $(this).val();
            var harga_total = $('#total_harga_ajax').val();
            var total_persen = percentageCalculator(diskon_persen, harga_total);
            var total_all = harga_total - total_persen;
            $('#diskon_total').val(total_persen);
            $('#diskon_total1').val(total_persen);
            $('#total_all').val(total_all);
            console.log(total_persen);
        });
        $("#diskon_total").val(""); 
    });
    $("#diskon_total").keypress(function(){ 
        $('#diskon_total').on('input', function() { 
            var diskon_total = $(this).val();
            var harga_total = $('#total_harga_ajax').val();
            var total_harga = hargaCalculator(diskon_total, harga_total);
            var total_all = harga_total - diskon_total;
            $('#diskon_persen').val(total_harga);
            $('#diskon_total1').val(diskon_total);
            $('#total_all').val(total_all);
            console.log(total_harga);
        });
        $("#diskon_persen").val(""); 
    });
    function percentageCalculator(persentase, harga_persen) {       
        return ((persentase * harga_persen) / 100).toFixed(2)
    }

    function hargaCalculator(diskon_total, harga_persen) {       
        return ((diskon_total / harga_persen) * 100).toFixed(2)
    }
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