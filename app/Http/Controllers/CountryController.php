<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CountryController extends Controller
{
    //
    public function index(){
        $countries = Country::with(['states' , 'cities'])->paginate(env('PAGINATION_COUNT'));
        return view('admin.countries.countries')->with([
            'countries' => $countries,
            'showLinks' => true
        ]);
    }
    private function checkCountryName($country){
        $countryNames = Country::where(
            'name','=',$country
        )->get();
        if(count($countryNames)>0){
            Session::flash('message','Country ('.$country.') name already exist');
            return true;
        }
        return false;
    }

    public function store(Request $request){
        $request->validate([
            'country_name' => 'required',
            'iso03' => 'required',
            'iso02' => 'required',
            'phone_code' => 'required',
            'capital' => 'required',
            'currency' => 'required',
            'flag' => 'required',
            'wikipedia_data_id' => 'required'
        ]);

        $name = $request->input('country_name');
        $iso03 = $request->input('iso03');
        $iso02 = $request->input('iso02');
        $phoneCode = $request->input('phone_code');
        $capital = $request->input('capital');
        $currency = $request->input('currency');
        $flag = $request->input('flag');
        $wikiDataId = $request->input('wikipedia_data_id');
        if($this->checkCountryName($name)){
            return back();
        }
        $country = new Country();
        $country->name = $name;
        $country->iso3 = $iso03;
        $country->iso2 = $iso02;
        $country->phonecode = $phoneCode;
        $country->capital = $capital;
        $country->currency = $currency;
        $country->flag = $flag;
        $country->wikiDataId = $wikiDataId;
        $country->save();
        Session::flash('message' , 'country (' .$name. ') has been added');
        return back();

    }
    public function delete(Request $request){
        if(is_null($request->input('country_id')) || empty($request->input('country_id'))){
            Session::flash('message' , 'country id is required');
            return back();
        }
        $countryId = intval($request->input('country_id'));//cast any to integer
        Country::destroy($countryId);
        Session::flash('message' , 'country has been deleted');
        return back();
    }
    public function search(Request $request){
        $request->validate([
            'search_country' => 'required'
        ]);
        $term = $request->input('search_country');
        $result = Country::where(
            'name' , 'like' , '%'.$term.'%'
        )->get();
        if(count($result)>0){
            return view('admin.countries.countries')->with([
                'countries' => $result,
                'showLinks' => false
            ]);

        }
        Session::flash('message' , 'this country is not found');
        return back();
    }
}
