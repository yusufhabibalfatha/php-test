<?php

class UserController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($data)
    {
        if (!isset($data['name']) || empty($data['name'])) {
            http_response_code(400);
            return ['error' => 'Name is required'];
        }

        $stmt = $this->db->prepare("INSERT INTO users (name) VALUES (:name)");
        $stmt->execute([
            'name' => $data['name']
        ]);

        return ['message' => 'User created'];
    }
}
