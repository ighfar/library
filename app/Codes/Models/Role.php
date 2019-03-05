<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name'
    ];

    public function getAdmin()
    {
        return $this->hasMany(Admin::class, 'role_id', 'id');
    }

}
