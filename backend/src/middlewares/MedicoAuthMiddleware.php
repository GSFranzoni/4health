<?php

namespace Middlewares;

use Exception;
use Firebase\JWT\JWT;
use Model\TipoUsuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Throwable;

class MedicoAuthMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $token = $request->getHeader('Authorization')[0] ?? "";
        CheckToken::run($token, TipoUsuario::MEDICO);
        return $handler->handle($request);
    }
}