<?php

namespace Middlewares;

use Errors\UnauthorizedException;
use Exception;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Throwable;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $token = $request->getHeader('Authorization')[0] ?? "";
        try {
            $decoded = (array) JWT::decode($token, getenv('secret'), array('HS256'));
        }
        catch(Exception $e) {
            throw new UnauthorizedException();
        }
        return $handler->handle($request);
    }
}