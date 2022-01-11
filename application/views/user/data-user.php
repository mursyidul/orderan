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
        <h2>User</h2>
        <ol class="breadcrumb">
            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="active"><strong><a>User</a></strong></li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">                   
                <div class="ibox-content">
                    <?php if($this->session->userdata('role')=='ADMIN'){ ?>
                        <button id="btn_add_data" class="btn btn-sm btn-info" type="button"><i class="fa fa-plus"></i> Add User</button>
                        <br>
                        <br>
                    <?php } ?>
                    <div class="table-responsive">
                    <table id="table_user" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                        <th width="5%">No</th>
                        <th width="15%"><center>Nama User</center></th>
                        <th width="15%"><center>Nama Pangilan</center></th>
                        <th width="15%"><center>Email</center></th>
                        <th width="6%"><center>Jumlah Cuti</center></th>
                        <th width="7%"><center>Phone</center></th>
                        <th width="7%"><center>Role</center></th>
                        <th width="10%"><center>status</center></th>
                        <?php if($this->session->userdata('role')=='ADMIN'){?>

                        <th width="20%"><center>Aksi</center></th>
                    <?php } ?>
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

<div class="modal inmodal fade" id="modalAdd" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header gradient">

                <button type="button" class="close" data-dismiss="modal">

                    <span aria-hidden="true" onclick="relocate_home()">&times;</span>

                    <span class="sr-only">Close</span>

                </button>

                <h6 class="modal-title" id="title-quis"><label id="label_id">Add User</label></h6>

            </div>

            <div class="modal-body">

                <form id="formAddUser" class="form-horizontal" autocomplete="off">
                    <div class="form-group">

                        <label class="col-sm-3 control-label">Nama Lengkap</label>

                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" name="id_user" id="id_user">
                            <input type="text" class="form-control" name="full_name" id="full_name" required>

                        </div>

                    </div>
                    <div class="form-group">
                         <label class="col-sm-3 control-label">Nama Pangilan</label>
                         <div class="col-sm-8">
                             <input type="tetx" name="username" class="form-control" id="username" required>
                         </div>
                    </div>
                    <div class="form-group">

                        <label class="col-sm-3 control-label">Email</label>

                        <div class="col-sm-8">

                            <input type="email" class="form-control" name="email" id="email" required>

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-sm-3 control-label">Role</label>

                        <div class="col-sm-8">

                            <select class="form-control select2" name="id_role" id="id_role" required>

                                <option value="">Pilih Role</option>

                                <?php

                                    foreach ($role as $p) {

                                        echo '<option value="'.$p->id_role.'">'.$p->name_role.'</option>';

                                    }

                                ?>

                                

                            </select>

                        </div>

                    </div>
                    <div class="form-group">

                        <label class="col-sm-3 control-label">Jumlah Cuti</label>

                        <div class="col-sm-8">

                            <input type="number" class="form-control" name="jumlah_cuti" id="jumlah_cuti" min="1" required>

                        </div>

                    </div>
                    <div class="form-group">

                        <label class="col-sm-3 control-label">Telp.</label>

                        <div class="col-sm-8">

                            <input type="text" class="form-control" name="phone" id="phone" required>

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-sm-3 control-label">Password</label>

                        <div class="col-sm-7">

                            <input type="password" class="form-control" name="password" id="password-user">

                        </div>
                        <div class="col-sm-1">
                            <center>
                                <span toggle="#password-user" class="fa fa-fw fa-eye field-icon toggle-password-user" style="margin-top: 10px; margin-left: -25px;"></span>
                            </center>
                        </div>

                    </div>
                        <center><sup class="text-danger" id="note_password"></sup></center>

                    <div class="form-group">

                        <label class="col-sm-3 control-label">Status</label>

                        <div class="col-sm-8">

                            <select class="form-control select2" id="status" name="status" required>

                                    <option value="">Pilih Status</option>

                                    <option value="1">ACTIVE</option>

                                    <option value="0">NON ACTIVE</option>

                                </select>

                        </div>

                    </div>

                    <div class="form-group" style="text-align: center;">

                        <div class="col-sm-11">

                            <button style="width: 100px;" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>&nbsp;
                            <button style="width: 100px;" type="button" class="btn btn-sm btn-danger" data-dismiss="modal" onclick="relocate_home()"><i class="fa fa-times"></i> Batal</button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
<script>

    function hapusUser(id){
        var hapus = confirm("Apakah anda yakin ingin menghapus?");
        if(hapus){
            window.location = "<?php echo base_url('user/action_hapus/') ?>"+id;
        }
    }
