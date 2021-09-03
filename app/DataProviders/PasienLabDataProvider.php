<?php

namespace App\DataProviders;

use Illuminate\Support\Facades\DB;
use App\Models\PasienLab;
use App\Models\PasienLabProses;
use App\Models\PasienLabBatal;
use App\Models\PasienLabKeteranganHasil;
use App\Mail\KirimHasilMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PasienLabDataProvider
{
    public static $status_proses = [
        "masuk" => "masuk",
        "selesai_periksa" => "selesai_periksa",
        "selesai_hasil" => "selesai_hasil",
    ];

    public static function add(PasienLab $pasienLab, $bukti_pembayaran = null)
    {
        $pasienLab->nomor = "";
        $pasienLab->save();
        if($bukti_pembayaran != null) {
            $file = $bukti_pembayaran;
            $extension = $file->getClientOriginalExtension();
    
            if(strtolower($extension) == "png" || strtolower($extension) == "jpg" || strtolower($extension) == "gif") {
                $file_name = md5($pasienLab->id_pasien_lab) . ".png";
                $destination_path = \public_path() . "/bukti_pembayaran";
                $file->move($destination_path, $file_name);
            }
        }
    }

    public static function edit(PasienLab $pasienLab, $bukti_pembayaran = null)
    {
        $pasienLab->save();
    }

    /**
     * digunakan untuk mendapatkan daftar pasien yang sedang mengantri
     */
    public static function getPasienQueue($tanggal = "")
    {
        $tanggal = ($tanggal == "" ? date("Y-m-d") : $tanggal);

        $pasien = PasienLab::leftJoin('t_kegiatan', 't_pasien_lab.id_kegiatan', 't_kegiatan.id_kegiatan')
                    ->leftJoin('t_pasien_lab_proses', 't_pasien_lab.id_pasien_lab', 't_pasien_lab_proses.id_pasien_lab')
                    ->leftJoin('t_pasien_lab_batal', 't_pasien_lab.id_pasien_lab', 't_pasien_lab_batal.id_pasien_lab')
                    ->where('t_pasien_lab.tanggal', $tanggal)
                    ->whereNull('t_pasien_lab_proses.id_pasien_lab')
                    ->whereNull('t_pasien_lab_batal.id_pasien_lab')
                    ->orderBy('t_pasien_lab.created_at', 'asc')
                    ->select('t_pasien_lab.*', 't_kegiatan.kegiatan', 't_pasien_lab_proses.status AS status_proses')
                    ->get();

        return $pasien;
    }

    /**
     * untuk mendapatkan daftar pasien yang gak jadi melakukan pemeriksaan lab
     */
    public static function getPasienBatal($dari = "", $sampai = "")
    {
        $dari = ($dari == "" ? date("Y-m-d") : $dari);
        $sampai = ($sampai == "" ? date("Y-m-d") : $sampai);

        $pasien = PasienLab::leftJoin('t_kegiatan', 't_pasien_lab.id_kegiatan', 't_kegiatan.id_kegiatan')
                    ->leftJoin('t_pasien_lab_batal', 't_pasien_lab.id_pasien_lab', 't_pasien_lab_batal.id_pasien_lab')
                    ->whereBetween('t_pasien_lab.tanggal', [$dari, $sampai])
                    ->whereNotNull('t_pasien_lab_batal.id_pasien_lab')
                    ->orderBy('t_pasien_lab.created_at', 'asc')
                    ->select('t_pasien_lab.*', 't_kegiatan.kegiatan', 't_pasien_lab_batal.alasan AS alasan_batal')
                    ->get();

        return $pasien;
    }

    /**
     * untuk mendapatkan daftar pasien yang sedang masuk ke dalam lab
     */
    public static function getPasienSudahMasuk($tanggal = "")
    {
        $tanggal = ($tanggal == "" ? date("Y-m-d") : $tanggal);

        $pasien = PasienLab::leftJoin('t_kegiatan', 't_pasien_lab.id_kegiatan', 't_kegiatan.id_kegiatan')
                    ->leftJoin('t_pasien_lab_proses', 't_pasien_lab.id_pasien_lab', 't_pasien_lab_proses.id_pasien_lab')
                    ->where('t_pasien_lab.tanggal', $tanggal)
                    ->where('t_pasien_lab_proses.status', self::$status_proses["masuk"])
                    ->whereNotNull('t_pasien_lab_proses.id_pasien_lab')
                    ->orderBy('t_pasien_lab.created_at', 'asc')
                    ->select('t_pasien_lab.*', 't_kegiatan.kegiatan')
                    ->get();

        return $pasien;
    }

    /**
     * untuk mendapatkan daftar pasien yang sudah selesai pemeriksaan lab, tinggal menginput hasilnya saja
     */
    public static function getPasienSelesaiPeriksa($tanggal = "")
    {
        $tanggal = ($tanggal == "" ? date("Y-m-d") : $tanggal);

        $pasien = PasienLab::leftJoin('t_kegiatan', 't_pasien_lab.id_kegiatan', 't_kegiatan.id_kegiatan')
                    ->leftJoin('t_pasien_lab_proses', 't_pasien_lab.id_pasien_lab', 't_pasien_lab_proses.id_pasien_lab')
                    ->where('t_pasien_lab.tanggal', $tanggal)
                    ->where('t_pasien_lab_proses.status', self::$status_proses["selesai_periksa"])
                    ->whereNotNull('t_pasien_lab_proses.id_pasien_lab')
                    ->orderBy('t_pasien_lab.created_at', 'asc')
                    ->select('t_pasien_lab.*', 't_kegiatan.kegiatan')
                    ->get();

        return $pasien;
    }

    /**
     * untuk mendapatkan daftar pasien yang sudah selesai pemeriksaan lab dan sudah diinput hasilnya,
     * Pasien sudah selesai
     */
    public static function getPasienSelesaiHasil($dari = "", $sampai = "", $id_kegiatan = "")
    {
        $dari = ($dari == "" ? date("Y-m-d") : $dari);
        $sampai = ($sampai == "" ? date("Y-m-d") : $sampai);

        $pasien = PasienLab::leftJoin('t_kegiatan', 't_pasien_lab.id_kegiatan', 't_kegiatan.id_kegiatan')
                    ->leftJoin('t_pasien_lab_proses', 't_pasien_lab.id_pasien_lab', 't_pasien_lab_proses.id_pasien_lab')
                    ->leftJoin('t_penanda_tangan_hasil as ttd_dokter', 't_pasien_lab.id_dokter', 'ttd_dokter.id_penanda_tangan_hasil')
                    ->leftJoin('t_penanda_tangan_hasil as ttd_petugas', 't_pasien_lab.id_petugas', 'ttd_petugas.id_penanda_tangan_hasil')
                    ->leftJoin('t_penanda_tangan_hasil as ttd_karumkit', 't_pasien_lab.id_karumkit', 'ttd_karumkit.id_penanda_tangan_hasil')
                    ->whereBetween('t_pasien_lab.tanggal', [$dari, $sampai])
                    ->where('t_pasien_lab_proses.status', self::$status_proses["selesai_hasil"])
                    ->whereNotNull('t_pasien_lab_proses.id_pasien_lab')
                    ->where(function($q) use($id_kegiatan) {
                        if($id_kegiatan != "")
                            $q->where('t_pasien_lab.id_kegiatan', $id_kegiatan);
                    })
                    ->orderBy('t_pasien_lab.created_at', 'asc')
                    ->select(
                        't_pasien_lab.*', 't_kegiatan.kegiatan', 'ttd_dokter.nama AS nama_dokter', 'ttd_dokter.keterangan AS keterangan_dokter',
                        'ttd_petugas.nama AS nama_petugas', 'ttd_petugas.keterangan AS keterangan_petugas',
                        'ttd_karumkit.nama AS nama_karumkit', 'ttd_karumkit.keterangan AS keterangan_karumkit'
                    )
                    ->get();

        return $pasien;
    }

    /**
     * digunakan untuk men set pasien ketika masuk kedalam lab
     */
    public static function pasienMasuk($id_pasien_lab)
    {
        $sudahMasuk = PasienLabProses::find($id_pasien_lab);
        if(!$sudahMasuk) {
            $pasienLabProses = new PasienLabProses;
            $pasienLabProses->id_pasien_lab = $id_pasien_lab;
            $pasienLabProses->status = self::$status_proses["masuk"];
            $pasienLabProses->save();
        } else {
            $sudahMasuk->status = self::$status_proses["masuk"];
            $sudahMasuk->save();
        }
    }

    /**
     * digunakan untuk men set ketika pasien gak jadi masuk ke lab dan balik ke antrian
     */
    public static function pasienBatalMasukLab($id_pasien_lab)
    {
        $pasienLabProses = PasienLabProses::find($id_pasien_lab);
        $pasienLabProses->delete();
    }

    /**
     * digunakan ketika pasien gak jadi melakukan pemeriksaan lab
     */
    public static function pasienBatal($id_pasien_lab, $alasan)
    {
        $sudahBatal = PasienLabBatal::find($id_pasien_lab);
        if(!$sudahBatal) {
            $pasienLabBatal = new PasienLabBatal;
            $pasienLabBatal->id_pasien_lab = $id_pasien_lab;
            $pasienLabBatal->alasan = $alasan;
            $pasienLabBatal->save();
        }
    }

    /**
     * untuk men set pasien bahwa dia sudah selesai pemeriksaan lab, tinggal memasukkan hasilnya saja
     */
    public static function pasienSelesaiPeriksaLab($id_pasien_lab)
    {
        $pasienLabProses = PasienLabProses::find($id_pasien_lab);
        $pasienLabProses->status = self::$status_proses["selesai_periksa"];
        $pasienLabProses->save();
    }

    /**
     * untuk men set pasien bahwa dia sudah selesai pemeriksaan lab dan sudah diinput hasilnya,
     * berarti proses nya telah selesai
     */
    public static function pasienSelesaiInputHasil($id_pasien_lab)
    {
        $pasienLabProses = PasienLabProses::find($id_pasien_lab);
        $pasienLabProses->status = self::$status_proses["selesai_hasil"];
        $pasienLabProses->save();
    }

    /**
     * untuk mencari data lengkap per record untuk pasien lab
     */
    public static function findPasienComplete($id_pasien_lab)
    {
        $pasien = PasienLab::leftJoin('t_kegiatan', 't_pasien_lab.id_kegiatan', 't_kegiatan.id_kegiatan')
                    ->leftJoin('t_penanda_tangan_hasil as ttd_dokter', 't_pasien_lab.id_dokter', 'ttd_dokter.id_penanda_tangan_hasil')
                    ->leftJoin('t_penanda_tangan_hasil as ttd_petugas', 't_pasien_lab.id_petugas', 'ttd_petugas.id_penanda_tangan_hasil')
                    ->leftJoin('t_penanda_tangan_hasil as ttd_karumkit', 't_pasien_lab.id_karumkit', 'ttd_karumkit.id_penanda_tangan_hasil')
                    ->where('t_pasien_lab.id_pasien_lab', $id_pasien_lab)
                    ->select(DB::raw(
                        '
                            t_pasien_lab.*, t_kegiatan.kegiatan, FLOOR(DATEDIFF(CURDATE(),tgl_lahir) / 365) AS umur,
                            CASE
                                WHEN t_pasien_lab.gender = "l" THEN "Laki-Laki"
                                WHEN t_pasien_lab.gender = "p" THEN "Perempuan"
                            END AS gender_i,
                            ttd_dokter.nama AS nama_dokter, ttd_dokter.keterangan AS keterangan_dokter,
                            ttd_petugas.nama AS nama_petugas, ttd_petugas.keterangan AS keterangan_petugas,
                            ttd_karumkit.nama AS nama_karumkit, ttd_karumkit.keterangan AS keterangan_karumkit
                        '
                    ))
                    ->first();

        return $pasien;
    }

    /**
     * menentukan pelayanan yang di set per id_pasien_lab pada table t_pasien_lab_pelayanan_dipilih
     */
    public static function tentukanPelayananPerPasien($id_pasien_lab, $all_id_pelayanan_lab)
    {

        // Pertama lihat dulu apakah ada yg di uncheck tapi masih ada di database
        $cariUncheck = \App\Models\PasienLabPelayananDipilih::where('id_pasien_lab', $id_pasien_lab)->get();
        foreach ($cariUncheck as $cu) {
            $id_pelayanan_lab = $cu->id_pelayanan_lab;
            if(!in_array($id_pelayanan_lab, $all_id_pelayanan_lab)) {

                // Jika si id_pelayanan_lab yang dirujuk tidak ada didalam data checklist, maka hapus dari database
                \App\Models\PasienLabPelayananDipilih::where('id_pasien_lab', $id_pasien_lab)
                ->where('id_pelayanan_lab', $id_pelayanan_lab)
                ->delete();
            }
        }

        // Kemudian insert datanya
        foreach ($all_id_pelayanan_lab as $id_pelayanan_lab) {

            // Cari apakah sudah ada
            $sudahAda = \App\Models\PasienLabPelayananDipilih::where('id_pasien_lab', $id_pasien_lab)
                        ->where('id_pelayanan_lab', $id_pelayanan_lab)->first();

            if(!$sudahAda) {
                // Jika belum ada, maka simpan
                $dipilih = new \App\Models\PasienLabPelayananDipilih;
                $dipilih->id_pasien_lab = $id_pasien_lab;
                $dipilih->id_pelayanan_lab = $id_pelayanan_lab;
                $dipilih->save();
            }
        }
    }

    /**
     * digunakan ketika hasil pemeriksaan sudah didapat dan akan diinput
     */
    public static function isiHasilPemeriksaanLab(
        $id_pasien_lab, $hasil_pemeriksaan,
        $nomor,
        $kesimpulan,
        $bahan_diterima,
        $swab_ke,
        $tgl_pengambilan_spesimen,
        $jam_pengambilan_spesimen,
        $tgl_keluar_hasil,
        $jam_keluar_hasil,
        $keterangan,
        $id_petugas,
        $id_dokter,
        $id_karumkit
    )
    {
        // input hasil ke table t_pasien_lab_pelayanan_dipilih
        foreach ($hasil_pemeriksaan as $hp) {
            $pelayananDipilih = \App\Models\PasienLabPelayananDipilih::where('id_pasien_lab', $id_pasien_lab)
                                ->where('id_pelayanan_lab', $hp["id_pelayanan_lab"])->first();
            if($pelayananDipilih) {
                $id_pasien_lab_pelayanan_dipilih = $pelayananDipilih->id_pasien_lab_pelayanan_dipilih;
                $pelayananDipilihObj = \App\Models\PasienLabPelayananDipilih::find($id_pasien_lab_pelayanan_dipilih);
                $pelayananDipilihObj->hasil = $hp["hasil"];
                $pelayananDipilihObj->save();
            }
        }

        // input keterangan hasil ke table t_pasien_lab_keterangan_hasil
        $ketHasil = PasienLabKeteranganHasil::find($id_pasien_lab);
        if(!$ketHasil)
            $ketHasil = new PasienLabKeteranganHasil;

        $ketHasil->id_pasien_lab = $id_pasien_lab;
        $ketHasil->kesimpulan = $kesimpulan;
        $ketHasil->bahan_diterima = $bahan_diterima;
        $ketHasil->swab_ke = $swab_ke;
        $ketHasil->tgl_pengambilan_spesimen = $tgl_pengambilan_spesimen;
        $ketHasil->jam_pengambilan_spesimen = $jam_pengambilan_spesimen;
        $ketHasil->tgl_keluar_hasil = $tgl_keluar_hasil;
        $ketHasil->jam_keluar_hasil = $jam_keluar_hasil;
        $ketHasil->keterangan = $keterangan;
        $ketHasil->save();

        // Input nomor Lab nya
        $pasienLabObj = PasienLab::find($id_pasien_lab);
        $pasienLabObj->nomor = $nomor;
        $pasienLabObj->id_petugas = $id_petugas;
        $pasienLabObj->id_dokter = $id_dokter;
        $pasienLabObj->id_karumkit = $id_karumkit;
        $pasienLabObj->save();
    }

    /**
     * mengambil semua id id yang telah ditentukan per id_pasien_lab dari table t_pasien_lab_pelayanan_dipilih
     */
    public static function idPelayananYangTelahDitentukan($id_pasien_lab)
    {
        $data = \App\Models\PasienLabPelayananDipilih::where('id_pasien_lab', $id_pasien_lab)->get();
        $ids = [];
        foreach ($data as $data) {
            array_push($ids, $data->id_pelayanan_lab);
        }

        return $ids;
    }

    /**
     * menampilkan data pelayanan yang udah dipilih untuk diinput. Akan dibentuk dalam format html
     */
    public static function pelayananUntukDiinput($id_pasien_lab)
    {
        $id_pelayanan_labs = self::idPelayananYangTelahDitentukan($id_pasien_lab);
        $recurse_pelayanan = \App\DataProviders\PelayananLabDataProvider::recursePelayanan(0, $id_pelayanan_labs, true);

        $array_builder = [];
        self::pelayananUntukDiinputRecurseHelper($array_builder, $recurse_pelayanan);

        foreach ($array_builder as &$ab) {
            $cariHasil = \App\Models\PasienLabPelayananDipilih::where('id_pasien_lab', $id_pasien_lab)
                            ->where('id_pelayanan_lab', $ab->id_pelayanan_lab)->first();
            if($cariHasil)
                $ab->hasil = $cariHasil->hasil;
            else
                $ab->hasil = "";
        }

        return $array_builder;
    }

    public static function pelayananUntukDiinputRecurseHelper(&$array_builder, $array_referer)
    {
        foreach ($array_referer as $arr) {
            array_push($array_builder, $arr);
            self::pelayananUntukDiinputRecurseHelper($array_builder, $arr->children);
        }
    }

    public static function keteranganHasilperPasien($id_pasien_lab)
    {
        $ketHasil = PasienLabKeteranganHasil::find($id_pasien_lab);

        if($ketHasil)
            return $ketHasil;
        else
            return null;
    }

    /**
     * Digunakan untuk mengirim SMS hasilnya ke pasien
     */
    public static function kirimSMSHasil($id_pasien_lab)
    {
        $urlAPI = "http://localhost:8080/rsbm_sms_monitor/api/send";
        $urlCetak = "http://localhost:8080/lab_rsbm/cetak/narkoba?id_pasien_lab=" . $id_pasien_lab;
        $appKey = "123456789";
        $detail = self::findPasienComplete($id_pasien_lab);
        $ketHasil = self::keteranganHasilperPasien($id_pasien_lab);
        $dtHasil = $ketHasil->tgl_keluar_hasil . "T" . $ketHasil->jam_keluar_hasil;
        $dtSpesimen = $ketHasil->tgl_pengambilan_spesimen . "T" . $ketHasil->jam_pengambilan_spesimen;
        $sebutan = ($detail->gender == "l" ? "Bapak" : "Ibu");
        $no_hp = $detail->no_hp;
        $isi = "
            Hai " . $sebutan . " " . $detail->nama . ",\n" . "Pemeriksaan laboratorium anda pada RS. Bhayangkara TK II Medan telah selesai.\n
            Silahkan mengambil spesimen dan hasilnya langsung ke lokasi,
            atau silahkan klik link dibawah untuk mendapatkan soft copy hasil nya\n
            " . $urlCetak . "
        ";

        $data = [
            "destination_number" => $no_hp,
            "text" => $isi,
            "application_key" => $appKey,
            "application_record_id" => $id_pasien_lab
        ];

        return [
            "endpoint" => $urlAPI,
            "appkey" => $appKey,
            "body" => $data
        ];
    }

    public static function emailHasil($id_pasien_lab)
    {
        $urlCetak = "http://202.152.20.114:1237/lab/cetak?id_pasien_lab=" . $id_pasien_lab;
        $detail = self::findPasienComplete($id_pasien_lab);
        $ketHasil = self::keteranganHasilperPasien($id_pasien_lab);
        $dtHasil = $ketHasil->tgl_keluar_hasil . "T" . $ketHasil->jam_keluar_hasil;
        $dtSpesimen = $ketHasil->tgl_pengambilan_spesimen . "T" . $ketHasil->jam_pengambilan_spesimen;
        $sebutan = ($detail->gender == "l" ? "Bapak" : "Ibu");
        $email = $detail->no_hp;

        $hasil = "";
        switch ($detail->id_kegiatan) {
            case '1':
            case '6':
            case '7':
            case '8':
            case '9':
            case '10':
                $cetak = new \App\DataProviders\CetakPemeriksaanLab($id_pasien_lab);
                $hasil = $cetak->getIsi();
                break;
            case '2':
            case '3':
                $cetak = new \App\DataProviders\CetakPemeriksaanNarkoba($id_pasien_lab);
                $hasil = $cetak->getIsi();
                break;
            case '4':
                $cetak = new \App\DataProviders\CetakPemeriksaanAntigen($id_pasien_lab);
                $hasil = $cetak->getIsi();
                break;
            case '5':
                $cetak = new \App\DataProviders\CetakPemeriksaanSwab($id_pasien_lab);
                $hasil = $cetak->getIsi();
                break;
            default:
                # code...
                break;
        }
        
        Mail::to($email)->send(new KirimHasilMail($sebutan, $detail->nama, $detail->kegiatan, $hasil, $urlCetak));
    }
}
