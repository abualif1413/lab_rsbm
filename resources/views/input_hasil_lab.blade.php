@extends('layout.master')

@section('content')

<x-content-title title="Input Hasil Pemeriksaan Lab" />
<x-content-card title="Informasi Pasien">
    <x-slot name="body">
        <div class="row">
            <div class="col-lg-2">Nama</div>
            <div class="col-lg-10">: {{ $pasien->nama }}</div>
        </div>
        <div class="row">
            <div class="col-lg-2">NIK</div>
            <div class="col-lg-10">: {{ $pasien->nik }}</div>
        </div>
        <div class="row">
            <div class="col-lg-2">Kesatuan</div>
            <div class="col-lg-10">: {{ $pasien->kesatuan }}</div>
        </div>
        <div class="row">
            <div class="col-lg-2">Tgl. Lahir</div>
            <div class="col-lg-10">: {{ $pasien->tgl_lahir }}</div>
        </div>
        <div class="row">
            <div class="col-lg-2">Umur</div>
            <div class="col-lg-10">: {{ $pasien->umur }}</div>
        </div>
        <div class="row">
            <div class="col-lg-2">Gender</div>
            <div class="col-lg-10">: {{ $pasien->gender_i }}</div>
        </div>
        <div class="row">
            <div class="col-lg-2">Alamat</div>
            <div class="col-lg-10">: {{ $pasien->alamat }}</div>
        </div>
        <div class="row">
            <div class="col-lg-2">Jenis Pemeriksaan</div>
            <div class="col-lg-10">: {{ $pasien->kegiatan }}</div>
        </div>
        <div class="row">
            <div class="col-lg-2">Tgl Pemeriksaan</div>
            <div class="col-lg-10">: {{ $pasien->tanggal }}</div>
        </div>
    </x-slot>
    <x-slot name="footer">
                
    </x-slot>
</x-content-card>

