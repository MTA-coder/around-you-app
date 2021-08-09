<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'categoryId', 'image'];

    public function products()
    {
        return $this->hasMany(Product::class, 'subCategory_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
