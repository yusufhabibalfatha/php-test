<?php

header('Content-Type: application/json');

// CORS (sesuaikan domain kalau mau lebih aman)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

// path menyesuaikan hosting
$db = require_once __DIR__ . '/../api/config/database.php';

require_once __DIR__ . '/../api/router/web.php';

http_response_code(404);
echo json_encode(['error' => 'Route not found']);
