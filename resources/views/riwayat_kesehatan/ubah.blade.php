@extends('layout.master')

@section('content')

<x-content-title title="Ubah Data Riwayat Kesehatan" />
<x-content-card title="Form Riwayat Kesehatan Personil">
    <x-slot name="body">
        <form action="" autocomplete="off" id="frm_rikes">
            @csrf
            <input type="hidden" name="id_riwayat_kesehatan" id="id_riwayat_kesehatan" value="{{ $rikes->id_riwayat_kesehatan }}">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="">Nama Personil</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $rikes->nama }}">
                </div>
                <div class="form-group col-sm-4">
                    <label for="">Pangkat</label>
                    <select name="id_pangkat" id="id_pangkat" class="form-control">
                        <option value="">- Pilih pangkat -</option>
                        @foreach ($pangkat as $p)
                            @if ($p["key"] == $rikes->id_pangkat)
                                <option value="{{ $p["key"] }}" selected>{{ $p["value"] }}</option>
                            @else
                                <option value="{{ $p["key"] }}">{{ $p["value"] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="">Satuan Kerja</label>
                    <select name="id_satuan_kerja" id="id_satuan_kerja" class="form-control">
                        <option value="">- Pilih satuan kerja -</option>
                        @foreach ($satker as $sk)
                        @if ($sk["key"] == $rikes->id_satuan_kerja)
                            <option value="{{ $sk["key"] }}" selected>{{ $sk["value"] }}</option>
                        @else
                            <option value="{{ $sk["key"] }}">{{ $sk["value"] }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="">Diagnosa</label>
                    <textarea name="diagnosa" id="diagnosa" class="form-control">{{ $rikes->diagnosa }}</textarea>
                </div>
                <div class="form-group col-sm-6">
                    <label for="">Terapi</label>
                    <textarea name="terapi" id="terapi" class="form-control">{{ $rikes->terapi }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="">Tindak Lanjut</label>
                    <textarea name="tindak_lanjut" id="tindak_lanjut" class="form-control">{{ $rikes->tindak_lanjut }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    <label for="">Tgl. Pemeriksaan</label>
                    <input type="date" name="tgl_pemeriksaan" id="tgl_pemeriksaan" class="form-control" value="{{ $rikes->tgl_pemeriksaan }}">
                </div>
                <div class="form-group col-sm-3">
                    <label for="">Tgl. Kontrol Ulang</label>
                    <input type="date" name="tgl_kontrol_ulang" id="tgl_kontrol_ulang" class="form-control" value="{{ $rikes->tgl_kontrol_ulang }}">
                </div>
                <div class="form-group col-sm-6">
                    <label for="">Status Cuti</label>
                    <select name="status_cuti" id="status_cuti" class="form-control">
                        <option value="">- Pilih status cuti -</option>
                        @foreach ($status_cuti as $sc)
                        @if ($sc["key"] == $rikes->status_cuti)
                            <option value="{{ $sc["key"] }}" selected>{{ $sc["value"] }}</option>
                        @else
                            <option value="{{ $sc["key"] }}">{{ $sc["value"] }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="">Dokter Pemeriksa</label>
                    <input type="text" name="dokter_pemeriksa" id="dokter_pemeriksa" class="form-control" value="{{ $rikes->dokter_pemeriksa }}">
                </div>
                <div class="form-group col-sm-4">
                    <label for="">Home Visit</label>
                    <select name="home_visit" id="home_visit" class="form-control">
                        <option value="">- Pilih Home Visit -</option>
                        <option value="1" @if($rikes->home_visit == "1") selected @endif>Ya</option>
                        <option value="0" @if($rikes->home_visit == "0") selected @endif>Tidak</option>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="">Rumah Sakit</label>
                    <input type="text" name="rumah_sakit" id="rumah_sakit" class="form-control" value="{{ $rikes->rumah_sakit }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="">Tahap</label>
                    <select name="tahap" id="tahap" class="form-control">
                        <option value="">- Pilih Tahap -</option>
                        <option value="1" @if($rikes->tahap == "1") selected @endif>1</option>
                        <option value="2" @if($rikes->tahap == "2") selected @endif>2</option>
                        <option value="3" @if($rikes->tahap == "3") selected @endif>3</option>
                        <option value="4" @if($rikes->tahap == "4") selected @endif>4</option>
                    </select>
                </div>
            </div>
        </form>
    </x-slot>
    <x-slot name="footer">
        <button type="button" class="btn btn-primary" id="btn_simpan" onclick="add();">Simpan</button>
        <button type="button" class="btn btn-warning" onclick="document.location.href='{{ url("/riwayat_kesehatan") }}'">Kembali</button>
    </x-slot>
</x-content-card>

@endsection

@section('js')
<script type="text/javascript">
    function add() {
        if(confirm("Anda yakin akan menyimpan data riwayat kesehatan ini?")) {
            var formData = new FormData(document.querySelector("#frm_rikes"))
            $.ajax({
                url         : "{{ url('/riwayat_kesehatan/update') }}",
                type        : "post",
                dataType    : "json",
                data        : formData,
                processData : false,
                contentType : false,
                success     : function(r, textStatus, xhr) {
                    alert(r.message);
                    document.location.href = "{{ url('/riwayat_kesehatan') }}";
                },
                statusCode: {
                    422: function(responseObject, textStatus, jqXHR) {
                        let error_response = responseObject.responseJSON;
                        let error_message = "Data yang diinput belum lengkap \n" + JSON.stringify(error_response.errors)
                        console.log(responseObject);
                        alert(error_message);
                    }         
                }
            })
        }
    }
</script>
@endsection

@section('modal')

@endsection