</script>
<script type="text/javascript">
    function relocate_home() {
     location.reload();
    }
    $("document").ready(function(){
        // var sess = "<?php echo $this->session->userdata("role"); ?>";
        // if (sess == "SUPERADMIN" || sess == "HRD" || sess == "OWNER") {
        //     var visible = true;
        // } else {
        //     var visible = false;
        // }

        var table_user = $("#table_user").dataTable({
            processing: true,
            select: false,
            scrollX: true,

            ajax: {
                url : "<?= base_url('user/get_data_user') ?>",
                dataType : "JSON",
                type : "GET",
                dataSrc : function (data){
                    var returnDataUser = new Array();
                    if(data.status == "success"){
                        $.each(data["data"], function(i, item){

                            var data_status = item['status'];
                            var name_role   = item['name_role'];
                               if(data_status == 1){
                                var data_status = "<center>ACTIVE</center>";
                               } else {
                                var data_status = "<center>NONACTIVE</center>";
                               }

                            var sessionAdmin = "<?php echo $this->session->userdata('role') ?>";

                            if(sessionAdmin == 'ADMIN'){
                                if (name_role == 'DESAIN') {
                                var editBtn = "<center><button style='width:70px;' id='btn_edit' data-id_user='"+item["id_user"]+"' class='btn btn-xs btn-warning'><i class='fa fa-edit'></i> Edit</button>&nbsp;"+"<button style='width:70px;' id='btn_delete' data-id_user='"+item["id_user"]+"' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i> Delete</button></center>";
                                } else if (name_role == 'ADMIN') {   
                                var editBtn = "<center><button style='width:70px;' id='btn_edit' data-id_user='"+item["id_user"]+"' class='btn btn-xs btn-warning'><i class='fa fa-edit'></i> Edit</button></center>";
                                }
                            } else {
                               var editBtn = "";
                            }

                            returnDataUser.push({

                                "no" : (i+1),
                                "full_name" : item["full_name"],
                                "username" : item["username"],
                                "email" : item["email"],
                                "jumlah_cuti" : item["jumlah_cuti"],
                                "phone" : item["phone"],
                                "name_role" : item["name_role"],
                                "status" : data_status,
                                "action" : editBtn
                            });
                        });
                    }
                    return returnDataUser;
                }
            },
            columns : [
                {data : "no"},
                {data : "full_name"},
                {data : "username"},
                {data : "email"},
                {data : "jumlah_cuti"},
                {data : "phone"},
                {data : "name_role"},
                {data : "status"},
                {data : "action"}
            ]

            // ,
            // columnDefs : [{
            //     "targets" : [9],

            //     "visible" : visible
            // }]

        });

    });


    $(document).on("click", "#btn_add_data", function(e){

        $('#formAddUser')[0].reset();

        $("#id_user").val("");

        $("#note_password").html("");

        $("#modalAdd").modal("show");

    });

    $(document).on("click", "#btn_edit", function(e){

        e.preventDefault();

        $('#formAddUser')[0].reset();

        var id_user = $(this).data("id_user");

        $.ajax({

            "async": true,

            "crossDomain": true,

            "url": "<?= base_url('user/get_data_user') ?>/"+id_user,

            "method": "GET",

        }).done(function (response) {

            var data = JSON.parse(response);
            $("#id_user").val(data.data[0].id_user);
            $("#full_name").val(data.data[0].full_name);
            $("#username").val(data.data[0].username);
            $("#phone").val(data.data[0].phone);
            $("#email").val(data.data[0].email);
            $("#jumlah_cuti").val(data.data[0].jumlah_cuti);
            $("#id_role").val(data.data[0].id_role).change();
            $("#status").val(data.data[0].status).change();
            $("#note_password").html("Jika tidak mengubah password, kolom ini kosongkan saja");
            $('#label_id').text("Edit User");
            $("#modalAdd").modal("show");
            // $('select[name*="leader_name"] option[value^="499"]').attr("hide");



        });

    });

    $(document).on("submit", "#formAddUser", function(e){

        e.preventDefault();

        var id_user = $("#id_user").val();

        var url = (id_user == "" ? "addUser" : "editUser");

        $.ajax({

            "async": true,

            "crossDomain": true,

            "url": "<?= base_url('user') ?>/"+url,

            "method": "POST",

            "data": $(this).serialize(),

        }).done(function (response) {

            var data = JSON.parse(response)

            var message = data.message;

            if(data.status == "success"){

                $("#modalAdd").modal("hide");

                swal({

                    title: "Success",

                    text: message,

                    type: "success",

                    confirmButtonColor: "#a5dc86",

                    confirmButtonText: "Close",

                }, function(isConfirm){

                    $("#table_user").DataTable().ajax.reload();

                });

                

            } else {

                swal("Failed", message, "warning");

            }

        });

    });

    $(document).on("click", ".toggle-password-user", function() {

        $(this).toggleClass("fa-eye fa-eye-slash");

        var input = $($(this).attr("toggle"));

        if (input.attr("type") == "password") {

            input.attr("type", "text");

        } else {

            input.attr("type", "password");

        }

    });

    $(document).on("click", "#btn_delete", function(e){
        var id_user = $(this).data("id_user");
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
                    "url": "<?= base_url('user/delete_user') ?>",
                    "method": "POST",
                    "data": {
                        "id_user": id_user
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
                            $("#table_user").DataTable().ajax.reload();
                        });
                    } else {
                        swal("Gagal menghapus data.", message.toUpperCase(), "warning");
                    }
                });   
            }
        });
    });
</script>
<script>

    $('.select2').select2({

        // dropdownParent: $('#modalAdd .modal-content'),

        width: '100%'

    });

</script>