<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappingKegiatan extends Model
{
    use HasFactory;
    protected $table = 't_mapping_kegiatan';
    protected $primaryKey = 'id_mapping_kegiatan';
}
