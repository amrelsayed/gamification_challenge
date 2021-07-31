<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    /**
     * Achiement Types
     *
     * @var array
     */
    const TYPES = [
    	'LESSON_WATCHED' => 1,
    	'COMMENT_WRITTEN' => 2,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'points'
    ];
}
