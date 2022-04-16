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
        'details'
    ];

    public function universities(){
        return $this->belongsToMany('App\Models\University');
    }
}
