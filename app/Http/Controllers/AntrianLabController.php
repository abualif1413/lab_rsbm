<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AntrianLabController extends Controller
{
    public function home(Request $req)
    {
        $antrian = \App\DataProviders\PasienLabDataProvider::getPasienQueue();
        $gender = \App\DataProviders\CommonFunction::genders();
        $kegiatan = \App\DataProviders\KegiatanDataProvider::all();

        $ada_yang_masuk = false;
        foreach ($antrian as &$q) {
            if(strtolower($q->status_proses) == \App\DataProviders\PasienLabDataProvider::$status_proses["masuk"]) {
                $ada_yang_masuk = true;
                $q->sedang_masuk = true;
            } else {
                $q->sedang_masuk = false;
            }
        }

        return view('antrian_lab', [
            "antrian" => $antrian,
            "tgl_sekarang" => date("Y-m-d"),
            "gender" => $gender,
            "kegiatan" => $kegiatan,
            "ada_yang_masuk" => $ada_yang_masuk
        ]);
    }

    public function antrianBatal(Request $req)
    {
        $antrian = [];
        if($req->dari != "" && $req->sampai != "")
            $antrian = \App\DataProviders\PasienLabDataProvider::getPasienBatal($req->dari, $req->sampai);
        else
            $antrian = \App\DataProviders\PasienLabDataProvider::getPasienBatal();
        $gender = \App\DataProviders\CommonFunction::genders();
        $kegiatan = \App\DataProviders\KegiatanDataProvider::all();

        return view('antrian_batal', [
            "antrian" => $antrian,
            "tgl_sekarang" => date("Y-m-d"),
            "gender" => $gender,
            "kegiatan" => $kegiatan,
            "dari" => $req->dari,
            "sampai" => $req->sampai
        ]);
    }

    public function antrianMasuk(Request $req)
    {
        $antrian = [];
        $antrian = \App\DataProviders\PasienLabDataProvider::getPasienSudahMasuk();
        $gender = \App\DataProviders\CommonFunction::genders();
        $kegiatan = \App\DataProviders\KegiatanDataProvider::all();

        return view('antrian_masuk', [
            "antrian" => $antrian,
            "tgl_sekarang" => date("Y-m-d"),
            "gender" => $gender,
            "kegiatan" => $kegiatan
        ]);
    }

    public function antrianSelesaiPeriksa(Request $req)
    {
        $antrian = [];
        $antrian = \App\DataProviders\PasienLabDataProvider::getPasienSelesaiPeriksa();
        $gender = \App\DataProviders\CommonFunction::genders();
        $kegiatan = \App\DataProviders\KegiatanDataProvider::all();

        return view('antrian_selesai_periksa', [
            "antrian" => $antrian,
            "tgl_sekarang" => date("Y-m-d"),
            "gender" => $gender,
            "kegiatan" => $kegiatan
        ]);
    }

    public function antrianSelesaiHasil(Request $req)
    {
        $antrian = [];
        if($req->dari != "" && $req->sampai != "") {
            if($req->id_kegiatan_src == "")
                $antrian = \App\DataProviders\PasienLabDataProvider::getPasienSelesaiHasil($req->dari, $req->sampai);
            else
                $antrian = \App\DataProviders\PasienLabDataProvider::getPasienSelesaiHasil($req->dari, $req->sampai, $req->id_kegiatan_src);
        }
        else {
            if($req->id_kegiatan_src == "")
                $antrian = \App\DataProviders\PasienLabDataProvider::getPasienSelesaiHasil();
            else
                $antrian = \App\DataProviders\PasienLabDataProvider::getPasienSelesaiHasil("", $req->id_kegiatan_src);
        }
        $gender = \App\DataProviders\CommonFunction::genders();
        $kegiatan = \App\DataProviders\KegiatanDataProvider::all();

        return view('antrian_selesai_hasil', [
            "antrian" => $antrian,
            "tgl_sekarang" => date("Y-m-d"),
            "gender" => $gender,
            "kegiatan" => $kegiatan,
            "dari" => $req->dari,
            "sampai" => $req->sampai,
            "id_kegiatan_src" => $req->id_kegiatan_src
        ]);
    }

    public function inputHasil($id_pasien_lab)
    {
        $pasien_lab = \App\DataProviders\PasienLabDataProvider::findPasienComplete($id_pasien_lab);
        $id_pelayanan_yang_telah_ditentukan = \App\DataProviders\PasienLabDataProvider::idPelayananYangTelahDitentukan($id_pasien_lab);
        $pelayanan_jstree = \App\DataProviders\PelayananLabDataProvider::jstreePerKegiatan($pasien_lab->id_kegiatan, $id_pelayanan_yang_telah_ditentukan);
        $pelayanan_untuk_diinput = \App\DataProviders\PasienLabDataProvider::pelayananUntukDiinput($id_pasien_lab);
        $keterangan_hasil = \App\DataProviders\PasienLabDataProvider::keteranganHasilperPasien($id_pasien_lab);

        $objPenandaTangan = new \App\DataProviders\PenandaTanganHasilDataProvider;

        return view('input_hasil_lab', [
            "id_pasien_lab" => $id_pasien_lab,
            "pasien" => $pasien_lab,
            "pelayanan_jstree" => json_encode($pelayanan_jstree),
            "pelayanan_untuk_diinput" => $pelayanan_untuk_diinput,
            "keterangan_hasil" => $keterangan_hasil,
            "petugas" => $objPenandaTangan->getPenandaTangan("petugas"),
            "karumkit" => $objPenandaTangan->getPenandaTangan("karumkit"),
            "dokter" => $objPenandaTangan->getPenandaTangan("dokter"),
        ]);
    }

    public function add(Request $req)
    {
        if($req->submit_type == "add") {
            $pasienLab = new \App\Models\PasienLab;
            $pasienLab->id_kegiatan = $req->id_kegiatan;
            $pasienLab->tanggal = $req->tanggal;
            $pasienLab->nama = $req->nama;
            $pasienLab->nik = $req->nik;
            $pasienLab->kesatuan = $req->kesatuan;
            $pasienLab->no_hp = $req->no_hp;
            $pasienLab->tgl_lahir = $req->tgl_lahir;
            $pasienLab->gender = $req->gender;
            $pasienLab->alamat = $req->alamat;
            \App\DataProviders\PasienLabDataProvider::add($pasienLab);
        } elseif($req->submit_type == "edit") {
            $pasienLab = \App\Models\PasienLab::find($req->id_pasien_lab);
            $pasienLab->id_kegiatan = $req->id_kegiatan;
            $pasienLab->tanggal = $req->tanggal;
            $pasienLab->nama = $req->nama;
            $pasienLab->nik = $req->nik;
            $pasienLab->kesatuan = $req->kesatuan;
            $pasienLab->no_hp = $req->no_hp;
            $pasienLab->tgl_lahir = $req->tgl_lahir;
            $pasienLab->gender = $req->gender;
            $pasienLab->alamat = $req->alamat;
            \App\DataProviders\PasienLabDataProvider::edit($pasienLab);
        } elseif($req->submit_type == "batal") {
            \App\DataProviders\PasienLabDataProvider::pasienBatal($req->id_pasien_lab, $req->alasan);
        }

        return redirect("/antrian_lab");
    }

    public function pasienMasuk(Request $req)
    {
        \App\DataProviders\PasienLabDataProvider::pasienMasuk($req->id_pasien_lab);

        return redirect("/antrian_lab");
    }

    public function pasienBatalMasuk(Request $req)
    {
        \App\DataProviders\PasienLabDataProvider::pasienBatalMasukLab($req->id_pasien_lab);

        return redirect("/antrian_lab/antrian_masuk");
    }

    public function pasienSelesaiPeriksaLab(Request $req)
    {
        \App\DataProviders\PasienLabDataProvider::pasienSelesaiPeriksaLab($req->id_pasien_lab);

        return redirect("/antrian_lab/antrian_masuk");
    }

    public function pasienBatalSelesaiPeriksa(Request $req)
    {
        \App\DataProviders\PasienLabDataProvider::pasienMasuk($req->id_pasien_lab);

        return redirect("/antrian_lab/antrian_selesai_periksa");
    }

    public function find($id_pasien_lab)
    {
        $pasienLab = \App\Models\PasienLab::find($id_pasien_lab);

        return response()->json($pasienLab);
    }

    public function inputHasilTentukanPelayanan(Request $req)
    {
        $id_pelayanan_lab = json_decode($req->id_pelayanan_lab, true);
        \App\DataProviders\PasienLabDataProvider::tentukanPelayananPerPasien($req->id_pasien_lab, $id_pelayanan_lab);

        return response()->json(["success" => 1]);
    }

    public function inputHasilIsiHasilPemeriksaanLab(Request $req)
    {
        $hasil_pemeriksaan = json_decode($req->hasil_pemeriksaan, true);
        \App\DataProviders\PasienLabDataProvider::isiHasilPemeriksaanLab(
            $req->id_pasien_lab,
            $hasil_pemeriksaan,
            $req->nomor,
            $req->kesimpulan,
            $req->bahan_diterima,
            $req->swab_ke,
            $req->tgl_pengambilan_spesimen,
            $req->jam_pengambilan_spesimen,
            $req->tgl_keluar_hasil,
            $req->jam_keluar_hasil,
            $req->keterangan,
            $req->id_petugas_lab,
            $req->id_dokter_pemeriksa,
            $req->id_karumkit
        );
        \App\DataProviders\PasienLabDataProvider::pasienSelesaiInputHasil($req->id_pasien_lab);

        return response()->json(["success" => 1]);
    }
}
