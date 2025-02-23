<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'student_id',
        'date',
        'amount',
        'description',
        'type',
    ];
}
