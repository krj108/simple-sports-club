<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Facility extends Model
{
    // Define the attributes that can be mass-assigned
    protected $fillable = ['name', 'description'];
        // Define the many-to-many relationship with the Sport model
    public function sports(): BelongsToMany
    {
        return $this->belongsToMany(Sport::class, 'facility_sport');
    }
}
