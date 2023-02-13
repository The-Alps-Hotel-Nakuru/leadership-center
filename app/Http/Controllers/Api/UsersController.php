<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email'=>['The Provided Credentials are incorrect'],
            ]);
        }


        return $user->createToken($request->email)->plainTextToken;
    }
}
