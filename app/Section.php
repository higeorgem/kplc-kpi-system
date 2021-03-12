<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    protected $table = 'sections';

    protected $fillable = [
        'section_name',
        'division_id',
        'department_id'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function manageStructure()
    {
        return $this->hasOne(ManageStructures::class, 'structure_id', 'id');
    }


}
