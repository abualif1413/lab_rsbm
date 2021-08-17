<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelayananLab extends Model
{
    use HasFactory;
    protected $table = 't_pelayanan_lab';
    protected $primaryKey = 'id_pelayanan_lab';
}
