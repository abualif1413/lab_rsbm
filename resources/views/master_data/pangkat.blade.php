@extends('layout.master')

@section('content')

{{-- <x-content-title title="Master Pangkat / Gol. Ruang" />
<x-content-card title="Form Dokter">
    <x-slot name="body">
        
    </x-slot>
    <x-slot name="footer">
        
    </x-slot>
</x-content-card> --}}

<x-content-card title="Daftar Pangkat">
    <x-slot name="body">
        <table class="table table-striped table-sm table-hover" id="tbl_pangkat">
            <thead>
                <tr>
                    <th width="30px">No.</th>
                    <th>Gol. Ruang</th>
                    <th>Pangkat</th>
                    <th>Kepanjangan</th>
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

        $('#tbl_pangkat').DataTable({
            ajax: {
                url: "{{ url('/master_data/pangkat/getpangkatdt') }}"
            },
            columns: [
                { data: 'DT_RowIndex' },
                { data: 'gol_ruang' },
                { data: 'pangkat' },
                { data: 'kepanjangan' }
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