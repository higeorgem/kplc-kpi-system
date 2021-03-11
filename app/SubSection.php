<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubSection extends Model
{
    use SoftDeletes;

    protected $table = 'sub_sections';

    protected $fillable = [
        'division_id',
        'department_id',
        'section_id',
        'subsection_name'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
