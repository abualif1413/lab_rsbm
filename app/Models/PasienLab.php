<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienLab extends Model
{
    use HasFactory;
    protected $table = 't_pasien_lab';
    protected $primaryKey = 'id_pasien_lab';
}
