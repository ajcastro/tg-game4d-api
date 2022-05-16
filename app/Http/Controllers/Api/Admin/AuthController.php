<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login user and create token
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['username', 'password']);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Credentials not found.'
            ], 401);
        }

        /** @var User */
        $user = $request->user();

        $tokenResult = $user->createToken($this->getTokenName($request), ['*']);

        return $this->respondWithToken($tokenResult->plainTextToken, $user);
    }

    private function respondWithToken($token, User $user)
    {
        return JsonResource::make([
            'access_token' => $token,
            'user' => $user->toArray() + [
                'fullName' => $user->name,
                'role' => 'admin',
                'ability' => $user->getCaslAbilities(),
                'admin_redirect' => $user->getAdminRedirect(),
            ],
            'token_type' => 'Bearer',
        ]);
    }

    private function getTokenName(Request $request)
    {
        return $request->device_name ?? $request->header('user-agent');
    }

    /**
     * Get the authenticated user
     */
    public function me(Request $request)
    {
        $user = $request->user();
        return JsonResource::make($user);
    }

    /**
     * Logout user (Revoke the token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return JsonResource::make([
            'message' => 'Successfully logged out'
        ]);
    }

    public function changePassword(Request $request)
    {
        /** @var User */
        $user = $request->user();
        $request->validate([
            'old_password' => [
                'required',
                function ($attributes, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password) ){
                        $fail('Invalid old password');
                    }
                }
            ],
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
            ]
        ]);

        $user = $request->user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return [];
    }
}
