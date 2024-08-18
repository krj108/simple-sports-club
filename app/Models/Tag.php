<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // Define which attributes can be mass assigned
    protected $fillable = ['name'];

    // Define the many-to-many relationship with the Article model
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
