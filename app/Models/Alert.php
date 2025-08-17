<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = [
        'title',
        'hazard_type',
        'level',
        'description',
        'date',
        'active',
    ];
}
