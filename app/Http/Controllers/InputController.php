<?php

namespace App\Http\Controllers;

use App\Models\Input;
use App\Models\Player_Product;
use App\Models\Player_Product_Input;
use Illuminate\Http\Request;

class InputController extends Controller
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

    public function addInput(Request $request){
        $this->validate($request, [
            'player_product_id' => 'required',
            'name' => 'required',
            'input_type' => 'required',
            'quantity' => 'required',
            'metric' => 'required',
            'transaction_type' => 'required',
        ]);
        
        //$product = Product::create([
            //'name' => $request->input('name'),
        //]);

        $input = Input::where('name', $request->input('name'))->first();

        if (!(isset($input))) { 
            $input = Input::create([
                'name' => $request->input('name'),
                'input_type' => $request->input('input_type'),
            ]);
            
            $player_product_input = Player_Product_Input::create([
                'player_product_id' => $request->input('player_product_id'),
                'input_id' => $input->id,
                'quantity' => $request->input('quantity'),
                'metric' => $request->input('metric'),
                'transaction_type' => $request->input('transaction_type'),
            ]);
            
            return response()->json(['status' => 'success','message' => 'Input successfully added!', 'input_id' => $input->id], 200);
    
        } else {
            $player_product_input = Player_Product_Input::create([
                'player_product_id' => $request->input('player_product_id'),
                'input_id' => $input->id,
                'quantity' => $request->input('quantity'),
                'metric' => $request->input('metric'),
                'transaction_type' => $request->input('transaction_type'),
            ]);

            return response()->json(['status' => 'fail','message' => 'Input already exists!', 'input_id' => $input->id], 200);
        }
    }

    public function getPlayerProductInput(Request $request){
        $this->validate($request, [
            'player_product_id' => 'required',
        ]);

        $player_product_input = Player_Product_Input::where('player_product_id', $request->input('player_product_id'))->get();

        return response()->json(['status' => 'success', 'data' => $player_product_input], 200);
    }

    public function getInput(Request $request){
        $this->validate($request, [
            'input_id' => 'required',
        ]);

        $input = Input::where('id', $request->input('input_id'))->get();

        return response()->json(['status' => 'success', 'data' => $input], 200);
    }

    public function getInputByName(Request $request){
        $this->validate($request, [
            'name' => 'required',
        ]);

        $input = Input::where('name', $request->input('name'))->get();

        return response()->json(['status' => 'success', 'data' => $input], 200);
    
    }

    public function getPlayerProductInputByInput(Request $request){
        $this->validate($request, [
            'input_id' => 'required',
        ]);

        $player_product_input = Player_Product_Input::where('input_id', $request->input('input_id'))->get();

        return response()->json(['status' => 'success', 'data' => $player_product_input], 200);
    
    }

    public function getPlayerProductByInput(Request $request){
        $this->validate($request, [
            'player_product_id' => 'required',
        ]);

        $player_product = Player_Product::where('id', $request->input('player_product_id'))->get();

        return response()->json(['status' => 'success', 'data' => $player_product], 200);
    
    }
    //
}
