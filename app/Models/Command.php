<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Command extends Model
{
    use HasFactory;

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $fillable = [
        'frequency',
        'command',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'frequency' => 'string',
        'command' => 'string',
    ];
}
