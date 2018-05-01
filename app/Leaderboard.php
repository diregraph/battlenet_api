<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    protected $fillable = ['name-realm','2v2', '3v3', '5v5', 'rbg'];
}
