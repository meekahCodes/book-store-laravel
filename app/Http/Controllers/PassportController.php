<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PassportController extends Controller
{
    
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_active' => 1, //active by default
        ]);

        $role = Role::where('slug', '=', 'author')->first();

        $user_roles = UserRole::create([
            'user_id' => $user->id,
            'role_id' => $role->id //author role hardcoded for now
        ]);

        $token = $user->createToken('Auth Token')->accessToken;

        $user = auth()->user();
        $user->role = auth()->user()->roles()->orderBy('rank', 'DESC')->first()->slug;

        return response()->json(['token' => $token, 'user' => $user], 200);

    }

    public function login(Request $request)
    {

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('Auth Token')->accessToken;

            $user = auth()->user();
            $user->role = auth()->user()->roles()->orderBy('rank', 'DESC')->first()->slug;

            return response()->json(['token' => $token, 'user' => $user], 200);
        } else {
            return response()->json(['error' => 'Un Authorized'], 401);
        }
    }

    public function details()
    {
        $user = auth()->user();
        $user->role =   auth()->user()->roles()->orderBy('rank', 'DESC')->first()->slug;
        return response()->json(['user' => $user], 200);
    }
}
