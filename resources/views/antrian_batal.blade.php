@extends('layout.master')

@section('content')

<x-content-title title="Antrian Laboratorium yang Batal" />
<x-content-card title="Daftar Pasien yang Batal">
    <x-slot name="body">
        <form action="{{ url('/antrian_lab/antrian_batal') }}">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label">tanggal : </label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="dari" name="dari" value="{{ $dari }}">
                </div>
                <label class="col-sm-1 col-form-label text-center">S/D</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="sampai" name="sampai" value="{{ $sampai }}">
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                </div>
            </div>
        </form>
        <br />
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-sm table-striped table-hover" id="tbl_data">
                    <thead>
                        <tr>
                            <th width="50px"></th>
                            <th width="30px">No.</th>
                            <th>Nama</th>
                            <th>Jenis Kegiatan</th>
                            <th>Alasan Batal</th>
                            <th width="150px">Waktu Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($antrian as $q)
                            <tr>
                                <td><button class="btn btn-sm btn-success btn-block" onclick="goFind({{ $q->id_pasien_lab }});">Detail</button></td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $q->nama }}</td>
                                <td>{{ $q->kegiatan }}</td>
                                <td>{{ $q->alasan_batal }}</td>
                                <td>{{ $q->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
                
    </x-slot>
</x-content-card>

@endsection

@section('modal')

<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="{{ url('/antrian_lab/add') }}" method="post" onsubmit="return saveAdd();">
        <input type="hidden" name="submit_type" id="submit_type" value="add" />
        <input type="hidden" name="id_pasien_lab" id="id_pasien_lab" value="0" />
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Pasien Laboratorium</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col lg-7">
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-4 col-form-label">Tanggal</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $tgl_sekarang }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label">Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_lahir" class="col-sm-4 col-form-label">Tgl. Lahir</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" disabled></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-4 col-form-label">Gender</label>
                                <div class="col-sm-8">
                                    <select name="gender" id="gender" class="form-control" disabled>
                                        <option value="">- Pilih gender -</option>
                                        @foreach ($gender as $i_jk => $jk)
                                            <option value="{{ $i_jk }}">{{ $jk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <label class="col-form-label">Jenis Kegiatan</label>
                            <div class="form-group">
                                @foreach ($kegiatan as $keg)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="id_kegiatan" id="id_kegiatan_{{ $keg->id_kegiatan }}" value={{ $keg->id_kegiatan }} disabled>
                                        <label class="form-check-label" for="id_kegiatan_{{ $keg->id_kegiatan }}">{{ $keg->kegiatan }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')

<script type="text/javascript">
    $(function() {
        $("#tbl_data").DataTable();
    });
    
    function goFind(id_pasien_lab) {
        $.get("{{ url('/antrian_lab/find') }}/" + id_pasien_lab)
        .done(function(r) {
            $("#submit_type").val("edit");
            $("#id_pasien_lab").val(r.id_pasien_lab);
            $("#tanggal").val(r.tanggal);
            $("#nama").val(r.nama);
            $("#tgl_lahir").val(r.tgl_lahir);
            $("#alamat").val(r.alamat);
            $("#gender").val(r.gender);
            var jenis_kegiatan = document.getElementsByName("id_kegiatan");
            for(var i=0; i<jenis_kegiatan.length; i++) {
                if(jenis_kegiatan[i].value == r.id_kegiatan) {
                    jenis_kegiatan[i].checked = true;
                }
            }
            $("#modal_tambah").modal({
                show: true
            })
        })
    }
</script>

@endsection