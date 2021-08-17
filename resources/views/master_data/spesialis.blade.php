@extends('layout.master')

@section('content')

<x-content-title title="Master Data Spesialis" />
<x-content-card title="Form Spesialis">
    <x-slot name="body">
        <form action="" id="frm_spesialis">
            @csrf
            <input type="hidden" name="id_spesialis" id="id_spesialis">
            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="">Spesialis</label>
                    <input type="text" name="spesialis" id="spesialis" class="form-control" />
                </div>
            </div>
        </form>
    </x-slot>
    <x-slot name="footer">
        <button type="button" class="btn btn-primary" onclick="add();" id="btn_simpan">Simpan</button>
        <button type="button" class="btn btn-success" onclick="edit();" id="btn_ubah">Ubah</button>
        <button type="button" class="btn btn-warning" onclick="goReset();" id="btn_reset">Reset</button>
    </x-slot>
</x-content-card>

<x-content-card title="Daftar Spesialis">
    <x-slot name="body">
        <table class="table table-hover table-striped table-sm" id="tbl_spesialis">
            <thead>
                <tr>
                    <th width="30px"></th>
                    <th width="30px"></th>
                    <th width="30px">No.</th>
                    <th>Spesialis</th>
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

        $('#tbl_spesialis').DataTable({
            ajax: {
                url: "{{ url('/master_data/spesialis/getspesialisdt') }}"
            },
            columns: [
                { data: 'edit' },
                { data: 'delete' },
                { data: 'DT_RowIndex' },
                { data: 'spesialis' }
            ],
            ordering: false
        });
    })

    function add() {
        var formData = new FormData(document.querySelector("#frm_spesialis"))
        $.ajax({
            url         : "{{ url('/master_data/spesialis/add') }}",
            type        : "post",
            dataType    : "json",
            data        : formData,
            processData : false,
            contentType : false,
            success     : function(r) {
                goReset();
                $('#tbl_spesialis').DataTable().ajax.reload();
            }
        })
    }

    function edit() {
        var formData = new FormData(document.querySelector("#frm_spesialis"))
        $.ajax({
            url         : "{{ url('/master_data/spesialis/edit') }}",
            type        : "post",
            dataType    : "json",
            data        : formData,
            processData : false,
            contentType : false,
            success     : function(r) {
                goReset();
                $('#tbl_spesialis').DataTable().ajax.reload();
            }
        })
    }

    function goDelete(id_spesialis) {
        if(confirm("Anda yakin akan menghapus data spesialis ini?")) {
            $.get("{{ url('/master_data/spesialis/delete') }}/" + id_spesialis)
                .done(function(r) {
                    $('#tbl_spesialis').DataTable().ajax.reload();
                });
        }
    }

    function goEdit(id_spesialis) {
        $.get("{{ url('/master_data/spesialis/goedit') }}/" + id_spesialis)
            .done(function(r) {
                $("#id_spesialis").val(r.id_spesialis);
                $("#spesialis").val(r.spesialis);
                $("#btn_simpan").hide();
                $("#btn_ubah").show();
                window.scrollTo(0, 0);
            });
    }

    function goReset() {
        $("#spesialis").val("");
        $("#btn_simpan").show();
        $("#btn_ubah").hide();
    }
</script>
@endsection