<?php

namespace App\Http\Controllers;

use App\Http\Auth\Requests\LoginRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * register a new user
     *
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register( RegisterUserRequest $request)
    {

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        return response()->json([
            'message' => __('auth.messages.success.register')
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {

        $credentials = request(['email', 'password']);

        abort_if(!Auth::attempt($credentials), 401);

        $user = $request->user();

        $tokenResult = $user->createToken('Personal access token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Log the user out and revoke token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }

    /**
     * Return the currently logged in user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
