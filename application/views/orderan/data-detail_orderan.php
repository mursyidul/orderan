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
    .gambar_desain {
        position:absolute;
        left: 0px;
        width: auto; 
        height: 90%;
        width: 100%;
        opacity: 0;
        /*background: #00f;*/
        z-index:999;
    }
    .datepicker{z-index:+1, !important}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Orderan</h2>
        <ol class="breadcrumb">
            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="active"><strong><a>Detail Orderan</a></strong></li>
        </ol>
    </div>
</div>
<!-- <?php echo "<pre>", print_r($nama_produk, 1), "</pre>"; ?> -->
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
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
            <div class="ibox">
                <div class="ibox-content">
                    <!-- <h2><strong><center><?php echo $detail_orderan[0]['nama_produk']; ?></center></strong></h2> -->
                    <!-- <br> -->

                    <div class="row">
                        <div class="col-sm-4">
                            <dl class="dl-horizontal">

                                <dt>No Pesanan :</dt> <dd><?php echo $detail_orderan[0]['no_pesanan']; ?></dd>
                                <dt>Nama :</dt> <dd><?php echo $detail_orderan[0]['nama_penerima']; ?></dd>
                            </dl>
                        </div>
                        <div class="col-sm-3">
                            <dl class="dl-horizontal" >
                                <dt>Whats App :</dt> <dd><a href="https://api.whatsapp.com/send?phone=<?php echo $detail_orderan[0]['no_telepon']; ?>&text=Hai%20kak%20<?php echo $detail_orderan[0]['nama_penerima']; ?>, perkenalkan kami customer service dari *Emcorp Studio (Studio Print)*  ." target="_blank"><?php echo $detail_orderan[0]['no_telepon']; ?></a></dd>
                                <dt>Status Pengerjaan :</dt> <dd> <?php echo $detail_orderan[0]['status_kerjakan']; ?></dd>
                            </dl>
                        </div>
                        <div class="col-sm-5">
                            <dl class="dl-horizontal" >
                                <dt>Order :</dt> <dd><?php echo date('d F Y', strtotime($detail_orderan[0]['waktu_dibuat'])) ?></dd>
                                <dt>Deadline :</dt> <dd> <?php echo date('d F Y', strtotime($detail_orderan[0]['waktu_batas'])); ?></dd>
                            </dl>
                        </div>
                        <?php if($detail_orderan[0]['status_kerjakan'] == 'ANTRI CETAK'){ ?>

                            <button id="btn_cetak_selesai" data-no_pesanan ="<?= $detail_orderan[0]['no_pesanan']?>" data-id_user_cetak ="<?= $this->session->userdata('id_user');?>"  class="btn btn-sm btn-primary pull-right" style="margin-right: 15px;" type="button" ><i class="fa fa-eye"></i> Cetak Selesai</button>

                        <?php } ?>
                    </div>

                    <div>
                        <p id="demo"></p>
                    </div>
                    <div class="clients-list">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-picture-o"></i> Desain</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-cubes"></i> Pemakaian Bahan</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-3" onclick="myFunction()"><i class="fa fa-minus-circle"></i> Kerusakan</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <br>
                                <button data-toggle="modal" data-target="#modalAdddesain" type="button" class="btn btn-sm btn-info"><i class="fa fa-plus"> Add Desain</i> </button>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="20%">Desain</th>
                                                <th width="25%">Nama Pengguna</th>
                                                <th width="35%">Nama Produk</th>
                                                <th width="15%">Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $a=1; foreach ($desain as $de) { ?>
                                                <tr>
                                                    <td><?php echo $a; ?></td>
                                                    <td>
                                                        <!-- <center> -->
                                                            <img class="img-thumbnail" src="<?php echo base_url() ?>./file/desain/<?=$de['upload_gambar'];?>" style="max-width: 120px; width: auto; max-height: 120px;">
                                                        <!-- </center> -->
                                                    </td>
                                                    <td><?php echo $de['full_name'];?></td>
                                                    <td><?php echo $de['nama_produk'];?></td>
                                                    <td><?php echo $de['jumlah_order'];?></td>
                                                </tr>
                                            <?php $a++;} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="full-height-scroll">
                                <br>
                                <button data-toggle="modal" data-target="#modalAddpengeluaranbahan" type="button" class="btn btn-sm btn-info"><i class="fa fa-plus"> Add Pemakaian Bahan</i> </button>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="15%">Nama Pengguna</th>
                                                <th width="25%">Nama Produk</th>
                                                <th width="15%">Nama Bahan</th>
                                                <th width="20%">Jumlah Bahan</th>
                                                <th width="20%">Deskripsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $a=1; foreach ($pengeluaran_bahan as $pe) {?>
                                            <tr>
                                                <td><?php echo $a; ?></td>
                                                <td><?php echo $pe['full_name']; ?></td>
                                                <td><?php echo $pe['nama_produk']; ?></td>
                                                <td><?php echo $pe['jenis_bahan']; ?></td>
                                                <td>
                                                    <p style='text-align: left;'> <?php echo "Jumlah : ".$pe['jumlah_bahan']; ?></p> 
                                                    <p style='text-align: left;'> <?php echo "Harga : "."Rp.".number_format($pe['harga_barang']); ?></p>
                                                    <p style='text-align: left;'> <?php echo "Total : "."Rp.".number_format($pe['total_harga']); ?></p>
                                                </td>
                                                <td><?php echo $pe['deskripsi']; ?></td>
                                            </tr>
                                        <?php $a++; } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane" >
                            <div class="full-height-scroll">
                            <br>
                            <button data-toggle="modal" data-target="#modalAddkerusakan" type="button" class="btn btn-sm btn-info"><i class="fa fa-plus"> Add Kerusakan</i> </button>
                            <br>
                            <br>
                            <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pembuat</th>
                                            <th>Nama Bahan</th>
                                            <th>Kerusakan</th>
                                            <th>Keterangan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=1; foreach ($kerusakan as $k) {?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
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
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal fade" id="modalAddkerusakan" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                <form action="<?php echo base_url('upload_orderan/tambah_kerusakan') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="id_user" class="form-control" value="<?php echo $this->session->userdata('id_user'); ?>">
                        <input type="hidden" name="no_pesanan" class="form-control" value="<?php echo $detail_orderan[0]['no_pesanan']; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kategori</label>
                            <div class="col-sm-8">
                                <select name="id_kategori" class="form-control select2" required>
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
                            <button style="width: 107px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>&nbsp;
                            <button style="width: 107px;" type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="modalAddpengeluaranbahan" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label>Add Pemakaian Bahan</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('upload_orderan/tambah_pengeluaran') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="id_user" class="form-control" value="<?php echo $this->session->userdata('id_user'); ?>">
                        <input type="hidden" name="no_pesanan" class="form-control" value="<?php echo $detail_orderan[0]['no_pesanan']; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama Produk</label>
                            <div class="col-sm-8">
                                <select name="nama_produk" class="form-control select2" required>
                                    <option value="">Pilih Nama Produk</option>

                                    <?php foreach ($nama_produk as $na) { ?>
                                        <option value="
                                        <?php if ($na[0][0]["deskripsi"] != "") { ?>
                                            <?php echo $na[0][0]["deskripsi"].' ('.$na[0][0]["nama_variasi"].')'; ?>
                                        <?php } else { ?>
                                            <?php echo $na[0][0]["nama_produk"].' ('.$na[0][0]["nama_variasi"].')'; ?>
                                        <?php } ?>
                                        ">
                                            <?php if ($na[0][0]["deskripsi"] != "") {?>
                                                <?php echo $na[0][0]["deskripsi"].' ('." Variasi : ".$na[0][0]["nama_variasi"]."  &nbsp;"."Qty : ".$na[0][0]["total_qty"].')';?>
                                            <?php } else { ?>
                                                <?php echo $na[0][0]["nama_produk"].' ('." Variasi : ".$na[0][0]["nama_variasi"]."  &nbsp;"."Qty : ".$na[0][0]["total_qty"].')';?>
                                            <?php } ?>
                                            </option>
                                    <?php } ?>
                                    
                                    <!-- <?php foreach ($nama_produk as $na) { ?>
                                        <option value="
                                        <?php if ($na[0][0]["deskripsi"] != "") { ?>
                                            <?php echo $na[0][0]["deskripsi"]; ?>
                                        <?php } else { ?>
                                            <?php echo $na[0][0]["nama_produk"]; ?>
                                        <?php } ?>
                                        ">
                                            <?php if ($na[0][0]["deskripsi"] != "") {?>
                                                <?php echo $na[0][0]["deskripsi"];?>
                                            <?php } else { ?>
                                                <?php echo $na[0][0]["nama_produk"];?>
                                            <?php } ?>
                                            </option>
                                    <?php } ?> -->
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
                            <label class="col-sm-3 control-label">Jumlah Pengeluaran</label>
                            <div class="col-sm-8">
                                <input type="number" name="jumlah_bahan" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Deskripsi</label>
                            <div class="col-sm-8">
                                <textarea name="deskripsi" class="form-control" type="text" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-11">
                            <button style="width: 107px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>&nbsp;
                            <button style="width: 107px;" type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php foreach ($pengeluaran_bahan as $pen) { ?>
<div class="modal inmodal fade" id="modalEdit<?php echo $pen['id_pengeluaran_bahan']; ?>" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label>Edit Pengeluaran Bahan</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('upload_orderan/edit_pengeluaran') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="id_pengeluaran_bahan" class="form-control" value="<?php echo $pen['id_pengeluaran_bahan']; ?>">
                        <input type="hidden" name="id_user" class="form-control" value="<?php echo $this->session->userdata('id_user'); ?>">
                        <input type="hidden" name="no_pesanan" class="form-control" value="<?php echo $pen['no_pesanan']; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama Produk</label>
                            <div class="col-sm-8">
                                <select name="nama_produk" class="form-control select2" required>
                                    <option value="">Pilih Nama Produk</option>
                                    <?php foreach ($nama_produk as $na) { ?>
                                        <option value="
                                        <?php if ($na[0][0]["deskripsi"] != "") { ?>
                                            <?php echo $na[0][0]["deskripsi"]; ?>
                                        <?php } else { ?>
                                            <?php echo $na[0][0]["nama_produk"]; ?>
                                        <?php } ?>
                                        " 
                                        <?php if ($na[0][0]["deskripsi"] != "") { ?>
                                            <?php if ($na[0][0]["deskripsi"] == $pen['nama_produk']) : ?> selected <?php endif; ?>
                                        <?php } else { ?>
                                            <?php if ($na[0][0]["nama_produk"] == $pen['nama_produk']) : ?> selected <?php endif; ?>
                                        <?php } ?>
                                        >
                                            <?php if ($na[0][0]["deskripsi"] != "") {?>
                                                <?php echo $na[0][0]["deskripsi"];?>
                                            <?php } else { ?>
                                                <?php echo $na[0][0]["nama_produk"];?>
                                            <?php } ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jenis Bahan</label>
                            <div class="col-sm-8">
                                <select name="id_bahan" class="form-control select2" required>
                                    <option value="">Pilih Jenis Bahan</option>
                                    <?php 
                                        foreach ($bahan as $ba) {
                                            $selected = "";
                                            if ($ba->id_bahan == $pen['id_bahan']) {
                                                $selected = 'selected';
                                            }
                                            echo '<option value="'.$ba->id_bahan.'"'.$selected.'>'.$ba->jenis_bahan.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jumlah Pengeluaran</label>
                            <div class="col-sm-8">
                                <input type="number" name="jumlah_bahan" class="form-control" value="<?php echo $pen['jumlah_bahan']; ?>" required>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-11">
                            <button style="width: 107px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>&nbsp;
                            <button style="width: 107px;" type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="modal inmodal fade" id="modalAdddesain" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label>Add Desain</label></h6>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('upload_orderan/tambah_desain') ?>" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="id_user" class="form-control" value="<?php echo $this->session->userdata('id_user'); ?>">
                        <input type="hidden" name="no_pesanan" class="form-control" value="<?php echo $detail_orderan[0]['no_pesanan']; ?>">

                        <div class="row">
                            <div class="col-md-12">
                                <!-- <center><label><h3>Gambar</h3></label></center> -->
                                <input type='file' id='gambar' name="gambar" accept=".jpg, .png, .jpeg" class="gambar_desain" onchange="showGambar(event)">
                                <center><img class="img-thumbnail" id="show_gambar1" src="<?php echo base_url() ?>./assets/images/no_image.jpg" style="max-width: 280px; width: auto; max-height: 230px;"><br>
                            <br>
                            <p style="color: red;">*Masukkan gambar dengan ukuran 800 x 600 supaya hasil maksimal</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama Produk</label>
                            <div class="col-sm-8">
                                <select name="nama_produk" class="form-control select2" required>
                                    <option value="">Pilih Nama Produk</option>
                                    <?php foreach ($nama_produk as $na) { ?>
                                        <option value="
                                        <?php if ($na[0][0]["deskripsi"] != "") { ?>
                                            <?php echo $na[0][0]["deskripsi"].' ('.$na[0][0]["nama_variasi"].')'; ?>
                                        <?php } else { ?>
                                            <?php echo $na[0][0]["nama_produk"].' ('.$na[0][0]["nama_variasi"].')'; ?>
                                        <?php } ?>
                                        ">
                                            <?php if ($na[0][0]["deskripsi"] != "") {?>
                                                <?php echo $na[0][0]["deskripsi"].' ('." Variasi : ".$na[0][0]["nama_variasi"]." &nbsp;"."Qty : ".$na[0][0]["total_qty"].')';?>
                                            <?php } else { ?>
                                                <?php echo $na[0][0]["nama_produk"].' ('." Variasi : ".$na[0][0]["nama_variasi"]."  &nbsp;"."Qty : ".$na[0][0]["total_qty"].')';?>
                                            <?php } ?>
                                            </option>
                                    <?php } ?>
                                    <!-- <?php foreach ($nama_produk as $na) { ?>
                                        <option value="
                                        <?php if ($na[0][0]["deskripsi"] != "") { ?>
                                            <?php echo $na[0][0]["deskripsi"]; ?>
                                        <?php } else { ?>
                                            <?php echo $na[0][0]["nama_produk"]; ?>
                                        <?php } ?>
                                        ">
                                            <?php if ($na[0][0]["deskripsi"] != "") {?>
                                                <?php echo $na[0][0]["deskripsi"];?>
                                            <?php } else { ?>
                                                <?php echo $na[0][0]["nama_produk"];?>
                                            <?php } ?>
                                            </option>
                                    <?php } ?> -->
                                </select>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jumlah Order</label>
                            <div class="col-sm-8">
                                <input type="number" name="jumlah_order" class="form-control" required>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-11">
                            <button style="width: 107px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>&nbsp;
                            <button style="width: 107px;" type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on("click", "#id_kerusakan", function(e){
        var no_pesanan = $(this).data("no_pesanan");
        $(".modal-body #no_pesanan").val(no_pesanan);
    });
    $('.select2').select2({

        width: '100%'

    });
    $(document).ready(function(){
        $("#table_orderan").dataTable();
    });
    // function myFunction() {
    //   document.getElementById("demo").innerHTML = "YOU CLICKED ME!";
    // }
    var showGambar = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
          var output = document.getElementById('show_gambar1');
          var image_size = event.target.files[0].size;
          // if (image_size <= 2000000) {
            output.src = reader.result;
          // } else {
          //   $('.company_class').val("");
          //   $('#show_image').attr('src', '../assets/images/no_image.jpg');
          //   alert('Image size maksimal 2 MB!');
          // }
        };
        reader.readAsDataURL(event.target.files[0]);
    };

    $(document).on("click", "#btn_cetak_selesai", function(e){
        var no_pesanan      = $(this).data("no_pesanan");
        var id_user_cetak   = $(this).data("id_user_cetak");
        swal({
            title: "Apakah anda yakin desainya selesai ?",
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
                    "url": "<?= base_url('upload_orderan/change_status_cetak_selesai') ?>",
                    "method": "POST",
                    "data": {
                        "id_user_cetak": id_user_cetak,
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
                           // window.location.href = "./orderan/upload_orderan/", true;
                        });
                    } else {
                        swal("Gagal menghapus data.", message.toUpperCase(), "warning");
                    }
                });   
            }
        });
    });

</script>