<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;
use App\Application\Exception\AuthException as Auth;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

final class AuthMiddleware extends BaseMiddleware
{
    /**
     * @throws Auth
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $jwtHeader = $request->getHeaderLine('Authorization');
        if (!$jwtHeader) {
            throw new Auth('JWT Token required.', 401);
        }
        $jwt = explode('Bearer ', $jwtHeader);
        if (!isset($jwt[1])) {
            throw new Auth('JWT Token invalid.', 401);
        }
        return $response;
    }
}
