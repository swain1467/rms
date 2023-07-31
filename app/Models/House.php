<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model
{
    protected $fillable = ['area_id','city_id','type_id','from_date','contact_no', 
    'advance','rent', 'detailed_address', 'image', 'created_by','updated_by','created_at','updated_at','status'];

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
    public function user(){
        return $this->belongsTo(User::class,"created_by","id");
    }
    // Accessor
    public function getFromDateAttribute($value){
        return date("d-M-Y", strtotime($value));
    }
    // Mutator
    public function setFromDateAttribute($value){
        $this->attributes['from_date'] = date("Y-m-d", strtotime($value));
    }
}
