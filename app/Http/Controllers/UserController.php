<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash as FacadesHash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->get();

        return view('users.index', compact('data'));
        // ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function manageUserStructure(Request $request)
    {

        $data = DB::table($request->query_table)
                ->where('id', $request->query_id)
                ->select('id', substr($request->query_table,0,-1).'_name as name')
                ->get();

        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'division_id' => 'required',
            'department_id' => 'required',
            'staff_no' => 'required|unique:users,staff_no',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'section_id' => 'required',
            'sub_section_id' => 'required',
        ]);


        $input = $request->all();
        $input['password'] = FacadesHash::make($input['password']);


        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();


        return view('users.edit', compact('user', 'roles', 'userRole'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'division_id' => 'required',
            'department_id' => 'required',
            // 'staff_no' => 'required',
            'email' => 'required|email',
            // 'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'section_id' => 'required',
            'sub_section_id' => 'required',
        ]);


        $input = $request->all();

        if (!empty($input['password'])) {

            $input['password'] = Hash::make($input['password']);

            $usr = User::find($id);
            $usr->password_changed_at = NULL;
            $usr->save();
        } else {
            $input = \Arr::except($input, array('password'));
        }


        $user = User::find($id);
        $user->update($input);
        FacadesDB::table('model_has_roles')->where('model_id', $id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
