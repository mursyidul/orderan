<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Point</h2>
        <ol class="breadcrumb">
            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="active"><strong><a href="<?php echo base_url('point'); ?>">Point</a></strong></li>
            <li class="active"><strong><a>Detail Point</a></strong></li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <!-- <?php echo "<pre>", print_r($detail_point,1), "</pre>"; ?> -->
                    <center><h2><strong>Username : <?php echo $point->username; ?></strong></h2></center>
                    <div class="table-responsive">
                    <table id="table_detail" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                        <th width="5%"><center>No</center></th>
                        <th width="95%"><center>Jumlah Point</center></th>
                    </tr>
                   </thead>
                    <tbody>
                        <?php $i=1; foreach ($detail_point as $k) { ?>
                            <tr>
                            <td><center><?php echo $i; ?></center></td>
                            <td><?php echo $k->jumlah_point." Point"; ?></td>
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



<script>
    $(document).ready(function(){
        $("#table_detail").dataTable();
    });
</script>