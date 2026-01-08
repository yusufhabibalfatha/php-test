<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

$db = require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../router/web.php';

// 404 fallback
http_response_code(404);
echo json_encode(['error' => 'Route not found']);
