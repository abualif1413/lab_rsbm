<?php

namespace App\DataProviders;

use \App\Interfaces\ICetakHasilLab;
use \Carbon\Carbon;

class CetakPemeriksaanAntigen extends CetakBase implements ICetakHasilLab
{
    public function __construct($id_pasien_lab)
    {
        parent::__construct($id_pasien_lab);
    }

    public function getIsi() {
        $hasil = PasienLabDataProvider::pelayananUntukDiinput($this->id_pasien_lab);
        $ketHasil = \App\Models\PasienLabKeteranganHasil::find($this->id_pasien_lab);

        $txtHasil = "";
        foreach ($hasil as $hasil) {
            if(count($hasil->children) == 0) {
                $txtHasil .= "
                    <tr style='text-align: center'>
                        <td>" . $hasil->pelayanan_lab . "</td>
                        <td>" . $hasil->hasil . "</td>
                        <td>NEGATIV</td>
                    </tr>
                ";
            }
        }

        $waktuPengambilanSpesimen = $ketHasil->tgl_pengambilan_spesimen . "T" . $ketHasil->jam_pengambilan_spesimen;
        $isi = "
            <h4 style='text-decoration: underline; text-align: center; font-size: 15pt;'>HASIL PEMERIKSAAN RAPID TEST ANTIGEN SARS - CoV - 2</h4>
            <table width='100%' border='2' style='border-collapse: collapse;'>
                <thead style='background-color: #bfffbf;'>
                    <tr>
                        <th style='padding: 5px 2px;'>PARAMETER</th>
                        <th style='padding: 5px 2px;'>INTERPRESTASI</th>
                        <th style='padding: 5px 2px;'>NILAI RUJUKAN</th>
                    </tr>
                </thead>
                <tbody>" . $txtHasil . "</tbody>
            </table>
            <br />
            <table width='100%'>
                <tr>
                    <td valign='top' width='250px'>Kesimpulan</td>
                    <td valign='top' width='30px'>:</td>
                    <td valign='top'>" . $ketHasil->kesimpulan . "</td>
                </tr>
                <tr>
                    <td valign='top'>Tanggal Pengambilan Spesimen</td>
                    <td valign='top'>:</td>
                    <td valign='top'>" . Carbon::parse($waktuPengambilanSpesimen)->isoFormat("DD-MM-YYYY HH:mm") . " WIB</td>
                </tr>
                <tr>
                    <td valign='top'>Keterangan</td>
                    <td valign='top'>:</td>
                    <td valign='top'>" . $ketHasil->keterangan . "</td>
                </tr>
            </table>
        ";

        return $isi;
    }
}
