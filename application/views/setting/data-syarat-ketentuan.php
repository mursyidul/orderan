<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-10">

        <h2>Syarat & Ketentuan</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Syarat & Ketentuan</a></strong></li>

        </ol>

    </div>

</div>

<div class="wrapper wrapper-content animated fadeIn">

    <div class="row">

        <div class="col-lg-12">

            <div class="ibox float-e-margins">

                <div class="ibox-content">

                    <div class="table-responsive">

                    <table id="table_point" class="table table-striped table-bordered table-hover dataTables-example" >

                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="20%"><center>Judul</center></th>
                            <th width="65%"><center>Syarat dan Ketentuan</center></th>
                            <th width="10%"><center>Aksi</center></th>
                        </tr>
                   </thead>

                    <tbody>
                        <?php $i=1; foreach ($syarat as $k) { ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $k->judul_ketentuan;?></td>
                                <td><?php echo substr($k->syarat_ketentuan, 0,160);?>...</td>
                                <td>
                                    <center>
                                       <a href="<?php echo base_url('syarat_ketentuan/edit/'.$k->id_ketentuan); ?>" style="width: 70px;" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>
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
<script type="text/javascript">
    $(document).ready(function(){
        $("#table_point").dataTable();
    });
</script>