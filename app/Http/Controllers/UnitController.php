<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller
{
    /*
     * method:index
     * */
    public function index(){
        //$units = Unit::all();
        $units = Unit::paginate(env('PAGINATION_COUNT')); //paginate(number) ->links
        //units
        return view('admin.units.units')->with([
            'units' => $units
        ]);
    }
    /*
     * method:check Unit name if exist
     * */
    private function unitNameExists($unitName){
        $unit = Unit::where(
            'unit_name','=',$unitName
        )->first();
        if(!is_null($unit)){
            Session::flash('message','unit Name('.$unitName.') already exist');
            return false;
        }
        return true;
    }
    /*
     * method:check Unit code if exist
     * */
    private function unitCodeExists($unitCode){
        $unit = Unit::where(
            'unit_code','=',$unitCode
        )->first();
        if(!is_null($unit)){
            Session::flash('message','unit Code('.$unitCode.') already exist');
            return false;
        }
        return true;
    }
    /*
     * method:store
     * */
    public function store(Request $request){
        $request->validate([
            'unit_name' => 'required',
            'unit_code' => 'required'
        ]);
        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');
        if(!$this->unitNameExists($unitName)){
            return redirect()->back();
        }
        if(!$this->unitCodeExists($unitCode)){
            return redirect()->back();
        }
        $unit = new Unit();
        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();
        Session::flash('message' , 'unit ' . $unit->unit_name . ' has been added');
        return redirect()->back();
        //1:04:00
    }
    /*
     * method:delete
     * */
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

    /*
    * method:update
    * */
    public function update(Request $request){
        //TODO: update the given unit
        $request->validate([
            'unit_id' => 'required',
            'unit_name' => 'required',
            'unit_code' => 'required'
        ]);
        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');
        if(!$this->unitNameExists($unitName)){
            return redirect()->back();
        }
        if(!$this->unitCodeExists($unitCode)){
            return redirect()->back();
        }
        $unitID = intval($request->input('unit_id'));
        $unit = Unit::find($unitID);
        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();
        Session::flash('message' , 'unit ' .$unit->unit_name.' has been updated');
        return redirect()->back();
    }

    /*
    * method:search
    * */
    public function search(Request $request){
        //TODO:make search for given unit
    }
}
