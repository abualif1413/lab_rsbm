@extends('layout.master')

@section('content')

<x-content-title title="Jadwal Dokter" />
<form action="{{ url('/master_data/jadwaldokter') }}">
    <x-content-card title="Pilih Dokter">
        <x-slot name="body">
            <div class="form-group">
                <select name="id_dokter" id="id_dokter" class="form-control select2bs4" style="width: 100%;">
                    <option value="">- Pilih Dokter -</option>
                    @foreach ($dokter as $dok)
                        @if ($dok["key"] == $id_dokter)
                            <option value="{{ $dok["key"] }}" selected="selected">{{ $dok["value"] }}</option>
                        @else
                            <option value="{{ $dok["key"] }}">{{ $dok["value"] }}</option>    
                        @endif
                    @endforeach
                </select>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button class="btn btn-primary" type="submit">Set Jadwal</button>
        </x-slot>
    </x-content-card>
</form>

<x-content-card title="Setting Jadwal">
    <x-slot name="body">
        <table class="table table-striped table-sm table-hover">
            <thead>
                <tr>
                    <th width="50px"></th>
                    <th>Hari</th>
                    <th>Jadwal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jaddok as $jad)
                    <tr>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="show_modal({{ $jad['dow'] }});"><i class="fa fa-edit"></i></button>
                        </td>
                        <td>{{ $jad["day"] }}</td>
                        @if ($jad["dari"] != "" && $jad["sampai"] != "")
                            <td>{{ $jad["dari"] }} S/D {{ $jad["sampai"] }}</td>
                        @else
                            <td>- Tidak diset -</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-slot>
    <x-slot name="footer"></x-slot>
</x-content-card>

@endsection

@section('js')
<div class="modal fade bd-example-modal-lg" id="modal_jadwal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Jadwal : {{ $nama_dokter }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/master_data/jadwaldokter/add') }}" id="frm_jadwal">
                    @csrf()
                    <input type="hidden" name="id_dokter" value="{{ $id_dokter }}" />
                    <input type="hidden" name="dow" id="txt_dow" />
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="">Hari</label>
                            <input type="text" name="" id="txt_hari" class="form-control" disabled />
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">dari</label>
                            <input type="time" name="dari" id="txt_dari" class="form-control" />
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="">sampai</label>
                            <input type="time" name="sampai" id="txt_sampai" class="form-control" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" onclick="save_jadwal();">Simpan</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function show_modal(dow) {
        $.get("{{ url('/master_data/showjadwal') }}/{{ $id_dokter }}/" + dow)
            .done(function(r) {
                $("#txt_hari").val(r.hari);
                $("#txt_dari").val(r.dari);
                $("#txt_sampai").val(r.sampai);
                $("#txt_dow").val(dow);
                $('#modal_jadwal').modal({
                    backdrop: 'static',
                    show: true
                })
            });
    }

    function save_jadwal() {
        var dari = $("#txt_dari").val();
        var sampai = $("#txt_sampai").val();
        if(dari == "" || sampai == "") {
            alert("Tentukan jadwal terlebih dahulu");
        } else {
            var formData = new FormData(document.querySelector("#frm_jadwal"))
            $.ajax({
                url         : "{{ url('/master_data/jadwaldokter/add') }}",
                type        : "post",
                dataType    : "json",
                data        : formData,
                processData : false,
                contentType : false,
                success     : function(r) {
                    window.location.reload();
                }
            })
        }
    }
</script>
@endsection