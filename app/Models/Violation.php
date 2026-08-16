<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'violation_type',
        'recorded_speed',
        'decibel_level',
        'location',
        'status',
    ];
}