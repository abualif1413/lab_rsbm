<?php

namespace App\DataProviders;

use \App\Interfaces\ICetakHasilLab;
use \Carbon\Carbon;

class CetakPemeriksaanLab extends CetakBase implements ICetakHasilLab
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
                        <td style='border: solid 1px black;'>" . $hasil->pelayanan_lab . "</td>
                        <td style='border: solid 1px black;'>" . $hasil->hasil . "</td>
                        <td style='border: solid 1px black;'>" . $hasil->satuan . "</td>
                        <td style='border: solid 1px black;'>" . $hasil->normal . "</td>
                    </tr>
                ";
            } else {
                $txtHasil .= "
                    <tr style='text-align: center; font-weight: bold;'>
                        <td style='border: solid 1px black;'>" . $hasil->pelayanan_lab . "</td>
                        <td style='border: solid 1px black;'>" . $hasil->hasil . "</td>
                        <td style='border: solid 1px black;'>" . $hasil->satuan . "</td>
                        <td style='border: solid 1px black;'>" . $hasil->normal . "</td>
                    </tr>
                ";
            }
        }

        $waktuPengambilanSpesimen = $ketHasil->tgl_pengambilan_spesimen . "T" . $ketHasil->jam_pengambilan_spesimen;
        $isi = "
            <h4 style='text-decoration: underline; text-align: center; font-size: 15pt;'>HASIL PEMERIKSAAN LABORATORIUM</h4>
            <table width='100%' border='0' style='border-collapse: collapse; page-break-inside: auto;'>
                <thead style='background-color: #bfffbf;'>
                    <tr>
                        <th style='padding: 5px 2px; border: solid 1px black;'>PEMERIKSAAN</th>
                        <th style='padding: 5px 2px; border: solid 1px black;'>HASIL</th>
                        <th style='padding: 5px 2px; border: solid 1px black;'>SATUAN</th>
                        <th style='padding: 5px 2px; border: solid 1px black;'>NILAI NORMAL</th>
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
