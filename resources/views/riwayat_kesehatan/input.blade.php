@extends('layout.master')

@section('content')

<x-content-title title="Input Data Riwayat Kesehatan" />
<x-content-card title="Form Riwayat Kesehatan Personil">
    <x-slot name="body">
        <form action="" autocomplete="off" id="frm_rikes">
            @csrf
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="">Nama Personil</label>
                    <input type="text" name="nama" id="nama" class="form-control">
                </div>
                <div class="form-group col-sm-4">
                    <label for="">Pangkat</label>
                    <select name="id_pangkat" id="id_pangkat" class="form-control">
                        <option value="">- Pilih pangkat -</option>
                        @foreach ($pangkat as $p)
                            <option value="{{ $p["key"] }}">{{ $p["value"] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="">Satuan Kerja</label>
                    <select name="id_satuan_kerja" id="id_satuan_kerja" class="form-control">
                        <option value="">- Pilih satuan kerja -</option>
                        @foreach ($satker as $sk)
                            <option value="{{ $sk["key"] }}">{{ $sk["value"] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="">Diagnosa</label>
                    <textarea name="diagnosa" id="diagnosa" class="form-control"></textarea>
                </div>
                <div class="form-group col-sm-6">
                    <label for="">Terapi</label>
                    <textarea name="terapi" id="terapi" class="form-control"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="">Tindak Lanjut</label>
                    <textarea name="tindak_lanjut" id="tindak_lanjut" class="form-control"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-3">
                    <label for="">Tgl. Pemeriksaan</label>
                    <input type="date" name="tgl_pemeriksaan" id="tgl_pemeriksaan" class="form-control">
                </div>
                <div class="form-group col-sm-3">
                    <label for="">Tgl. Kontrol Ulang</label>
                    <input type="date" name="tgl_kontrol_ulang" id="tgl_kontrol_ulang" class="form-control">
                </div>
                <div class="form-group col-sm-6">
                    <label for="">Status Cuti</label>
                    <select name="status_cuti" id="status_cuti" class="form-control">
                        <option value="">- Pilih status cuti -</option>
                        @foreach ($status_cuti as $sc)
                            <option value="{{ $sc["key"] }}">{{ $sc["value"] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="">Dokter Pemeriksa</label>
                    <input type="text" name="dokter_pemeriksa" id="dokter_pemeriksa" class="form-control">
                </div>
                <div class="form-group col-sm-4">
                    <label for="">Home Visit</label>
                    <select name="home_visit" id="home_visit" class="form-control">
                        <option value="">- Pilih Home Visit -</option>
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="">Rumah Sakit</label>
                    <input type="text" name="rumah_sakit" id="rumah_sakit" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="">Tahap</label>
                    <select name="tahap" id="tahap" class="form-control">
                        <option value="">- Pilih Tahap -</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
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
        var formData = new FormData(document.querySelector("#frm_rikes"))
        $.ajax({
            url         : "{{ url('/riwayat_kesehatan/add') }}",
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
                    // No content found (404)
                    // This code will be executed if the server returns a 404 response
                }         
            }
        })
        // .fail(function(xhr, textStatus) {
        //     alert("Oops" + "\n" + xhr.status + "\n" + textStatus);
        // })
    }
</script>
@endsection

@section('modal')

@endsection