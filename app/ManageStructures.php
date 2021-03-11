<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ManageStructures extends Model
{
    protected $table = 'structure_managers';

    protected $fillable = [
        "structure_id",
        "manager_type",
        "manager_id",
    ];

}
