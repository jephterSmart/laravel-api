<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash; // this is bcrypt for hashing

class AuthController extends Controller
{
    public function register(Request $request): Response {
       $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);
        $user = User::create([
            'name'=> $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
       
        $response = [
            'user' => $user   
        ];
        return response($response, 201);
    }
    public function login(Request $request){
        $fields = $request->validate([
            'email'=>'string|required',
            'password'=>'required|string'
        ]);
        $user = User::where('email',$fields['email'])->first();
        if(!$user || Hash::check($user->password, $fields['password'])){
            return response([
                'message' => 'Not valid credentials'
            ],401);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 200);
        
    }
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
    }
}
