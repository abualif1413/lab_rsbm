<?php

namespace App\DataProviders;

class MappingKegiatanDataProvider
{
    public static function insert($id_kegiatan, $id_pelayanan_lab)
    {
        // Hapus dulu sebelumnya
        \App\Models\MappingKegiatan::where('id_kegiatan', $id_kegiatan)->delete();

        // Baru masukkan yang baru
        foreach ($id_pelayanan_lab as $id_pl) {
            $mappingKegiatan = new \App\Models\MappingKegiatan;
            $mappingKegiatan->id_kegiatan = $id_kegiatan;
            $mappingKegiatan->id_pelayanan_lab = $id_pl;
            $mappingKegiatan->save();
        }
    }

    public static function getPelayananLabMapOnKegiatan($id_kegiatan)
    {
        $mapp = \App\Models\MappingKegiatan::where('id_kegiatan', $id_kegiatan)->get();
        $id_pelayanan_lab = [];
        foreach ($mapp as $mapp) {
            array_push($id_pelayanan_lab, $mapp->id_pelayanan_lab);
        }
        
        return $id_pelayanan_lab;
    }
}
