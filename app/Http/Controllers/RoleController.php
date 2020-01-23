<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    //TODO:show all
    public function index(){
        return view('admin.roles.roles')->with([
            'roles' => Role::all(),
            'showLinks' => true,
        ]);
    }
    //TODO:check role name
    private function checkRoleName($roleName){
        $roles = Role::where(
            'role' , '=' , '%'.$roleName.'%'
        )->get();
        if(count($roles)>0){
            Session::flash('message' , 'this role is already exist');
            return true;
        }
        return false;
    }
    //TODO:Store new
    public function store(Request $request){
        $request->validate([
            'role_name' => 'required'
        ]);
        $roleName = $request->input('role_name');
        if($this->checkRoleName($roleName)){
            return back();
        }
        $role = new Role();
        $role->role = $roleName;
        $role->save();
        Session::flash('message' , 'role ('. $roleName.') has been added ');
        return back();

    }
    //TODO:delete
    public function delete(Request $request){
        $roleId = intval($request->input('role_id'));
        if (is_null($roleId) || empty($roleId)){
            Session::flash('message' , 'role id is required');
            return back();
        }
        Role::destroy($roleId);
        Session::flash('message' , 'this role has been deleted');
        return back();

    }
    //TODO:Update
    public function update(Request $request){
        $request->validate([
            'role_id' => 'required',
            'role_name' => 'required'
        ]);
        $roleId = $request->input('role_id');
        $roleName = $request->input('role_name');
        if($this->checkRoleName($roleName)){
            return back();
        }
        $role = Role::find($roleId);
        $role->role = $roleName;
        $role->save();
        Session::flash('message' , 'role (' .$roleName. ') has been updated');
        return back();

    }
    //TODO:search
    public function search(Request $request){
        $request->validate([
            "search_name" => 'required'
        ]);
        $term = $request->input('search_name');
        $result = Role::where(
            'role' , 'like' , '%'.$term.'%'
        )->get();
        if(count($result) > 0){
            return view('admin.roles.roles')->with([
                'roles' => $result
            ]);
        }
        Session::flash('message' , 'this role not found');
        return back();

    }

}
