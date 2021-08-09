<?php

namespace App\Models;

use App\Models\Course\UserCourse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name', 'image'];

    public function subCategory()
    {
        return $this->hasMany(SubCategory::class,'categoryId');
    }
}
