@extends('layout.master')

@section('content')

<x-content-title title="Mapping Kegiatan" />
<x-content-card title="Proses Mapping Kegiatan">
    <x-slot name="body">
        <div class="row">
            <div class="col-lg-6">
                <div class="list-group">
                    @foreach ($kegiatan as $keg)
                        @if ($id_kegiatan == $keg->id_kegiatan)
                            <a href="{{ url('/kegiatan') }}?id_kegiatan={{ $keg->id_kegiatan }}"
                                class="list-group-item list-group-item-action active">{{ $keg->kegiatan }}</a>
                        @else    
                            <a href="{{ url('/kegiatan') }}?id_kegiatan={{ $keg->id_kegiatan }}"
                                class="list-group-item list-group-item-action">{{ $keg->kegiatan }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                @if ($id_kegiatan)    
                    <button type="button" class="btn btn-sm btn-primary" onclick="simpan();">Simpan</button>
                    <br /><br />
                    <div id="pelayanan_jstree" style="height: 400px; overflow: scroll;"></div>
                @endif
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
                
    </x-slot>
</x-content-card>

@endsection

@section('js')

<script type="text/javascript">
    $(function() {
        $('#pelayanan_jstree').jstree({
            'core' : {
                'data' : {!! $pelayanan_jstree !!},
            },
            'checkbox' : {
                "keep_selected_style" : false,
                "three_state" : true
            },
            'plugins' : [ "checkbox" ]
        });
    })

    function simpan() {
        var selected_node = $('#pelayanan_jstree').jstree("get_selected", true);
        var undetermined_node = $('#pelayanan_jstree').jstree("get_undetermined", true);
        var checked_ids = selected_node.map(function(node) {
            return node.id;
        });
        var undetermined_ids = undetermined_node.map(function(node) {
            return node.id
        });
        var all_ids = [...checked_ids, ...undetermined_ids];

        $.post("{{ url('/kegiatan/mapping') }}", {
            _token: "{{ csrf_token() }}",
            id_kegiatan: {{ $id_kegiatan ?? 0 }},
            id_pelayanan_lab: JSON.stringify(all_ids)
        }).done(function(r) {
            console.log(r);
            document.location.href = "{{ url('/kegiatan') }}?id_kegiatan={{ $id_kegiatan }}";
        })
    }
</script>

@endsection