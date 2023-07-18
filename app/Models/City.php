<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function area(){
        // return $this->hasMany('App\Models\Area');
        return $this->hasMany(Area::class,"city_id","id");
    }
}
