<?php

namespace App\Models;

use COM;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'price',
        'image_path',
        'color',
        'brand',
        'description',
        'status_id',
        'user_id'
    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item', 'item_id', 'category_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
