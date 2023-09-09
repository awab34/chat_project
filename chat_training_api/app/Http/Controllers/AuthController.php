<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Events\Registered;


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

        event(new Registered($user));
        
        $token = $user->createToken('awab')->plainTextToken;

        
        return response([
            'user' => $user,
            'token' => $token
        ]);
    }


    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email|string',
            'password' =>'required|string',
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
            'description'=>'required|string',
            
        ]);

        $user = Auth::user();
        
        

        $user->update([
            'name' => $data['name'],
            'description'=> $data['description']
        ]);

        return response([
            'success'=>true
        ]);
    }
    public function changeEmail(Request $request){
        
        $data = $request->validate([
            'email' => 'required|email|string',
            'password'=>'required|string',
            
        ]);

        $user = Auth::user();
        if(!password_verify($data['password'],$user['password'])){
            return response([
                'wrong'=>'wrong password'
            ]); 
        }
        

        $user->update([
            'email' => $data['email'],
            'email_verified_at'=>null
        ]);

        event(new Registered($user));

        return response([
            'success'=>true
        ]);
    }
    public function resetPassword(Request $request){
        
        $data = $request->validate([
            'oldpassword' => 'required|string',
            'password' =>['required','confirmed',
        Password::min(8)->numbers()->symbols()],
            
        ]);

        $user = Auth::user();
        
        
        if(!password_verify($data['oldpassword'],$user['password'])){
            return response([
                'wrong'=>'wrong credintials'
            ]); 
        }

        $user->update([
            'password' => bcrypt($data['password']),
        ]);
        

        return response([
            'success'=>true
        ]);
    }

    public function showEmail(){
        $user = Auth::user();
        return response([
            'email' => $user->email
        ]);
    }


    public function userData(){
        $user = Auth::user();
        return response([
            'userData' => $user
        ]);
    }
}