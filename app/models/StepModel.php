<?php

class StepModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Ambil semua langkah berdasarkan ID Roadmap
    public function getStepsByRoadmap($roadmap_id) {
        $stmt = $this->db->prepare("SELECT * FROM steps WHERE roadmap_id = :id ORDER BY order_no ASC");
        $stmt->execute(['id' => $roadmap_id]);
        return $stmt->fetchAll();
    }

    // Tambah langkah baru & otomatis atur order_no
    public function createStep($data) {
    $stmt = $this->db->prepare("SELECT MAX(order_no) as max_order FROM steps WHERE roadmap_id = :id");
    $stmt->execute(['id' => $data['roadmap_id']]);
    $res = $stmt->fetch();
    $next_order = ($res['max_order'] ?? 0) + 1;

    // Tambahkan video_url dan attachment di query
    $query = "INSERT INTO steps (roadmap_id, title, content, video_url, attachment, order_no) 
              VALUES (:roadmap_id, :title, :content, :video_url, :attachment, :order_no)";
    $stmt = $this->db->prepare($query);
    
    $data['order_no'] = $next_order;
    return $stmt->execute($data);
}
    // Tambahkan di dalam class StepModel

public function getStepById($id) {
    $stmt = $this->db->prepare("SELECT * FROM steps WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

public function updateStep($data) {
    // Tambahkan update untuk video_url dan attachment
    $query = "UPDATE steps SET title = :title, content = :content, 
              video_url = :video_url, attachment = :attachment 
              WHERE id = :id";
    $stmt = $this->db->prepare($query);
    return $stmt->execute($data);
}

public function deleteStep($id) {
    $step = $this->getStepById($id);
    
    // Hapus file lampiran jika ada
    if (!empty($step['attachment'])) {
        $path = ATTACHMENT_UPLOAD_PATH . '/' . $step['attachment'];
        if (file_exists($path)) {
            unlink($path);
        }
    }

    $stmt = $this->db->prepare("DELETE FROM steps WHERE id = ?");
    return $stmt->execute([$id]);
}

// Tambahkan di dalam class StepModel
public function getCommentsByStep($step_id) {
    $query = "SELECT c.*, u.username, u.role 
              FROM comments c 
              JOIN users u ON c.user_id = u.id 
              WHERE c.step_id = :step_id 
              ORDER BY c.created_at ASC";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['step_id' => $step_id]);
    return $stmt->fetchAll();
}

public function addComment($data) {
    $query = "INSERT INTO comments (step_id, user_id, message) VALUES (:step_id, :user_id, :message)";
    $stmt = $this->db->prepare($query);
    return $stmt->execute($data);
}

}