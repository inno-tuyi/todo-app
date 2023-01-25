<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $credentials = $request->only(['email', 'password']);
       
        if (Auth::attempt($credentials)) {

           /** @var User */
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;
            return response()->json(['token' => $token, "clients"=>$user->clients()], 200);
        }
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    public function logout() {

         /** @var User */
         
        $user = Auth::guard('api')->user();
        $user->token()->revoke();
        return response()->json(['message' => 'Logged out successfully']);
    }
    

    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if( $user->save()) {

            return response()->json(["message"=>"user creted", "user"=>$user], 200);
    }

    else {

         return response()->json(["error"=>"user not registered"]);
    }

 }
       

public function authenticate(){


    return 'hello';

}

      
        
}
