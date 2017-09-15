<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    protected $table = 'meal';

    protected $casts = [
        'id' => 'integer',
        '_cookid' => 'integer',
        'uuid' => 'string',
        'slug' => 'string',
        'title' => 'string',
        'imagesmall' => 'string',
        'imagelarge' => 'string',
        'summary' => 'string',
        'description' => 'string',
        'availabledate' => 'date',
        'unavailabledate' => 'date',
        'isfavorite' => 'boolean',
        'price' => 'float',
        'originalprice' => 'float',
        'rating' => 'float',
        'status' => 'string',
        'created' => 'timestamp',
        'modified' => 'timestamp',
        'isdeleted' => 'boolean',
        'isavailable' => 'boolean',
    ];
    
    // use SoftDeletes;

    public $incrementing = false;

    protected $fillable = ['cook_id', 'slug', 'title', 'description', 'price', 'meta', 'sort'];

    protected $hidden = ['uuid', 'slug', 'imagelarge', 'availabledate', 'unavailabledate', 'originalprice', 'status', 'created' , 'modified', 'isdeleted', 'isdeleted', 'category_id', 'category'];

    public function scopeActiveMeal($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeLike($query, $title)
    {
        return $query->where('title', 'LIKE', "%$title%");
    }

    public function scopeFavorite($fav)
    {
        return $fav->where('isfavorite', '1');
    }

    public function cook()
    {
        return $this->belongsTo('App\Models\Cook', '_cookid', 'id');
    }
}
