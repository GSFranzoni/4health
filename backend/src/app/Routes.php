<?php

use Controller\AtendimentoSolicitacaoController;
use Controller\ExameController;
use Controller\MedicoController;
use Controller\PacienteController;
use Controller\UsuarioController;
use Middlewares\AdminAuthMiddleware;
use Middlewares\AuthMiddleware;
use Middlewares\MedicoAuthMiddleware;
use Middlewares\PacienteAuthMiddleware;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;

$app->post('/usuarios/auth', UsuarioController::class . ':login');
$app->post('/usuarios/me', UsuarioController::class . ':me');

$app->get('/exames', ExameController::class . ':getAll');

$app->group('', function (RouteCollectorProxy $group) {
	$group->post('/solicitacoes', AtendimentoSolicitacaoController::class . ':insert');
	$group->get('/medicos/disponiveis', MedicoController::class . ':getDisponiveis');
	$group->post('/paciente/anonimizar', PacienteController::class . ':anonimizar');
})->add(new PacienteAuthMiddleware());

$app->group('', function (RouteCollectorProxy $group) {
	$group->get('/exames/{id}', ExameController::class . ':get');
	$group->get('/medicos', MedicoController::class . ':getAll');
	$group->get('/pacientes/{id}/exames', ExameController::class . ':getByPaciente');
	$group->get('/pacientes', PacienteController::class . ':getAll');
	$group->get('/medicos/{id}', MedicoController::class . ':get');
	$group->get('/pacientes/{id}', PacienteController::class . ':get');
})->add(new AuthMiddleware());

$app->group('', function (RouteCollectorProxy $group) {
	$group->get('/usuarios/{id}', UsuarioController::class . ':get');
	$group->get('/usuarios', UsuarioController::class . ':getAll');
	$group->put('/usuarios/{id}', UsuarioController::class . ':update');
	$group->post('/medicos/{id}/usuario', UsuarioController::class . ':insertMedico');
	$group->post('/pacientes/{id}/usuario', UsuarioController::class . ':insertPaciente');

	$group->post('/medicos', MedicoController::class . ':insert');
	$group->put('/medicos/{id}', MedicoController::class . ':update');
	$group->delete('/medicos/{id}', MedicoController::class . ':delete');

	$group->post('/pacientes', PacienteController::class . ':insert');
	$group->delete('/pacientes/{id}', PacienteController::class . ':delete');
	$group->put('/pacientes/{id}', PacienteController::class . ':update');
})->add(new AdminAuthMiddleware());

$app->group('', function (RouteCollectorProxy $group) {
	$group->get('/medicos/{id}/solicitacoes', AtendimentoSolicitacaoController::class . ':getByMedico');
	$group->get('/medicos/{id}/exames', ExameController::class . ':getByMedico');
	$group->post('/exames', ExameController::class . ':insert');
	$group->put('/exames/{id}', ExameController::class . ':update');
	$group->delete('/exames/{id}', ExameController::class . ':delete');
	$group->put('/solicitacoes/{id}', AtendimentoSolicitacaoController::class . ':update');
})->add(new MedicoAuthMiddleware());

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
	throw new HttpNotFoundException($request);
});
