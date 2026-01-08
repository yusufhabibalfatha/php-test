<?php

header('Content-Type: application/json');

$host = 'localhost';
$db   = 'belajar_api';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/users' && $method === 'GET') {

    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($users);
    exit;
}

if ($uri === '/users' && $method === 'POST') {

    $body = json_decode(file_get_contents('php://input'), true);

    if (!isset($body['name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Name is required']);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO users (name) VALUES (:name)");
    $stmt->execute([
        'name' => $body['name']
    ]);

    echo json_encode([
        'message' => 'User created'
    ]);
    exit;
}

