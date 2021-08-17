@extends('layout.master')

@section('content')
<x-content-title title="Rekap Jadwal Dokter" />
<x-content-card title="Jadwal Dokter Per Hari">
    <x-slot name="body">
        <div class="row">
            <div class="col-sm-2">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                    @foreach ($rekap as $rkp)
                        <a class="nav-link"
                            id="vert-tabs-{{ $rkp["dow"] }}-tab"
                            data-toggle="pill" href="#vert-tabs-{{ $rkp["dow"] }}" role="tab"
                            aria-controls="vert-tabs-home" aria-selected="true">{{ $rkp["hari"] }}</a>
                        
                    @endforeach
                </div>
            </div>
            <div class="col-sm-10">
                <div class="tab-content" id="vert-tabs-tabContent">
                    @foreach ($rekap as $rkp)
                        <div class="tab-pane text-left fade" id="vert-tabs-{{ $rkp["dow"] }}" role="tabpanel" aria-labelledby="vert-tabs-2-tab">
                            <div id="accordion">
                                @foreach ($rkp["spesialis"] as $spesialis)
                                    <div class="card">
                                        <div class="card-header" id="heading_{{ $rkp["dow"] }}_{{ $spesialis["id_spesialis"] }}">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link btn-sm" data-toggle="collapse" data-target="#collapse_{{ $rkp["dow"] }}_{{ $spesialis["id_spesialis"] }}" aria-expanded="true" aria-controls="collapse_{{ $rkp["dow"] }}_{{ $spesialis["id_spesialis"] }}">
                                                {{ $spesialis["spesialis"] }}
                                                </button>
                                            </h5>
                                        </div>
                                    
                                        <div id="collapse_{{ $rkp["dow"] }}_{{ $spesialis["id_spesialis"] }}" class="collapse" aria-labelledby="heading_{{ $rkp["dow"] }}_{{ $spesialis["id_spesialis"] }}" data-parent="#accordion">
                                            <div class="card-body row">
                                                @foreach ($spesialis["dokter"] as $dokter)
                                                    <div class="col-sm-6">
                                                        <div class="info-box">
                                                            <div class="info-box-content">
                                                                <span class="info-box-text">{{ $dokter["nama_dokter"] }}</span>
                                                                <span class="info-box-number">{{ $dokter["dari"] }} S/D {{ $dokter["sampai"] }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        
    </x-slot>
</x-content-card>
@endsection

@section('js')
@endsection