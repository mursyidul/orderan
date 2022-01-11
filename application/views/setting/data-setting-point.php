<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-10">

        <h2>Pengaturan Poin</h2>

        <ol class="breadcrumb">

            <li><a  href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

            <li class="active"><strong><a>Pengaturan Poin</a></strong></li>

        </ol>

    </div>

</div>

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="table-responsive">
                    <table id="table_setting" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th width="5%"><center>No</center></th>
                            <th width="45%"><center>Harga</center></th>
                            <th width="40%"><center>Poin</center></th>
                            <?php if($this->session->userdata('role') == 'ADMIN'){?>
                            <th width="10%"><center>Aksi</center></th>
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

    <div class="modal inmodal fade" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header gradient">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h6 class="modal-title" id="title-quis"><label id="label_id">Edit Setting Point</label></h6>
            </div>
            <div class="modal-body">
                <form id="form_setting" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Harga</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="id_setting" id="id_setting">
                            <input type="number" class="form-control" name="harga_setting" id="harga_setting" placeholder="Harga Setting" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Point</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="jumlah_setting" id="jumlah_setting" placeholder="Point Setting" required>
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

<script>
    $("document").ready(function(){
        var table_setting = $("#table_setting").dataTable({
            "bPaginate": false,
            // "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            // "bAutoWidth": false,
            processing: true,
            select: false,
            ajax: {
                url : "<?= base_url('setting_point/get_data_setting') ?>",
                dataType : "JSON",
                type : "GET",
                dataSrc : function (data){
                    var returnDataclient = new Array();
                    if(data.status == "success"){
                        $.each(data["data"], function(i, item){
                            var rupiah = item["harga_setting"];

                            if (rupiah != "") {

                                var tampilan_rupiah = convertToRupiah(item["harga_setting"]);

                            } else {

                                var tampilan_rupiah = "Rp.0";

                            }
                            returnDataclient.push({
                                "no" : (i+1),
                                "harga_setting" : tampilan_rupiah,
                                "jumlah_setting" : item["jumlah_setting"],
                                "action" : "<center><button style='width: 70px;' id='btn_edit' data-id_setting='"+item["id_setting"]+"' class='btn btn-xs btn-warning'><i class='fa fa-edit'></i> Edit</button></center>"
                            });
                        });
                    }
                    return returnDataclient;
                }
            },
            columns : [
                {data : "no"},
                {data : "harga_setting"},
                {data : "jumlah_setting"},
                {data : "action"}
            ]
        });
    });

    $(document).on("click", "#btn_add_data", function(e){
        $('#form_setting')[0].reset();
        $("#id_setting").val("");
        $("#modalAdd").modal("show");
    });

    $(document).on("click", "#btn_edit", function(e){
        e.preventDefault();
        $('#form_setting')[0].reset();
        var id_setting = $(this).data("id_setting");
        $.ajax({
            "async": true,
            "crossDomain": true,
            "url": "<?= base_url('setting_point/get_data_setting') ?>/"+id_setting,
            "method": "GET",
        }).done(function (response) {
            var data = JSON.parse(response);
            $("#id_setting").val(data.data[0].id_setting);
            $("#harga_setting").val(data.data[0].harga_setting);
            $("#jumlah_setting").val(data.data[0].jumlah_setting);
            $("#modalAdd").modal("show");
        });
    });

    $(document).on("submit", "#form_setting", function(e){
        e.preventDefault();
        var id_setting = $("#id_setting").val();
        var url = (id_setting == "" ? "add_setting" : "edit_setting");
        $.ajax({
            "async": true,
            "crossDomain": true,
            "url": "<?= base_url('setting_point') ?>/"+url,
            "method": "POST",
            "data": $(this).serialize(),
        }).done(function (response) {
            var data = JSON.parse(response)
            var message = data.message;
            console.log(data);
            if(data.status == "success"){
                $("#modalAdd").modal("hide");
                swal({
                    title: "Success",
                    text: message,
                    type: "success",
                    confirmButtonColor: "#a5dc86",
                    confirmButtonText: "Close",
                }, function(isConfirm){
                    $("#table_setting").DataTable().ajax.reload();
                });
            } else {
                swal("Failed", message, "warning");
            }
        });
    });

    $(document).on("click", "#btn_delete", function(e){
        var id_setting = $(this).data("id_setting");
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
                    "url": "<?= base_url('setting_point/delete_setting') ?>",
                    "method": "POST",
                    "data": {
                        "id_setting": id_setting
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
                            $("#table_setting").DataTable().ajax.reload();
                        });
                    } else {
                        swal("Gagal menghapus data.", message.toUpperCase(), "warning");
                    }
                });   
            }
        });
    });

    function convertToRupiah(angka){
        var rupiah = '';        
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    }
</script>