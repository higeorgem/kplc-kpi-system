<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    // protected $table = 'departmetns';
    protected $fillable = [
        'division_id',
        'department_name',
        'created_by'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function manageStructure()
    {
        return $this->hasOne(ManageStructures::class, 'structure_id', 'id');
    }
}
