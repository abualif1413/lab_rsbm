@extends('layout.master')

@section('content')

<x-content-title title="Antrian Laboratorium yang Sudah Selesai" />
<x-content-card title="Daftar Pasien yang Sudah Selesai">
    <x-slot name="body">
        <form action="{{ url('/antrian_lab/antrian_selesai_hasil') }}">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">tanggal : </label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="dari" name="dari" value="{{ $dari }}">
                </div>
                <label class="col-sm-1 col-form-label text-center">S/D</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="sampai" name="sampai" value="{{ $sampai }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Pemeriksaan : </label>
                <div class="col-sm-5">
                    <select name="id_kegiatan_src" id="id_kegiatan_src" class="form-control">
                        <option value="">- Semua Pemeriksaan -</option>
                        @foreach ($kegiatan as $kg)
                        @if ($kg->id_kegiatan == $id_kegiatan_src)
                            <option value="{{ $kg->id_kegiatan }}" selected>{{ $kg->kegiatan }}</option>
                        @else
                            <option value="{{ $kg->id_kegiatan }}">{{ $kg->kegiatan }}</option>   
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <hr />
            <div class="form-group row">
                <div class="col-lg-2">
                    <button class="btn btn-primary btn-sm" type="submit">Cari Data Pasien</button>
                </div>
            </div>
        </form>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-sm table-striped table-hover" id="tbl_data">
                    <thead>
                        <tr>
                            <th width="50px"></th>
                            <th width="50px"></th>
                            <th width="50px"></th>
                            <th width="50px"></th>
                            <th width="30px">No.</th>
                            <th>Nama</th>
                            <th>Jenis Kegiatan</th>
                            <th width="150px">Tgl Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($antrian as $q)
                            <tr>
                                <td><button class="btn btn-sm btn-success btn-block" onclick="goFind({{ $q->id_pasien_lab }});">Detail</button></td>
                                {{-- <td><button class="btn btn-sm btn-primary btn-block" onclick="goCetak({{ $q->id_pasien_lab }})">Cetak</button></td> --}}
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Cetak
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="javascript:goCetak({{ $q->id_pasien_lab }}, 1);">Dengan Kop Surat</a>
                                            <a class="dropdown-item" href="javascript:goCetak({{ $q->id_pasien_lab }}, 0);">Tanpa Kop Surat</a>
                                        </div>
                                    </div>
                                </td>
                                <td><button class="btn btn-sm btn-warning btn-block" onclick="goHasil({{ $q->id_pasien_lab }})">Hasil</button></td>
                                <td><button class="btn btn-sm btn-primary btn-block" onclick="goSMS({{ $q->id_pasien_lab }}, this)">Email</button></td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $q->nama }}</td>
                                <td>{{ $q->kegiatan }}</td>
                                <td>{{ $q->tanggal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        <a href="{{ url('/cetak/pasien_selesai') }}?dari={{ $dari }}&sampai={{ $sampai }}&id_kegiatan={{ $id_kegiatan_src }}" target="_blank" class="btn btn-sm btn-primary">Cetak Data</a>
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

    function goCetak(id_pasien_lab, cetak_kop) {
        window.open("{{ url('/cetak') }}?id_pasien_lab=" + id_pasien_lab + "&cetak_kop=" + cetak_kop);
    }

    function goHasil(id_pasien_lab) {
        document.location.href = "{{ url('/antrian_lab/input_hasil') }}/" + id_pasien_lab;
    }

    function goSMS(id_pasien_lab, elm) {
        if(confirm("Anda yakin akan mengirim pesan kepada pasien ini?")) {
            $(elm).attr("disabled", true);
            $(elm).html("Loading...");
            $.get("{{ url('/antrian_lab/sms_hasil') }}/" + id_pasien_lab)
            .done(function(r) {
                console.log(r);
                alert("Email informasi pengambilan hasil telah dikirim");
                $(elm).removeAttr("disabled");
                $(elm).html("Email");
            })
        }
    }
</script>

@endsection