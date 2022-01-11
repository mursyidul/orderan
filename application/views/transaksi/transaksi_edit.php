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

            <li class="active"><strong><a>Transaksi Edit</a></strong></li>

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
                        <input type="hidden" class="form-control" name="no_pesanan" id="no_pesanan" value="<?php echo $no_pesanan; ?>" required>
                        <center><h3 style="margin-top: -20px;"><?php echo "No Pesanan / Nama Produk : ".$no_pesanan." / <span class='sub_nama_produk'></span>"; ?></h3></center>
                        <br>

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
                    <table id="table_transaksi_edit" class="table table-striped table-bordered table-hover dataTables-example">
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
            </div>
        </div>
    </div>

<script type="text/javascript">
    $("document").ready(function(){
        var no_pesanan = '<?php echo $no_pesanan ?>';
        var table_transaksi_edit = $("#table_transaksi_edit").dataTable({
            processing: true,
            select: false,
            ajax: {
                url : "<?= base_url('transaksi/get_transaksi_edit/') ?>"+'<?php echo $no_pesanan ?>',
                dataType : "JSON",
                type : "GET",
                dataSrc : function (data){
                    // console.log(data);
                    var returnData_transaksi = new Array();
                    if(data.status == "success"){
                        $.each(data["data"], function(i, item){
                            // console.log(item["id_orderan"]);
                            var total_harga = "Rp. "+number_format(item['total_harga']);
                            var harga_awal = "Rp. "+number_format(item['harga_awal']);
                            var jumlah_orderan = item['jumlah_orderan'][0]['jumlah_orderan'];
                            if (jumlah_orderan > 1) {
                                // console.log("tampil tombol delete");
                                var button = "<center><button id='btn_edit' data-id_orderan='"+item["id_orderan"]+"' class='btn btn-xs btn-warning'><i class='fa fa-edit'></i> </button>&nbsp;"+
                                            "<button id='btn_delete' data-id_orderan='"+item["id_orderan"]+"' data-total='"+item["total_harga"]+"' data-no_pesanan='"+item["no_pesanan"]+"' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i> </button></center>";
                            } else {
                                // console.log("tidak tampil tombol delete");
                                var button = "<center><button id='btn_edit' data-id_orderan='"+item["id_orderan"]+"' class='btn btn-xs btn-warning'><i class='fa fa-edit'></i> </button>&nbsp;</center>";
                            }
                            // console.log(jumlah_orderan);
                            returnData_transaksi.push({
                                "no" : (i+1),
                                "no_pesanan" : item["no_pesanan"],
                                "nama_produk" : item["nama_produk"],
                                "nama_variasi" : item["nama_variasi"],
                                "harga_awal" : harga_awal,
                                "qty" : item["total_qty"],
                                "total" : total_harga,
                                "keterangan" : item["catatan_pembeli"],
                                "action" : button
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

    $(document).on("click", "#btn_edit", function(e){
        e.preventDefault();
        $('#form_tambah')[0].reset();
        var id_orderan = $(this).data("id_orderan");
        var no_pesanan = '<?php echo $no_pesanan; ?>';
        $.ajax({
            "async": true,
            "crossDomain": true,
            "url": "<?= base_url('transaksi/get_transaksi_edit_perpesanan') ?>/"+id_orderan,
            "method": "GET",
        }).done(function (response) {
            var data = JSON.parse(response);
            console.log(data);
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
        var url = (id_orderan == "" ? "action_transaksi_tambah" : "action_transaksi_ubah");
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

                // $("#table_transaksi_edit").DataTable().ajax.reload();
                location.reload();
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
        var no_pesanan = $(this).data("no_pesanan");
        var total = $(this).data("total");
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
                    "url": "<?= base_url('transaksi/delete_transaksi_edit') ?>",
                    "method": "POST",
                    "data": {
                        "id_orderan": id_orderan,
                        "total": total,
                        "no_pesanan": no_pesanan
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
                            $("#table_transaksi_edit").DataTable().ajax.reload();
                            // console.log(id_orderan);
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

    // $('#diskon_persen').on('input', function() { 
    //     var input = $(this).val();
    //     console.log(input);
    // }); 
    // $('#diskon_persen').keypress(function() {
    //     $('#diskon_persen').on('input', function() { 
    //         var diskon_persen = $(this).val();
    //         var harga_total = $('#total_harga_ajax').val();
    //         var total_persen = percentageCalculator(diskon_persen, harga_total);
    //         var total_all = harga_total - total_persen;
    //         $('#diskon_total').val(total_persen);
    //         $('#diskon_total1').val(total_persen);
    //         $('#total_all').val(total_all);
    //         console.log(total_persen);
    //     });
    //     $("#diskon_total").val(""); 
    // });
    // $("#diskon_total").keypress(function(){ 
    //     $('#diskon_total').on('input', function() { 
    //         var diskon_total = $(this).val();
    //         var harga_total = $('#total_harga_ajax').val();
    //         var total_harga = hargaCalculator(diskon_total, harga_total);
    //         var total_all = harga_total - diskon_total;
    //         $('#diskon_persen').val(total_harga);
    //         $('#diskon_total1').val(diskon_total);
    //         $('#total_all').val(total_all);
    //         console.log(total_harga);
    //     });
    //     $("#diskon_persen").val(""); 
    // });
    // function percentageCalculator(persentase, harga_persen) {       
    //     return ((persentase * harga_persen) / 100).toFixed(2)
    // }

    // function hargaCalculator(diskon_total, harga_persen) {       
    //     return ((diskon_total / harga_persen) * 100).toFixed(2)
    // }
        // var rupiah = document.getElementById("rupiah");
        // rupiah.addEventListener("keyup", function(e) {
        //   // tambahkan 'Rp.' pada saat form di ketik
        //   // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        //   rupiah.value = formatRupiah(this.value, "Rp. ");
        // });

        // /* Fungsi formatRupiah */
        // function formatRupiah(angka, prefix) {
        //   var number_string = angka.replace(/[^,\d]/g, "").toString(),
        //     split = number_string.split(","),
        //     sisa = split[0].length % 3,
        //     rupiah = split[0].substr(0, sisa),
        //     ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        //   // tambahkan titik jika yang di input sudah menjadi angka ribuan
        //   if (ribuan) {
        //     separator = sisa ? "." : "";
        //     rupiah += separator + ribuan.join(".");
        //   }

        //   rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        //   return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        // }
</script>