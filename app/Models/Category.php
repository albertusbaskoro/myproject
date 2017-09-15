<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $table = 'category';

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'slug' => 'string',
        'title' => 'string',
        'description' => 'string',
        'imagesmall' => 'string',
        'imagelarge' => 'string',
        'status' => 'string',
        'created' => 'timestamp',
        'modified' => 'timestamp',
        'isdeleted' => 'boolean',
    ];

    // use SoftDeletes;

    public $incrementing = false;

    protected $visible = ['id', 'uuid', 'title', 'description'];

    public function scopeActiveCategory($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeTitleScope($query, $id)
    {
        return $query->where('id', $id);
    }

    public function meal()
    {
        return $this->belongsToMany('App\Models\Meal','category_meal', '_categoryid', '_mealid');
    }

    public function categorymeal()
    {
        return $this->hasMany('App\Models\CategoryMeal', '_categoryid', 'id');
    }
}
