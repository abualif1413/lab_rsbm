@extends('layout.master')

@section('content')

<x-content-title title="Master Pengguna Satuan Kerja" />
<x-content-card title="Form Pengguna Satuan Kerja">
    <x-slot name="body">
        <form action="" autocomplete="off" id="frm_usersatker">
            @csrf
            <input type="text" name="id" id="id" style="display: none;">
            <input type="text" name="username" id="username" style="display: none;">
            <input type="password" name="password" id="password" style="display: none;">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="">Nama</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="">Email</label>
                    <input type="text" name="email" id="email" class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-sm-4">
                    <label for="">Password</label>
                    <input type="password" name="pass1" id="pass1" class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-sm-4">
                    <label for="">Ulangi Password</label>
                    <input type="password" name="pass2" id="pass2" class="form-control" autocomplete="off">
                </div>
            </div>
        </form>
    </x-slot>
    <x-slot name="footer">
        <button type="button" class="btn btn-primary" id="btn_simpan" onclick="add();">Simpan</button>
        <button type="button" class="btn btn-success" id="btn_ubah">Ubah</button>
        <button type="button" class="btn btn-warning">Reset</button>
    </x-slot>
</x-content-card>

<x-content-card title="Daftar Pengguna Satuan Kerja">
    <x-slot name="body">
        <table class="table table-striped table-sm table-hover" id="tbl_usersatker">
            <thead>
                <tr>
                    <th width="150px"></th>
                    <th width="30px">No.</th>
                    <th>Nama</th>
                    <th>Email</th>
                </tr>
            </thead>
        </table>
    </x-slot>
    <x-slot name="footer"></x-slot>
</x-content-card>

@endsection

@section('js')
<script type="text/javascript">
    $(function() {
        goReset();

        $('#tbl_usersatker').DataTable({
            ajax: {
                url: "{{ url('/master_data/usersatker/getusersatkerdt') }}"
            },
            columns: [
                { data: 'reset' },
                { data: 'DT_RowIndex' },
                { data: 'name' },
                { data: 'email' }
            ],
            ordering: false
        });
    })

    function add() {
        var formData = new FormData(document.querySelector("#frm_usersatker"))
        if(formData.get("name") == "" || formData.get("id_satuan_kerja") == "" || formData.get("email") == "" || formData.get("pass1") == "" || formData.get("pass2") == "") {
            alert("Harap isikan semua data");
        } else {
            if(formData.get("pass1") != formData.get("pass2")) {
                alert("Password pertama dan kedua tidak sama. Harap diinput password yang sama");
            } else {
                $.ajax({
                    url         : "{{ url('/master_data/usersatker/add') }}",
                    type        : "post",
                    dataType    : "json",
                    data        : formData,
                    processData : false,
                    contentType : false,
                    success     : function(r) {
                        goReset();
                        $('#tbl_usersatker').DataTable().ajax.reload();
                        goReset();
                    }
                })
            }
        }
    }

    function edit() {
        var formData = new FormData(document.querySelector("#frm_dokter"))
        $.ajax({
            url         : "{{ url('/master_data/dokter/edit') }}",
            type        : "post",
            dataType    : "json",
            data        : formData,
            processData : false,
            contentType : false,
            success     : function(r) {
                goReset();
                $('#tbl_usersatker').DataTable().ajax.reload();
            }
        })
    }

    function goDelete(id_dokter) {
        if(confirm("Anda yakin akan menghapus data dokter ini?")) {
            $.get("{{ url('/master_data/dokter/delete') }}/" + id_dokter)
                .done(function(r) {
                    $('#tbl_usersatker').DataTable().ajax.reload();
                });
        }
    }

    function goEdit(id_dokter) {
        $.get("{{ url('/master_data/dokter/goedit') }}/" + id_dokter)
            .done(function(r) {
                $("#id_dokter").val(r.id_dokter);
                $("#nama_dokter").val(r.nama_dokter);
                $("#no_telepon").val(r.no_telepon);
                $("#nip").val(r.nip);
                $("#id_spesialis").val(r.id_spesialis);
                $("#btn_simpan").hide();
                $("#btn_ubah").show();
                window.scrollTo(0, 0);
            });
    }

    function goResetPassword(id) {
        $("#modal_reset_password").modal({
            show: true
        });
        $("#lbl_id").val(id);
        $("#lbl_satuan_kerja").val("Loading...");
        $("#lbl_nama").val("Loading...");
        $("#lbl_email").val("Loading...");
        $("#lbl_pass1").attr("disabled", "disabled");
        $("#lbl_pass2").attr("disabled", "disabled");
        $("#lbl_pass1").val("");
        $("#lbl_pass2").val("");
        $("#btn_modal_save").attr("disabled", "disabled");
        $.get("{{ url('/master_data/usersatker/getusersatker') }}/" + id)
            .done(function(r) {
                $("#lbl_satuan_kerja").val(r.satuan_kerja);
                $("#lbl_nama").val(r.name);
                $("#lbl_email").val(r.email);
                $("#btn_modal_save").removeAttr("disabled");
                $("#lbl_pass1").removeAttr("disabled");
                $("#lbl_pass2").removeAttr("disabled");
            })
    }

    function goReset() {
        $("#id").val("");
        $("#name").val("");
        $("#id_satuan_kerja").val("");
        $("#email").val("");
        $("#pass1").val("");
        $("#pass2").val("");
        $("#btn_ubah").hide();
        $("#btn_simpan").show();
    }

    function resetPassword() {
        var formData = new FormData(document.querySelector("#frm_reset_password"))
        var id = formData.get("id");
        var pass1 = formData.get("pass1");
        var pass2 = formData.get("pass2");

        if(pass1 != pass2) {
            alert("Password dan ulangi password harus sama");
        } else {
            $.ajax({
                url         : "{{ url('/master_data/usersatker/resetpassword') }}",
                type        : "post",
                dataType    : "json",
                data        : formData,
                processData : false,
                contentType : false,
                success     : function(r) {
                    $('#tbl_usersatker').DataTable().ajax.reload();
                    $("#modal_reset_password").modal('hide');
                    alert(r.message);
                }
            })
        }
    }
</script>
@endsection

@section('modal')
<div class="modal fade" id="modal_reset_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" class="form-horizontal" id="frm_reset_password">
                    @csrf
                    <input type="hidden" name="id" id="lbl_id">
                    <input type="text" name="username_palsu" style="display: none;">
                    <input type="password" name="password_palsu" style="display: none;">
                    <div class="row form-group">
                        <label for="lbl_nama" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lbl_nama" disabled>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="lbl_email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lbl_email" disabled>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="lbl_pass1" class="col-sm-5 col-form-label">Password Baru</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="lbl_pass1" name="pass1">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="lbl_pass2" class="col-sm-5 col-form-label">Ulangi Password</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="lbl_pass2" name="pass2">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_modal_save" onclick="resetPassword();">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection