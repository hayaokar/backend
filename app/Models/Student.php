<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'certificates'
    ];


    public function training_opps(){
        return $this->belongsToMany('App\Models\training_opp');
    }
}
