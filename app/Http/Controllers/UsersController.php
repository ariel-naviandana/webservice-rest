<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    private function anonymize_email($email)
    {
        if (!$email) return null;
        [$user, $domain] = explode('@', $email);
        return substr($user, 0, 2) . str_repeat('*', max(strlen($user) - 2, 0)) . '@' . $domain;
    }

    public function index()
    {
        Log::info('List all users', [
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);
        return response()->json(User::all());
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        Log::info('Show user details', [
            'target_user_id' => $id,
            'target_email' => $this->anonymize_email($user->email),
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'string|min:6',
            'photo_url' => 'nullable|url',
            'role' => 'in:admin,user,critic',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        Log::info('User updated', [
            'target_user_id' => $id,
            'target_email' => $this->anonymize_email($user->email),
            'user_id' => $request->user()?->id,
            'ip' => $request->ip(),
        ]);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        Log::info('User deleted', [
            'target_user_id' => $id,
            'target_email' => $this->anonymize_email($user->email),
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);

        return response()->json(null, 204);
    }
}
