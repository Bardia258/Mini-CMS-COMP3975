<?php

require_once __DIR__ . '/src/System/DatabaseConnector.php';
require_once __DIR__ . '/src/TableGateways/ArticlesGateway.php';
require_once __DIR__ . '/src/Controller/ArticlesController.php';
use Src\Controller\ArticlesController;
use Src\System\DatabaseConnector;

$dbConnection = (new DatabaseConnector())->getConnection();



header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$uri = array_values(array_filter($uri));

// All of our endpoints are /articles or /articles/{id}
$id = null;
$resource = $uri[count($uri) - 1] ?? '';
if (count($uri) > 1 && ctype_digit($uri[count($uri) - 1])) {
    $id = (int) $uri[count($uri) - 1];
    $resource = $uri[count($uri) - 2];
}
if ($resource !== 'articles') {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error' => 'Not found']);
    exit;
}

$requestMethod = $_SERVER['REQUEST_METHOD'];
$controller = new ArticlesController($dbConnection, $requestMethod, $id);
$controller->processRequest();
