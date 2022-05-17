<?php

namespace App\Http\Controllers\Api\Gamesite;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'token'             => ['required', 'string'],
            'from_website_url'  => ['required', 'string'],
        ]);

        $token = $request->input('token');
        $fromWebsiteUrl = $request->input('from_website_url');

        $response = Http::withToken($token)
            ->withHeaders(['Accept' => 'application/json'])
            ->get($fromWebsiteUrl.'/api/user');

        if ($response->successful()) {
            $json = $response->json();
            $member = Member::firstOrCreate([
                'website_code' => Arr::get($json, 'website.code'),
                'website_username' => $json['username'],
            ]);

            $tokenResult = $member->createToken($this->getTokenName($request), ['*']);

            if ($request->wantsJson()) {
                return $this->respondForApi($tokenResult->plainTextToken, $member);
            }

            return redirect(config('app.ui_url').'/login?token='.$tokenResult->plainTextToken);
        } else {
            return [
                'success' => false,
                'status' => $response->status(),
                'message' => "Cannot login",
            ];
        }
    }

    private function getTokenName(Request $request)
    {
        return $request->input('from_website_url');
    }

    private function respondForApi($token, Member $member)
    {
        return JsonResource::make([
            'access_token' => $token,
            'member' => $member->toArray(),
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Get the authenticated user
     */
    public function me(Request $request)
    {
        $user = $request->user();
        return JsonResource::make($user);
    }

    public function getTokenForDev()
    {
        if (app()->isProduction()) {
            return response('', 404);
        }

        $member = Member::first();

        $tokenResult = $member->createToken('development', ['*']);

        return $this->respondForApi($tokenResult->plainTextToken, $member);
    }
}
