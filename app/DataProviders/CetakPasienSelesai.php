<?php

namespace App\DataProviders;

use \App\Interfaces\ICetakHasilLab;
use \Carbon\Carbon;

class CetakPasienSelesai implements ICetakHasilLab
{
    private $dari;
    private $sampai;
    private $id_kegiatan;

    public function __construct($dari, $sampai, $id_kegiatan)
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
        $this->id_kegiatan = $id_kegiatan;
    }

    public function getIsi() {
        $antrian = [];
        if($this->dari != "" && $this->sampai != "") {
            if($this->id_kegiatan == "")
                $antrian = \App\DataProviders\PasienLabDataProvider::getPasienSelesaiHasil($this->dari, $this->sampai);
            else
                $antrian = \App\DataProviders\PasienLabDataProvider::getPasienSelesaiHasil($this->dari, $this->sampai, $this->id_kegiatan);
        }
        else {
            if($this->id_kegiatan == "")
                $antrian = \App\DataProviders\PasienLabDataProvider::getPasienSelesaiHasil();
            else
                $antrian = \App\DataProviders\PasienLabDataProvider::getPasienSelesaiHasil("", $this->id_kegiatan);
        }

        $kegiatan = \App\DataProviders\KegiatanDataProvider::find($this->id_kegiatan);
        $nama_kegiatan = ($kegiatan ? $kegiatan->kegiatan : " - Semua jenis pemeriksaan - ");

        $isi_antrian = "";
        foreach ($antrian as $i => $q) {
            $isi_antrian .= "
                <tr style='page-break-inside: avoid;'>
                    <td>" . ($i + 1) . "</td>
                    <td>" . $q->kegiatan . "</td>
                    <td>" . $q->nama . "</td>
                    <td align='center'>" . \Carbon\Carbon::parse($q->tanggal)->isoFormat("DD-MM-YYYY") . "</td>
                    <td>" . $q->nama_petugas . "</td>
                    <td>" . $q->nama_dokter . "</td>
                </tr>
            ";
        }

        $isi = "
            <h4 style='position: fixed; top: -2cm;'>
                <div style='font-size: 120%;'>RUMAH SAKIT BHAYANGKARA TK II MEDAN</div>
                Daftar Pasien yang Melakukan Pemeriksaan Laboratorium<br />
                Pada tanggal " . \Carbon\Carbon::parse($this->dari)->isoFormat("DD-MM-YYYY") . " S/D " . \Carbon\Carbon::parse($this->sampai)->isoFormat("DD-MM-YYYY") . "
                untuk pemeriksaan : " . $nama_kegiatan . "
            </h4>
            <table width='100%' cellspacing='0' cellpadding='2' border='1' style='border-collapse: collapse;'>
                <thead style='page-break-inside: avoid;'>
                    <tr>
                        <th width='30px'>No.</th>
                        <th>Pemeriksaan</th>
                        <th>Nama</th>
                        <th>Tgl. Daftar</th>
                        <th>Petugas Lab</th>
                        <th>Dokter Pemeriksa</th>
                    </tr>
                </thead>
                <tbody>" . $isi_antrian . "</tbody>
            </table>
        ";

        return $isi;
    }
}
