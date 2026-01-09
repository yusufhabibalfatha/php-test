<?php
require_once __DIR__ . '/db.php';

$method = $_SERVER['REQUEST_METHOD'];
$id = $segments[1] ?? null;

// =======================
// GET
// =======================
if ($method === 'GET') {

    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();

        if (!$user) {
            http_response_code(404);
            echo json_encode([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ]);
            exit;
        }

        echo json_encode([
            'status' => true,
            'data' => $user
        ]);
        exit;
    }

    $stmt = $pdo->query("SELECT * FROM users ORDER BY id ASC");
    echo json_encode([
        'status' => true,
        'data' => $stmt->fetchAll()
    ]);
    exit;
}

// =======================
// POST
// =======================
if ($method === 'POST') {

    $input = json_decode(file_get_contents("php://input"), true);

    if (!$input || empty($input['name'])) {
        http_response_code(422);
        echo json_encode([
            'status' => false,
            'message' => 'Field name wajib diisi'
        ]);
        exit;
    }

    $stmt = $pdo->prepare(
        "INSERT INTO users (name) VALUES (:name)"
    );
    $stmt->execute([':name' => $input['name']]);

    echo json_encode([
        'status' => true,
        'id' => $pdo->lastInsertId()
    ]);
    exit;
}

// =======================
// PUT
// =======================
if ($method === 'PUT') {

    if (!$id) {
        http_response_code(422);
        echo json_encode([
            'status' => false,
            'message' => 'ID wajib'
        ]);
        exit;
    }

    $input = json_decode(file_get_contents("php://input"), true);

    if (!$input || empty($input['name'])) {
        http_response_code(422);
        echo json_encode([
            'status' => false,
            'message' => 'Field name wajib'
        ]);
        exit;
    }

    $stmt = $pdo->prepare(
        "UPDATE users SET name = :name WHERE id = :id"
    );
    $stmt->execute([
        ':id' => $id,
        ':name' => $input['name']
    ]);

    echo json_encode([
        'status' => true,
        'message' => 'User diupdate'
    ]);
    exit;
}

// =======================
// DELETE
// =======================
if ($method === 'DELETE') {

    if (!$id) {
        http_response_code(422);
        echo json_encode([
            'status' => false,
            'message' => 'ID wajib'
        ]);
        exit;
    }

    $stmt = $pdo->prepare(
        "DELETE FROM users WHERE id = :id"
    );
    $stmt->execute([':id' => $id]);

    echo json_encode([
        'status' => true,
        'message' => 'User dihapus'
    ]);
    exit;
}

// =======================
http_response_code(405);
echo json_encode([
    'status' => false,
    'message' => 'Method tidak diizinkan'
]);
