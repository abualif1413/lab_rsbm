<?php

namespace App\DataProviders;

use \App\Models\PenandaTanganHasil;

class PenandaTanganHasilDataProvider
{
    public $jenis_jenis = [
        "dokter" => "Dokter Pemeriksa",
        "petugas" => "Petugas Laboratorium",
        "karumkit" => "Kepala Rumah Sakit",
    ];

    public function add($jenis, $nama, $keterangan)
    {
        $ttd = new PenandaTanganHasil;
        $ttd->jenis = $jenis;
        $ttd->nama = $nama;
        $ttd->keterangan = $keterangan;
        $ttd->save();
    }

    public function edit($id_penanda_tangan_hasil, $jenis, $nama, $keterangan)
    {
        $ttd = PenandaTanganHasil::find($id_penanda_tangan_hasil);
        $ttd->jenis = $jenis;
        $ttd->nama = $nama;
        $ttd->keterangan = $keterangan;
        $ttd->save();
    }

    public function delete($id_penanda_tangan_hasil)
    {
        $ttd = PenandaTanganHasil::find($id_penanda_tangan_hasil);
        $ttd->delete();
    }

    public function find($id_penanda_tangan_hasil)
    {
        $ttd = PenandaTanganHasil::find($id_penanda_tangan_hasil);

        return $ttd;
    }

    public function getPenandaTangan($jenis = "")
    {
        $ttd = [];
        if($jenis != "")
            $ttd = PenandaTanganHasil::where('jenis', $jenis)->orderBy('jenis', 'asc')->orderBy('nama', 'asc')->get();
        else
            $ttd = PenandaTanganHasil::orderBy('jenis', 'asc')->orderBy('nama', 'asc')->get();

        return $ttd;
    }

    public static function getJenis()
    {
        $saya = new PenandaTanganHasilDataProvider;
        $jenis_jenis = $saya->jenis_jenis;

        return $jenis_jenis;
    }
}
