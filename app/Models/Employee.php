<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'paternal_name',
        'maternal_name',
        'first_name',
        'other_names',
        'employment_country',
        'id_type',
        'id_number',
        'email',
        'entry_date',
        'area',
        'status',
        'registration_date',
    ];
}
