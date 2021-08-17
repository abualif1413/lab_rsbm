<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\DataProviders\PenandaTanganHasilDataProvider;
use \App\Models\PenandaTanganHasil;

class PenandaTanganHasilController extends Controller
{
    public function home(Request $req)
    {
        $provider = new PenandaTanganHasilDataProvider;
        $daftar = $provider->getPenandaTangan();
        foreach ($daftar as &$dft) {
            $dft->jenis_i = $provider->jenis_jenis[$dft->jenis];
        }

        $find = null;
        if($req->id_penanda_tangan_hasil)
            $find = $provider->find($req->id_penanda_tangan_hasil);

        return view('penanda_tangan_hasil', [
            "jenis" => PenandaTanganHasilDataProvider::getJenis(),
            "daftar" => $daftar,
            "find" => $find
        ]);
    }

    public function submit(Request $req)
    {
        $provider = new PenandaTanganHasilDataProvider;
        if($req->submit_type == "add")
            $provider->add($req->jenis, $req->nama, $req->keterangan);
        elseif($req->submit_type == "edit")
            $provider->edit($req->id_penanda_tangan_hasil, $req->jenis, $req->nama, $req->keterangan);

        return redirect("/penanda_tangan_hasil");
    }

    public function delete(Request $req)
    {
        $provider = new PenandaTanganHasilDataProvider;
        $provider->delete($req->id_penanda_tangan_hasil);

        return redirect("/penanda_tangan_hasil");
    }
}
