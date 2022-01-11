<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Setting Profile User</h2>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="active"><strong>Setting Profile User</strong></li>
        </ol>
    </div>
</div>
<div class="flash-data" data-flashdata="<?php echo $this->session->flashdata("success") ?>"></div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="jumbotron" >
                        <div class="row">
                            <form action="<?php echo base_url('profile/editProfile'); ?>" method="POST" role="form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Lengkap</label>
                                            <input type="text" name="full_name" class="form-control" value="<?php echo $user[0]->full_name ?>" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Telepon</label>
                                            <input type="text" class="form-control" name="phone" value="<?php echo $user[0]->phone ?>" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" name="email" value="<?php echo $user[0]->email ?>" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password">
                                            <sup class="text-danger">Jika tidak mengubah password, kolom ini kosongkan saja</sup>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-sm btn-block btn-primary" value="SIMPAN">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="reset" value="RESET" class="btn btn-sm btn-block btn-warning"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <a href="<?php echo base_url('dashboard') ?>" class="btn btn-sm btn-block btn-info">KEMBALI</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
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
</script>