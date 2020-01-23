<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller
{
    //TODO:show all
    public function index(){
        //$units = Unit::all();
        $units = Unit::paginate(env('PAGINATION_COUNT')); //paginate(number) ->links
        //units
        return view('admin.units.units')->with([
            'units' => $units,
            'showLinks' => true
        ]);
    }
    /*
     * method:check Unit name if exist
     * */
    private function unitNameExists($unitName){
        $unit = Unit::where(
            'unit_name','=',$unitName
        )->get();
        if(count($unit) > 0){
            Session::flash('message','unit name ('.$unitName.') already exist');
            return true;
        }
        return false;
    }
    /*
     * method:check Unit code if exist
     * */
    private function unitCodeExists($unitCode){
        $unit = Unit::where(
            'unit_code','=',$unitCode
        )->get();
        if(count($unit) > 0){
            Session::flash('message','unit Code ('.$unitCode.') already exist');
            return true;
        }
        return false;
    }
    //TODO:store new
    public function store(Request $request){
        $request->validate([
            'unit_name' => 'required',
            'unit_code' => 'required'
        ]);
        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');
        if($this->unitNameExists($unitName)){
            return redirect()->back();
        }
        if($this->unitCodeExists($unitCode)){
            return redirect()->back();
        }
        $unit = new Unit();
        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();
        Session::flash('message' , 'unit ' . $unit->unit_name . ' has been added');
        return redirect()->back();
    }
    //TODO:delete
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

    //TODO:Update
    public function update(Request $request){
        //TODO: update the given unit
        $request->validate([
            'unit_id' => 'required',
            'unit_name' => 'required',
            'unit_code' => 'required'
        ]);
        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');
        if($this->unitNameExists($unitName)){
            return redirect()->back();
        }
        if($this->unitCodeExists($unitCode)){
            return redirect()->back();
        }
        $unitID = intval($request->input('unit_id'));
        $unit = Unit::find($unitID);
        $unit->unit_name = $unitName;
        $unit->unit_code = $unitCode;
        $unit->save();
        Session::flash('message' , 'unit ' .$unit->unit_name.' has been updated');
        return redirect()->back();
    }

    //TODO:search
    public function search(Request $request){
        //TODO:make search for given unit
        $request->validate([
            'unit-search' => 'required'
        ]);
        $searchTerm = $request->input('unit-search');
        $units = Unit::where(
            'unit_name' , 'like' , '%' . $searchTerm . '%'
        )->orWhere(
         'unit_code' , 'like' , '%'.$searchTerm.'%'
        )->get(); //my solution paginate directly & without showLinks
        if(count($units) > 0){
            return view('admin.units.units')->with([
                'units' => $units,
                'showLinks' => false
            ]);
        }
        Session::flash('message','this unit das not exist');
        return redirect()->route('units');
    }
}
