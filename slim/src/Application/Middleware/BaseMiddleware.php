<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Application\Exception\AuthException;
use Firebase\JWT\JWT;
use App\Application\Settings\SettingsInterface;

abstract class BaseMiddleware
{

    protected function checkToken(string $token): object
    {
        try {
            return JWT::decode($token, "ef41rfr41gt41ht4h656thyth4y65unavion", ['HS256']);
        } catch (\UnexpectedValueException $ex) {
            throw new AuthException('Forbidden: you are not authorized.', 403);
        }
    }
}
