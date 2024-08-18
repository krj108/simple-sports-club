<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sport extends Model
{
    // Define the attributes that can be mass-assigned
    protected $fillable = ['name', 'description', 'images', 'videos', 'days'];

    // Cast the 'images', 'videos', and 'days' attributes to arrays
    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
        'days' => 'array',
    ];

    // Define the one-to-many relationship with the Room model
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

       // Define the many-to-many relationship with the Facility model
       public function facilities(): BelongsToMany
       {
           return $this->belongsToMany(Facility::class, 'facility_sport');
       }
}
