<?php

namespace App\Http\Controllers;

use App\Models\Business_Enabler_Product;
use Illuminate\Http\Request;
use App\Models\Enabler;

class EnablerController extends Controller
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

    public function addEnabler(Request $request){
        $this->validate($request, [
            'player_id' => 'required',
            'name' => 'required',
            'type' => 'required',
            'kind_of_support' => 'required',
            'product' => 'required',
        ]);

        $enabler = Enabler::create([
            'name' => $request->input('name'),
            'type_of_organization' => $request->input('type'),
        ]);

        $business_enabler_product = Business_Enabler_Product::create([
            'player_id' => $request->input('player_id'),
            'enabler_id' => $enabler->id,
            'kind_of_support' => $request->input('kind_of_support'),
            'product' => $request->input('product'),
        ]);

        return response()->json(['status' => 'success','message' => 'Enabler successfully registered!'], 200);
    }

    public function getEnablerProduct(Request $request){
        $this->validate($request, [
            'player_id' => 'required',
        ]);

        $filterData = Business_Enabler_Product::where('player_id', $request->input('player_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }

    public function getEnabler(Request $request){
        $this->validate($request, [
            'enabler_id' => 'required',
        ]);

        $filterData = Enabler::where('id', $request->input('enabler_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }
}