<?php

use Middlewares\AdminAuthMiddleware;
use Slim\Factory\AppFactory;
use Routes\MedicoRoute;
use Routes\UsuarioRoute;
use Middlewares\ExceptionHandler as ExceptionHandler;
use Middlewares\MedicoAuthMiddleware;
use Middlewares\PacienteAuthMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

$dotenv = \Dotenv\Dotenv::create(realpath( __DIR__. '/../../'));
$dotenv->load();

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$customErrorHandler = function (
    ServerRequestInterface $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
)
use ($app) {
    $payload = ['message' => $exception->getMessage()];
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(
        json_encode($payload, JSON_UNESCAPED_UNICODE)
    );
    return $response->withStatus(500);
};

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

$app->get('/medicos/{id}', MedicoRoute::class. '::get')->add(AdminAuthMiddleware::class);
$app->post('/medicos', MedicoRoute::class. '::insert');
$app->get('/medicos', MedicoRoute::class. '::getAll');
$app->get('/usuarios/{id}', UsuarioRoute::class. '::get');
$app->get('/usuarios', UsuarioRoute::class. '::getAll');
$app->post('/usuarios/auth', UsuarioRoute::class. '::login');
$app->post('/usuarios/me', UsuarioRoute::class. '::me');

$app->run();

/*
"medico": {
		"nome": "med",
		"especialidade": "neurologista",
		"crm": "23442",
		"cpf": "140.526.066-12"
	},
	"usuario": {
		"login": "med1591",
		"senha": "16159846",
		"tipo_usuario": 1
	}
*/