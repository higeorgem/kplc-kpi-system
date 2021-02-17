<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable =['division_id','group_name'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
