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
    .not-allowed{
     cursor: not-allowed! important;
        
    }
</style>
<style>
    tr, th, td {
      border: 1px solid black;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Orderan Siap Kirim</h2>
        <ol class="breadcrumb">
            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="active"><strong><a>Orderan Siap Kirim</a></strong></li>
        </ol>
    </div>
</div>
<!-- <?php echo "<pre>", print_r($orderan,1), "<?pre>"; ?> -->
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata("success") ?>"></div>

                <div class="flash-data_error" data-flashdata="<?php echo $this->session->flashdata("error") ?>"></div>                    
                <div class="ibox-content">
                    <div class="table-responsive">
                    <table id="table_orderan" class="table table-striped table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="10%"><center>Customer</center></th>
                            <th width="40%"><center>Nama Barang</center></th>
                            <th width="15%"><center>Detail</center></th>
                           <!--  <th width="20%"><center>Informasi</center></th>-->
                            <th width="15%"><center>Aksi</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($orderan as $k) { ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><center>
                                    <?php echo 
                                        "<strong>".$k['source']."</strong>"."<br>".
                                        $k['no_pesanan']."<br><br>".
                                        $k['opsi_pengiriman']."<br><br>".
                                        "<strong>".$k['username']."</strong>"."<br>".
                                        $k['nama_penerima']."<br>".
                                        $k['kota_kabupaten']."<br>"
                                    ?>
                                    </center>
                                </td>
                                <td>
                                    <div class="row">
                                        <?php for ($a=0; $a <$k['jumlah_order'][0]['jumlah'] ; $a++) { ?>
                                        <div class="col-sm-12">
                                            <div class="col-sm-3">
                                                <?php if ($k['nomor_sku_order'][$a][0][0]['gambar'] != "") { ?>
                                                <img class="img-thumbnail" src="<?php echo base_url() ?>./file/dokumen/<?=$k['nomor_sku_order'][$a][0][0]['gambar'];?>" style="max-width: 80px; width: auto; max-height: 80px;">
                                                <br>
                                                <br>
                                                <?php } else{ ?>
                                                <img class="img-thumbnail" src="<?php echo base_url('assets/images/no_image.jpg')?>" style="max-width: 80px; width: auto; max-height: 80px;">
                                                <br>
                                                <br>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-9">
                                                <?php 
                                                  if ($k['nomor_sku_order'][$a][0][0]['deskripsi'] != "") {
                                                    echo 
                                                    "&#9658; Deskripsi : ".$k['nomor_sku_order'][$a][0][0]['deskripsi']."<br>".
                                                    "&#9658; Variasi : "."<strong>".$k['nomor_sku_order'][$a][0][0]['nama_variasi']."</strong>"."<br>".
                                                    "&#9658; Nomor SKU : "."<strong>".$k['nomor_sku_order'][$a][0][0]['nomor_sku']." (".$k['nomor_sku_order'][$a][0][0]['sku_induk'].")"."</strong>"."<br>".
                                                    "&#9658; Qty : "."<strong>".$k['nomor_sku_order'][$a][0][0]['total_qty']."</strong>"."<br><br>";
                                                    } else {
                                                    echo 
                                                    "&#9658; Deskripsi : ".$k['nomor_sku_order'][$a][0][0]['nama_produk']."<br>".
                                                    "&#9658; Variasi : "."<strong>".$k['nomor_sku_order'][$a][0][0]['nama_variasi']."</strong>"."<br>".
                                                    "&#9658; Nomor SKU : "."<strong>".$k['nomor_sku_order'][$a][0][0]['nomor_sku']." (".$k['nomor_sku_order'][$a][0][0]['sku_induk'].")"."</strong>"."<br>".
                                                    "&#9658; Qty : "."<strong>".$k['nomor_sku_order'][$a][0][0]['total_qty']."</strong>"."<br><br>";
                                                    } 
                                                ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td>
                                    <?php echo 
                                        "Proses by : "."<strong>".$k['full_name']."</strong>"."<br><br>".
                                        "Cetak by : "."<strong>".$k['user_cetak']."</strong>"."<br><br>".
                                        "Deadline : "."<strong>".$k['waktu_batas']."</strong>"."<br><br>".
                                        "Order : "."<strong>".$k['waktu_dibuat']."</strong>"."<br>".
                                        "Status Pesanan : "."<strong>".strtoupper($k['status_pesanan'])."</strong>"."<br>"
                                    ?>
                                    <?php if ($k['status_kerjakan'] == "") { ?>
                                        <?php echo "Status Pengerjaan :"."<strong>"."BELUM DI KERJAKAN"."</strong>"; ?>
                                    <?php } else{ ?>
                                        <?php echo "Status Pengerjaan : "."<strong>".strtoupper($k['status_kerjakan'])."</strong>"?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <center>
                                        <?php if ($k['status_kerjakan'] == 'PACKING') { ?>
                                            <button data-toggle="modal" data-target="#orderan_siap<?php echo $k['no_pesanan']; ?>" id="id_orderan_siap"  data-no_pesanan ="<?= $k['no_pesanan']?>" class="btn btn-block btn-xs btn-success" type="button"><i class="fa fa-car"></i> Siap Kirim</button>
                                        <?php } else if($k['status_kerjakan'] == "DIKIRIM"){ ?>

                                            <button class="btn btn-block btn-xs btn-primary not-allowed" type="button"><i class="fa fa-car"></i> Dikirim</button>

                                        <?php } ?>
                                        <button  data-toggle="modal" data-target="#kerusakan" id="id_kerusakan" data-no_pesanan="<?=$k['no_pesanan'];?>" class='btn btn-block btn-xs btn-warning'><i class="fa fa-cubes"></i> Kerusakan </button>
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

<div class="modal inmodal fade" id="kerusakan" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                <form action="<?php echo base_url('orderan_siap/tambah_kerusakan') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="id_user" class="form-control" value="<?php echo $this->session->userdata('id_user'); ?>">
                        <input type="hidden" name="no_pesanan" class="form-control" id="no_pesanan">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kategori</label>
                            <div class="col-sm-8">
                                <select name="id_kategori" class="form-control select2"  required>
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
                                <select name="id_bahan" class="form-control select2" required>
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
                            <button style="width: 100px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>&nbsp;
                            <button style="width: 100px;" type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="detail_orderan" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label>Add Detail Orderan</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('orderan_siap/tambah_detail_orderan') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="id_user" class="form-control" value="<?php echo $this->session->userdata('id_user'); ?>">
                        <input type="hidden" name="no_pesanan" class="form-control" id="no_pesanan">
                        <div class="col-sm-6">
                            <div class="form-group">
                                
                                <label class="col-sm-3 control-label"><center>Kraft Paper</center></label>
                                
                                <div class="col-sm-8">
                                    <select name="perlembar_kraft" class="form-control select2">
                                        <option value="">Pilih Ukuran Kraft</option>
                                        <?php foreach ($kraft as $k) {
                                            echo '<option value="'.$k->isi_perpich.'">'.$k->ukuran.'</option>';
                                        } ?>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                
                                <label class="col-sm-3 control-label"><center>Art Paper</center></label>
                                
                                <div class="col-sm-8">
                                    <select name="perlembar_art" class="form-control select2">
                                        <option value="">Pilih Ukuran Art</option>
                                        <?php foreach ($art as $k) {
                                            echo '<option value="'.$k->isi_perpich.'">'.$k->ukuran.'</option>';
                                        } ?>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                
                                <label class="col-sm-3 control-label"><center>Samson</center></label>
                                
                                <div class="col-sm-8">
                                    <select name="perlembar_samson" class="form-control select2">
                                        <option value="">Pilih Ukuran Samson</option>
                                        <?php foreach ($roll as $k) {
                                            echo '<option value="'.$k->isi_perpich.'">'.$k->ukuran.'</option>';
                                        } ?>
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                
                                <label class="col-sm-3 control-label"><center>Jumlah Kraft</center></label>
                                
                                <div class="col-sm-8">
                                    <input type="number" name="jumlah_kraft" min="1" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                
                                <label class="col-sm-3 control-label"><center>Jumlah Art</center></label>
                                
                                <div class="col-sm-8">
                                    <input type="number" name="jumlah_art" min="1" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                
                                <label class="col-sm-3 control-label"><center>Jumlah Samson</center></label>

                                <div class="col-sm-8">
                                    <input type="number" name="jumlah_samson" min="1" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea type="text" name="keterangan" class="form-control" rows="5" placeholder="Deskripsi"></textarea>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-12">
                            <center>
                                <button style="width: 100px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>&nbsp;
                                <button style="width: 100px;" type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                            </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $i=0; foreach ($orderan as $k) { ?>
<div class="modal inmodal fade" id="orderan_siap<?php echo $k['no_pesanan'] ?>" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
               <!--  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> -->
                <h4 class="modal-title">ORDERAN SIAP KIRIM</h4>
            </div>
            <div class="modal-body">
            <form action="<?php echo base_url('orderan_siap/change_status_siap_kirim') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <!-- <div id="tampilan"></div> -->
                    <div id="my_photo_booth<?php echo $k['no_pesanan'] ?>">
                        <!-- <div class="row">
                        <div class="col-md-4"></div>
                        <center>
                        <div class="col-md-4"> -->
                            <center>
                            <div id="my_camera<?php echo $k['no_pesanan'] ?>"></div>
                            </center>
                        <!-- </div>
                        </center>
                        <div class="col-md-4"></div>
                        </div> -->
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- <div class="col-md-4"></div>
                            <center>
                            <div class="col-md-4"> -->
                                <center>
                                <div id="results<?php echo $k['no_pesanan'] ?>" style="display:none">
                                </div></center>
                            <!-- </div>
                            </center>
                            <div class="col-md-4"></div> -->
                        </div>
                    </div> 
                </div>
                <center>
                    <div class="col-sm-12" id="button_hilang<?php echo $k['no_pesanan'] ?>">
                        <div id="pre_take_buttons">
                            <button type="button" class="btn btn-primary" onClick="save_photo<?php echo $k['no_pesanan'] ?>()"><i class="fa fa-camera"> Foto</i></button>
                        </div>
                    </div>

                    <div class="col-sm-12" id="button_siap<?php echo $k['no_pesanan'] ?>" style="display: none">
                        <a href='<?php echo base_url('orderan_siap'); ?>' class="btn btn-primary" ><i class="fa fa-camera"></i> Foto</a>
                    </div>
                </center> 
                <br>
                <br>
                <div class="row">
                </div>

                <div class="row">
                    <input type="hidden" name="total" class="form-control" value="<?php echo $k['jumlah_order'][0]['jumlah'];?>">
                    <input type="hidden" name="picture" class="form-control image-tag<?php echo $k['no_pesanan'] ?>">
                    <input type="hidden" name="pesanan_no" class="form-control" id="no_pesanan">

                <div class="col-sm-12">
                    <div class="form-group">
                        <br>
                        <label class="col-sm-6 control-label">Amplop</label>
                        <div class="col-sm-6">
                            <select name="id_bahan" class="form-control select2" required>
                                <option value="">Pilih Amplop</option>  
                                <?php foreach ($bahan as $ba) {
                                    echo '<option value="'.$ba->id_bahan.'">'.$ba->jenis_bahan.'</option>';
                                } ?>
                            </select>
                        </div>
                        
                    </div>
                </div>

                <?php for ($q=0; $q <$k['jumlah_order'][0]['jumlah'] ; $q++) { ?>
                    <input type="hidden" name="created_date[]" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>">
                    <input type="hidden" name="id_user[]" class="form-control" value="<?php echo $this->session->userdata('id_user'); ?>">
                    <input type="hidden" name="no_pesanan[]" class="form-control" id="no_pesanan">
                    <input type="hidden" name="status_kerjakan[]" class="form-control" value="<?php echo "DIKIRIM"; ?>">
                    <input type="hidden" name="nomor_sku[]" class="form-control" value="<?php echo $k['nomor_sku_order'][$q][0][0]['nomor_sku']; ?>">

                <?php if ($k['nomor_sku_order'][$q][0][0]['nomor_sku'] != "") { ?>
                    <input type="hidden" name="id_orderan[]" class="form-control" value="<?php echo $k['nomor_sku_order'][$q][0][0]['orderan_ada']; ?>">
                    <?php } else { ?>
                    <input type="hidden" name="id_orderan[]" class="form-control" value="<?php echo $k['nomor_sku_order'][$q][0][0]['orderan_kosong']; ?>">
                <?php } ?>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-sm-8">
                                <br>
                                <div class="col-sm-4">
                                    <center>
                                        <?php if ($k['nomor_sku_order'][$q][0][0]['gambar'] != "") { ?>
                                        <img class="img-thumbnail" src="<?php echo base_url() ?>./file/dokumen/<?=$k['nomor_sku_order'][$q][0][0]['gambar'];?>" style="max-width: 80px; width: auto; max-height: 80px;">
                                        <br>
                                        <?php } else { ?>
                                            <img class="img-thumbnail" src="<?php echo base_url('assets/images/no_image.jpg')?>" style="max-width: 80px; width: auto; max-height: 80px;">
                                        <?php } ?>
                                    </center>
                                </div>
                                <div class="col-sm-8">
                                    <center>
                                        
                                        <label style="text-align: left;">
                                        <?php 
                                            if ($k['nomor_sku_order'][$q][0][0]['deskripsi'] != "") {
                                                echo 
                                                "Nama Produk : ".$k['nomor_sku_order'][$q][0][0]['deskripsi']."<br>".
                                                "Variasi : ".$k['nomor_sku_order'][$q][0][0]['nama_variasi']."<br>". 
                                                "Qty : ".$k['nomor_sku_order'][$q][0][0]['total_qty']; 
                                            } else {
                                                echo 
                                                "Nama Produk : ".$k['nomor_sku_order'][$q][0][0]['nama_produk']."<br>".
                                                "Variasi : ".$k['nomor_sku_order'][$q][0][0]['nama_variasi']."<br>". 
                                                "Qty : ".$k['nomor_sku_order'][$q][0][0]['total_qty']; 
                                            }
                                        ?>
                                        </label>
                                    </center><br>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <br>
                                <input type="number" name="jumlah_order[]" class="form-control" min="<?php echo $k['nomor_sku_order'][$q][0][0]['total_qty']; ?>" required placeholder="Jumlah Order" value="<?php echo $k['nomor_sku_order'][$q][0][0]['total_qty']; ?>"></input>
                                <br>
                                <input type="number" name="bonus_order[]" class="form-control" required value="0" min="0" placeholder="Bonus Order"></input>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
            <div class="modal-footer">
                <div class="row">
                    <a href='<?php echo base_url('orderan_siap'); ?>' class="btn btn-white" >Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    Webcam.set({
        // live preview size
        width: 190,
        height: 150,
        // device capture size
        dest_width: 190,
        dest_height: 190,
        // final cropped size

        // crop_width: 300,

        // crop_height: 300,

        // format and quality

        image_format: 'jpeg',
        jpeg_quality: 100,
        // flip horizontal (mirror mode)
        flip_horiz: true
    });
    Webcam.attach( '#my_camera<?php echo $k['no_pesanan'] ?>' );

    function save_photo(<?php echo $k['no_pesanan'] ?>) {
        // actually snap photo (from preview freeze) and display it
        Webcam.snap( function(data_uri) {
            // display results in page
            $(".image-tag<?php echo $k['no_pesanan'] ?>").val(data_uri);
            document.getElementById('results<?php echo $k['no_pesanan'] ?>').innerHTML = 
                '<img class="img-fluid" src="'+data_uri+'"/><br/><br/>';
            // shut down camera, stop capturing
            Webcam.reset();
            // show results, hide photo booth
            document.getElementById('results<?php echo $k['no_pesanan'] ?>').style.display = '';
            document.getElementById('button_siap<?php echo $k['no_pesanan'] ?>').style.display = '';
            document.getElementById('button_hilang<?php echo $k['no_pesanan'] ?>').style.display = 'none';
            document.getElementById('my_photo_booth<?php echo $k['no_pesanan'] ?>').style.display = 'none';
        } );
    }
</script>
<?php $i++; } ?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#table_orderan").dataTable();
    });

    $(document).on("click", "#btn_siap_kirim", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        swal({
            title: "Apakah anda yakin ingin orderan siap kirim?",
            text: "Anda tidak dapat mengembalikannya.!!",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#0c19c5",
            confirmButtonText: "Ya, lanjutkan!",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm){
            if(isConfirm){
                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "<?= base_url('upload_orderan/change_status_siap_kirim') ?>",
                    "method": "POST",
                    "data": {
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
                            location.reload();
                        });
                    } else {
                        swal("Gagal menghapus data.", message.toUpperCase(), "warning");
                    }
                });   
            }
        });
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

    $('.select2').select2({

        width: '100%'

    });
    $(document).on("click", "#id_orderan_siap", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        $(".modal-body #no_pesanan").val(no_pesanan);
    });
    $(document).on("click", "#id_kerusakan", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        $(".modal-body #no_pesanan").val(no_pesanan);
    });
    $(document).on("click","#id_detail_orderan", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        $(".modal-body #no_pesanan").val(no_pesanan);
    });


    // Webcam.set({
    //     // live preview size
    //     width: 190,
    //     height: 150,
    //     // device capture size
    //     dest_width: 190,
    //     dest_height: 190,
    //     // final cropped size

    //     // crop_width: 300,

    //     // crop_height: 300,

    //     // format and quality

    //     image_format: 'jpeg',
    //     jpeg_quality: 100,
    //     // flip horizontal (mirror mode)
    //     flip_horiz: true
    // });
    // Webcam.attach( '#my_camera' );

    // function save_photo() {
    //     // actually snap photo (from preview freeze) and display it
    //     Webcam.snap( function(data_uri) {
    //         // display results in page
    //         $(".image-tag").val(data_uri);
    //         document.getElementById('results').innerHTML = 
    //             '<img class="img-fluid" src="'+data_uri+'"/><br/><br/>';
    //         // shut down camera, stop capturing
    //         Webcam.reset();
    //         // show results, hide photo booth
    //         document.getElementById('results').style.display = '';
    //         document.getElementById('button_siap').style.display = '';
    //         document.getElementById('button_hilang').style.display = 'none';
    //         document.getElementById('my_photo_booth').style.display = 'none';
    //     } );
    // }

    $(document).ready(function(){
        $('#id_kategori_add').change(function(){
        var id=$(this).val();
            $.ajax({
                url : "<?php echo base_url();?>orderan_siap/get_bahan_add",
                method : "POST",
                data : {id: id},
                async : false,
                dataType : 'json',
                success: function(data){
                    var html = '';
                    var i;
                    html += '<option value="">Pilih Jenis Bahan</option>';
                    for(i=0; i<data.length; i++){
                            html += '<option value="'+data[i].id_bahan+'">'+data[i].jenis_bahan+"  "+data[i].ukuran+'</option>';
                    }
                    $('#id_bahan_add').html(html);
                    
                }
            });
        });
        
    });
</script> 