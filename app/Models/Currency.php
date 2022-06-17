<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
        'iso_code',
        'iso_numeric_code',
        'common_name',
        'official_name',
        'symbol'
    ];
}
