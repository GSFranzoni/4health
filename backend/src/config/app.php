<?php

use Controller\MedicoController;
use Controller\PacienteController;
use Controller\TipoUsuarioController;
use Controller\UsuarioController;
use Errors\DefaultException;
use Middlewares\AdminAuthMiddleware;
use Middlewares\MedicoAuthMiddleware;
use Middlewares\PacienteAuthMiddleware;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteCollectorProxy;

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
	$status = 500;
	if($exception instanceof DefaultException) {
		$status = $exception->getCode();
	}
    return $response->withStatus($status);
};

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);


$app->post('/usuarios/auth', UsuarioController::class. ':login');
$app->post('/usuarios/me', UsuarioController::class. ':me');

$app->get('/tipos/{id}', TipoUsuarioController::class. ':get');
$app->get('/tipos', TipoUsuarioController::class. ':getAll');
$app->get('/medicos/{id}', MedicoController::class. ':get');
$app->get('/exames', ExameController::class. ':getAll');

$app->get('/pacientes/{id}', PacienteController::class. ':get');

$app->group('', function (RouteCollectorProxy $group) {

	$group->get('/usuarios/{id}', UsuarioController::class. ':get');
	$group->get('/usuarios', UsuarioController::class. ':getAll');

	$group->post('/medicos', MedicoController::class. ':insert');
	$group->put('/medicos/{id}', MedicoController::class. ':update');
	$group->delete('/medicos/{id}', MedicoController::class. ':delete');
	$group->get('/medicos', MedicoController::class. ':getAll');

	$group->get('/pacientes', PacienteController::class. ':getAll');
	$group->post('/pacientes', PacienteController::class. '::insert');
	$group->delete('/pacientes/{id}', PacienteController::class. ':delete');
	$group->put('/pacientes/{id}', PacienteController::class. ':update');

})->add(new AdminAuthMiddleware());

$app->group('', function (RouteCollectorProxy $group) {

})->add(new MedicoAuthMiddleware());

$app->group('', function (RouteCollectorProxy $group) {

})->add(new PacienteAuthMiddleware());





$app->run();