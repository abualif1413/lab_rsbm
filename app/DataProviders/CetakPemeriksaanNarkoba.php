<?php

namespace App\DataProviders;

use \App\Interfaces\ICetakHasilLab;
use \Carbon\Carbon;

class CetakPemeriksaanNarkoba extends CetakBase implements ICetakHasilLab
{
    public function __construct($id_pasien_lab)
    {
        parent::__construct($id_pasien_lab);
    }

    public function getIsi() {
        $pasien = PasienLabDataProvider::findPasienComplete($this->id_pasien_lab);
        $hasil = PasienLabDataProvider::pelayananUntukDiinput($this->id_pasien_lab);
        $ketHasil = \App\Models\PasienLabKeteranganHasil::find($this->id_pasien_lab);

        $txtHasil = "";
        foreach ($hasil as $hasil) {
            if(count($hasil->children) == 0) {
                $txtHasil .= "
                    <tr style='text-align: left'>
                        <td width='150px'>" . $hasil->pelayanan_lab . "</td>
                        <td width='30px'>:</td>
                        <td>" . $hasil->hasil . "</td>
                    </tr>
                ";
            }
        }

        $waktuPengambilanSpesimen = $ketHasil->tgl_pengambilan_spesimen . "T" . $ketHasil->jam_pengambilan_spesimen;
        $isi = "
            <div style='text-decoration: underline; text-align: center; font-size: 12pt; font-weight: bold;'>
                <div style='text-decoration: underline'>SURAT KETERANGAN ANALISA URINE</div>
                <div>Nomor : " . $pasien->nomor . "</div>
            </div>
            <p>
                Yang bertanda tangan di bawah ini Dokter pada Laboratorium Rumah Sakit Bhayangkara Medan
                melakukan Pemeriksaan / Screening Urine pada :
            </p>
            <table style='margin-left: 20px;'>
                <tr>
                    <td>Hari / Tanggal</td>
                    <td>:</td>
                    <td>" . Carbon::parse($pasien->tanggal)->isoFormat("DD-MM-YYYY") . "</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>" . $pasien->nama . "</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>" . $pasien->umur . " Tahun</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>" . $pasien->gender_i . "</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>" . $pasien->alamat . "</td>
                </tr>
            </table>
            <br />
            Dengan hasil sebagai berikut :
            <br />
            <br />
            <table border='0' style='border-collapse: collapse; margin-left: 20px;' cellpadding='4'>
                <tbody>" . $txtHasil . "</tbody>
            </table>
            <br />
            Dari hasil analisa tersebut di atas diterangkan bahwa : <br />
            " . $ketHasil->keterangan . "
            <br />
            Demikian surat Keterangan hasil analisa ini dibuat dengan sebenar-benarnya atas kekuatan sumpah jabatan.
        ";

        return $isi;
    }
}
