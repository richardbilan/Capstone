<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MapFeature extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category', // infrastructure | route | pwd
        'type',     // barangay_hall | evac_routes | pwd_households | ...
        'name',
        'description',
        'latitude',
        'longitude',
        'geometry',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
        'geometry' => 'array',
    ];
}
