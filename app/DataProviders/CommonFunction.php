<?php

namespace App\DataProviders;

class CommonFunction
{
    public static function genders()
    {
        return ["l" => "Laki-laki", "p" => "Perempuan"];
    }

    public static $bulanIndonesia = [
        "01" => "Januari",
        "02" => "Februari",
        "03" => "Maret",
        "04" => "April",
        "05" => "Mei",
        "06" => "Juni",
        "07" => "Juli",
        "08" => "Agustus",
        "09" => "September",
        "10" => "Oktober",
        "11" => "November",
        "12" => "Desember",
    ];

    public static function tgl_indonesia($tanggal)
    {
        $split_date = explode("-", $tanggal);
        $tanggal = $split_date[2] . " " . self::$bulanIndonesia[$split_date[1]] . " " . $split_date[0];

        return $tanggal;
    }
}
