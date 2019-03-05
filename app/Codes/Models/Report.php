<?php

namespace App\Codes\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'report';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'reference_id',
        'module',
        'additional_info',
        'date',
        'year',
        'account_number',
        'info',
        'amount'
    ];

    protected $appends = [
        'date_format',
        'amount_format'
    ];

    public function getDateFormatAttribute()
    {
        if (intval($this->date)) {
            return set_date_format($this->date);
        }
        return '';
    }

    public function getAmountFormatAttribute()
    {
        if (intval($this->amount)) {
            return number_format($this->amount, 2);
        }
        return '';
    }

}
