<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienLabBatal extends Model
{
    use HasFactory;
    protected $table = 't_pasien_lab_batal';
    protected $primaryKey = 'id_pasien_lab';
    public $incrementing = false;
}
