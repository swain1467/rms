<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{

    protected $fillable = ['type', 'created_by','updated_by','created_at','updated_at','status'];

    use HasFactory;
}
