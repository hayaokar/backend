<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    use HasFactory;

    protected $fillable=[
        'id',
        'name',
        'email',
        'password',
        'country',
        'fax',
        'activated',
    ];


    public function training_opps(){
        return $this->hasMany('App\Models\training_opp');
    }
}
