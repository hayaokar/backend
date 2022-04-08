<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class training_opp extends Model
{
    use HasFactory;

    protected $fillable=[
        'company_id',
        'target',
        'duration',
        'number of seats',
        'name'
    ];

    public function company(){
        return $this->belongsTo('App\Models\company');
    }
    public function students(){
        return $this->belongsToMany('App\Models\student');
    }
}
