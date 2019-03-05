<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'key',
        'name',
        'value'
    ];

}
