<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'name_en', 'desc_en', 'desc_ar', 'image', 'count', 'active', 'price', 'discount', 'category_id',];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
