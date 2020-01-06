<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(){
        //$units = Unit::all();
        $units = Unit::paginate(); //paginate(number) ->links
        //units
        return view('admin.units.units')->with([
            'units' => $units
        ]);


        //
    }
    //
}