<x-content-card title="Pilih Pemeriksaan dan Isikan Hasilnya">
    <x-slot name="body">
        <div class="row">
            <div class="col-lg-6">
                <h5>Tentukan pemeriksaan dahulu</h5>
                <div id="jstree_pelayanan"></div>
                <br />
                <button type="button" class="btn btn-sm btn-primary" onclick="tentukan_pelayanan();">Tentukan</button>
            </div>
            <div class="col-lg-6">
                <h5>Kemudian isikan hasilnya</h5>
                <table class="table table-sm table-striped table-hover">
                    <thead class="bg-success">
                        <tr>
                            <th>Pemeriksaan</th>
                            <th width="150px">Hasil</th>
                            <th width="70px">Satuan</th>
                            <th width="70px">Normal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelayanan_untuk_diinput as $pud)
                            @if (count($pud->children) == 0)
                                <tr style="font-size: 90%;">
                                    <td style="padding-left: 20px;">{{ $pud->pelayanan_lab }}</td>
                                    <td>
                                        <input type="text" id_pelayanan_lab="{{ $pud->id_pelayanan_lab }}"
                                            class="form-control form-control-sm txt_input_hasil_pemeriksaan"
                                            value="{{ $pud->hasil }}" />
                                    </td>
                                    <td>{{ $pud->satuan }}</td>
                                    <td>{{ $pud->normal }}</td>
                                </tr>
                            @else
                                <tr style="font-weight: bold;">
                                    <td>{{ $pud->pelayanan_lab }}</td>
                                    <td></td>
                                    <td>{{ $pud->satuan }}</td>
                                    <td>{{ $pud->normal }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <br />
                <button type="button" class="btn btn-sm btn-primary" onclick="go_isi();">Simpan Hasil Pemeriksaan</button>
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
                
    </x-slot>
</x-content-card>

@endsection

@section('modal')

<div class="modal fade" id="modal_hasil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="" method="post" onsubmit="">
        <input type="hidden" name="id_pasien_lab" id="id_pasien_lab_batal" value="{{ $id_pasien_lab }}" />
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Isi Keterangan Hasil Pemeriksaan Lab</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col lg-12">
                            <label for="tanggal" class="col-form-label">No. Lab</label>
                            <input type="text" name="nomor" id="nomor" class="form-control" value="{{ ($pasien ? $pasien->nomor : '') }}" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col lg-12">
                            <label for="tanggal" class="col-form-label">Kesimpulan</label>
                            <input type="text" name="kesimpulan" id="kesimpulan" class="form-control" value="{{ ($keterangan_hasil ? $keterangan_hasil->kesimpulan : '') }}" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-8">
                            <label for="tanggal" class="col-form-label">Bahan Diterima</label>
                            <input type="text" name="bahan_diterima" id="bahan_diterima" class="form-control" value="{{ ($keterangan_hasil ? $keterangan_hasil->bahan_diterima : '') }}" />
                        </div>
                        <div class="col-lg-4">
                            <label for="tanggal" class="col-form-label">Pemeriksaan ke</label>
                            <input type="text" name="swab_ke" id="swab_ke" class="form-control" value="{{ ($keterangan_hasil ? $keterangan_hasil->swab_ke : '') }}" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-3">
                            <label for="tanggal" class="col-form-label">Tgl. Ambil Spesimen</label>
                            <input type="date" name="tgl_pengambilan_spesimen" id="tgl_pengambilan_spesimen" class="form-control" value="{{ ($keterangan_hasil ? $keterangan_hasil->tgl_pengambilan_spesimen : '') }}" />
                        </div>
                        <div class="col-lg-3">
                            <label for="tanggal" class="col-form-label">Jam Ambil Spesimen</label>
                            <input type="time" name="jam_pengambilan_spesimen" id="jam_pengambilan_spesimen" class="form-control" value="{{ ($keterangan_hasil ? $keterangan_hasil->jam_pengambilan_spesimen : '') }}" />
                        </div>
                        <div class="col-lg-3">
                            <label for="tanggal" class="col-form-label">Tgl. Keluar Hasil</label>
                            <input type="date" name="tgl_keluar_hasil" id="tgl_keluar_hasil" class="form-control" value="{{ ($keterangan_hasil ? $keterangan_hasil->tgl_keluar_hasil : '') }}" />
                        </div>
                        <div class="col-lg-3">
                            <label for="tanggal" class="col-form-label">Jam Keluar Hasil</label>
                            <input type="time" name="jam_keluar_hasil" id="jam_keluar_hasil" class="form-control" value="{{ ($keterangan_hasil ? $keterangan_hasil->jam_keluar_hasil : '') }}" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-12">
                            <label for="tanggal" class="col-form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control">{{ ($keterangan_hasil ? $keterangan_hasil->keterangan : '') }}</textarea>
                        </div>
                    </div>
                    <hr />
                    <h5>Penanda Tangan Hasil</h5>
                    <div class="row form-group">
                        <div class="col lg-12">
                            <label for="tanggal" class="col-form-label">Petugas Lab</label>
                            <select name="id_petugas_lab" id="id_petugas_lab" class="form-control">
                                <option value="">- Pilih petugas lab -</option>
                                @foreach ($petugas as $i)
                                    <option value="{{ $i->id_penanda_tangan_hasil }}">{{ $i->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col lg-12">
                            <label for="tanggal" class="col-form-label">Dokter Pemeriksa</label>
                            <select name="id_dokter_pemeriksa" id="id_dokter_pemeriksa" class="form-control">
                                <option value="">- Pilih dokter pemeriksa -</option>
                                @foreach ($dokter as $i)
                                    <option value="{{ $i->id_penanda_tangan_hasil }}">{{ $i->nama }} - {{ $i->keterangan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col lg-12">
                            <label for="tanggal" class="col-form-label">Karumkit</label>
                            <select name="id_karumkit" id="id_karumkit" class="form-control">
                                <option value="">- Pilih karumkit -</option>
                                @foreach ($karumkit as $i)
                                    <option value="{{ $i->id_penanda_tangan_hasil }}">{{ $i->nama }} - {{ $i->keterangan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" onclick="isi_hasil_pemeriksaan();">Simpan</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')

<script src="{{ url('/js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">

    $(function() {
        var konten = document.getElementById("keterangan");
        CKEDITOR.replace(konten,{language:'en-us'});
        CKEDITOR.config.allowedContent = true;

        $('#jstree_pelayanan').jstree({
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

    function tentukan_pelayanan() {
        var selected_node = $('#jstree_pelayanan').jstree("get_selected", true);
        var undetermined_node = $('#jstree_pelayanan').jstree("get_undetermined", true);
        var checked_ids = selected_node.map(function(node) {
            return node.id;
        });
        var undetermined_ids = undetermined_node.map(function(node) {
            return node.id
        });
        var all_ids = [...checked_ids, ...undetermined_ids];

        $.post("{{ url('/antrian_lab/input_hasil/tentukan_pelayanan') }}", {
            _token: "{{ csrf_token() }}",
            id_pasien_lab: {{ $id_pasien_lab ?? 0 }},
            id_pelayanan_lab: JSON.stringify(all_ids)
        }).done(function(r) {
            document.location.href = "{{ url('/antrian_lab/input_hasil') }}/{{ $id_pasien_lab }}";
        })
    }

    function go_isi() {
        $("#modal_hasil").modal({
            show: true
        })
    }

    function isi_hasil_pemeriksaan() {
        if(window.confirm("Anda yakin bahwa hasil pemeriksaan lab pasien ini telah benar dan akan disimpan?")) {
            var hasil_pemeriksaan = [];
            $(".txt_input_hasil_pemeriksaan").each(function() {
                var hasil = $(this).val();
                var id_pelayanan_lab = $(this).attr("id_pelayanan_lab");
                var temp = {
                    id_pelayanan_lab: id_pelayanan_lab,
                    hasil: hasil
                }
                hasil_pemeriksaan.push(temp);
            });
            var nomor = $("#nomor").val();
            var id_petugas_lab = $("#id_petugas_lab").val();
            var id_dokter_pemeriksa = $("#id_dokter_pemeriksa").val();
            var id_karumkit = $("#id_karumkit").val();
            var kesimpulan = $("#kesimpulan").val();
            var bahan_diterima = $("#bahan_diterima").val();
            var swab_ke = $("#swab_ke").val();
            var tgl_pengambilan_spesimen = $("#tgl_pengambilan_spesimen").val();
            var jam_pengambilan_spesimen = $("#jam_pengambilan_spesimen").val();
            var tgl_keluar_hasil = $("#tgl_keluar_hasil").val();
            var jam_keluar_hasil = $("#jam_keluar_hasil").val();
            var keterangan = CKEDITOR.instances.keterangan.getData();;

            $.post("{{ url('/antrian_lab/input_hasil/isi_hasil_pemeriksaan') }}", {
                _token: "{{ csrf_token() }}",
                nomor: nomor,
                id_petugas_lab: id_petugas_lab,
                id_dokter_pemeriksa: id_dokter_pemeriksa,
                id_karumkit:id_karumkit,
                id_pasien_lab: {{ $id_pasien_lab ?? 0 }},
                hasil_pemeriksaan: JSON.stringify(hasil_pemeriksaan),
                kesimpulan: kesimpulan,
                bahan_diterima: bahan_diterima,
                swab_ke: swab_ke,
                tgl_pengambilan_spesimen: tgl_pengambilan_spesimen,
                jam_pengambilan_spesimen: jam_pengambilan_spesimen,
                tgl_keluar_hasil: tgl_keluar_hasil,
                jam_keluar_hasil: jam_keluar_hasil,
                keterangan: keterangan
            }).done(function(r) {
                alert("Data hasil pemeriksaan lab pasien telah disimpan");
                window.open("{{ url('/cetak') }}?id_pasien_lab=" + {{ $id_pasien_lab ?? 0 }});
                document.location.href = "{{ url('/antrian_lab/antrian_selesai_periksa') }}";
            })
        }
    }
</script>

@endsection