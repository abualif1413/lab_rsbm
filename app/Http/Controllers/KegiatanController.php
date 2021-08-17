<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function home(Request $req)
    {
        $kegiatan = \App\DataProviders\KegiatanDataProvider::all();
        $id_pelayanan_lab_map = \App\DataProviders\MappingKegiatanDataProvider::getPelayananLabMapOnKegiatan($req->id_kegiatan);
        $pelayanan_jstree = \App\DataProviders\PelayananLabDataProvider::jstree($id_pelayanan_lab_map);

        return view('kegiatan', [
            "id_kegiatan" => $req->id_kegiatan,
            "kegiatan" => $kegiatan,
            "pelayanan_jstree" => json_encode($pelayanan_jstree)
        ]);
    }

    public function mapping(Request $req)
    {
        $id_pelayanan_lab = json_decode($req->id_pelayanan_lab, true);
        \App\DataProviders\MappingKegiatanDataProvider::insert($req->id_kegiatan, $id_pelayanan_lab);

        return response()->json(["success" => 1]);
    }
}
