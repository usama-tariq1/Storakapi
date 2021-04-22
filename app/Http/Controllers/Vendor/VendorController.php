<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    
    public function register(Request $request){
        return AuthController::register($request , 3);
    }

    // Get Profile
    public function profile(){

        $user = User::where('id' , Auth::user()->id)->with('Role')->first();
        
        return response()->json($user);
    }

    // update Profile
    public function updateProfile(Request $request){

        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            
        ]);
        // dd($validator);
        if($validator->fails()){
            return response()->json(
                [
                    "code" => 409,
                    "message" => "Invalid Input ",
                    "errors" => $validator->errors(),
                ]
            );
        }

        $user = User::where('id' , Auth::user()->id)->with('Role')->first();
        $user->name = $request->name;
        $user->save();
       
        return $this->profile();
    }
}
