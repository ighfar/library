<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'judul',
        'isbn',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'jumlah_buku',
        'deskripsi',
        'lokasi'
    ];

    public function getSaleDetails()
    {
        return $this->hasMany(SaleDetails::class, 'category_id', 'id');
    }

    public function getPurchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class, 'category_id', 'id');
    }

}
