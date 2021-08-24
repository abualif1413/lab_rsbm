@extends('layout.master_non_template')

@section('content')

<div style="display: flex; flex-direction: row; margin-top: 20px;">
    <div style="flex-basis: 100px;">
        <img src="{{ url('/public/images/logo_dokkes.png') }}" alt="Dokkes" style="width: 100%; object-fit: contain; object-position: center center;">
    </div>
    <div style="flex-basis: 0px; flex-grow: 1; display: flex; align-items: center; padding-left: 20px;">
        <h3 style="font-size: 4vw;">
            LAMAN PENDAFTARAN PASIEN LABORATORIUM<br />
            <small>RS. Bhayangkara TK. II Medan</small>
        </h3>
    </div>
</div>

<hr />
<br />

@if ($sudah_daftar == 0)
    <form action="{{ url('/antrian_lab/add_from_guest') }}" method="post" onsubmit="return saveAdd();" enctype="multipart/form-data">
        <input type="hidden" name="submit_type" id="submit_type" value="add" />
        <input type="hidden" name="id_pasien_lab" id="id_pasien_lab" value="0" />
        @csrf
        
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
                    <label for="nama" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Email" value="">
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
                <div class="form-group row">
                    <label for="nama" class="col-sm-4 col-form-label">Foto Bukti Pembayaran</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran"
                            placeholder="Foto Bukti Pembayaran" value=""
                            accept="image/png, image/gif, image/jpeg" />
                    </div>
                </div>
            </div>
            <div class="col-lg-5" style="font-size: 120%;">
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
        <hr />
        <button class="btn btn-primary" type="submit">Simpan Data Pendaftaran Anda</button>
    </form>
@else
    <div class="alert alert-primary">
        Anda sudah melakukan pendaftaran. Silahkan melihat daftar antrian pasien lab
        agar anda dapat mengetahui sudah sejauh apa antrian berlangsung.
    </div>
    <a href="{{ url('/guest') }}" class="btn btn-success">Kembali ke pendaftaran pasien</a>
    <button class="btn btn-primary" onclick="window.location.reload();">Muat ulang</button>
    <br />
    <br />
    <table class="table table-sm table-striped table-hover" id="tbl_data">
        <thead>
            <tr>
                <th width="30px">No.</th>
                <th>Nama</th>
                <th>Jenis Kegiatan</th>
                <th width="150px">Waktu Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($antrian as $q)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $q->nama }}</td>
                    <td>{{ $q->kegiatan }}</td>
                    <td>{{ $q->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
<br />

@endsection

@section('js')

<script type="text/javascript">
    function saveAdd() {
        var tanggal = $("#tanggal").val();
        var nama = $("#nama").val();
        var tgl_lahir = $("#tgl_lahir").val();
        var alamat = $("#alamat").val();
        var gender = $("#gender").val();
        var bukti_pembayaran = $("#bukti_pembayaran").val();

        if(tanggal == "" || nama == "" || tgl_lahir == "" || alamat == "" || gender == "" || bukti_pembayaran == "") {
            alert("Input belum lengkap dan bukti pembayaran harap di foto");
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
</script>

@endsection