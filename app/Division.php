<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use SoftDeletes;

    protected $fillable = ['division_name'];

    // public function groups()
    // {
    //     return $this->hasMany(Group::class);
    // }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function manageStructure()
    {
        return $this->hasOne(ManageStructures::class, 'structure_id', 'id');
    }

    public function head($id)
    {
        $head = User::find($id);

        return $head;
    }
}
