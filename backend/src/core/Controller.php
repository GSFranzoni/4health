<?php
namespace Core;

use Errors\DefaultException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

abstract class Controller {

    protected static $model;

    public function get(Request $request, Response $response, $args) {

        $result = self::$model->get($args['id']);

        if(!$result) {
            throw new DefaultException("A chave informada não corresponde à nenhum registro!", 400);
        }

        return $this->makeResponse($response, [
            'message' => 'Registro recuperado com sucesso!',
            'body' => $result
        ]);
        
    }

    public function getAll(Request $request, Response $response, $args) {

        return $this->makeResponse($response, [
            'message' => 'Dados recuperados com sucesso',
            'body' => self::$model->getAll()
        ]);

    }

    public function insert(Request $request, Response $response, $args) {

        return $this->makeResponse($response, [
            'message' => 'Dados salvos com sucesso',
            'body' => [ 'id' => self::$model->save($request->getParsedBody()) ]
        ]);

    }

    public function delete(Request $request, Response $response, $args) {

        if(!self::$model->get($args['id'])) {
            throw new DefaultException("A chave informada não corresponde à nenhum registro!", 400);
        }

        self::$model->delete($args['id']);

        return $this->makeResponse($response, [
            'message' => 'Dados deletados com sucesso'
        ]);

    }

    public function update(Request $request, Response $response, $args) {

        if(!self::$model->get($args['id'])) {
            throw new DefaultException("A chave informada não corresponde à nenhum registro!", 400);
        }

        self::$model->update($args['id'], $request->getParsedBody());

        return $this->makeResponse($response, [
            'message' => 'Dados atualizados com sucesso'
        ]);

    }

    protected function makeResponse(Response $response, array $array) {
        $response->getBody()->write(json_encode($array));
        return $response;
    }

}