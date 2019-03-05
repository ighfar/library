<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id',
        'npm',
        'nama',
        'tempat_lahir',
        'tgl_lahir',
        'prodi',
        'jk'
    ];


}
