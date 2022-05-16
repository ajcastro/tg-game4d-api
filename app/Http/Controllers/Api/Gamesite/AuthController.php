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
            'token' => ['required'],
            'from_website_url' => ['required'],
        ]);

        if ($request->wantsJson()) {
            return response([
                'status' => 400,
                'message' => 'Should be performed on browser to redirect to frontend UI url.',
            ], 400);
        }

        $token = $request->input('token');
        $fromWebsiteUrl = $request->input('from_website_url');

        $response = Http::withToken($token)->get($fromWebsiteUrl.'/api/user');

        if ($response->successful()) {
            $json = $response->json();
            $member = Member::firstOrCreate([
                'website_code' => Arr::get($json, 'website.code'),
                'website_username' => $json['username'],
            ]);

            $tokenResult = $member->createToken($this->getTokenName($request), ['*']);

            return redirect(config('app.ui_url').'/auth_callback?token='.$tokenResult->plainTextToken);
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
}
