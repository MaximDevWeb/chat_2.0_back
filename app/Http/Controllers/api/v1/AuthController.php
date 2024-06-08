<?php

namespace App\Http\Controllers\api\v1;

use App\Events\UserCreated;
use App\Exceptions\EmailTokenNotFoundException;
use App\Exceptions\UserNotCreatedException;
use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\EmailVerificationRequest;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\AuthUserResource;
use App\Http\Resources\SuccessResource;
use App\Models\EmailToken;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @throws UserNotCreatedException
     */
    public function register(RegisterRequest $request): SuccessResource
    {
        $validated = $request->validated();

        try {
            $user = User::create($validated);
            UserCreated::dispatch($user);
        } catch (QueryException $exception) {
            throw new UserNotCreatedException();
        }

        return new SuccessResource($request);
    }

    public function emailVerification(EmailVerificationRequest $request): SuccessResource
    {
        $request->validated();

        $emailToken = EmailToken::query()
            ->where('token', $request->token)
            ->firstOr(function () {
                throw new EmailTokenNotFoundException();
            });

        $emailToken->user()->update([
            'email_verified_at' => now(),
        ]);

        $emailToken->delete();

        return new SuccessResource($request);
    }

    public function login(LoginRequest $request): AuthResource
    {
        $request->validated();
        $user = User::query()
            ->where('email', $request->email)
            ->firstOr(function () {
                throw new UserNotFoundException();
            });

        if (! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email и пароль не совпадают'],
            ]);
        }

        return new AuthResource($user);
    }

    public function session(): AuthUserResource
    {
        return new AuthUserResource(auth()->user());
    }
}
