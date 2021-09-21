<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;

class CetakController extends Controller
{
    public function cetak(Request $req)
    {
        $cetak_kop = $req->cetak_kop ?? 1;
        $pasien = \App\Models\PasienLab::find($req->id_pasien_lab);
        switch ($pasien->id_kegiatan) {
            case '1':
            case '6':
            case '7':
            case '8':
            case '9':
            case '10':
                return redirect("/cetak/lab?id_pasien_lab=" . $req->id_pasien_lab . "&cetak_kop=" . $cetak_kop);
                break;
            case '2':
            case '3':
                return redirect("/cetak/narkoba?id_pasien_lab=" . $req->id_pasien_lab);
                break;
            case '4':
                return redirect("/cetak/antigen?id_pasien_lab=" . $req->id_pasien_lab . "&cetak_kop=" . $cetak_kop);
                break;
            case '5':
                return redirect("/cetak/swab?id_pasien_lab=" . $req->id_pasien_lab . "&cetak_kop=" . $cetak_kop);
                break;
            default:
                # code...
                break;
        }
    }

    public function cetakSwab(Request $req)
    {
        $cetak = new \App\DataProviders\CetakPemeriksaanSwab($req->id_pasien_lab);
        $cetak->getKopSuratHijau($req->cetak_kop);
        $cetak->getInformasiPasien();
        $cetak->getTtdPetugasLab();
        
        $pdf = PDF::loadview('cetak_swab', [
            "kop_surat_hijau" => $cetak->kopSuratHijau,
            "informasi_pasien" => $cetak->informasiPasien,
            "isi" => $cetak->getIsi(),
            "ttd" => $cetak->ttdPetugasLab
        ]);
        return $pdf->stream();
    }

    public function cetakAntigen(Request $req)
    {
        $cetak = new \App\DataProviders\CetakPemeriksaanAntigen($req->id_pasien_lab);
        $cetak->getKopSuratHijau($req->cetak_kop);
        $cetak->getInformasiPasien();
        $cetak->getTtdPetugasLab();
        
        $pdf = PDF::loadview('cetak_antigen', [
            "kop_surat_hijau" => $cetak->kopSuratHijau,
            "informasi_pasien" => $cetak->informasiPasien,
            "isi" => $cetak->getIsi(),
            "ttd" => $cetak->ttdPetugasLab
        ]);
        return $pdf->stream();
    }

    public function cetakLab(Request $req)
    {
        $cetak = new \App\DataProviders\CetakPemeriksaanLab($req->id_pasien_lab);
        $cetak->getKopSuratHijau($req->cetak_kop);
        $cetak->getInformasiPasien();
        $cetak->getTtdPetugasLab();
        
        $pdf = PDF::loadview('cetak_lab', [
            "kop_surat_hijau" => $cetak->kopSuratHijau,
            "informasi_pasien" => $cetak->informasiPasien,
            "isi" => $cetak->getIsi(),
            "ttd" => $cetak->ttdPetugasLab
        ]);
        return $pdf->stream();
    }

    public function cetakNarkoba(Request $req)
    {
        $cetak = new \App\DataProviders\CetakPemeriksaanNarkoba($req->id_pasien_lab);
        $cetak->getKopSuratPolri();
        $cetak->getTtdPetugasKhususNarkoba();
        
        $pdf = PDF::loadview('cetak_lab', [
            "kop_surat_hijau" => $cetak->kopSuratPolri,
            "informasi_pasien" => $cetak->informasiPasien,
            "isi" => $cetak->getIsi(),
            "ttd" => $cetak->ttdPetugasLab
        ]);
        return $pdf->stream();
    }

    public function cetakPasienSelesai(Request $req)
    {
        $cetak = new \App\DataProviders\CetakPasienSelesai($req->dari, $req->sampai, $req->id_kegiatan);
        
        $pdf = PDF::loadview('cetak_pasien_selesai', [
            "isi" => $cetak->getIsi()
        ]);
        return $pdf->stream();
    }
}
