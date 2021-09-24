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

    public function getKopSuratHijau($pake_kop = 1)
    {
        if($pake_kop == 1) {
            $this->kopSuratHijau = "
                <table width='100%' style='background-color: #bfffbf; border-bottom: solid 3px #ff8989;'>
                    <tr>
                        <td width='120px'>
                            <img src='" . \public_path() . "/images/logo_polda_sumut.png' style='width: 120px; height: 120px; object-fit: contain;' />
                        </td>
                        <td style='text-align: center;'>
                            <div style='font-weight: bold; font-size: 17pt;'>RUMAH SAKIT BHAYANGKARA TK-II MEDAN</div>
                            <div style='font-weight: bold; font-size: 17pt;'>BIDDOKKES POLDA SUMATERA UTARA</div>
                            <div style='font-size: 13pt;'>Jl. K.H. Wahid Hasyim No. 1 Medan 20154</div>
                            <div style='font-size: 13pt;'>Telp: 061-8215990, HP: 081361462147, FAX: 061-8220812</div>
                            <div style='font-size: 13pt;'>Email: subbagpers_rsbm@yahoo.com</div>
                        </td>
                        <td width='120px'>
                            <img src='" . \public_path() . "/images/logo_dokkes.png' style='width: 120px; height: 120px; object-fit: contain;' />
                        </td>
                    </tr>
                </table>
            ";
        } else {
            $this->kopSuratHijau = "
                <div style='height: 3.4cm;'>&nbsp;</div>
            ";
        }
    }

    public function getKopSuratPolri($pake_kop = 1)
    {
        $this->kopSuratPolri = "
            <div style='text-align: center; width: 400px; margin-top: 100px;'>
                <div>KEPOLISIAN NEGARA REPUBLIK INDONESIA</div>
                <div>DAERAH SUMATERA UTARA</div>
                <div style='text-decoration: underline'>RUMAH SAKIT BHAYANGKARA TK II MEDAN</div>
            </div>
            <br />
            <div style='text-align: center;'>
                <img src='" . \public_path() . "/images/logo_polri.png' style='width: 80px; height: 80px; object-fit: contain;' />
            </div>
        ";
    }

    public function getInformasiPasien()
    {
        $pasien = PasienLabDataProvider::findPasienComplete($this->id_pasien_lab);
        $this->informasiPasien = "
            <table width='100%'>
                <tr>
                    <td width='100px' style='vertical-align: top'>Nama</td>
                    <td width='5px' valign='top'>:</td>
                    <td style='vertical-align: top'>" . $pasien->nama . "</td>
                    <td width='90px' style='vertical-align: top'>No. LAB / TGL</td>
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
        $ttd_provider = new \App\DataProviders\PenandaTanganHasilDataProvider;
        $pasien = PasienLabDataProvider::findPasienComplete($this->id_pasien_lab);
        $ttd_dokter = $ttd_provider->find($pasien->id_dokter);
        $ttd_petugas = $ttd_provider->find($pasien->id_petugas);

        $this->ttdPetugasLab = "
            
            <table width='100%' style='font-weight: bold;'>
                <tr>
                    <td width='200px' style='text-align: center;' valign='top'>
                        <div style='flex-basis: 100%; text-align: center;'>PETUGAS LAB</div>
                        <div style='height: 2cm;'>
                            <img src='" . \public_path() . "/ttd_pegawai/" . $ttd_petugas->scan_ttd . "' style='height: 2cm; object-fit: contain' />
                        </div>
                        <div style='flex-basis: 100%; text-align: center;'>" . $pasien->nama_petugas . "</div>
                    </td>
                    <td></td>
                    <td width='300px' style='text-align: center;' valign='top'>
                        <img src='" . \public_path() . "/images/stempel_rs.png' style='height: 2cm; object-fit: contain; position: absolute; z-index: -4; top: 15px; margin-left: 1cm; opacity: 0.4' />
                        <div style='flex-basis: 100%; text-align: center;'>SALAM SEJAWAT</div>
                        <div style='height: 2cm;'>
                            <img src='" . \public_path() . "/ttd_pegawai/" . $ttd_dokter->scan_ttd . "' style='height: 2cm; object-fit: contain' />
                        </div>
                        <div style='flex-basis: 100%; text-align: center;'><span style='text-decoration: underline;'>" . $pasien->nama_dokter . "</span><br />" . $pasien->keterangan_dokter . "</div>
                    </td>
                </tr>
            </table>
        ";
    }

    public function getTtdPetugasKhususNarkoba()
    {
        $ttd_provider = new \App\DataProviders\PenandaTanganHasilDataProvider;
        $pasien = PasienLabDataProvider::findPasienComplete($this->id_pasien_lab);
        $ttd_dokter = $ttd_provider->find($pasien->id_dokter);
        $ttd_karumkit = $ttd_provider->find($pasien->id_karumkit);
        $ketHasil = \App\Models\PasienLabKeteranganHasil::find($this->id_pasien_lab);

        $tgl_ttd = \App\DataProviders\CommonFunction::tgl_indonesia($ketHasil->tgl_keluar_hasil);

        $this->ttdPetugasLab = "
            
            <table width='100%'>
                <tr>
                    <td width='400px' style='text-align: center;' valign='top'>
                    <img src='" . \public_path() . "/images/stempel_rumkit.png' style='height: 3.5cm; object-fit: contain; position: absolute; z-index: -4; top: 15px; margin-left: 2.5cm; opacity: 0.4;' />
                        <div style='flex-basis: 100%; text-align: center;'>Diketahui Oleh:<br />KEPALA RUMAH SAKIT BHAYANGKARA TK II MEDAN</div>
                        <div style='height: 2cm;'>
                            <img src='" . \public_path() . "/ttd_pegawai/" . $ttd_karumkit->scan_ttd . "' style='height: 2cm; object-fit: contain' />
                        </div>
                        <div style='flex-basis: 100%; text-align: center;'><span style='text-decoration: underline;'>" . $pasien->nama_karumkit . "</span><br />" . $pasien->keterangan_karumkit . "</div>
                    </td>
                    <td></td>
                    <td width='300px' style='text-align: center;' valign='top'>
                        <div style='flex-basis: 100%; text-align: center;'>Medan: " . $tgl_ttd . "<br />DOKTER PEMERIKSA</div>
                        <div style='height: 2cm;'>
                            <img src='" . \public_path() . "/ttd_pegawai/" . $ttd_dokter->scan_ttd . "' style='height: 2cm; object-fit: contain' />
                        </div>
                        <div style='flex-basis: 100%; text-align: center;'><span style='text-decoration: underline;'>" . $pasien->nama_dokter . "</span><br />" . $pasien->keterangan_dokter . "</div>
                    </td>
                </tr>
            </table>
        ";
    }
}
