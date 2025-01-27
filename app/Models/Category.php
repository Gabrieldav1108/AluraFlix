<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'color'];

    public $timestamps = false;
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
