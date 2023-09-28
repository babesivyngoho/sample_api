<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User_Permission;
use App\Models\User_Type;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('auth:api');
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function show()
    {
        return response()->json(User::all());
    }

    public function showRoles()
    {
        return response()->json(User_Type::all());
    }

    public function showPermissions()
    {
        return response()->json(User_Permission::all());
    }

    public function login(Request $request){
        
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if (isset($user)) {
            if($user->active == 1){
                if (Hash::check($request->input('password'), $user->password)) {
                    // $apikey = base64_encode(Str::random(40));
                    // User::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);;

                    $user_permissions = User_Permission::where('user_type_id', $user->user_type_id)->get();
                    $permission_array = [];
                    for($i = 0; $i < sizeof($user_permissions); $i++){
                        $permission = Permission::where('id', $user_permissions[$i]->permission_id)->get();
                        array_push($permission_array, $permission[0]);
                    }

                    $user_type = User_Type::where('id', $user->user_type_id)->get();

                    return response()->json(['status' => 'success', 'user_id' => $user->id, 'user' => $user, 'user_type' => $user_type, 'permissions' => $permission_array], 200);
                } else {
                    return response()->json(['status' => 'fail', 'message' => 'Incorrect password!'], 401);
                }
            }else{
                return response()->json(['status' => 'fail', 'message' => 'Account is not yet activated!'], 401);
            }
            
        } else {
            return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
        }

        //return response()->json(['status' => 'success'], 200);

    }
    
    // public function loginUsingFB(Request $request){
    //     try{
    //         $fb_user = Socialite::driver('facebook')->userFromToken($request->access_token);
    //     }catch( \Exception $e ){
    //         return response()->json(['status' => 'fail', 'message' => 'Access token is invalid!'], 401);
    //     }

    //     $user = User::where('facebook_id', $fb_user->id)->first();
    //     if(!$user){
    //         return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
    //     }
        
    //     $apikey = base64_encode(Str::random(40));
    //     User::where('facebook_id', $fb_user->id)->update(['api_key' => "$apikey"]);
    //     return response()->json(['status' => 'success', 'user_id' => $user->id,'api_key' => $apikey], 200);
    // }

    // public function connectFacebookToUserAccount(Request $request){
    //     try{
    //         $fb_user = Socialite::driver('facebook')->userFromToken($request->access_token);
    //     }catch( \Exception $e ){
    //         return response()->json(['status' => 'fail', 'message' => 'Access token is invalid!'], 401);
    //     }

    //     $connected_user = User::where('facebook_id', $fb_user->id)->first();
    //     if($connected_user){
    //         return response()->json(['status' => 'fail', 'message' => 'Facebook account is already linked to another account!'], 401);
    //     }

    //     $user = User::where('id', $request->user()->id)->first();
    //     if($user){
    //         User::where('id', $request->user()->id)->update(['facebook_id' => "$fb_user->id"]);
    //         return response()->json(['status' => 'success'], 201);
    //     }else{
    //         return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
    //     }
    // }

    public function register(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'sex_at_birth' => 'required',
            'contact_no' => 'required',
        //    'institution' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_check' => 'required',
        ]);
        //return response()->json(['status' => 'success', 'message' => 'User successfully registered!'], 200);


        //$apikey = base64_encode(Str::random(40));
        
        $user = User::where('name', $request->input('name'))->first();
        
        if (isset($user)) {
            return response()->json(['status' => 'fail', 'message' => 'User already exists!'], 401);
        } else {
            
            if($request->input('password') == $request->input('password_check')){
                
                $user = User::create([
        //             'name' => $request->input('name'),
        //             'institution' => $request->input('institution'),
                    'name' => $request->input('name'),
                    'assigned_sex_at_birth' => $request->input('sex_at_birth'),
                    'contact_no' => $request->input('contact_no'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'active' => 0,
        //             'userimage' => '/storage/default/profile-default.jpg'
                ]);
            
                //return response()->json(['status' => 'success', 'message' => 'User successfully registered!', 'user_id' => $user->id], 200);
                return response()->json(['status' => 'success', 'message' => 'User successfully registered!'], 200);

            }else{
                return response()->json(['status' => 'fail', 'message' => 'Password does not match!'], 401);
            }
        }
        
    }

    public function addUser(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'sex_at_birth' => 'required',
            'contact_no' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'assigned_sex_at_birth' => $request->input('sex_at_birth'),
            'contact_no' => $request->input('contact_no'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json(['status' => 'success', 'message' => 'User successfully registered!', 'user_id' => $user->id], 200);
    }

    // public function update(Request $request){
        
    //     $this->validate($request, [
    //         'username' => 'required',
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);

    //     if ($request->user()->cannot('update_a', User::class)) {
    //         // abort(403);
    //         return response()->json('Unauthorized.', 403);
    //     }

    //     $user = User::where('username', $request->input('username'))->first();

    //     if (isset($user)) {
    //         $user->username = $request->input('username');
    //         $user->email = $request->input('email');
    //         $user->password = Hash::make($request->input('password'));
    //         $user->save();

    //         return response()->json(['status' => 'success', 'message' => 'User updated successfully!'], 200);
    //     } else {
    //         return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
    //     }
    // }

    //public function updateProfile(Request $request, $id){
    public function updateProfile(Request $request){

        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'sex_at_birth' => 'required',
            'email' => 'required',
            'contact_no' => 'required',
        ]);

        //return response()->json(['status' => 'success', 'message' => 'User updated successfully!'], 200);

    //     echo($request->user());

    //     if ($request->user()->cannot('update_a', User::class)) {
    //         // abort(403);
    //         return response()->json('Unauthorized.', 403);
    //     }

        $user = User::where('id', $request['id'])->first();

        if (isset($user)) {
    //         $user->username = $request['username'];
            $user->name = $request['name'];
            $user->assigned_sex_at_birth = $request['sex_at_birth'];
            $user->email = $request['email'];
            $user->contact_no = $request['contact_no'];

    //         $user->institution = $request['institution'];
    //         $user->bio = $request['bio'];
           $user->save();

            return response()->json(['status' => 'success', 'message' => 'User updated successfully!', 'user' => $user], 200);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
        }
    }

    // public function delete(Request $request){
    //     $this->validate($request, [
    //         'username' => 'required',
    //         'password' => 'required'
    //     ]);

    //     if ($request->user()->cannot('update_a', User::class)) {
    //         // abort(403);
    //         return response()->json('Unauthorized.', 403);
    //     }

    //     $user = User::where('username', $request->input('username'))->first();
    //     if (isset($user)) {
            
    //         if (Hash::check($request->input('password'), $user->password)) {
    //             $user->delete();

    //             return response()->json(['status' => 'success', 'message' => 'User deleted successfully!'], 200);
    //         } else {
    //             return response()->json(['status' => 'fail', 'message' => 'Unauthorized.'], 401);
    //         }
           
    //     } else {
    //         return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
    //     }
    // }

    // public function getUserIDByUsername(Request $request){
    //     $this->validate($request, [
    //         'username' => 'required'
    //     ]);

    //     // if ($request->user()->cannot('update_a')) {
    //     //     // abort(403);
    //     //     return response()->json('Unauthorized.', 403);
    //     // }

    //     $user = User::where('username', $request->input('username'))->first();
    //     if (isset($user)) {
    //         return response()->json(['user_id' => $user->id], 201);
    //     } else {
    //         return response()->json(['status' => 'fail', 'message' => 'Username does not exist!'], 401);
    //     }
    // }

    // public function info($id){
    //     // return Auth::user();
    //     $user = User::where('id', $id)->first();
        
    //     return response()->json($user, 200);
    // }

    // public function checkPassword(Request $request, $id){
    //     $this->validate($request, [
    //         'password' => 'required'
    //     ]);
    
    //     $user = User::where('id', $id)->first();
    //     // echo($id);
    //     if (isset($user)) {
    //         if (Hash::check($request->input('password'), $user->password)) {
    //             return response()->json(['status' => 'success'], 200);
    //         } else {
    //             return response()->json(['status' => 'fail', 'message' => 'Incorrect password!'], 401);
    //         }
    //     } else {
    //         return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
    //     }
    //     // return response($request->input('password'));
    // }

    public function updatePassword(Request $request){
        $this->validate($request, [
            'id' => 'required',
            'old_password' => 'required',
            'new_password' => 'required',
            'new_password_confirm' => 'required'
        ]);
        
        $user = User::where('id', $request['id'])->first();

        if (isset($user)) {
            if (Hash::check($request->input('old_password'), $user->password)) {
                //return response()->json(['status' => 'success'], 200);
                if ($request->input('new_password') == $request->input('new_password_confirm')){
                    //         $user = User::where('id', $id)->first();
                    $user->password = Hash::make($request->input('new_password'));
                    $user->save();
                    return response()->json(['status' => 'success'], 200);
                } else {
                    return response()->json(['status' => 'fail not match', 'message' => 'New Password does not match!'], 401);
                }
            } else {
                return response()->json(['status' => 'fail incorrect', 'message' => 'Incorrect password!'], 401);
            }
        } else {
            return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
        }
            //     // return response($request->input('password'));

        //return response()->json(['status' => 'success'], 200);
        
       // if ($request->input('new_password') == $request->input('new_password_confirm')){
    //         $user = User::where('id', $id)->first();
    //         $user->password = Hash::make($request->input('new_pw'));
    //         $user->save();
         //   return response()->json(['status' => 'success'], 200);
       // } else {
         //   return response()->json(['status' => 'fail', 'message' => 'New Password does not match!'], 401);
       // }
        
    }

    public function searchUser(Request $request){
        $this->validate($request, [
            'user_id' => 'required',
        ]);
        
        $user = User::where('id', $request['user_id'])->first();

        return response()->json(['status' => 'success', 'data' => $user], 200);
    }

    public function updatePermissions(Request $request){
        $this->validate($request, [
            'user_type_id' => 'required',
            'permission_id' => 'required',
        ]);

        $user_permission = User_Permission::create([
            'user_type_id' => $request['user_type_id'],
            'permission_id' => $request['permission_id'],
        ]);

        return response()->json(['status' => 'success', 'data' => $user_permission], 200);
    }

    public function deletePermissions(){

        $user_permission = User_Permission::all();

        for($i = 0; $i < sizeof($user_permission); $i++){
            $user_permission[$i]->delete();
        }
    }
}
