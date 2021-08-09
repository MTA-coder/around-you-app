<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'subCategory_id', 'name', 'price', 'isNew', 'city', 'address', 'description',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

}
