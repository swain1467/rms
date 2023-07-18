<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model
{
    use HasFactory;
    use softDeletes;
    public function area(){
        return $this->belongsTo(Area::class,"area_id","id");
    }
    public function city(){
        return $this->belongsTo(City::class,"city_id","id");
    }
    public function type(){
        return $this->belongsTo(Type::class,"type_id","id");
    }
    public function getFromDateAttribute($value){
        return date("d-M-Y", strtotime($value));
    }
}
