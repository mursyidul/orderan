<style type="text/css">
    .disabled[disabled] {
        color: red;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Schedule</h2>
        <ol class="breadcrumb">
            <li><a  href="<?php echo base_url('Dashboard'); ?>">Dashboard</a></li>
            <li class="active"><strong><a>Tambah Schedule</a></strong></li>

        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content" id="create_modal">
                    <h2>Schedule hari ini pada tanggal <?php echo $_GET["date"] ?></h2>
                    <br>
                    <!-- <form action="<?php echo base_url('schedule/tambah_schedule'); ?>" method="post" role="form"> -->
                        <div class="table-responsive">
                            <div class="form-group">
                                <input type="hidden" name="tanggal" class="form-control" value="<?php echo $_GET["date"] ?>" readonly>
                            </div>
                            <table id="tableschedule" class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>

                                    <tr>
                                    <th width="5%"><center>No</center></th>
                                    <th><center>Pekerja</center></th>
                                    <th width="10%"><center>OFF</center></th>
                                    <th width="10%"><center>SHIFT 1</center></th>
                                    <th width="10%"><center>SHIFT 2</center></th>
                                    <th width="10%"><center>SHIFT 3</center></th>
                                    <th width="10%"><center>NON SHIFT</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php if ($user) {
                                    
                                    $i=1; foreach ($user as $s) { ?>
                                        <tr>
                                            <?php 
                                                $tanggal = $_GET["date"];
                                                $tes = $this->db->query("SELECT tbl_schadule.*, tbl_schadule.shift_kerja as shift_kerja, tbl_user.full_name as nama FROM tbl_schadule INNER JOIN tbl_user ON tbl_user.id_user=tbl_schadule.id_user where tbl_schadule.id_user = '$s->id_user' and tbl_schadule.tanggal = '$tanggal'");
                                                if(sizeof($tes->result_array())>0){
                                                    foreach ($tes->result_array() as $p) {
                                                        $id_user = $p['id_user'];
                                                        $shift_kerja = $p['shift_kerja'];
                                                        if ($s->id_user == $id_user) {
                                            ?>  
                                            <td><input type="hidden" name="id_schadule<?php echo $p['id_user'] ?>" value="<?php echo $p['id_schadule'] ?>"><?php echo $i?></td>
                                            <td><input type="hidden" name="id_user<?php echo $p['id_user'] ?>" value="<?php echo $p['id_user'] ?>"><?php echo $p['nama']; ?></td>
                                            <td>
                                                <center><input type="radio" class="disabled" name="shift_kerja<?php echo $id_user ?>" value="OFF" 
                                                <?php if($shift_kerja=='OFF'){ 
                                                        echo 'checked';
                                                    } else {
                                                        echo 'disabled';
                                                    } ?>>
                                                </center>
                                            </td>
                                            <td>
                                                <center><input type="radio" name="shift_kerja<?php echo $id_user ?>" class="disabled" value="SHIFT_1" 
                                                    <?php if($shift_kerja == "SHIFT_1"){
                                                        echo "checked"; 
                                                    } else {
                                                        echo "disabled";
                                                    } ?>>
                                                </center>
                                            </td>
                                            <td>
                                                <center><input type="radio" name="shift_kerja<?php echo $id_user ?>" class="disabled" value="SHIFT_2" 
                                                <?php if($shift_kerja == "SHIFT_2"){
                                                    echo "checked";
                                                } else {
                                                    echo "disabled";
                                                } ?>>
                                                </center>
                                            </td>
                                            <td>
                                                <center><input type="radio" name="shift_kerja<?php echo $id_user ?>" class="disabled" value="SHIFT_3" 
                                                <?php if($shift_kerja == "SHIFT_3"){
                                                    echo "checked";
                                                } else {
                                                    echo "disabled";
                                                } ?>>
                                                </center>
                                            </td>
                                            <td>
                                                <center><input type="radio" name="shift_kerja<?php echo $id_user ?>" class="disabled" value="NON_SHIFT" 
                                                <?php if($shift_kerja == "NON_SHIFT"){
                                                    echo "checked";
                                                } else {
                                                    echo "disabled";
                                                } ?>>
                                                </center>
                                            </td>
                                            <?php 
                                                        } 
                                                    }
                                                }else{
                                            ?>
                                                    <td><?php echo $i?></td>
                                                    <td><?php echo $s->full_name; ?> </td>                                              
                                                    <td><center><input type="radio" checked name="shift_kerja<?php echo $s->id_user ?>" value="OFF" class="disabled" required></center></td>
                                                    <td><center><input type="radio" name="shift_kerja<?php echo $s->id_user ?>" value="SHIFT_1" disabled="" required></center></td>
                                                    <td><center><input type="radio" name="shift_kerja<?php echo $s->id_user ?>" value="SHIFT_2" disabled="" required></center></td>
                                                    <td><center><input type="radio" name="shift_kerja<?php echo $s->id_user ?>" value="SHIFT_3" disabled="" required></center></td>
                                                    <td><center><input type="radio" name="shift_kerja<?php echo $s->id_user ?>" value="NON_SHIFT" disabled="" required></center></td>
                                            <?php } ?> 
                                        </tr>                   
                                    <?php $i++; } ?>
                                    <?php } else {
                                        echo "";
                                    } ?>


                                </tbody>
                            </table>
                            
                        </div>
                    <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
        $("#tableschedule").dataTable();
    });
    </script>
