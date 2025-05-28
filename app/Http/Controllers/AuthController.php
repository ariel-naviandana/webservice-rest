<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    private function anonymize_email($email)
    {
        if (!$email) return null;
        [$user, $domain] = explode('@', $email);
        return substr($user, 0, 2) . str_repeat('*', max(strlen($user) - 2, 0)) . '@' . $domain;
    }

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'user',
            ]);

            Log::info('User registered', [
                'user_id' => $user->id,
                'email' => $this->anonymize_email($user->email),
                'ip' => $request->ip()
            ]);

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Register error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip()
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $credentials['email'])->first();

            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                Log::warning('Failed login attempt', [
                    'email' => $this->anonymize_email($request->email),
                    'ip' => $request->ip()
                ]);
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            Log::info('User logged in', [
                'user_id' => $user->id,
                'email' => $this->anonymize_email($user->email),
                'ip' => $request->ip()
            ]);
            $token = $user->createToken('api-token')->plainTextToken;
            $user->tokens()->latest()->first()->update(['expires_at' => now()->addHours(2)]);

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Login error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip()
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();

            Log::info('User logged out', [
                'user_id' => $user->id,
                'email' => $this->anonymize_email($user->email),
                'ip' => $request->ip()
            ]);
            return response()->json(['message' => 'Logged out successfully'], 200);
        } catch (\Throwable $e) {
            Log::error('Logout error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip()
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }

    public function assignRole(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'role' => 'required|in:user,critic,admin',
            ]);

            $user = User::findOrFail($id);
            $user->update(['role' => $validated['role']]);

            Log::info('User role updated', [
                'admin_id' => $request->user()?->id,
                'admin_email' => $this->anonymize_email($request->user()?->email),
                'target_user_id' => $user->id,
                'target_email' => $this->anonymize_email($user->email),
                'new_role' => $validated['role'],
                'ip' => $request->ip()
            ]);

            return response()->json($user, 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('AssignRole error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip()
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }
}
