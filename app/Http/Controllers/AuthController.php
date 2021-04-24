<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Tooling;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponser;
    use Tooling;

    public static function register(Request $request , $role_id = 4)
    {

        $otp = self::uniqueNumber();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            
        ]);

        if($validator->fails()){
            
            return response()->json(
                [
                    "code" => 409,
                    "message" => "Invalid Input ",
                    "errors" => $validator->errors(),
                ]
            );
        }

        $user = User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            "role_id" => $role_id,
            "otp" => $otp,
            'status' => 1
        ]);



        $emailto = $request->email;
        $name = $request->name;



        Mail::send('Auth.verifyemail', ['otp' => $otp] , function($message) use ($emailto ,  $name) {
            $message->to($emailto, $name)
            ->subject('Please Verify Your Email Address');
            $message->from(env('MAIL_FROM_ADDRESS'),env('APP_NAME'));
        });



        return self::success([

            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }


    public function who(){
        return $this->profile();
    }

    public function profile(){

        $user = User::where('id' , Auth::user()->id)->with('Role')->first();
        // dd($user);
        return response()->json([
            "code"=>200,
            "profile" => $user
        ]);
        
    }

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

    public static function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return self::error('Credentials not match', 401);
        }


        if(auth()->user()->status == 0){
            return response()->json(
                [
                    "code" => 403,
                    "message" => "Account is Disabled",
                    
                ]
            );

        }


        if(auth()->user()->role_id != 4){
            return response()->json([
                "code" => 403,
                "message" => "Can Not Access This Information"
            ]);
        }
        




        return self::success([
            
            'token' => auth()->user()->createToken('API Token')->plainTextToken,
            'user' => Auth::user('id' , auth()->user()->id)->with('Role')->first()
        ]);


    }


    public static function verifyemail(Request $request){
        $suspectedOtp = $request->otp;
        $user = User::where('id' , Auth::user()->id)->first();

        if($suspectedOtp == $user->otp){
            $user->Otp = null;
            $user->email_verified_at = Carbon::now();
            $user->save();

            return response()->json([
                "code" => 200,
                "message" => "Success"
            ]);
        }
        else{
            return response()->json([
                "code" => 409,
                "message" => "Invalid OTP"
            ]);
        }
        
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        // dd('hit');

        return [
            "code" => 200,
            'message' => 'Token Revoked'
        ];
    }
}