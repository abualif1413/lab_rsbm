<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelayananLabController extends Controller
{
    public function home(Request $req)
    {
        $daftarPelayananLab = \App\DataProviders\PelayananLabDataProvider::getListByParentId($req->id_parent);
        $pelayananLab = null;
        if($req->find == 1)
            $pelayananLab = \App\Models\PelayananLab::find($req->id_pelayanan_lab);

        // Mencari breadcrumb
        $breadcrumb = \App\DataProviders\PelayananLabDataProvider::breadCrumbById(($req->id_parent ?? 0));

        return view('pelayanan_lab', [
            "id_parent" => $req->id_parent ?? 0,
            "pelayanan_lab" => $pelayananLab,
            "daftar_pelayanan_lab" => $daftarPelayananLab,
            "breadcrumb" => $breadcrumb
        ]);
    }

    public function insert(Request $req)
    {
        if($req->submit_type == "simpan")
        {
            $pelayananLab = new \App\Models\PelayananLab;
            $pelayananLab->id_parent = $req->id_parent;
            $pelayananLab->pelayanan_lab = $req->pelayanan_lab;
            $pelayananLab->satuan = $req->satuan;
            $pelayananLab->normal = $req->normal;
            \App\DataProviders\PelayananLabDataProvider::goAdd($pelayananLab);
        }
        elseif($req->submit_type == "ubah")
        {
            $pelayananLab = \App\Models\PelayananLab::find($req->id_pelayanan_lab);
            $pelayananLab->id_parent = $req->id_parent;
            $pelayananLab->pelayanan_lab = $req->pelayanan_lab;
            $pelayananLab->satuan = $req->satuan;
            $pelayananLab->normal = $req->normal;
            \App\DataProviders\PelayananLabDataProvider::goUpdate($pelayananLab);
        }

        return redirect("/pelayanan_lab?id_parent=" . ($req->id_parent ?? 0));
    }

    public function delete(Request $req)
    {
        $pelayananLab = \App\Models\PelayananLab::find($req->id_pelayanan_lab);
        $id_parent = $pelayananLab->id_parent;
        \App\DataProviders\PelayananLabDataProvider::goDelete($req->id_pelayanan_lab);

        return redirect("/pelayanan_lab?id_parent=" . $id_parent);
    }
}
