<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use App\Traits\Tooling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    //

    use Tooling;

    public function index(){
        $stores = Store::where('status' , 1)->get();
        return [
            "code" => 200,
            "stores" => $stores
        ];
    }

    public function show($id){
        $store = Store::where(['status'=> 1 , 'id' => $id])->first();
        if($store){
            return [
                "code" => 200,
                "stores" => $store
            ];
        }
        else{
            return [
                "code" => 404,
                "message" => "Store Not Found"
            ];
        }
    }

    public function store(Request $request){
        
        $count_check  = Store::where(['status'=> 1 ,  'user_id' => Auth::user()->id])->count();
        $user = User::where('id' , Auth::user()->id)->with('Role')->first();
        
        if($user->role_id != 1 && $user->role_id != 3){
            return [
                'code' => 403,
                "message" => "Not Allowed To Create A Store",
            ];
        }

        



        if($count_check == 0){
            $store = Store::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $request->image,
                'status' => 1,
                'user_id' => Auth::user()->id ,
                'code' => self::uniqueString()
            ]);
            return [
                'code'=> 200 , 
                'store' => $store
            ];
        }
        else{
            return [
                'code'=> 409 , 
                'message' => "Already Have A Store"
            ];
        }
    }


    // update Store 
    public function update(Request $request , $id){

        // dd(
        //     $request->all()
        // );

        $store  = Store::where(['status'=> 1 ,  'id' => $id])->first();

        if($store){
            $store->name = $request->name;
            $store->description = $request->description;
            $store->save();
    
    
            return [ 
                'code' => 200,
                'store'  => $store
            ];

        }
        else{
            return [ 
                'code' => 404,
                'message' => "Store not found"
            ];
        }


    }

    // mystore
    public function mystore(){
        $store  = Store::where(['status'=> 1 ,  'user_id' => Auth::user()->id])->first();

        if($store){
            return [
                'code' => 200,
                'store' => $store
            ];
        }else{
            return [
                'code' => 404,
                'store' => $store,
                'message' => "Store Not Found"
            ];
        }
    }



}
