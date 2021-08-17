<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienLabKeteranganHasil extends Model
{
    use HasFactory;
    protected $table = 't_pasien_lab_keterangan_hasil';
    protected $primaryKey = 'id_pasien_lab';
    public $incrementing = false;
}
