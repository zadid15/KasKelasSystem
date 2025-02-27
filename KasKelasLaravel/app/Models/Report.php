<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $fillable = [
        'month',
        'year',
        'total_income',
        'total_expense',
        'balance',
    ];
}
