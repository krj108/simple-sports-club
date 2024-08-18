<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    // Define the attributes that can be mass-assigned
    protected $fillable = ['name', 'sport_id', 'capacity'];

    // Define the many-to-one relationship with the Sport model
    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }
}
