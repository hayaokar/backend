<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'password',
        'phone',
        'gender',
        'certificates'
    ];

    public function university(){
        return $this->belongsTo('App\Models\university');
    }

    public function country(){
        return $this->belongsTo('App\Models\Country');
    }
}
