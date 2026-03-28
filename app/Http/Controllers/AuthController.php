<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // 1.1 Register
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'sometimes|in:admin,student',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'] ?? 'student',
        ]);

        return response()->json(['user' => $user, 'token' => $user->createToken('auth_token')->plainTextToken], 201);
    }

    // 1.2 Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => ['Invalid credentials.']]);
        }

        return response()->json(['user' => $user, 'token' => $user->createToken('auth_token')->plainTextToken]);
    }

    // 1.3 Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    }

    // Get authenticated user
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}