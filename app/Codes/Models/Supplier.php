<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name'
    ];

    public function getPurchase()
    {
        return $this->hasMany(Purchase::class, 'supplier_id', 'id');
    }

}
