<?php

namespace App\DataProviders;

use \Carbon\Carbon;

class CetakBase
{
    protected $id_pasien_lab;
    public $kopSuratHijau;
    public $kopSuratPolri;
    public $informasiPasien;
    public $ttdPetugasLab;

    public function __construct($id_pasien_lab)
    {
        $this->id_pasien_lab = $id_pasien_lab;
    }

    public function getKopSuratHijau()
    {
        $this->kopSuratHijau = "
            <table width='100%' style='background-color: #bfffbf; border-bottom: solid 3px #ff8989;'>
                <tr>
                    <td width='120px'>
                        <img src='" . url("/images/logo_polda_sumut.png") . "' style='width: 120px; height: 120px; object-fit: contain;' />
                    </td>
                    <td style='text-align: center;'>
                        <div style='font-weight: bold; font-size: 17pt;'>RUMAH SAKIT BHAYANGKARA TK-II MEDAN</div>
                        <div style='font-weight: bold; font-size: 17pt;'>BIDDOKKES POLDA SUMATERA UTARA</div>
                        <div style='font-size: 13pt;'>Jl. K.H. Wahid Hasyim No. 1 Medan 20154</div>
                        <div style='font-size: 13pt;'>Telp: 061-8215990, HP: 081361462147, FAX: 061-8220812</div>
                        <div style='font-size: 13pt;'>Email: subbagpers_rsbm@yahoo.com</div>
                    </td>
                    <td width='120px'>
                        <img src='" . url("/images/logo_dokkes.png") . "' style='width: 120px; height: 120px; object-fit: contain;' />
                    </td>
                </tr>
            </table>
        ";
    }

    public function getKopSuratPolri()
    {
        $this->kopSuratPolri = "
            <div style='text-align: center; width: 400px; margin-top: 100px;'>
                <div>KEPOLISIAN NEGARA REPUBLIK INDONESIA</div>
                <div>DAERAH SUMATERA UTARA</div>
                <div style='text-decoration: underline'>RUMAH SAKIT BHAYANGKARA TK II MEDAN</div>
            </div>
            <br />
            <div style='text-align: center;'>
                <img src='" . url("/images/logo_polri.png") . "' style='width: 80px; height: 80px; object-fit: contain;' />
            </div>
        ";
    }

    public function getInformasiPasien()
    {
        $pasien = PasienLabDataProvider::findPasienComplete($this->id_pasien_lab);
        $this->informasiPasien = "
            <table width='100%'>
                <tr>
                    <td width='150px' style='vertical-align: top'>Nama</td>
                    <td width='5px' valign='top'>:</td>
                    <td style='vertical-align: top'>" . $pasien->nama . "</td>
                    <td width='150px' style='vertical-align: top'>No. LAB / TGL</td>
                    <td width='5px' valign='top'>:</td>
                    <td style='vertical-align: top'>" . $pasien->nomor . " / " . Carbon::parse($pasien->tanggal)->isoFormat("DD-MM-YYYY") . "</td>
                </tr>
                <tr>
                    <td style='vertical-align: top'>Tgl. Lahir / Umur</td>
                    <td width='5px' valign='top'>:</td>
                    <td style='vertical-align: top'>" . $pasien->tgl_lahir . " / " . $pasien->umur . "</td>
                    <td style='vertical-align: top'>NIK</td>
                    <td width='5px' valign='top'>:</td>
                    <td style='vertical-align: top'>" . $pasien->nik . "</td>
                </tr>
                <tr>
                    <td style='vertical-align: top'>Jenis Kelamin</td>
                    <td width='5px' valign='top'>:</td>
                    <td style='vertical-align: top'>" . $pasien->gender_i . "</td>
                    <td style='vertical-align: top'></td>
                    <td style='vertical-align: top'></td>
                    <td style='vertical-align: top'></td>
                </tr>
                <tr>
                    <td style='vertical-align: top'>Alamat Domisili</td>
                    <td width='5px' valign='top'>:</td>
                    <td style='vertical-align: top'>" . $pasien->alamat . "</td>
                    <td style='vertical-align: top'></td>
                    <td style='vertical-align: top'></td>
                    <td style='vertical-align: top'></td>
                </tr>
            </table>
        ";
    }

    public function getTtdPetugasLab()
    {
        $pasien = PasienLabDataProvider::findPasienComplete($this->id_pasien_lab);
        $this->ttdPetugasLab = "
            
            <table width='100%'>
                <tr>
                    <td width='200px' style='text-align: center;' valign='top'>
                        <div style='flex-basis: 100%; text-align: center;'>PETUGAS LAB</div>
                        <div style='height: 2cm;'></div>
                        <div style='flex-basis: 100%; text-align: center;'>" . $pasien->nama_petugas . "</div>
                    </td>
                    <td></td>
                    <td width='300px' style='text-align: center;' valign='top'>
                        <div style='flex-basis: 100%; text-align: center;'>SALAM SEJAWAT</div>
                        <div style='height: 2cm;'></div>
                        <div style='flex-basis: 100%; text-align: center;'><span style='text-decoration: underline;'>" . $pasien->nama_dokter . "</span><br />" . $pasien->keterangan_dokter . "</div>
                    </td>
                </tr>
            </table>
        ";
    }

    public function getTtdPetugasKhususNarkoba()
    {
        $pasien = PasienLabDataProvider::findPasienComplete($this->id_pasien_lab);
        $this->ttdPetugasLab = "
            
            <table width='100%'>
                <tr>
                    <td width='300px' style='text-align: center;' valign='top'>
                        <div style='flex-basis: 100%; text-align: center;'>Diketuahui Oleh:<br />KEPALA RUMAH SAKIT BHAYANGKARA TK II MEDAN</div>
                        <div style='height: 2cm;'></div>
                        <div style='flex-basis: 100%; text-align: center;'><span style='text-decoration: underline;'>" . $pasien->nama_karumkit . "</span><br />" . $pasien->keterangan_karumkit . "</div>
                    </td>
                    <td></td>
                    <td width='300px' style='text-align: center;' valign='top'>
                        <div style='flex-basis: 100%; text-align: center;'>&nbsp;<br />SALAM SEJAWAT</div>
                        <div style='height: 2cm;'></div>
                        <div style='flex-basis: 100%; text-align: center;'><span style='text-decoration: underline;'>" . $pasien->nama_dokter . "</span><br />" . $pasien->keterangan_dokter . "</div>
                    </td>
                </tr>
            </table>
        ";
    }
}
