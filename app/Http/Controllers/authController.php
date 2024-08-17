<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class authController extends Controller
{
    public function login(UserRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $user = User::where('email', $validatedData['email'])->first();

            if (! $user || ! Hash::check($validatedData['password'], $user->password)) {
                throw ValidationException::withMessages([
                    "messages" => "E-posta adresiniz veya şifreniz hatalı.",
                ]);
            }
            $user['token'] = $user->createToken("access", ['admin'])->plainTextToken;
            return $user;
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }

    }

    public function logout(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $tokennId = explode('|', $request->token);
        $user->tokens()->where('id', $tokennId[0])->delete();
    }
}
