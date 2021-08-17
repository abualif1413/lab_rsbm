<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienLabProses extends Model
{
    use HasFactory;
    protected $table = 't_pasien_lab_proses';
    protected $primaryKey = 'id_pasien_lab';
    public $incrementing = false;
}
