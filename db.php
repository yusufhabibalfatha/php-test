<?php
// db.php

$host = "localhost";
$dbname = "u943973772_phptest";
$user = "u943973772_phptest";
$pass = "phptes.T6";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => false,
        'message' => 'Koneksi database gagal',
        'error' => $e->getMessage()
    ]);
    exit;
}
