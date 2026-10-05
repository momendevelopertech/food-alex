<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Enums\Ask;
use App\Enums\Role as EnumRole;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\SocialLoginManagerService;

class MobileSocialLoginController extends Controller
{
    protected $socialLoginManagerService;

    public function __construct(SocialLoginManagerService $socialLoginManagerService)
    {
        $this->socialLoginManagerService = $socialLoginManagerService;
    }

    public function mobileSocialLogin(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'string', 'email', 'max:255'],
            'name'     => ['required', 'string', 'max:255'],
            'provider' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], 422);
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $user = User::create([
                    'name'              => $request->name,
                    'username'          => Str::slug($request->name) . rand(1, 500),
                    'email'             => $request->email,
                    'email_verified_at' => Carbon::now()->getTimestamp(),
                    'is_guest'          => Ask::NO,
                    'password'          => Hash::make(Str::random(12))
                ]);

                $user->assignRole(EnumRole::CUSTOMER);
            }

            return $this->socialLoginManagerService->provider($request->provider)->provider->Login($user);
        } catch (Exception $exception) {
            return new JsonResponse([
                'errors' => ['server_error' => $exception->getMessage()]
            ], 500);
        }
    }
}
