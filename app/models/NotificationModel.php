<?php

class NotificationModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function add($user_id, $title, $message) {
        $query = "INSERT INTO notifications (user_id, title, message) VALUES (:user_id, :title, :message)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'user_id' => $user_id,
            'title' => $title,
            'message' => $message
        ]);
    }

    public function getUnreadByUser($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM notifications WHERE user_id = :user_id AND is_read = 0 ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public function markAsRead($id) {
        $stmt = $this->db->prepare("UPDATE notifications SET is_read = 1 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}