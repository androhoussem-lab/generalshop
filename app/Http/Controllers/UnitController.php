<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller
{
    /*
     *return:view
     * */
    public function index(){
        //$units = Unit::all();
        $units = Unit::paginate(env('PAGINATION_COUNT')); //paginate(number) ->links
        //units
        return view('admin.units.units')->with([
            'units' => $units
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'unit_name' => 'required',
            'unit_code' => 'required'
        ]);
        $unit = new Unit();
        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();
        Session::flash('message' , 'unit ' . $unit->unit_name . ' has been added');
        return redirect()->back();
        //1:04:00
    }
    public function delete(Request $request){
        //TODO:check if the id already exist

        if(  is_null($request->input('unit_id') || empty($request->input('unit_id'))) ){
            Session::flash('message' , 'unit id is required');
            return redirect()->back();
        }
        $id = $request->input('unit_id');
        Unit::destroy($id);
        Session::flash('message' , 'unit has been deleted');
        return redirect()->back();
    }
    public function update(Request $request){
        //TODO: update the given unit
        $request->validate([
            'unit_id' => 'required',
            'unit_name' => 'required',
            'unit_code' => 'required'
        ]);
        $unitID = intval($request->input('unit_id'));
        $unit = Unit::find($unitID);
        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();
        Session::flash('message' , 'unit ' .$unit->unit_name.' has been updated');
        return redirect()->back();




    }
    public function search(Request $request){
        //TODO:make search for given unit
    }
}
