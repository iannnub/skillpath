<?php

class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function usernameExists($username) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return (bool) $stmt->fetchColumn();
    }

    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return (bool) $stmt->fetchColumn();
    }

    public function register($data) {
        $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $this->db->prepare($query);
        
        $password_hashed = password_hash($data['password'], PASSWORD_DEFAULT);
        
        return $stmt->execute([
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => $password_hashed,
            'role'     => $data['role']
        ]);
    }

    // --- FUNGSI BARU (SUDAH DI DALAM CLASS & PAKAI PDO MURNI) ---

    public function getAllUsers() {
        $stmt = $this->db->prepare("SELECT * FROM users ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(); // Pakai fetchAll() untuk ambil banyak data
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function updateRole($id, $role) {
        $stmt = $this->db->prepare("UPDATE users SET role = :role WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'role' => $role
        ]);
    }
    // Tambahkan di dalam class UserModel

public function getUserById($id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

public function updateProfile($id, $username, $email) {
    $stmt = $this->db->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
    return $stmt->execute([
        'id' => $id,
        'username' => $username,
        'email' => $email
    ]);
}

public function updatePassword($id, $new_password) {
    $password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE id = :id");
    return $stmt->execute([
        'id' => $id,
        'password' => $password_hashed
    ]);
}

} // <--- KURUNG KURAWAL PENUTUP CLASS HARUS DI PALING BAWAH