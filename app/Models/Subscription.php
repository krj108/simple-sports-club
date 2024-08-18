<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    // Define the attributes that can be mass-assigned
    protected $fillable = ['name', 'email', 'phone', 'status', 'discount'];

    // Specify how the 'discount' attribute should be cast to the desired data type
    protected $casts = [
        'discount' => 'float',
    ];
}
