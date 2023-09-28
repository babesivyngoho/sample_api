<?php

namespace App\Http\Controllers;

use App\Models\Input;
use App\Models\Player_Product;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
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

    public function show(){
        return response()->json(Product::all());
    }

    public function showByName(Request $request){
        //echo 'productcontroller';
        
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        $filterData = Product::where('id', $request->input('product_id'))->get();
        //$filterData = Product::all();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
        
    }

    public function editPlayerProduct(Request $request){
        $this->validate($request, [
            'player_id' => 'required',
            'name' => 'required',
            'quantity' => 'required',
            'metric' => 'required',
            'date' => 'required',
            'step_by_step_des' => 'required',
            'major_tech_des' => 'required',
            'service_provider_des' => 'required',
            'raw_materials_des' => 'required',
        ]);
    }

    public function addProduct(Request $request){
        $this->validate($request, [
            'player_id' => 'required',
            'name' => 'required',
            'quantity' => 'required',
            'metric' => 'required',
            'date' => 'required',
            'step_by_step_des' => 'required',
            'major_tech_des' => 'required',
            'service_provider_des' => 'required',
            'raw_materials_des' => 'required',
        ]);

        $product = Product::where('name', $request->input('name'))->first();

        if (!(isset($product))) { 
            $product = Product::create([
                'name' => $request->input('name'),
            ]);
    
            $player_product = Player_Product::create([
                'player_id' => $request->input('player_id'),
                'product_id' => $product->id,
                'product_quantity' => $request->input('quantity'),
                'product_metric' => $request->input('metric'),
                'product_date' => $request->input('date'),
                'step_by_step_des' => $request->input('step_by_step_des'),
                'major_tech_des' => $request->input('major_tech_des'),
                'service_provider_des' => $request->input('service_provider_des'),
                'raw_materials_des' => $request->input('raw_materials_des'),
            ]);
    
            return response()->json(['status' => 'success','message' => 'Product successfully added!', 'product_id' => $product->id, 'player_product_id' => $player_product->id], 200);
        
        } else {
            $player_product = Player_Product::create([
                'player_id' => $request->input('player_id'),
                'product_id' => $product->id,
                'product_quantity' => $request->input('quantity'),
                'product_metric' => $request->input('metric'),
                'product_date' => $request->input('date'),
                'step_by_step_des' => $request->input('step_by_step_des'),
                'major_tech_des' => $request->input('major_tech_des'),
                'service_provider_des' => $request->input('service_provider_des'),
                'raw_materials_des' => $request->input('raw_materials_des'),
            ]);
    
            return response()->json(['status' => 'fail','message' => 'Product already existed!', 'product_id' => $product->id, 'player_product_id' => $player_product->id], 200);
        
        }

       }
    //
}
