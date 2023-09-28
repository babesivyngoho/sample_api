<?php

namespace App\Http\Controllers;
use App\Models\Business_Address;
use App\Models\Municipality;
use App\Models\Province;
use App\Models\Province_Municipality;
use App\Models\Region;
use App\Models\Region_Province;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getRegions(){
        return response()->json(Region::all());
    }

    public function show(){
        return response()->json(Business_Address::all());
    }

    public function getProvinces(Request $request){
        $this->validate($request, [
            'region_id' => 'required'
        ]);
        $filterData = Province::where('region_id', $request->input('region_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }

    public function getBusinessAddress(Request $request){
        $this->validate($request, [
            'business_address_id' => 'required'
        ]);
        $filterData = Business_Address::where('id', $request->input('business_address_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    
    }

    public function getProvinceName(Request $request){
        $this->validate($request, [
            'province_id' => 'required'
        ]);
        $filterData = Province::where('id', $request->input('province_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    
    }

    public function getMunicipalities(Request $request){
        $this->validate($request, [
            'province_id' => 'required'
        ]);
        $filterData = Municipality::where('province_id', $request->input('province_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    
    }

    public function getAllMunicipalities(Request $request){
        return response()->json(Municipality::all());
    }

    public function getMunicipalityName(Request $request){
        $this->validate($request, [
            'municipality_id' => 'required'
        ]);
        $filterData = Municipality::where('id', $request->input('municipality_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    
    }

    //
}
