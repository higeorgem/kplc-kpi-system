<?php

namespace App\Http\Controllers;

use App\KPI;
use App\KPIStructure;
use App\ManageStructures;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;

class ManageStructuresController extends Controller
{
    public function manageStructure($structure, $structure_id, $manager_type)
    {
        // dd($structure, $structure_id, $manager_type);

        // check if role exists
        try {
            Role::findByName($manager_type)->get();
            // dd('re');
        } catch (RoleDoesNotExist $e) {
            flash('Create ' . $manager_type . ' Role to proceed.')->warning();
            return redirect()->back();
        }
        // get used manager ids
        $invalid_manager_ids = ManageStructures::pluck('manager_id')->toArray();
        // dd($invalid_manager_ids);
        // get not signed users with manager roles
        $valid_managers = User::role($manager_type)
            ->whereNotIn('id', $invalid_manager_ids)
            ->get();
        // dd($valid_managers);
        // no manager ? go back : proceed
        if (count($valid_managers) == 0) {
            flash('Create ' . $manager_type . ' User to proceed.')->warning();
            return redirect()->back();
        } else {
            // get the structure
            $structure_details = DB::table($structure)
                ->select('id', substr($structure, 0, -1) . '_name' . " as structure_name")
                ->where('id', $structure_id)->first();


            // dd($structure_id, $structure, $structure_details, $valid_managers);

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

    public function structureKPI($type, $id)
    {
        //get kpi structure
        $structure = KPIStructure::where('structure_type', $type)->where('structure_id', $id)->get();

        if (count($structure) == 0) {
            flash('No assigned KPIs for this division.')->warning();
            return redirect()->back();
        }

        // get kpis for the structure
        $structure_kpis = KPI::where('id', $structure->kpi_id)->get();

        dd($structure_kpis);
    }
}
