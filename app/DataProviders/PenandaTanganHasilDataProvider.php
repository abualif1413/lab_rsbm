<?php

namespace App\DataProviders;

use \App\Models\PenandaTanganHasil;

class PenandaTanganHasilDataProvider
{
    private $ttd;

    public $jenis_jenis = [
        "dokter" => "Dokter Pemeriksa",
        "petugas" => "Petugas Laboratorium",
        "karumkit" => "Kepala Rumah Sakit",
    ];

    public function add($jenis, $nama, $keterangan, $scan)
    {
        $ttd = new PenandaTanganHasil;
        $ttd->jenis = $jenis;
        $ttd->nama = $nama;
        $ttd->keterangan = $keterangan;
        $ttd->save();
        $this->ttd = $ttd;
        $this->upload_scan($scan);
    }

    public function edit($id_penanda_tangan_hasil, $jenis, $nama, $keterangan, $scan)
    {
        $ttd = PenandaTanganHasil::find($id_penanda_tangan_hasil);
        $ttd->jenis = $jenis;
        $ttd->nama = $nama;
        $ttd->keterangan = $keterangan;
        $ttd->save();
        $this->ttd = $ttd;
        $this->upload_scan($scan);
    }

    private function upload_scan($scan)
    {
        if($scan) {
            $file = $scan;
            $extension = $file->getClientOriginalExtension();
    
            if(strtolower($extension) == "png" || strtolower($extension) == "jpg" || strtolower($extension) == "gif") {
                $file_name = md5($this->ttd->id_penanda_tangan_hasil) . ".png";
                $destination_path = \public_path() . "/ttd_pegawai";
                $file->move($destination_path, $file_name);
            }
        }
    }

    public function delete($id_penanda_tangan_hasil)
    {
        $ttd = PenandaTanganHasil::find($id_penanda_tangan_hasil);
        $scan_ttd = public_path() . "/ttd_pegawai/" . md5($id_penanda_tangan_hasil) . ".png";
        unlink($scan_ttd);
        $ttd->delete();
    }

    public function find($id_penanda_tangan_hasil)
    {
        $ttd = PenandaTanganHasil::find($id_penanda_tangan_hasil);
        $ttd->scan_ttd = md5($ttd->id_penanda_tangan_hasil) . ".png";

        return $ttd;
    }

    public function getPenandaTangan($jenis = "")
    {
        $ttd = [];
        if($jenis != "")
            $ttd = PenandaTanganHasil::where('jenis', $jenis)->orderBy('jenis', 'asc')->orderBy('nama', 'asc')->get();
        else
            $ttd = PenandaTanganHasil::orderBy('jenis', 'asc')->orderBy('nama', 'asc')->get();

        foreach ($ttd as &$sign) {
            $sign->scan_ttd = md5($sign->id_penanda_tangan_hasil) . ".png" ;
        }

        return $ttd;
    }

    public static function getJenis()
    {
        $saya = new PenandaTanganHasilDataProvider;
        $jenis_jenis = $saya->jenis_jenis;

        return $jenis_jenis;
    }
}
