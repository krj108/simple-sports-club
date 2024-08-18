<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Define the attributes that can be mass-assigned
    protected $fillable = ['name'];

    // Define the one-to-many relationship with the Article model
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
