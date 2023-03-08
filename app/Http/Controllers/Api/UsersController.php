<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // return $validator;

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['errors' => ['email' => 'The Provided Credentials are incorrect'],], 422);
        }


        return response(['user'=>$user,'token' => 'Bearer ' . $user->createToken($request->email)->plainTextToken], 200);

        // return $request->all();
    }


    public function getUser()
    {
        return response()->json(auth()->user())->setStatusCode(200);
    }
}
