<?php

use Errors\DefaultException;
use Psr\Http\Message\ServerRequestInterface;

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