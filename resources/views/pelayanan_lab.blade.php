@extends('layout.master')

@section('content')

<x-content-title title="Pengaturan Pelayanan Lab" />
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach ($breadcrumb as $bc)
            @if ($bc["active"] == false)
                <li class="breadcrumb-item"><a href="{{ url('/pelayanan_lab') }}?id_parent={{ $bc["id_pelayanan_lab"] }}">{{ $bc["pelayanan_lab"] }}</a></li>
            @else
                <li class="breadcrumb-item active" aria-current="page">{{ $bc["pelayanan_lab"] }}</li>
            @endif
        @endforeach
    </ol>
</nav>
<div class="row">
    <div class="col-lg-5">
        <form action="{{ url('/pelayanan_lab/insert') }}" method="post">
            @csrf()
            <input type="hidden" name="id_parent" value="{{ $id_parent }}">
            <input type="hidden" name="id_pelayanan_lab" value="{{ ($pelayanan_lab ? $pelayanan_lab->id_pelayanan_lab : '') }}">
            <x-content-card title="Data Pelayanan Lab">
                <x-slot name="body">
                    <div class="form-group row">
                        <label for="pelayanan_lab" class="col-sm-5 col-form-label">Pelayanan</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="pelayanan_lab" name="pelayanan_lab" placeholder="Pelayanan" value="{{ ($pelayanan_lab ? $pelayanan_lab->pelayanan_lab : '') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="satuan" class="col-sm-5 col-form-label">Satuan</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" value="{{ ($pelayanan_lab ? $pelayanan_lab->satuan : '') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="normal" class="col-sm-5 col-form-label">Nilai Normal</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="normal" name="normal" placeholder="Nilai Normal" value="{{ ($pelayanan_lab ? $pelayanan_lab->normal : '') }}">
                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    @if ($pelayanan_lab)
                        <button type="submit" class="btn btn-sm btn-primary" name="submit_type" value="ubah">Ubah</button>
                        <button type="button" class="btn btn-sm btn-warning" onclick="document.location.href='{{ url('pelayanan_lab') }}?id_parent={{ $id_parent }}'">Reset</button>
                    @else
                        <button type="submit" class="btn btn-sm btn-primary" name="submit_type" value="simpan">Simpan</button>
                    @endif
                </x-slot>
            </x-content-card>
        </form>
    </div>
    <div class="col-lg-7">
        <x-content-card title="Daftar Pelayanan Lab">
            <x-slot name="body">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="50px"></th>
                            <th width="50px"></th>
                            <th width="50px"></th>
                            <th width="20px">No.</th>
                            <th>Pelayanan</th>
                            <th width="50px">Satuan</th>
                            <th width="50px">Normal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftar_pelayanan_lab as $daftar)
                            <tr>
                                <td><a href="{{ url('/pelayanan_lab?id_parent=' . $daftar->id_pelayanan_lab) }}" class="btn btn-success btn-sm btn-block"><i class="fa fa-chevron-right"></i></a></td>
                                <td><button onclick="find({{ $daftar->id_pelayanan_lab }})" class="btn btn-primary btn-sm btn-block"><i class="fa fa-edit"></i></button></td>
                                <td><button onclick="goDelete({{ $daftar->id_pelayanan_lab }})" class="btn btn-warning btn-sm btn-block"><i class="fa fa-trash"></i></button></td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $daftar->pelayanan_lab }}</td>
                                <td>{{ $daftar->satuan }}</td>
                                <td>{{ $daftar->normal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-slot>
            <x-slot name="footer">
                
            </x-slot>
        </x-content-card>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript">
    function goDelete(id_pelayanan_lab) {
        if(window.confirm("Anda yakin akan menghapus data ini?")) {
            document.location.href = "{{ url('/pelayanan_lab/delete') }}?id_pelayanan_lab=" + id_pelayanan_lab;
        }
    }

    function find(id_pelayanan_lab) {
        document.location.href = "{{ url('/pelayanan_lab') }}?id_parent={{ $id_parent }}&find=1&id_pelayanan_lab=" + id_pelayanan_lab;
    }
</script>

@endsection