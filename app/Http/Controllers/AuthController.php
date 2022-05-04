<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ProfileResource;
use App\Models\FreelancerProfile;

class AuthController extends Controller
{


    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);

        if (Auth::guard('api')->attempt($credentials)) {
            $userStatus = Auth::guard('api')->User()->status;
            if ($userStatus === 0) {
                return response()->json([
                    'message' => 'This user not active',
                    'status' => 'NotActive',
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Incorrect Login',
                'status' => false,

            ])->setStatusCode(400);
        }

        $user = auth()->guard('api')->user();
        return (new ProfileResource($user));
    }

    // REGISTER EMPLOYEER
    public function register_employeer(Request $request)
    {
        try {

            request()->validate(
                [
                    'email'      =>  'required|string|email|unique:users',
                    'name'       =>  'required',
                    'password'   =>  'required|confirmed|min:6',
                ],
            );

            $user = new user;
            $user->email      = $request->email;
            $user->name       = $request->name;
            $user->statut     = 1; //1=active, 0=not_active
            $user->password   = Hash::make($request->password);
            $user->save();

            // assingRole
            $user->assignRole('Employeer');

            return response()->json(['success' => true,  'message' => 'Register Successfully !']);
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'message' => $e]);
        }
    }

    // REGISTER FREELANCER
    public function register_freelancer(Request $request)
    {
        try {
            request()->validate(
                [
                    'email'      =>  'required|string|email|unique:users',
                    'name'       =>  'required',
                    'password'   =>  'required|confirmed|min:6',
                ],

            );

            $user = new user;
            $user->email      = $request->email;
            $user->name       = $request->name;
            $user->statut     = 1; //1=active, 0=not_active
            $user->password   = Hash::make($request->password);
            $user->save();

            $profile = new FreelancerProfile;
            $profile->user_id          = $user->id;
            $profile->birthplace       = $request->birthplace;
            $profile->birthdate        = $request->birthdate;
            $profile->phone_number     = $request->phone_number;
            $profile->gender           = $request->gender; //1=men, 0=mowen
            $profile->address          = $request->address;
            $profile->save();

            // assingRole
            $user->assignRole('Freelancer');

            return response()->json(['success' => true, 'message' => 'Register Successfully !']);
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'message' => $e]);
        }
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message'   => 'Successfully logged out',
            'status'    => true,
        ]);
    }
}
