<?php

namespace App\DataProviders;

class KegiatanDataProvider
{
    public static function all()
    {
        $kegiatan = \App\Models\Kegiatan::orderBy('urutan', 'asc')->get();

        return $kegiatan;
    }

    public static function find($id_kegiatan)
    {
        $kegiatan = \App\Models\Kegiatan::find($id_kegiatan);

        return $kegiatan;
    }
}
