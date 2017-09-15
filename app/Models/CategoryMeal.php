<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryMeal extends Model
{
    protected $table = 'category_meal';

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'integer',
        'slug' => 'integer',
    ];

    protected $visible = ['_categoryid', '_mealid', 'id'];

    // public function category()
    // {
    //     return $this->belongsToMany('App\Models\Category','category_meal', '_categoryid', '_mealid');
    // }

    public function meal()
    {
        return $this->hasOne('App\Models\Meal', 'id', '_mealid');
    }

    public function scopeTitleScope($query, $categoryid)
    {
        return $query->where('_categoryid', $categoryid);
    }
}
