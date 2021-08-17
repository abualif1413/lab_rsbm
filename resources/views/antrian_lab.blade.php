@extends('layout.master')

@section('content')

<x-content-title title="Antrian Laboratorium" />
<x-content-card title="Daftar Pasien yang Antri">
    <x-slot name="body">
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn btn-sm btn-primary" onclick="goAdd();"><i class="fa fa-plus"></i> Tambah Pasien</button>
                <br />
                <br />
                <table class="table table-sm table-striped table-hover" id="tbl_data">
                    <thead>
                        <tr>
                            <th width="50px"></th>
                            <th width="50px"></th>
                            <th width="50px"></th>
                            <th width="30px">No.</th>
                            <th>Nama</th>
                            <th>Jenis Kegiatan</th>
                            <th width="150px">Waktu Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($antrian as $q)
                            <tr>
                                @if ($ada_yang_masuk == true)
                                    @if (strtolower($q->sedang_masuk == true))
                                        <td><button class="btn btn-sm btn-success btn-block" onclick="goFind({{ $q->id_pasien_lab }});">Ubah</button></td>
                                        <td></td>
                                        <td><button class="btn btn-sm btn-default btn-block" disabled onclick="goPasienMasuk({{ $q->id_pasien_lab }});">Masuk</button></td>
                                    @else
                                        <td><button class="btn btn-sm btn-success btn-block" onclick="goFind({{ $q->id_pasien_lab }});">Ubah</button></td>
                                        <td><button class="btn btn-sm btn-warning btn-block" onclick="goBatal({{ $q->id_pasien_lab }});">Batal</button></td>
                                        <td></td>
                                    @endif
                                @else
                                    <td><button class="btn btn-sm btn-success btn-block" onclick="goFind({{ $q->id_pasien_lab }});">Ubah</button></td>
                                    <td><button class="btn btn-sm btn-warning btn-block" onclick="goBatal({{ $q->id_pasien_lab }});">Batal</button></td>
                                    <td><button class="btn btn-sm btn-primary btn-block" onclick="goPasienMasuk({{ $q->id_pasien_lab }});">Masuk</button></td>
                                @endif
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $q->nama }}</td>
                                <td>{{ $q->kegiatan }}</td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pasien Laboratorium</h5>
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
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $tgl_sekarang }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label">Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label">NIK</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label">Kesatuan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="kesatuan" name="kesatuan" placeholder="Kesatuan" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label">No. HP</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="No. HP" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_lahir" class="col-sm-4 col-form-label">Tgl. Lahir</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-4 col-form-label">Gender</label>
                                <div class="col-sm-8">
                                    <select name="gender" id="gender" class="form-control">
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
                                        <input class="form-check-input" type="radio" name="id_kegiatan" id="id_kegiatan_{{ $keg->id_kegiatan }}" value={{ $keg->id_kegiatan }}>
                                        <label class="form-check-label" for="id_kegiatan_{{ $keg->id_kegiatan }}">{{ $keg->kegiatan }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="modal_batal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="{{ url('/antrian_lab/add') }}" method="post" onsubmit="return saveBatal();">
        <input type="hidden" name="submit_type" id="submit_type" value="batal" />
        <input type="hidden" name="id_pasien_lab" id="id_pasien_lab_batal" value="0" />
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Batalkan Pasien Laboratorium</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col lg-12">
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-2 col-form-label">Alasan Batal</label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control" id="alasan_batal" name="alasan" placeholder="Alasan Batal"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
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
    function goAdd() {
        $("#submit_type").val("add");
        $("#id_pasien_lab").val("0");
        $("#tanggal").val("{{ $tgl_sekarang }}");
        $("#nama").val("");
        $("#nik").val("");
        $("#kesatuan").val("");
        $("#no_hp").val("");
        $("#tgl_lahir").val("");
        $("#alamat").val("");
        $("#gender").val("");
        var jenis_kegiatan = document.getElementsByName("id_kegiatan");
        for(var i=0; i<jenis_kegiatan.length; i++) {
            jenis_kegiatan[i].checked = false;
        }
        $("#modal_tambah").modal({
            show: true
        })
    }

    function goPasienMasuk(id_pasien_lab) {
        if(window.confirm("Anda yakin bahwa pasien ini akan masuk Lab dan melakukan pemeriksaan?")) {
            document.location.href = "{{ url('/antrian_lab/pasien_masuk') }}?id_pasien_lab=" + id_pasien_lab;
        }
    }

    function goFind(id_pasien_lab) {
        $.get("{{ url('/antrian_lab/find') }}/" + id_pasien_lab)
        .done(function(r) {
            $("#submit_type").val("edit");
            $("#id_pasien_lab").val(r.id_pasien_lab);
            $("#tanggal").val(r.tanggal);
            $("#nama").val(r.nama);
            $("#nik").val(r.nik);
            $("#kesatuan").val(r.kesatuan);
            $("#no_hp").val(r.no_hp);
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

    function goBatal(id_pasien_lab) {
        $("#id_pasien_lab_batal").val(id_pasien_lab);
        $("#alasan_batal").val("");
        $("#modal_batal").modal({
            show: true
        })
    }

    function saveAdd() {
        var tanggal = $("#tanggal").val();
        var nama = $("#nama").val();
        var tgl_lahir = $("#tgl_lahir").val();
        var alamat = $("#alamat").val();
        var gender = $("#gender").val();

        if(tanggal == "" || nama == "" || tgl_lahir == "" || alamat == "" || gender == "") {
            alert("Input belum lengkap");
            return false;
        } else {
            var jenis_kegiatan = document.getElementsByName("id_kegiatan");
            var ada_dipilih = false;
            for(var i=0; i<jenis_kegiatan.length; i++) {
                if(jenis_kegiatan[i].checked == true) {
                    ada_dipilih = true;
                }
            }
            if(ada_dipilih == false) {
                alert("Harap isikan jenis kegiatan pemeriksaan laboratorium");
                return false;
            } else {
                return window.confirm("Anda yakin akan menyimpan data ini?");
            }
        }
    }

    function saveBatal() {
        var alasan = $("#alasan_batal").val();
        if(alasan.trim() == "") {
            alert("Harap isikan alasan kenapa pasien ini membatalkan pemeriksaan lab");
            return false;
        } else {
            return window.confirm("Anda yakin bahwa pasien ini akan membatalkan pemeriksaan lab?");
        }
    }
</script>

@endsection