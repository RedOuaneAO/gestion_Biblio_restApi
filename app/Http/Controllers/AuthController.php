<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','forgot','reset']]);
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('user');
        $token = Auth::login($user);
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
            ]
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        
        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorisation' => [
                'token' => $token,
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
    public function updateProfile(Request $request){
        $user=Auth::user(); 
                $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'success' => 'You Profile Has Been Updated Successfuly',
        ]);
    }
    public function deleteProfile($id){
        $user=Auth::user(); 
        if($user->can('delete every profile') || $user->id == $id){
            $user->where('id',$id)->delete();
            return response()->json(['success' => 'The Profile Has Been deleted Successfuly',]);
        }
        return response()->json(['error' => 'You dont have permission to delete this account',]);
        
    }
    
    public function forgot(Request $request){
        $validation = $request->validate(['email' => 'required|email|exists:users']);
        if($validation){
            // $user = User::where('email', $request->email)->first();
            $token = Str::random(64);
            $insert = DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
                if($insert){
                    Mail::send('email', ['token'=> $token], function($message) use($request){
                        $message->to($request->email);
                        $message->subject('Reset your password');
                    });
                    return response()->json(['success' => 'we have emailed you with reset password Token']);
                }
            }else{
                return response()->json(['Error' => 'Your email does not exist']);
            }
    }
    public function reset($token, Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);
        $validateToken = DB::table('password_resets')->where([
            'token' => $token,
            'email' => $request->email
        ])->first();

        if(!$validateToken){
            return response()->json(['Error' => 'Invalid Token']);
        }
        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        if($user){
            DB::table('password_resets')->where(['email'=> $request->email])->delete();
            return response()->json(['Success' => 'password updated successfully']);
        }
    }
}
