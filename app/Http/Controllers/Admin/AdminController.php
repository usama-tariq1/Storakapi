<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
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
