<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StructureNavigationController extends Controller
{

    public function structureUsers($structure_type, $query_type, $structure_id)
    {

        // dd($structure_type, $query_type, $structure_id);

        $data = DB::table($query_type)
            ->where($structure_type . '_id', $structure_id)
            ->get()->toArray();

        $structure = DB::table($structure_type.'s')
                        ->select($structure_type.'_name as name')->where('id', $structure_id)->first();
        // dd($structure);
            // $model = 'App\\'.ucfirst(\Str::substr($query_type, 0, -1));

            // $converted = $model::hydrate($data);

            flash('Showing ' . ucWords($structure->name . ' ' . $structure_type) . ' ' . $query_type . ' Data')->success();

        $title = strtoupper($structure->name.' '.$structure_type . ' ' . $query_type . ' Data');

        // dd($converted);
        return view(
            'structureManager.structure_members',
            compact(['data', 'title'])
        );
    }
}
