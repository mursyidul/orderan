<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-10">

        <h2>Poin</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Poin</a></strong></li>

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
                            <th width="45%"><center>Username</center></th>
                            <th width="40%"><center>Jumlah Poin</center></th>
                            <th width="10%"><center>Aksi</center></th>
                        </tr>
                   </thead>

                    <tbody>
                        <?php $i=1; foreach ($point as $k) { ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $k->username;?></td>
                                <td><?php echo $k->jumlah_point;?></td>
                                <td>
                                    <center>
                                        <a href="<?php echo base_url('point/detail/'.$k->username); ?>" style="width: 70px;" class="btn btn-xs btn-success"><i class="fa fa-book"> Detail</i></a>
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