<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $table = 'residents';

    public $timestamps = false; // adjust if your table has timestamps

    protected $fillable = [
        'firstname', 'middlename', 'surname', 'suffix',
        'birthday', 'age', 'gender', 'civil_status', 'purok', 'rbi_no',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];
}
