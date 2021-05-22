<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subCategory_id',
        'brand_id',
        'name',
        'price',
        'isNew',
        'views',
        'description',
        'Latitude',
        'longitude'
    ];
}
