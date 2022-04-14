<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'address',
        'certificates'
    ];


    public function training_opps(){
        return $this->belongsToMany('App\Models\training_opp');
    }
}
