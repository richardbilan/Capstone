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
        'toilet',
        'water',
        'electricity',
        'kitchen',
        'parking',
        'first_aid',
        'additional_info',
        'agreement',
        'status',
    ];
}
