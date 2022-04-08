<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class university extends Model
{
    use HasFactory;

    public function schoolarships(){
        return $this->hasMany('App\Models\schoolarship');
    }
    public function exchange_programs(){
        return $this->belongsToMany('App\Models\exchange_program');
    }
}
