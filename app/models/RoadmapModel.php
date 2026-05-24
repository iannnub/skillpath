<?php

class RoadmapModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Helper untuk membuat slug agar konsisten di create maupun update
    private function createSlug($title) {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
    }

    public function getRoadmapsByMentor($mentor_id) {
        $stmt = $this->db->prepare("SELECT * FROM roadmaps WHERE mentor_id = :id ORDER BY created_at DESC");
        $stmt->execute(['id' => $mentor_id]);
        return $stmt->fetchAll();
    }

    public function getAllCategories() {
        $stmt = $this->db->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function createRoadmap($data) {
        $query = "INSERT INTO roadmaps (category_id, mentor_id, title, slug, description, thumbnail) 
                  VALUES (:category_id, :mentor_id, :title, :slug, :description, :thumbnail)";
        
        // Gunakan helper slug
        $data['slug'] = $this->createSlug($data['title']);
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    public function getAllRoadmaps() {
        $query = "SELECT roadmaps.*, users.username as mentor_name, categories.name as category_name 
                  FROM roadmaps 
                  JOIN users ON roadmaps.mentor_id = users.id 
                  JOIN categories ON roadmaps.category_id = categories.id 
                  ORDER BY roadmaps.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getRoadmapById($id) {
        $query = "SELECT r.*, u.username as mentor_name, c.name as category_name 
                  FROM roadmaps r
                  JOIN users u ON r.mentor_id = u.id 
                  LEFT JOIN categories c ON r.category_id = c.id 
                  WHERE r.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getRoadmapBySlug($slug) {
        $query = "SELECT r.*, u.username as mentor_name, c.name as category_name 
                  FROM roadmaps r
                  JOIN users u ON r.mentor_id = u.id 
                  LEFT JOIN categories c ON r.category_id = c.id 
                  WHERE r.slug = :slug";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    public function updateRoadmap($data) {
        // UPDATE: Kita tambahkan slug di sini supaya URL ikut berubah kalau judul berubah
        $query = "UPDATE roadmaps SET category_id = :category_id, title = :title, slug = :slug,
                  description = :description, thumbnail = :thumbnail 
                  WHERE id = :id";
        
        $data['slug'] = $this->createSlug($data['title']);
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

   public function deleteRoadmap($id) {
    $roadmap = $this->getRoadmapById($id);
    
    // Hapus thumbnail jika bukan default
    if ($roadmap['thumbnail'] != 'default.jpg' && !empty($roadmap['thumbnail'])) {
        $path = ROADMAP_UPLOAD_PATH . '/' . $roadmap['thumbnail'];
        if (file_exists($path)) {
            unlink($path);
        }
    }

    $stmt = $this->db->prepare("DELETE FROM roadmaps WHERE id = :id");
    return $stmt->execute(['id' => $id]);
}

    public function getLatestRoadmaps($limit = 3) {
        $query = "SELECT r.*, u.username as mentor_name, c.name as category_name 
                  FROM roadmaps r
                  JOIN users u ON r.mentor_id = u.id 
                  JOIN categories c ON r.category_id = c.id 
                  ORDER BY r.created_at DESC LIMIT :limit";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function searchRoadmaps($keyword = '', $category_id = '') {
        $query = "SELECT r.*, c.name as category_name, u.username as mentor_name 
                  FROM roadmaps r
                  JOIN categories c ON r.category_id = c.id
                  JOIN users u ON r.mentor_id = u.id
                  WHERE r.status = 'published'";

        $params = [];
        if (!empty($keyword)) {
            $query .= " AND (r.title LIKE :keyword OR r.description LIKE :keyword OR u.username LIKE :keyword)";
            $params['keyword'] = "%$keyword%";
        }

        if (!empty($category_id)) {
            $query .= " AND r.category_id = :cat_id";
            $params['cat_id'] = $category_id;
        }

        $query .= " ORDER BY r.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Update fungsi getAllRoadmaps untuk Student (hanya yang published)
public function getAllPublishedRoadmaps() {
    $query = "SELECT r.*, u.username as mentor_name, c.name as category_name 
              FROM roadmaps r
              JOIN users u ON r.mentor_id = u.id 
              JOIN categories c ON r.category_id = c.id 
              WHERE r.status = 'published'
              ORDER BY r.created_at DESC";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Fungsi khusus Admin untuk moderasi
public function getPendingRoadmaps() {
    $query = "SELECT roadmaps.*, users.username as mentor_name 
              FROM roadmaps 
              JOIN users ON roadmaps.mentor_id = users.id 
              WHERE roadmaps.status = 'pending'
              ORDER BY roadmaps.created_at ASC";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Fungsi untuk merubah status (Approve/Reject)
public function updateStatus($id, $status) {
    $stmt = $this->db->prepare("UPDATE roadmaps SET status = :status WHERE id = :id");
    return $stmt->execute(['id' => $id, 'status' => $status]);
}

// Ambil rata-rata rating dari tabel reviews
public function getAverageRating($id) {
    $query = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews 
              FROM reviews WHERE roadmap_id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetch();
    return [
        'avg_rating' => $result['avg_rating'] ?? 0,
        'total_reviews' => $result['total_reviews'] ?? 0
    ];
}

// Ambil semua review beserta username untuk ditampilkan di detail.php
public function getReviewsByRoadmap($id) {
    $query = "SELECT rv.*, u.username 
              FROM reviews rv 
              JOIN users u ON rv.student_id = u.id 
              WHERE rv.roadmap_id = :id 
              ORDER BY rv.created_at DESC";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll();
}
}