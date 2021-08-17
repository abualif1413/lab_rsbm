<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienLabPelayananDipilih extends Model
{
    use HasFactory;
    protected $table = 't_pasien_lab_pelayanan_dipilih';
    protected $primaryKey = 'id_pasien_lab_pelayanan_dipilih';
}
