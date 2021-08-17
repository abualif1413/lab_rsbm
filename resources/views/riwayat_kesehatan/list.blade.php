@extends('layout.master')

@section('content')

<x-content-title title="Data Riwayat Kesehatan" />
<x-content-card title="Tampilkan Data Riwayat Kesehatan Personil">
    <x-slot name="body">
        <button class="btn btn-sm btn-primary" onclick="document.location.href='{{ url("/riwayat_kesehatan/input") }}';">Tambah data riwayat kesehatan</button>
        <hr />
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="">Satuan Kerja</label>
                <select name="id_satuan_kerja" id="id_satuan_kerja" class="form-control">
                    <option value="">- Pilih satuan kerja -</option>
                    @foreach ($satker as $sk)
                        <option value="{{ $sk["key"] }}">{{ $sk["value"] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="">Pangkat</label>
                <select name="id_pangkat" id="id_pangkat" class="form-control">
                    <option value="">- Semua pangkat -</option>
                    @foreach ($pangkat as $p)
                        <option value="{{ $p["key"] }}">{{ $p["value"] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="">Status Cuti</label>
                <select name="status_cuti" id="status_cuti" class="form-control">
                    <option value="">- Semua status cuti -</option>
                    @foreach ($status_cuti as $sc)
                        <option value="{{ $sc["key"] }}">{{ $sc["value"] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                <label for="">Tgl. Pemeriksaan (Dari)</label>
                <input type="date" name="tgl_pemeriksaan_dari" id="tgl_pemeriksaan_dari" class="form-control">
            </div>
            <div class="form-group col-sm-3">
                <label for="">Tgl. Pemeriksaan (Sampai)</label>
                <input type="date" name="tgl_pemeriksaan_sampai" id="tgl_pemeriksaan_sampai" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="">Dokter Pemeriksa</label>
                <input type="text" name="dokter_pemeriksa" id="dokter_pemeriksa" class="form-control">
            </div>
            <div class="form-group col-sm-4">
                <label for="">Rumah Sakit</label>
                <input type="text" name="rumah_sakit" id="rumah_sakit" class="form-control">
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        <button type="button" class="btn btn-primary" id="btn_simpan" onclick="tampilkan();">Tampilkan</button>
        <button type="button" class="btn btn-warning" onclick="goReset();">Reset</button>
    </x-slot>
</x-content-card>

<x-content-card title="Daftar Riwayat Kesehatan Personil">
    <x-slot name="body">
        <button class="btn btn-sm btn-primary" onclick="cetak_ver_01();">Cetak Versi Laporan Karumkit</button>
        <button class="btn btn-sm btn-primary">Cetak Versi Perawatan Sakit Menahun</button>
        <button class="btn btn-sm btn-primary">Cetak Versi Rekap Data Personil</button>
        <button class="btn btn-sm btn-primary">Cetak Versi Sakit Menahun Dengan Cuti</button>
        <br />
        <br />
        <br />
        <table class="table table-striped table-sm table-hover" id="tbl_rikes" style="font-size: 85%;">
            <thead>
                <tr>
                    <th width="50px"></th>
                    <th width="50px"></th>
                    <th width="30px">No.</th>
                    <th>Nama</th>
                    <th>Satker</th>
                    <th>Pangkat</th>
                    <th>Tgl Pemeriksaan</th>
                    <th>Status Cuti</th>
                    <th>Diagnosa</th>
                    <th>Dr. Pemeriksa</th>
                    <th>Rumah Sakit</th>
                </tr>
            </thead>
        </table>
    </x-slot>
    <x-slot name="footer"></x-slot>
</x-content-card>

@endsection

@section('js')
<script type="text/javascript">
    function goReset() {
        $("#id_satuan_kerja").val("");
        $("#id_pangkat").val("");
        $("#status_cuti").val("");
        $("#tgl_pemeriksaan_dari").val("");
        $("#tgl_pemeriksaan_sampai").val("");
        $("#dokter_pemeriksa").val("");
        $("#rumah_sakit").val("");
    }

    function tampilkan() {
        $('#tbl_rikes').DataTable().ajax.reload();
    }

    function goUbah(id_riwayat_kesehatan) {
        document.location.href = "{{ url('/riwayat_kesehatan/ubah') }}/" + id_riwayat_kesehatan;
    }

    function cetak_ver_01() {
        var d = {};
        d.id_satuan_kerja = $("#id_satuan_kerja").val();
        d.id_pangkat = $("#id_pangkat").val();
        d.status_cuti = $("#status_cuti").val();
        d.dokter_pemeriksa = $("#dokter_pemeriksa").val();
        d.rumah_sakit = $("#rumah_sakit").val();
        d.tgl_pemeriksaan_dari = $("#tgl_pemeriksaan_dari").val();
        d.tgl_pemeriksaan_sampai = $("#tgl_pemeriksaan_sampai").val();
        var qs = $.param(d);

        window.open("{{ url('/riwayat_kesehatan/cetak/ver01') }}?" + qs);
    }

    $(function() {
        $('#tbl_rikes').DataTable({
            ajax: {
                url: "{{ url('/riwayat_kesehatan/search') }}",
                type: "get",
                data: function(d) {
                    d.id_satuan_kerja = $("#id_satuan_kerja").val();
                    d.id_pangkat = $("#id_pangkat").val();
                    d.status_cuti = $("#status_cuti").val();
                    d.dokter_pemeriksa = $("#dokter_pemeriksa").val();
                    d.rumah_sakit = $("#rumah_sakit").val();
                    d.tgl_pemeriksaan_dari = $("#tgl_pemeriksaan_dari").val();
                    d.tgl_pemeriksaan_sampai = $("#tgl_pemeriksaan_sampai").val();
                }
            },
            
            columns: [
                { data: 'hapus' },
                { data: 'ubah' },
                { data: 'DT_RowIndex' },
                { data: 'nama' },
                { data: 'satuan_kerja' },
                { data: 'pangkat' },
                { data: 'tgl_pemeriksaan' },
                { data: 'stt_cuti' },
                { data: 'diagnosa' },
                { data: 'dokter_pemeriksa' },
                { data: 'rumah_sakit' }
            ],
            ordering: false
        });
    })
</script>
@endsection

@section('modal')

@endsection