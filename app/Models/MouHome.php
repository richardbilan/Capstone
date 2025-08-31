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
<<<<<<< HEAD
        'facilities',
=======
        'toilet',
        'water',
        'electricity',
        'kitchen',
        'parking',
        'first_aid',
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
        'additional_info',
        'agreement',
        'status',
    ];
<<<<<<< HEAD

    protected $casts = [
        'facilities' => 'array',
    ];
=======
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
}
