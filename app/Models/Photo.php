<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable=['file'];

    protected $uploads="backEnd\\public\\images\\";

    public function getFileAttribute($photo){
        return $this->uploads.$photo;
    }
}
