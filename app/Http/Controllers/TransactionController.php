<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Input;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
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

    public function addSupplierTransaction(Request $request){
        $this->validate($request, [
            'actor_id' => 'required',
            'name' => 'required',
            'input_product_id' => 'required',
            'quantity' => 'required',
            'metric' => 'required',
        ]);
    
        $actor = Actor::where('name', $request->input('name'))->first();

        if (!(isset($actor))) { 
            $actor = Actor::create([
                'name' => $request->input('name'),
            ]);

            $transaction = Transaction::create([
                'actor_id' => $request->input('actor_id'),
                'supplier_actor_id' => $actor->id,
                'input_product_id' => $request->input('input_product_id'),
                'quantity' => $request->input('quantity'),
                'metric' => $request->input('metric'),
            ]);
            
            return response()->json(['status' => 'Supplier success','message' => 'Transaction successfully added!'], 200);
        
        } else {
            $transaction = Transaction::create([
                'actor_id' => $request->input('actor_id'),
                'supplier_actor_id' => $actor->id,
                'input_product_id' => $request->input('input_product_id'),
                'quantity' => $request->input('quantity'),
                'metric' => $request->input('metric'),
            ]);
            
            return response()->json(['status' => 'Supplier success','message' => 'Transaction successfully added!'], 200);
        
        }
    }

    public function getSupplier(Request $request){
        $this->validate($request, [
            'player_id' => 'required'
        ]);

        $filterData = Transaction::where('actor_id', $request->input('player_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }

    public function getBuyer(Request $request){
        $this->validate($request, [
            'player_id' => 'required'
        ]);

        $filterData = Transaction::where('supplier_actor_id', $request->input('player_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }

    public function addIndustryPlayer(Request $request){
        $this->validate($request, [
            'player_id' => 'required',
            'agreement_type' => 'required',
            'player_name' => 'required',
            'product_name' => 'required',
            'quantity' => 'required',
            'metric' => 'required',
            'price' => 'required',
            'term_duration' => 'required',
        ]);

        $actor = Actor::where('name', $request->input('player_name'))->first();
        
        if (!(isset($actor))) { 
            $actor = Actor::create([
                'name' => $request->input('player_name'),
            ]);
            $actor_db_id = $actor->id;
            
            if($request->input('agreement_type') == 'buying'){
                $input = Input::where('name', $request->input('product_name'))->first();

                if(!(isset($input))){
                    $input = Input::create([
                        'name' => $request->input('product_name'),
                    ]);

                    $transaction = Transaction::create([
                        'actor_id' => $request->input('player_id'),
                        'supplier_actor_id' => $actor_db_id,
                        'input_product_id' => $input->id,
                        'quantity' => $request->input('quantity'),
                        'metric' => $request->input('metric'),
                        'price' => $request->input('price'),
                        'term_duration' => $request->input('term_duration'),
                    ]);
                    
                    return response()->json(['status' => 'success','message' => 'Industry Buying Transaction successfully added!'], 200);    
                }else{
                    $transaction = Transaction::create([
                        'actor_id' => $request->input('player_id'),
                        'supplier_actor_id' => $actor_db_id,
                        'input_product_id' => $input->id,
                        'quantity' => $request->input('quantity'),
                        'metric' => $request->input('metric'),
                        'price' => $request->input('price'),
                        'term_duration' => $request->input('term_duration'),
                    ]);

                    return response()->json(['status' => 'success','message' => 'Industry Buying Transaction successfully added!'], 200);    
                }
            } else {
                $product = Product::where('name', $request->input('product_name'))->first();

                if(!(isset($product))){
                    $product = Product::create([
                        'name' => $request->input('product_name'),
                    ]);

                    $transaction = Transaction::create([
                        'actor_id' => $actor_db_id,
                        'supplier_actor_id' => $request->input('player_id'),
                        'output_product_id' => $product->id,
                        'quantity' => $request->input('quantity'),
                        'metric' => $request->input('metric'),
                        'price' => $request->input('price'),
                        'term_duration' => $request->input('term_duration'),
                    ]);
                    return response()->json(['status' => 'success','message' => 'Industry Selling Transaction successfully added!'], 200);

                }else{ 
                    $transaction = Transaction::create([
                        'actor_id' => $actor_db_id,
                        'supplier_actor_id' => $request->input('player_id'),
                        'output_product_id' => $product->id,
                        'quantity' => $request->input('quantity'),
                        'metric' => $request->input('metric'),
                        'price' => $request->input('price'),
                        'term_duration' => $request->input('term_duration'),
                    ]);
                    return response()->json(['status' => 'success','message' => 'Industry Selling Transaction successfully added!'], 200);

                }
            }
        } else {
            if($request->input('agreement_type') == 'buying'){
                $input = Input::where('name', $request->input('product_name'))->first();

                if(!(isset($input))){
                    $input = Input::create([
                        'name' => $request->input('product_name'),
                    ]);

                    $transaction = Transaction::create([
                        'actor_id' => $request->input('player_id'),
                        'supplier_actor_id' => $actor->id,
                        'input_product_id' => $input->id,
                        'quantity' => $request->input('quantity'),
                        'metric' => $request->input('metric'),
                        'price' => $request->input('price'),
                        'term_duration' => $request->input('term_duration'),
                    ]);
                    
                    return response()->json(['status' => 'success','message' => 'Industry Buying Transaction successfully added!'], 200);    
                }else{
                    $transaction = Transaction::create([
                        'actor_id' => $request->input('player_id'),
                        'supplier_actor_id' => $actor->id,
                        'input_product_id' => $input->id,
                        'quantity' => $request->input('quantity'),
                        'metric' => $request->input('metric'),
                        'price' => $request->input('price'),
                        'term_duration' => $request->input('term_duration'),
                    ]);

                    return response()->json(['status' => 'success','message' => 'Industry Buying Transaction successfully added!'], 200);    
                }
            } else {
                $product = Product::where('name', $request->input('product_name'))->first();

                if(!(isset($product))){
                    $product = Product::create([
                        'name' => $request->input('product_name'),
                    ]);

                    $transaction = Transaction::create([
                        'actor_id' => $actor->id,
                        'supplier_actor_id' => $request->input('player_id'),
                        'output_product_id' => $product->id,
                        'quantity' => $request->input('quantity'),
                        'metric' => $request->input('metric'),
                        'price' => $request->input('price'),
                        'term_duration' => $request->input('term_duration'),
                    ]);
                    return response()->json(['status' => 'success','message' => 'Industry Selling Transaction successfully added!'], 200);

                }else{ 
                    $transaction = Transaction::create([
                        'actor_id' => $actor->id,
                        'supplier_actor_id' => $request->input('player_id'),
                        'output_product_id' => $product->id,
                        'quantity' => $request->input('quantity'),
                        'metric' => $request->input('metric'),
                        'price' => $request->input('price'),
                        'term_duration' => $request->input('term_duration'),
                    ]);
                    return response()->json(['status' => 'success','message' => 'Industry Selling Transaction successfully added!'], 200);

                }
            }
        }
    }

    public function addBuyerTransaction(Request $request){
        $this->validate($request, [
            'actor_id' => 'required',
            'name' => 'required',
            'output_product_id' => 'required',
            'quantity' => 'required',
            'metric' => 'required',
        ]);
        
        $actor = Actor::where('name', $request->input('name'))->first();

        if (!(isset($actor))) { 
            $actor = Actor::create([
                'name' => $request->input('name'),
            ]);
            
            $transaction = Transaction::create([
                'actor_id' => $actor->id,
                'supplier_actor_id' => $request->input('actor_id'),
                'output_product_id' => $request->input('output_product_id'),
                'quantity' => $request->input('quantity'),
                'metric' => $request->input('metric'),
            ]);
            
            return response()->json(['status' => 'Buyer success','message' => 'Transaction successfully added!'], 200);
        
        } else {
            $transaction = Transaction::create([
                'actor_id' => $actor->id,
                'supplier_actor_id' => $request->input('actor_id'),
                'output_product_id' => $request->input('output_product_id'),
                'quantity' => $request->input('quantity'),
                'metric' => $request->input('metric'),
            ]);
            
            return response()->json(['status' => 'Buyer success','message' => 'Transaction successfully added!'], 200);
        
        }
        
    }

    //
}
