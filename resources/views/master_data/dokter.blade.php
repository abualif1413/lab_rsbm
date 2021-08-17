@extends('layout.master')

@section('content')

<x-content-title title="Master Data Dokter" />
<x-content-card title="Form Dokter">
    <x-slot name="body">
        <form action="" id="frm_dokter">
            @csrf
            <input type="hidden" name="id_dokter" id="id_dokter">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="">Nama Dokter</label>
                    <input type="text" name="nama_dokter" id="nama_dokter" class="form-control" />
                </div>
                <div class="form-group col-sm-4">
                    <label for="">No. Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon" class="form-control" />
                </div>
                <div class="form-group col-sm-4">
                    <label for="">NRP / NIP / NIK</label>
                    <input type="text" name="nip" id="nip" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col col-sm-6">
                    <label for="">Spesialis</label>
                    <select name="id_spesialis" id="id_spesialis" class="form-control">
                        <option value="">- Pilih Spesialis -</option>
                        @foreach ($spesialis as $sp)
                            <option value="{{ $sp["key"] }}">{{ $sp["value"] }}</option>
                        @endforeach
                    </select>
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

<x-content-card title="Daftar Dokter">
    <x-slot name="body">
        <table class="table table-striped table-sm table-hover" id="tbl_dokter">
            <thead>
                <tr>
                    <th width="30px"></th>
                    <th width="30px"></th>
                    <th width="30px">No.</th>
                    <th>Spesialis</th>
                    <th>Nama Dokter</th>
                    <th>No. Telepon</th>
                    <th>NIK</th>
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

        $('#tbl_dokter').DataTable({
            ajax: {
                url: "{{ url('/master_data/dokter/getdokterdt') }}"
            },
            columns: [
                { data: 'edit' },
                { data: 'delete' },
                { data: 'DT_RowIndex' },
                { data: 'spesialis' },
                { data: 'nama_dokter' },
                { data: 'no_telepon' },
                { data: 'nip' }
            ],
            ordering: false
        });
    })

    function add() {
        var formData = new FormData(document.querySelector("#frm_dokter"))
        $.ajax({
            url         : "{{ url('/master_data/dokter/add') }}",
            type        : "post",
            dataType    : "json",
            data        : formData,
            processData : false,
            contentType : false,
            success     : function(r) {
                goReset();
                $('#tbl_dokter').DataTable().ajax.reload();
            }
        })
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
                $('#tbl_dokter').DataTable().ajax.reload();
            }
        })
    }

    function goDelete(id_dokter) {
        if(confirm("Anda yakin akan menghapus data dokter ini?")) {
            $.get("{{ url('/master_data/dokter/delete') }}/" + id_dokter)
                .done(function(r) {
                    $('#tbl_dokter').DataTable().ajax.reload();
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

    function goReset() {
        $("#id_dokter").val("");
        $("#nama_dokter").val("");
        $("#no_telepon").val("");
        $("#nip").val("");
        $("#id_spesialis").val("");
        $("#btn_simpan").show();
        $("#btn_ubah").hide();
    }
</script>
@endsection