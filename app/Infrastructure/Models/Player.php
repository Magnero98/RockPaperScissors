<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'id',
        'username',
        'points',
        'gender'
    ];


}
