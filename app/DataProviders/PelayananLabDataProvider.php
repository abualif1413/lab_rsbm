<?php

namespace App\DataProviders;

use \App\Models\PelayananLab;

class PelayananLabDataProvider
{
    public static function goAdd(PelayananLab $pelayananLab)
    {
        $pelayananLab->id_parent = $pelayananLab->id_parent ?? 0;
        $pelayananLab->save();
    }

    public static function goUpdate(PelayananLab $pelayananLab)
    {
        $pelayananLab->id_parent = $pelayananLab->id_parent ?? 0;
        $pelayananLab->save();
    }

    public static function getListByParentId($parent_id)
    {
        $parent_id = $parent_id ?? 0;
        $pelayananLab = \App\Models\PelayananLab::where('id_parent', $parent_id)->orderBy('pelayanan_lab', 'asc')->get();

        return $pelayananLab;
    }

    public static function goDelete($id_pelayanan_lab)
    {
        $pelayananLab = \App\Models\PelayananLab::find($id_pelayanan_lab);
        $pelayananLab->delete();
    }

    public static function breadCrumbById($id_pelayanan_lab)
    {
        $breadcrumb = [];
        $stop = false;
        while($stop == false) {
            if($id_pelayanan_lab != 0) {
                $pelayananLab = \App\Models\PelayananLab::find($id_pelayanan_lab);
                array_push($breadcrumb, [
                    "id_pelayanan_lab" => $pelayananLab->id_pelayanan_lab,
                    "pelayanan_lab" => $pelayananLab->pelayanan_lab,
                    "active" => false
                ]);
                $id_pelayanan_lab = $pelayananLab->id_parent;
            } else {
                array_push($breadcrumb, [
                    "id_pelayanan_lab" => 0,
                    "pelayanan_lab" => "Root",
                    "active" => false
                ]);
                $stop = true;
            }
        }

        $breadcrumb = array_reverse($breadcrumb);
        $breadcrumb[count($breadcrumb) - 1]["active"] = true;

        return $breadcrumb;
    }

    public static function jstreeBuilder($id_parent, $checked_id = []) {
        $data = [];
        $pelayananLab = \App\Models\PelayananLab::where('id_parent', $id_parent)->orderBy('pelayanan_lab', 'asc')->get();
        foreach ($pelayananLab as $pl) {
            $anak = \App\Models\PelayananLab::where('id_parent', $pl->id_pelayanan_lab)->get();
            
            $selected = in_array($pl->id_pelayanan_lab, $checked_id);
            if(count($anak) > 0 && $selected)
                $selected = false;

            $temp = [
                "id" => $pl->id_pelayanan_lab,
                "text" => $pl->pelayanan_lab,
                "state" => [
                    "opened" => true,
                    "selected" => $selected
                ],
                "children" => self::jstreeBuilder($pl->id_pelayanan_lab, $checked_id)
            ];
            array_push($data, $temp);
        }

        return $data;
    }

    public static function jstreePerKegiatanBuilder($id_parent, $id_kegiatan, $checked_id = []) {
        $data = [];
        $pelayananLab = \App\Models\PelayananLab::join('t_mapping_kegiatan', 't_pelayanan_lab.id_pelayanan_lab', 't_mapping_kegiatan.id_pelayanan_lab')
                        ->where('t_pelayanan_lab.id_parent', $id_parent)
                        ->where('t_mapping_kegiatan.id_kegiatan', $id_kegiatan)
                        ->orderBy('pelayanan_lab', 'asc')->get();
        foreach ($pelayananLab as $pl) {
            $anak = \App\Models\PelayananLab::where('id_parent', $pl->id_pelayanan_lab)->get();
            
            $selected = in_array($pl->id_pelayanan_lab, $checked_id);
            if(count($anak) > 0 && $selected)
                $selected = false;

            $temp = [
                "id" => $pl->id_pelayanan_lab,
                "text" => $pl->pelayanan_lab,
                "state" => [
                    "opened" => true,
                    "selected" => $selected
                ],
                "children" => self::jstreePerKegiatanBuilder($pl->id_pelayanan_lab, $id_kegiatan, $checked_id)
            ];
            array_push($data, $temp);
        }

        return $data;
    }

    public static function jstree($checked_id = [])
    {
        $jstree_builder = self::jstreeBuilder(0, $checked_id);

        return $jstree_builder;
    }

    public static function jstreePerKegiatan($id_kegiatan, $checked_id = [])
    {
        $jstree_builder = self::jstreePerKegiatanBuilder(0, $id_kegiatan, $checked_id);

        return $jstree_builder;
    }

    public static function recursePelayanan($id_parent, $terbatas_pada = [], $kunci_terbatas = false)
    {
        $data = [];
        if($kunci_terbatas) {
            $pelayananLab = \App\Models\PelayananLab::where('id_parent', $id_parent)
                            ->whereIn('id_pelayanan_lab', $terbatas_pada)
                            ->orderBy('pelayanan_lab', 'asc')->get();
        } else {
            if(count($terbatas_pada) == 0)
                $pelayananLab = \App\Models\PelayananLab::where('id_parent', $id_parent)->orderBy('pelayanan_lab', 'asc')->get();
            else {
                $pelayananLab = \App\Models\PelayananLab::where('id_parent', $id_parent)
                                ->whereIn('id_pelayanan_lab', $terbatas_pada)
                                ->orderBy('pelayanan_lab', 'asc')->get();
            }
        }
        foreach ($pelayananLab as &$pl) {
            $pl->children = self::recursePelayanan($pl->id_pelayanan_lab, $terbatas_pada, $kunci_terbatas);
            array_push($data, $pl);
        }

        return $data;
    }
}
