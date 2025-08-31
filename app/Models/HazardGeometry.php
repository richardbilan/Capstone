<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HazardGeometry extends Model
{
    protected $table = 'hazard_geometries';

    protected $fillable = [
        'hazard_type',
        'name',
        'color',
        'geometry',
        'properties',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'geometry' => 'array',
        'properties' => 'array',
    ];
}
