<?php

namespace App\Http\Controllers;

use App\ManageStructures;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageStructuresController extends Controller
{
    public function manageStructure($structure, $structure_id, $manager_type)
    {
        // dd($structure, $structure_id, $manager_type);
        // get used manager ids
        $invalid_manager_ids = ManageStructures::pluck('manager_id')->toArray();
        // get not signed users with manager roles
        $valid_managers = User::role($manager_type)
            ->whereNotIn('id', $invalid_manager_ids)
            ->get();
        // no manager ? go back : proceed
        if (count($valid_managers) == 0) {
            flash('Create Manager User to proceed.')->warning();
            return redirect()->back();
        } else {
            // get the structure
            $structure_details = DB::table($structure)
                ->select('id', substr($structure, 0, -1) . '_name' . " as structure_name")
                ->where('id', $structure_id)->first();


            // dd($structure_details, $valid_managers);

            return view('structureManager.create', [
                'structure' => $structure_details,
                'structure_type' => substr($structure, 0, -1),
                'managers' => $valid_managers,
                'manager_type' => $manager_type
            ]);
        }
    }

    public function saveManager(Request $request)
    {
        // dd($request);
        $request->validate([
            "structure_id" => "required",
            "manager_type" => "required",
            "manager_id" => "required",
        ]);
        // create manager
        ManageStructures::create([
            "structure_id" => $request->structure_id,
            "manager_type" => $request->manager_type,
            "manager_id" => $request->manager_id,
        ]);
        

        flash(ucfirst($request->manager_type) . ' Created')->success();
        // flash(ucfirst('Manager Created'))->success();

        return redirect()->route('home');
    }
}
