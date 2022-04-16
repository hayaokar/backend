<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'major',
        'country_id',
        'target',
        'duration',
        'conditions',
        'requirements',
        'type',
        'university_id',
        'charity_name',
        'url',
        'photo_id'

    ];

    public function university(){
        return $this->belongsTo('App\Models\university');
    }

    public function country(){
        return $this->belongsTo('App\Models\Country');
    }
}
