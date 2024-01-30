<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function registerUser(Request $request){
        $validate = Validator::make($request->all(),
         [
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => 'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 400,
                'message'=>"Validation Fails",
                'errors'=>$validate->errors(),

            ]);
        }

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'user_type' =>"user"
        ];

        $user = User::create($data);
        return response()->json([
            'status' => 201,
            'message'=>"Account Created Successfully",
            'data'=>$user,
        ]);
    }

    public function loginPost(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|exists:users,email',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Fails',
                'errors' => $validator->errors(),
            ]);
        }
        
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => 201,
                'message' => 'Login Successful',
                'user' => $user,
                'access_token' => $token,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid credentials',
            ]);
        }
        
    }

    public function logout(Request $request){
        return response()->json([
            'message'=>"Logged out Successfully",
            'status' => 201,
        ]);
    }



}
