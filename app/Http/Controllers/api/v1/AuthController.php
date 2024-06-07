<?php

namespace App\Http\Controllers\api\v1;

use App\Events\UserCreated;
use App\Exceptions\UserNotCreatedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\RegisterRequest;
use App\Http\Resources\SuccessResource;
use App\Models\User;
use Illuminate\Database\QueryException;

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

        return new SuccessResource($user);
    }
}
