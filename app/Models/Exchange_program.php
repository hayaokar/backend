<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exchange_program extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'number_of_students',
        'details',
        'university_name_1',
        'university_name_2'
    ];


}
