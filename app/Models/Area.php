<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    public function city(){
        // return $this->hasMany('App\Models\Area');
        return $this->belongsTo(City::class,"city_id","id");
    }
}
