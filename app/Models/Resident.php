<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $table = 'residents';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'firstname','middlename','surname','suffix',
        'birthday','age','gender','civil_status','rbi_no',
        'purok','solo_parent','type_of_disability','maternal_status','remark',
    ];

    // Accessor: Full name
    public function getFullnameAttribute()
    {
        $mi = $this->middlename ? ' ' . strtoupper(substr($this->middlename, 0, 1)) . '.' : '';
        $parts = array_filter([$this->firstname, $mi ? trim($mi) : null, $this->surname, $this->suffix]);
        return trim(implode(' ', $parts));
    }
}