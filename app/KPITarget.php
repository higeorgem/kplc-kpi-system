<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KPITarget extends Model
{
    use SoftDeletes;

    protected $guarded = [];
}
