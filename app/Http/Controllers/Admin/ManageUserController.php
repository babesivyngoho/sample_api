<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class ManageUserController extends Controller
{
    // list of registered users
    public function index(){
        if(!Gate::allows('manage-users')){
            abort(403, "This action is unauthorized.");
        }
        
        $users = User::all();
        return view('admin.users', ['users' => $users]);
    }
}
