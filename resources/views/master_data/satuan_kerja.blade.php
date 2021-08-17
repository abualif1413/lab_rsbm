@extends('layout.master')

@section('content')

<x-content-title title="Master Data Satuan Kerja" />
<x-content-card title="Form Satuan Kerja">
    <x-slot name="body">
        <form action="" id="frm_satker">
            @csrf
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="">Nama Satuan Kerja</label>
                    <input type="text" name="satuan_kerja" id="satuan_kerja" class="form-control" />
                </div>
                <div class="form-group col-sm-6">
                    <label for="">Kabupaten / Kota</label>
                    <select name="id_kabupaten" id="id_kabupaten" class="form-control">
                        <option value="">- Pilih Kabupaten Kota -</option>
                        @foreach ($kabkot as $kabkot)
                            <option value="{{ $kabkot["key"] }}">{{ $kabkot["value"] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </x-slot>
    <x-slot name="footer">
        <button type="button" class="btn btn-primary" onclick="add();" id="btn_simpan">Simpan</button>
        <button type="button" class="btn btn-success" onclick="" id="btn_ubah">Ubah</button>
        <button type="button" class="btn btn-warning" onclick="goReset();" id="btn_reset">Reset</button>
    </x-slot>
</x-content-card>

<x-content-card title="Daftar Satuan Kerja">
    <x-slot name="body">
        <table class="table table-bordered table-striped table-sm" id="tbl_satker">
            <thead>
                <tr>
                    <th width="30px"></th>
                    <th width="30px"></th>
                    <th width="30px">No.</th>
                    <th>Satuan Kerja</th>
                    <th>Kabupaten / Kota</th>
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

        $('#tbl_satker').DataTable({
            ajax: {
                url: "{{ url('/master_data/satuan_kerja/getsatker') }}"
            },
            columns: [
                { data: 'edit' },
                { data: 'delete' },
                { data: 'nomor' },
                { data: 'satuan_kerja' },
                { data: 'kabupaten' }
            ],
            ordering: false
        });
    })

    function add() {
        var formData = new FormData(document.querySelector("#frm_satker"))
        $.ajax({
            url         : "{{ url('/master_data/satuan_kerja/add') }}",
            type        : "post",
            dataType    : "json",
            data        : formData,
            processData : false,
            contentType : false,
            success     : function(r) {
                goReset();
                $('#tbl_satker').DataTable().ajax.reload();
            }
        })
    }

    function goReset() {
        $("#satuan_kerja").val("");
        $("#id_kabupaten").val("");
        $("#btn_simpan").show();
        $("#btn_ubah").hide();
    }
</script>
@endsection