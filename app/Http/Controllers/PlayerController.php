<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Business_Address;
use App\Models\Business_Enabler_Product;
use App\Models\Player_Product;
use App\Models\Player_Product_Input;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
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


    public function show()
    {
        return response()->json(Player::all());
    }

    public function showByName(Request $request){
        /*
        $this->validate($request, [
            'name' => 'required'
        ]);

        $filterData = Player::where('name','LIKE','%'.$request->input('name').'%')->get();

        return response()->json(['status' => 'success', 'data' => $filterData], 200);
        */

        $this->validate($request, [
            'string' => 'required'
        ]);

        $actorData = Actor::where('name','LIKE','%'.$request->input('string').'%')->get();
        $productData = Product::where('name','LIKE','%'.$request->input('string').'%')->get();
        return response()->json(['status' => 'success', 'actor_data' => $actorData, 'product_data' => $productData], 200);
        
        //return response()->json(['status' => 'success', 'data' => $filterData], 200);
        //$filterData = Player::all();
    }

    public function getPlayer(Request $request){
        $this->validate($request, [
            'actor_id' => 'required'
        ]);

        $filterData = Player::where('actor_id', $request->input('actor_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }

    public function getPlayerByPlayerID(Request $request){
        $this->validate($request, [
            'player_id' => 'required'
        ]);

        $filterData = Player::where('id', $request->input('player_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }

    public function getPlayerByRepresentative(Request $request){
        $this->validate($request, [
            'user_id' => 'required'
        ]);

        $filterData = Player::where('representative_id', $request->input('user_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }

    public function getFinalPlayer(Request $request){
        $this->validate($request, [
            'player_id' => 'required'
        ]);

        $filterData = Player::where('id', $request->input('player_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }

    public function setRepresentative(Request $request){
        $this->validate($request, [
            'business_name' => 'required',
            'representative_name' => 'required',
        ]);
        

        if($user_id = User::where('name', $request->input('representative_name'))->first() != null){
            $user_id = User::where('name', $request->input('representative_name'))->first();
            $actor_id = Actor::where('name', $request->input('business_name'))->first();
        
            $player_id = Player::where('actor_id', 'LIKE','%'.$actor_id->id.'%')->get();

            for($ctr = 0; $ctr < sizeof($player_id); $ctr++){
                $player = Player::where('id', $player_id[$ctr]->id)->first();
                $player->representative_id = $user_id->id;

                $player->save();
            }
            return response()->json(['status' => 'success', 'data' => $player_id], 200);
        }else{
            $actor_id = Actor::where('name', $request->input('business_name'))->first();
        
            $player_id = Player::where('actor_id', 'LIKE','%'.$actor_id->id.'%')->get();

            for($ctr = 0; $ctr < sizeof($player_id); $ctr++){
                $player = Player::where('id', $player_id[$ctr]->id)->first();
                $player->representative_id = null;

                $player->save();
            }
            return response()->json(['status' => 'success', 'data' => $player_id], 200);
        }
        
    }

    public function getActor(Request $request){
        $this->validate($request, [
            'actor_id' => 'required'
        ]);

        $filterData = Actor::where('id', $request->input('actor_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }

    public function getPlayerByProduct(Request $request){
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        $filterData = Player_Product::where('product_id',$request->input('product_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }

    public function getPlayerByAddress(Request $request){
        $this->validate($request, [
            'business_address_id' => 'required'
        ]);

        $filterData = Player::where('business_address_id',$request->input('business_address_id'))->get();
        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }
    
    public function showPlayerProducts(Request $request){
        $this->validate($request, [
            'player_id' => 'required'
        ]);

        $filterData = Player_Product::where('player_id', $request->input('player_id'))->get();

        return response()->json(['status' => 'success', 'data' => $filterData], 200);
        /*
        $user = Player::findOrFail($request->input('id'));
        $products = Player::find($request->input('id'))->products;

        return response()->json(['status' => 'success', 'user' => $user, 'products' => $products], 200);
        */
    }

    public function deletePlayer(Request $request){
        $this->validate($request, [
            'player_id' => 'required',
        ]);

        $transaction_one = Transaction::where('actor_id', $request->input('player_id'))->first();
        $transaction_two = Transaction::where('supplier_actor_id', $request->input('player_id'))->first();

        if (isset($transaction_one) || isset($transaction_two)) {
            return response()->json(['status' => 'fail','message' => 'Player failed to delete!'], 200); 
        } else {
            $player_product = Player_Product::where('player_id', $request->input('player_id'))->first();

            for($i = 0; $i < sizeof($player_product); $i++){
                $player_product_input = Player_Product_Input::where('player_product_id', $player_product[$i]->id)->first();

                for($j = 0; $j < sizeof($player_product_input); $j++){
                    $player_product_input[$j]->delete();
                }
                $player_product[$i]->delete();
            }
            
            $business_enabler_product = Business_Enabler_Product::where('player_id', $request->input('player_id'))->get();

            for($i = 0; $i < sizeof($business_enabler_product); $i++){
                $business_enabler_product[$i]->delete();
            }

            $player = Player::where('id', $request->input('player_id'))->first();

            $player->delete();

            return response()->json(['status' => 'success','message' => 'Player successfully deleted!'], 200); 
        }

           
    }

    public function deletePlayerProduct(Request $request){
        $this->validate($request, [
            'id' => 'required',
        ]);

        $player_product = Player_Product::where('player_id', $request->input('id'))->get();
        
        
        if(isset($player_product)){
            for($i = 0; $i < sizeof($player_product); $i++){
                $player_product_input = Player_Product_Input::where('player_product_id', $player_product[$i]->id)->get();
                if(isset($player_product_input)){
                    for($j = 0; $j < sizeof($player_product_input); $j++){
                        $player_product_input[$j]->delete();
                    }
                }
                $player_product[$i]->delete();
            }
        }

        $business_enabler_product = Business_Enabler_Product::where('player_id', $request->input('id'))->get();

        for($i = 0; $i < sizeof($business_enabler_product); $i++){
            $business_enabler_product[$i]->delete();
        }
        
        return response()->json(['status' => 'success','message' => 'Player successfully deleted!', 'data' => $player_product], 200); 

    }

    public function editPlayer(Request $request){
        $this->validate($request, [
            //'representative_id' => 'required',
            'id' => 'required',
            'name' => 'required',
            'address_no' => 'required',
            'address_street' => 'required',
            'address_city_municipality' => 'required',
            'contact_no' => 'required',
            'email_add' => 'required',
            'type' => 'required',
            'owner_name' => 'required',
            'owner_sex_at_birth' => 'required',
            'sector' => 'required',
            'role_id' => 'required',
        ]);

        $player = Player::where('id', $request['id'])->first();
        $final_actor = NULL;

        //$business_address_no = Business_Address::where('no', $request->input('address_no'))->first();
        //$business_address_street = Business_Address::where('street', $request->input('address_street'))->first();
        //$municipality_id = Business_Address::where('municipality_city_id', $request->input('address_city_municipality'))->first();

        if (isset($player)) {

            $municipality_id = Business_Address::where('municipality_city_id', $request->input('address_city_municipality'))->get();
            $message = '';
            $if_exist = NULL;
            $id_municipality = NULL;

            $address_no = $request->input('address_no');
            $address_street = $request->input('address_street');

            if($request->input('address_no') == 'undefined'){
                $address_no = NULL;
            }
            
            if($request->input('address_street') == 'undefined'){
                $address_street = NULL;
            }
            
            if(sizeof($municipality_id) != 0){
                for($i = 0; $i < sizeof($municipality_id); $i++){
                    //check if all are equal.
                    $business_address_no = $municipality_id[$i]->no;
                    $business_address_street = $municipality_id[$i]->street;

                    if(($business_address_no == $address_no) 
                        && ($business_address_street == $address_street)){
                            $if_exist = true;
                            $id_municipality = $municipality_id[$i]->id;
                            $message = 'success1';
                    }else{
                        
                        $if_exist = false;
                        $message = 'success2';
                       
                    }
                }
            } else {
                
                $if_exist = false;
                $message = 'success3';
            }

            if($if_exist == false){
                
                $business_address = Business_Address::create([
                    'no' => $address_no,
                    'street' => $address_street,
                    'municipality_city_id' => $request->input('address_city_municipality')
                ]);
                
                $player->business_address_id = $business_address->id;
                $player->business_contact_no = $request['contact_no'];
                $player->business_email_add = $request['email_add'];
                $player->business_type_id = $request['type'];
                $player->owner_name = $request['owner_name'];
                $player->owner_sex_at_birth = $request['owner_sex_at_birth'];
                $player->sector = $request['sector'];
                $player->role_id = $request['role_id'];

                $player->save();

                $actor = Actor::where('id', $player->actor_id)->first();
                if(isset($actor)){
                    $actor->name = $request['name'];
                    $actor->save();
                }
                $final_actor = $actor;
            
            }else{
                
                $player->business_address_id = $id_municipality;
                $player->business_contact_no = $request['contact_no'];
                $player->business_email_add = $request['email_add'];
                $player->business_type_id = $request['type'];
                $player->owner_name = $request['owner_name'];
                $player->owner_sex_at_birth = $request['owner_sex_at_birth'];
                $player->sector = $request['sector'];
                $player->role_id = $request['role_id'];

                $player->save();

                $actor = Actor::where('id', $player->actor_id)->first();
                if(isset($actor)){
                    $actor->name = $request['name'];
                    $actor->save();
                }

                $final_actor = $actor;
                
            }

            return response()->json(['status' => $message, 'message' => 'Player updated successfully!', 'player_id' => $player->id, 'actor_id' => $final_actor->id], 200);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'Player does not exist!'], 401);
        }
    }

    public function addPlayer(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'address_no' => 'required',
            'address_street' => 'required',
            'address_city_municipality' => 'required',
            'contact_no' => 'required',
            'email_add' => 'required',
            'type' => 'required',
            'owner_name' => 'required',
            'owner_sex_at_birth' => 'required',
            'sector' => 'required',
            'role_id' => 'required',
        ]);

        $actor = Actor::where('name', $request->input('name'))->first();
        
        if (!(isset($actor))) {
            $actor = Actor::create([
                'name' => $request->input('name'),
            ]);

            $municipality_id = Business_Address::where('municipality_city_id', $request->input('address_city_municipality'))->get();
            $message = '';
            $if_exist = NULL;
            $id_municipality = NULL;

            $address_no = $request->input('address_no');
            $address_street = $request->input('address_street');

            if($request->input('address_no') == 'undefined'){
                $address_no = NULL;
            }
            
            if($request->input('address_street') == 'undefined'){
                $address_street = NULL;
            }

            if(sizeof($municipality_id) != 0){
                for($i = 0; $i < sizeof($municipality_id); $i++){
                    //check if all are equal.
                    $business_address_no = $municipality_id[$i]->no;
                    $business_address_street = $municipality_id[$i]->street;
                    if(($business_address_no == $address_no) 
                        && ($business_address_street == $address_street)){
                        $if_exist = true;
                        $id_municipality = $municipality_id[$i]->id;
                        $message = 'success1';

                        /*
                        $player = Player::create([
                            'actor_id' => $actor->id,
                            'business_address_id' => $municipality_id[$i]->id,
                            'business_contact_no' => $request->input('contact_no'),
                            'business_email_add' => $request->input('email_add'),
                            'business_type_id' => $request->input('type'),
                            'owner_name' => $request->input('owner_name'),
                            'owner_sex_at_birth' => $request->input('owner_sex_at_birth'),
                            'sector' => $request->input('sector'),
                            'role_id' => $request->input('role_id'),
                            'is_active' => true,
                        ]);
                        $message = 'success1';
                        $final_player = $player;
                        */
                        //return response()->json(['status' => 'success1','message' => 'Player successfully registered!', 'actor_id' => $actor->id], 200);
                    }else{
                        $if_exist = false;
                        $message = 'success2';


                        //return response()->json(['status' => 'success2','message' => 'Player successfully registered!', 'actor_id' => $actor->id], 200);
                        /*
                        $address_no = !empty($address_no) ? "'$request->input('address_no')'" : NULL;
                        $address_street = !empty($address_street) ? "'$request->input('address_street')'" : NULL;
                        $business_address = Business_Address::create([
                            'no' => $address_no,
                            'street' => $address_street,
                            'municipality_city_id' => $request->input('address_city_municipality')
                        ]);

                        $player = Player::create([
                            'actor_id' => $actor->id,
                            'business_address_id' => $business_address->id,
                            'business_contact_no' => $request->input('contact_no'),
                            'business_email_add' => $request->input('email_add'),
                            'business_type_id' => $request->input('type'),
                            'owner_name' => $request->input('owner_name'),
                            'owner_sex_at_birth' => $request->input('owner_sex_at_birth'),
                            'sector' => $request->input('sector'),
                            'role_id' => $request->input('role_id'),
                            'is_active' => true,
                        ]);

                        $message = 'success2';
                        $final_player = $player;
                        */
                    }
                }
            }else{
                $if_exist = false;
                $message = 'success3';

                /*
                //return response()->json(['status' => 'success2','message' => 'Player successfully registered!', 'actor_id' => $actor->id], 200);
                $address_no = !empty($address_no) ? "'$request->input('address_no')'" : NULL;
                $address_street = !empty($address_street) ? "'$request->input('address_street')'" : NULL;
                $business_address = Business_Address::create([
                    'no' => $address_no,
                    'street' => $address_street,
                    'municipality_city_id' => $request->input('address_city_municipality')
                ]);

                $player = Player::create([
                    'actor_id' => $actor->id,
                    'business_address_id' => $business_address->id,
                    'business_contact_no' => $request->input('contact_no'),
                    'business_email_add' => $request->input('email_add'),
                    'business_type_id' => $request->input('type'),
                    'owner_name' => $request->input('owner_name'),
                    'owner_sex_at_birth' => $request->input('owner_sex_at_birth'),
                    'sector' => $request->input('sector'),
                    'role_id' => $request->input('role_id'),
                    'is_active' => true,
                ]);

                $message = 'success3';
                $final_player = $player;
                */
            }

            if($if_exist == false){
                $business_address = Business_Address::create([
                    'no' => $address_no,
                    'street' => $address_street,
                    'municipality_city_id' => $request->input('address_city_municipality')
                ]);

                $player = Player::create([
                    'actor_id' => $actor->id,
                    'business_address_id' => $business_address->id,
                    'business_contact_no' => $request->input('contact_no'),
                    'business_email_add' => $request->input('email_add'),
                    'business_type_id' => $request->input('type'),
                    'owner_name' => $request->input('owner_name'),
                    'owner_sex_at_birth' => $request->input('owner_sex_at_birth'),
                    'sector' => $request->input('sector'),
                    'role_id' => $request->input('role_id'),
                    'is_active' => true,
                ]);

                //return response()->json(['status' => $message], 200);
                return response()->json(['status' => 'success','message' => 'Player successfully registered!', 'player_id' => $player->id, 'actor_id' => $actor->id], 200);    

            }else{
                $player = Player::create([
                    'actor_id' => $actor->id,
                    'business_address_id' => $id_municipality,
                    'business_contact_no' => $request->input('contact_no'),
                    'business_email_add' => $request->input('email_add'),
                    'business_type_id' => $request->input('type'),
                    'owner_name' => $request->input('owner_name'),
                    'owner_sex_at_birth' => $request->input('owner_sex_at_birth'),
                    'sector' => $request->input('sector'),
                    'role_id' => $request->input('role_id'),
                    'is_active' => true,
                ]);

                //return response()->json(['status' => $message], 200);
                return response()->json(['status' => 'success','message' => 'Player successfully registered!', 'player_id' => $player->id, 'actor_id' => $actor->id], 200);    

            }
        } else {

            $municipality_id = Business_Address::where('municipality_city_id', $request->input('address_city_municipality'))->get();
            $message = '';
            $if_exist = NULL;
            $id_municipality = NULL;

            $address_no = $request->input('address_no');
            $address_street = $request->input('address_street');

            if($request->input('address_no') == 'undefined'){
                $address_no = NULL;
            }
            
            if($request->input('address_street') == 'undefined'){
                $address_street = NULL;
            }

            if(sizeof($municipality_id) != 0){
                for($i = 0; $i < sizeof($municipality_id); $i++){
                    //check if all are equal.
                    $business_address_no = $municipality_id[$i]->no;
                    $business_address_street = $municipality_id[$i]->street;
                    if(($business_address_no == $address_no) 
                        && ($business_address_street == $address_street)){
                        $if_exist = true;
                        $id_municipality = $municipality_id[$i]->id;
                        $message = 'success1';
                    }else{
                        $if_exist = false;
                        $message = 'success2';
                    }
                }
            }else{
                $if_exist = false;
                $message = 'success3';
            }

            if($if_exist == false){
                $business_address = Business_Address::create([
                    'no' => $address_no,
                    'street' => $address_street,
                    'municipality_city_id' => $request->input('address_city_municipality')
                ]);

                $player = Player::create([
                    'actor_id' => $actor->id,
                    'business_address_id' => $business_address->id,
                    'business_contact_no' => $request->input('contact_no'),
                    'business_email_add' => $request->input('email_add'),
                    'business_type_id' => $request->input('type'),
                    'owner_name' => $request->input('owner_name'),
                    'owner_sex_at_birth' => $request->input('owner_sex_at_birth'),
                    'sector' => $request->input('sector'),
                    'role_id' => $request->input('role_id'),
                    'is_active' => true,
                ]);

                //return response()->json(['status' => $message], 200);
                return response()->json(['status' => 'success','message' => 'Player successfully registered!', 'player_id' => $player->id, 'actor_id' => $actor->id], 200);    

            }else{
                $player = Player::create([
                    'actor_id' => $actor->id,
                    'business_address_id' => $id_municipality,
                    'business_contact_no' => $request->input('contact_no'),
                    'business_email_add' => $request->input('email_add'),
                    'business_type_id' => $request->input('type'),
                    'owner_name' => $request->input('owner_name'),
                    'owner_sex_at_birth' => $request->input('owner_sex_at_birth'),
                    'sector' => $request->input('sector'),
                    'role_id' => $request->input('role_id'),
                    'is_active' => true,
                ]);

                //return response()->json(['status' => $message], 200);
                return response()->json(['status' => 'success','message' => 'Player successfully registered!', 'player_id' => $player->id, 'actor_id' => $actor->id], 200);    

            }
        }
    }

    public function addPlayerAgain(Request $request){
        $this->validate($request, [
            //'representative_id' => 'required',
            'name' => 'required',
            'address_no' => 'required',
            'address_street' => 'required',
            'address_city_municipality' => 'required',
            'address_province' => 'required',
            'address_region' => 'required',
            'contact_no' => 'required',
            'email_add' => 'required',
            'type' => 'required',
            'owner_name' => 'required',
            'owner_sex_at_birth' => 'required',
        ]);

        $actor = Actor::where('name', $request->input('name'))->first();

        if (!(isset($actor))) { 
            $actor = Actor::create([
                'name' => $request->input('name'),
            ]);

            $player = Player::create([
                'actor_id' => $actor->id,
                //'representative_id' => $request->input('representative_id'),
                //'business_name' => $request->input('name'),
                'business_address_no' => $request->input('address_no'),
                'business_address_street' => $request->input('address_street'),
                'business_address_city_municipality' => $request->input('address_city_municipality'),
                'business_address_province' => $request->input('address_province'),
                'business_address_region' => $request->input('address_region'),
                'business_contact_no' => $request->input('contact_no'),
                'business_email_add' => $request->input('email_add'),
                //'business_type_id' => $request->input('type'),
                'owner_name' => $request->input('owner_name'),
                'owner_sex_at_birth' => $request->input('owner_sex_at_birth'),
                'is_active' => true,
            ]);
    
            return response()->json(['status' => 'success','message' => 'Player successfully registered!', 'player_id' => $player->id, 'actor_id' => $actor->id], 200);    
        } else {

            $player = Player::create([
                'actor_id' => $actor->id,
                //'representative_id' => $request->input('representative_id'),
                //'business_name' => $request->input('name'),
                'business_address_no' => $request->input('address_no'),
                'business_address_street' => $request->input('address_street'),
                'business_address_city_municipality' => $request->input('address_city_municipality'),
                'business_address_province' => $request->input('address_province'),
                'business_address_region' => $request->input('address_region'),
                'business_contact_no' => $request->input('contact_no'),
                'business_email_add' => $request->input('email_add'),
                //'business_type_id' => $request->input('type'),
                'owner_name' => $request->input('owner_name'),
                'owner_sex_at_birth' => $request->input('owner_sex_at_birth'),
                'is_active' => true,
            ]);

            return response()->json(['status' => 'fail','message' => 'Actor already exist!', 'player_id' => $player->id, 'actor_id' => $actor->id], 200);    
        }
    }
}
