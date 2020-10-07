<?php

use Controller\AtendimentoSolicitacaoController;
use Controller\ExameController;
use Controller\MedicoController;
use Controller\PacienteController;
use Controller\TipoUsuarioController;
use Controller\UsuarioController;
use Errors\DefaultException;
use Middlewares\AdminAuthMiddleware;
use Middlewares\MedicoAuthMiddleware;
use Middlewares\PacienteAuthMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

$dotenv = \Dotenv\Dotenv::create(realpath(__DIR__ . '/../../'));
$dotenv->load();

$app = AppFactory::create();

$app->options('/{routes:.+}', function ($request, $response, $args) {
	return $response;
});

$app->add(function ($request, $handler) {
	$response = $handler->handle($request);
	return $response
		->withHeader('Access-Control-Allow-Origin', '*')
		->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
		->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

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
	if ($exception instanceof DefaultException) {
		$status = $exception->getCode();
	}
	return $response->withStatus($status);
};

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);


$app->post('/usuarios/auth', UsuarioController::class . ':login');
$app->post('/usuarios/me', UsuarioController::class . ':me');

$app->get('/tipos/{id}', TipoUsuarioController::class . ':get');
$app->get('/tipos', TipoUsuarioController::class . ':getAll');
$app->get('/medicos/{id}', MedicoController::class . ':get');
$app->get('/pacientes/{id}/exames', ExameController::class . ':getByPaciente');
$app->get('/medicos/{id}/exames', ExameController::class . ':getByMedico');
$app->get('/medicos/{id}/solicitacoes', AtendimentoSolicitacaoController::class . ':getByMedico');
$app->put('/solicitacoes/{id}', AtendimentoSolicitacaoController::class . ':update');
$app->post('/solicitacoes', AtendimentoSolicitacaoController::class . ':insert');
$app->post('/exames', ExameController::class . ':insert');
$app->get('/solicitacoes', AtendimentoSolicitacaoController::class . ':getAll');
$app->get('/exames/{id}', ExameController::class . ':get');
	
$app->get('/pacientes/{id}', PacienteController::class . ':get');

$app->group('', function (RouteCollectorProxy $group) {

	$group->get('/usuarios/{id}', UsuarioController::class . ':get');
	$group->get('/usuarios', UsuarioController::class . ':getAll');
	$group->put('/usuarios/{id}', UsuarioController::class . ':update');
	$group->post('/medicos/{id}/usuario', UsuarioController::class . ':insertMedico');
	$group->post('/pacientes/{id}/usuario', UsuarioController::class . ':insertPaciente');

	$group->post('/medicos', MedicoController::class . ':insert');
	$group->put('/medicos/{id}', MedicoController::class . ':update');
	$group->delete('/medicos/{id}', MedicoController::class . ':delete');
	$group->get('/medicos', MedicoController::class . ':getAll');

	$group->get('/pacientes', PacienteController::class . ':getAll');
	$group->post('/pacientes', PacienteController::class . ':insert');
	$group->delete('/pacientes/{id}', PacienteController::class . ':delete');
	$group->put('/pacientes/{id}', PacienteController::class . ':update');
})/*->add(new AdminAuthMiddleware())*/;

$app->group('', function (RouteCollectorProxy $group) {
})->add(new MedicoAuthMiddleware());

$app->group('', function (RouteCollectorProxy $group) {
})->add(new PacienteAuthMiddleware());


$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
	throw new HttpNotFoundException($request);
});


$app->run();
