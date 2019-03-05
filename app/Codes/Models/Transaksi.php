<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'kode_transaksi',
        'anggota_id',
        'buku_id',
        'tgl_pinjam',
        'tgl_kembali',
        'status',
        'ket'
    ];


}
