<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KPIAchievement extends Model
{
    use SoftDeletes;

    protected $guarded = [];
}
