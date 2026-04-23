<?php
require_once APP_PATH . '/models/Model.php';

class UserModel extends Model {

    public function findByEmail($email) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function findById($id) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create($name, $email, $password) {
        $stmt = $this->db->prepare(
            'INSERT INTO users (full_name, email, password, role, allergies, plan)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $name,
            $email,
            $password,
            'patient',
            'None',
            'Basic Member',
        ]);
        return (int) $this->db->lastInsertId();
    }
}