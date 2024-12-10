<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validated = Validator::make($request->all(), [
           'email' => 'required|email|unique:users,email',
           'password' => 'required|min:8' 
        ]);

        if($validated->fails()) {
            return response()->json(['message' => 'Todos los campos son requeridos', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->getData();

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);
        $user->save();
        return response()->json(['message' => 'Usuario creado exitosamente'], 201);
    }

    public function login(Request $request) {
        $validated = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validated->fails()) {
            return response()->json(['
                message' => 'Todos los campos son requeridos',
                'errors' => $validated->errors(),
            ], 422);
        }

        $validated = $validated->getData();
        $user = User::where('email', $validated['email'])->first();
        
        if(!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Login Correcto',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Cierre de sesion exitoso'], 200);
    }
}
