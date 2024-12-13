<?php

namespace App\Data\Repositories\Auth;

use App\Models\User;
use App\Core\ApplicationModels\JwtToken;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Core\Repositories\Auth\IAuthRepository;

class AuthRepository implements IAuthRepository
{
    public function login(LoginAuthRequest $request): ?JwtToken
    {
        $token = auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);
        if (!$token) return null;
        $usuario = User::where('email', '=', $request->email)->first();
        $jwtToken = new JwtToken();
        $jwtToken->accessToken = $token;
        $jwtToken->userId = $usuario->id;
        $jwtToken->userName = $usuario->name;
        return $jwtToken;
    }

    public function logout(): void
    {
        auth()->logout();
    }
}
