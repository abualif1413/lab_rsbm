<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenandaTanganHasil extends Model
{
    use HasFactory;
    protected $table = 't_penanda_tangan_hasil';
    protected $primaryKey = 'id_penanda_tangan_hasil';
}
