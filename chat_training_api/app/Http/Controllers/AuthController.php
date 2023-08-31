<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
class AuthController extends Controller{
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'description'=>'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' =>['required','confirmed',
        Password::min(8)->numbers()->symbols()],
        ]);
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'description'=> $data['description']
        ]);
        $token = $user->createToken('awab')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }


    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email|string',
            'password' =>'required',
            'remember'=>'boolean',
        ]);
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);
        if(!Auth::attempt($credentials,$remember)){
            return response([
                'error'=>'The Provided Credentials are not correct'
            ],422);
        }

        $user = Auth::user();
        $token = $user->createToken('awab')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }


    public function logout(){
        $user = Auth::user();
        
        $user->currentAccessToken()->delete();
        return response([
            'success' => TRUE
        ]);
    }


    public function update(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'oldPassword'=>'required|string',
            'description'=>'required|string',
            'email' => 'required|email|string',
            'password' =>['required','confirmed',
        Password::min(8)->numbers()->symbols()],
        ]);


        $user = Auth::user();
        
        if(!password_verify($data['oldPassword'],$user['password'])){
            return response([
                'wrong'=>'wrong credintials'
            ]); 
        }
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'description'=> $data['description']
        ]);
        return response([
            'success'=>true
            ]);
        

        
    }



    public function userData(){
        $user = Auth::user();
        return response([
            'userData' => $user
        ]);
    }
}