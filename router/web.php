<?php

require_once __DIR__ . '/../controllers/UserController.php';

$userController = new UserController($db);

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/users' && $method === 'GET') {
    echo json_encode($userController->index());
    exit;
}

if ($uri === '/users' && $method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);
    echo json_encode($userController->store($body));
    exit;
}
