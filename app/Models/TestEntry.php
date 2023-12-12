<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class TestEntry extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'posts';

    protected $fillable = [
        'title', 'author'
    ];
}
