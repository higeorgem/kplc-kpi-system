<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['name'];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
