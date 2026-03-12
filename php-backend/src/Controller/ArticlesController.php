<?php

namespace Src\Controller;

use Src\TableGateways\ArticlesGateway;

class ArticlesController
{
    private $db;
    private $requestMethod;
    private $id;
    private $articlesGateway;

    public function __construct($db, $requestMethod, $id)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->id = $id;
        $this->articlesGateway = new ArticlesGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->id
                    ? $this->getById($this->id)
                    : $this->getAll();
                break;
            case 'POST':
                $response = $this->create();
                break;
            case 'PUT':
                $response = $this->update($this->id);
                break;
            case 'DELETE':
                $response = $this->delete($this->id);
                break;
            default:
                $response = $this->methodNotAllowedResponse();
                break;
        }

        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAll()
    {
        $result = $this->articlesGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getById($id)
    {
        $result = $this->articlesGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function create()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['title'])) {
            return $this->unprocessableEntityResponse('Title is required');
        }

        $this->articlesGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(['message' => 'Article created']);
        return $response;
    }

    private function update($id)
    {
        $result = $this->articlesGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['title'])) {
            return $this->unprocessableEntityResponse('Title is required');
        }

        $this->articlesGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['message' => 'Article updated']);
        return $response;
    }

    private function delete($id)
    {
        $result = $this->articlesGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }

        $this->articlesGateway->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['message' => 'Article deleted']);
        return $response;
    }

    private function methodNotAllowedResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 405 Method Not Allowed';
        $response['body'] = json_encode(['error' => 'Method not allowed']);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode(['error' => 'Not found']);
        return $response;
    }

    private function unprocessableEntityResponse($message)
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode(['error' => $message]);
        return $response;
    }
}