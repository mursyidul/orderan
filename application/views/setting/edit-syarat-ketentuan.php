<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Syarat & Ketentuan</h2>
        <ol class="breadcrumb">
            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li><a  href="<?php echo base_url('syarat_ketentuan'); ?>">Syarat & Ketentuan</a></li>
            <li class="active"><strong><a>Edit Syarat & Ketentuan</a></strong></li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">                   
                <?php echo form_open_multipart('syarat_ketentuan/update/'.$syarat->id_ketentuan);?>
                    <div class="ibox-content">
                       <div class="row">
                            <input type="hidden" name="id_ketentuan" value="<?php echo $syarat->id_ketentuan;?>">
                            <div class="form-group">
                                <center><label>Judul</label></center>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="judul_ketentuan" value="<?php echo $syarat->judul_ketentuan; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <center><label><h3>Syarat & Ketentuan</h3></label></center>
                            <div class="ibox float-e-margins">
                                <textarea name="syarat_ketentuan" class="form-control note" required> <?php echo $syarat->syarat_ketentuan; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12">
                        <div class="form-group">
                            <center>
                                <input type="submit" class="btn btn-sm btn-success" value="SIMPAN">
                                <a href="<?php echo base_url('syarat_ketentuan') ?>" class="btn btn-sm btn-danger">BATAL</a>
                            </center>
                        </div>
                    </div> 
                </form> 
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

            $('.note').summernote();

       });
</script>