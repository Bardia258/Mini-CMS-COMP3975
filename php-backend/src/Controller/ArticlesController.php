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
        if ($this->requestMethod !== 'GET') {
            $response = $this->methodNotAllowedResponse();
            header($response['status_code_header']);
            if ($response['body']) {
                echo $response['body'];
            }
            return;
        }

        if ($this->id) {
            $response = $this->getById($this->id);
        } else {
            $response = $this->getAll();
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

    private function methodNotAllowedResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 405 Method Not Allowed';
        $response['body'] = json_encode(['error' => 'Method not allowed']);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
