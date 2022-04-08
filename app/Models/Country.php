<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'photo_id',
        'token',

    ];
    public function photo(){
        return $this->belongsTo('App\Models\Photo');
    }

    public function scholarships(){
        return $this->hasMany('App\Models\Scholarship');
    }
}
