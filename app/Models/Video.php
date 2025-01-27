<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['title', 'description', 'url', 'category_id'];
    protected $with = ['category'];
    public  $timestamps = false;
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
