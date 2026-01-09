<?php
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$uri = trim($_SERVER['REQUEST_URI'], '/');

// hapus query string (?a=b)
$uri = explode('?', $uri)[0];

// contoh: users/1 → [users, 1]
$segments = explode('/', $uri);

// =======================
// ROUTING
// =======================
if ($segments[0] === 'users') {
    require __DIR__ . '/users.php';
    exit;
}

// =======================
http_response_code(404);
echo json_encode([
    'status' => false,
    'message' => 'Endpoint tidak ditemukan'
]);
