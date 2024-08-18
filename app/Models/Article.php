<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    // Define the attributes that can be mass-assigned
    protected $fillable = ['title', 'content', 'category_id', 'media_path'];

    // Define the many-to-one relationship with the Category model
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Define the many-to-many relationship with the Tag model
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
