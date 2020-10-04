<?php
namespace Core;

use Errors\DefaultException;
use Errors\ValidationException as ValidationException;
use Errors\InvalidPropertyException as InvalidPropertyException;
use Model\Medico as Medico;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

abstract class Controller {

    protected static $model;

    public function get(Request $request, Response $response, $args) {
        $result = self::$model->get($args['id'])[0];
        if(!$result) {
            throw new DefaultException("A chave informada não corresponde à nenhum registro!", 400);
        }
        $json = json_encode([
            'message' => 'Registro recuperado com sucesso!',
            'body' => $result
        ]);
        $response->getBody()->write($json);
        return $response;
    }

    public function getAll(Request $request, Response $response, $args) {
        $result  = self::$model->getAll();
        $json = json_encode([
            'message' => 'Dados recuperados com sucesso',
            'body' => $result ?? []
        ]);
        $response->getBody()->write($json);
        return $response;
    }

    public function insert(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $id = self::$model->save($data);
        $json = json_encode([
            'message' => 'Dados salvos com sucesso',
            'body' => [ 'id' => $id ]
        ]);
        $response->getBody()->write($json);
        return $response;
    }

    public function delete(Request $request, Response $response, $args) {
        if(!self::$model->get($args['id'])[0]) {
            throw new DefaultException("A chave informada não corresponde à nenhum registro!", 400);
        }
        self::$model->delete($args['id']);
        $json = json_encode([
            'message' => 'Registro deletado com sucesso'
        ]);
        $response->getBody()->write($json);
        return $response;
    }

    public function update(Request $request, Response $response, $args) {
        if(!self::$model->get($args['id'])[0]) {
            throw new DefaultException("A chave informada não corresponde à nenhum registro!", 400);
        }
        $data = $request->getParsedBody();
        self::$model->update($args['id'], $data);
        $json = json_encode([
            'message' => 'Dados atualizados com sucesso'
        ]);
        $response->getBody()->write($json);
        return $response;
    }

}