<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    use ApiResponser;

    // login
    public static function login(Request $request){
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return self::error('Credentials not match', 401);
        }

        $user = User::where('id' , Auth::user()->id)->with('Role')->first();

        if($user->status == 0){
            return response()->json(
                [
                    "code" => 403,
                    "message" => "Account is Disabled",
                    
                ]
            );

        }


        if($user->role_id != 1){
            return response()->json([
                "code" => 403,
                "message" => "Can Not Access This Information"
            ]);
        }
        




        return self::success([
            
            'token' => auth()->user()->createToken('API Token')->plainTextToken,
            'user' => $user
        ]);


    }

    // Get Profile
    public function profile(){

        $user = User::where('id' , Auth::user()->id)->with('Role')->first();
        // dd($user);
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
        // dd($user);
        return $this->profile();
    }
}
