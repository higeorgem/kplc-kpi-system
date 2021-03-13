<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StructureNavigationController extends Controller
{
    public function structureUsers($structure_type, $query_type, $structure_id)
    {
        $data = DB::table($query_type)
                    ->where(explode(' ',$structure_type)[1].'_id', $structure_id)
                    ->get()->toArray();

        // $model = 'App\\'.ucfirst(\Str::substr($query_type, 0, -1));

        // $converted = $model::hydrate($data);

        flash('Showing '. ucWords($structure_type) . ' ' . $query_type . ' Data')->success();
        $title = strtoupper($structure_type.' '.$query_type.' Data');
        // dd($converted);
        return view('structureManager.structure_members',
                    compact(['data', 'title']));
    }
    
}
