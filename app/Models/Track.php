<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Track extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tracks';

}
