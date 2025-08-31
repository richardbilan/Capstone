<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouHome extends Model
{
    use HasFactory;

    protected $fillable = [
        'homeowner_name',
        'contact_number',
        'address',
        'house_type',
        'capacity',
        'facilities',
        'additional_info',
        'agreement',
        'status',
    ];

    protected $casts = [
        'facilities' => 'array',
    ];
}
