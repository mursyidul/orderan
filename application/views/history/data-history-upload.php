<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-10">

        <h2>History Upload</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>History Upload</a></strong></li>

        </ol>

    </div>

</div>

<div class="wrapper wrapper-content animated fadeIn">

    <div class="row">

        <div class="col-lg-12">

            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <div class="table-responsive">

                    <table id="table_history" class="table table-striped table-bordered table-hover dataTables-example" >

                    <thead>

                        <tr>

                        <th width="5%"><center>No</center></th>

                        <th width="35%"><center>Nama User</center></th>
                        <th width="35%"><center>Toko Online</center></th>
                        <th width="25%"><center>Tanggal</center></th>

                    </tr>

                   </thead>

                    <tbody>
                        <?php $i=1; foreach ($history as $k) { ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $k->full_name; ?></td>
                                <td><?php echo $k->toko_online; ?></td>
                                <td><?php echo date('d F Y H:i:s', strtotime($k->tanggal));?></td>
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

    $(document).ready(function() {

      $("#table_history").dataTable();

    });

</script>