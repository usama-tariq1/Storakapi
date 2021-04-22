<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //

    public function profile(){

        $user = User::where('id' , Auth::user()->id)->with('Role')->first();
        // dd($user);
        return response()->json($user);
    }



}
