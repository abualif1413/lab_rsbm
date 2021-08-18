@extends('layout.master')

@section('content')

<x-content-title title="Pengaturan Penanda Tangan Hasil" />

<form action="{{ url('/penanda_tangan_hasil/submit') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id_penanda_tangan_hasil" id="id_penanda_tangan_hasil" value="{{ ($find != null) ? $find->id_penanda_tangan_hasil : "" }}">
    <x-content-card title="Data Penanda Tangan">
        <x-slot name="body">
            <div class="form-group row">
                <label for="pelayanan_lab" class="col-sm-1 col-form-label">Jenis</label>
                <div class="col-sm-4">
                    <select name="jenis" id="jenis" class="form-control">
                        <option value="">- Pilih jenis -</option>
                        @foreach ($jenis as $k_jenis => $v_jenis)
                            @if ($find != null && $find->jenis == $k_jenis)
                                <option value="{{ $k_jenis }}" selected>{{ $v_jenis }}</option>
                            @else
                                <option value="{{ $k_jenis }}">{{ $v_jenis }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <label for="pelayanan_lab" class="col-sm-1 col-form-label">Nama</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="{{ ($find != null) ? $find->nama : "" }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="pelayanan_lab" class="col-sm-2 col-form-label">Keterangan Dibawah</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan Dibawah Nama" value="{{ ($find != null) ? $find->keterangan : "" }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="pelayanan_lab" class="col-sm-2 col-form-label">Scan TTD</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="ttd" name="ttd" placeholder="Upload scan ttd penanda tangan">
                    @if ($find != null)
                        <small class="form-text text-muted">
                            Jika tanda tangan tidak berubah, silahkan di kosongkan
                        </small>
                    @endif
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            @if ($find == null)
                <button type="submit" class="btn btn-sm btn-primary" name="submit_type" value="add">Tambah</button>
            @else
                <button type="submit" class="btn btn-sm btn-primary" name="submit_type" value="edit">Ubah</button>
            @endif
            <a type="reset" class="btn btn-sm btn-warning" href="{{ url('/penanda_tangan_hasil') }}">Reset</a>
        </x-slot>
    </x-content-card>
</form>

<x-content-card title="Data Penanda Tangan">
    <x-slot name="body">
        <table class="table table-striped table-sm" id="tbl_data">
            <thead>
                <tr>
                    <th width="50px"></th>
                    <th width="50px"></th>
                    <th width="20px">No.</th>
                    <th width="200px">Jenis</th>
                    <th>Nama</th>
                    <th>Keterangan Dibawah Nama</th>
                    <th>TTD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftar as $daftar)
                    <tr>
                        <td>
                            <a href="{{ url('/penanda_tangan_hasil/delete') }}?id_penanda_tangan_hasil={{ $daftar->id_penanda_tangan_hasil }}" class="btn btn-sm btn-warning btn-block" onclick="return confirm('Anda yakin akan menghapus data ini?');">Delete</a>
                        </td>
                        <td>
                            <a href="{{ url('/penanda_tangan_hasil') }}?id_penanda_tangan_hasil={{ $daftar->id_penanda_tangan_hasil }}" class="btn btn-sm btn-success btn-block">Ubah</a>
                        </td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $daftar->jenis_i }}</td>
                        <td>{{ $daftar->nama }}</td>
                        <td>{{ $daftar->keterangan }}</td>
                        <td>
                            <img src="{{ url('/public/ttd_pegawai/' . $daftar->scan_ttd) }}" alt="" width="200px" style="object-fit: contain;">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-slot>
    <x-slot name="footer">
        
    </x-slot>
</x-content-card>

@endsection

@section('js')

<script type="text/javascript">
    $(function() {
        $("#tbl_data").DataTable();
    });
</script>

@endsection