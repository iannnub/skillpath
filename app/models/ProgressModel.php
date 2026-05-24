<?php

class ProgressModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Cek apakah satu step tertentu sudah selesai oleh student
    // FIX: Kolom is_completed TIDAK ADA di tabel user_progress.
    // Keberadaan record = sudah selesai.
    public function isCompleted($student_id, $step_id) {
        $stmt = $this->db->prepare("SELECT * FROM user_progress WHERE student_id = ? AND step_id = ?");
        $stmt->execute([$student_id, $step_id]);
        return $stmt->fetch();
    }

    // Tandai step sebagai selesai
    // FIX: Tambahkan ON DUPLICATE KEY UPDATE agar tidak error jika diklik 2x
    public function completeStep($student_id, $roadmap_id, $step_id) {
        $query = "INSERT INTO user_progress (student_id, roadmap_id, step_id) 
                  VALUES (:sid, :rid, :stepid)
                  ON DUPLICATE KEY UPDATE completed_at = CURRENT_TIMESTAMP";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'sid' => $student_id,
            'rid' => $roadmap_id,
            'stepid' => $step_id
        ]);
    }

    // HITUNG PROGRESS (%)
    // FIX: Hapus referensi is_completed yang tidak ada di tabel
    public function getProgress($student_id, $roadmap_id) {
        // 1. Hitung total steps di roadmap ini
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM steps WHERE roadmap_id = ?");
        $stmt->execute([$roadmap_id]);
        $totalSteps = $stmt->fetch()['total'];

        if ($totalSteps == 0) return 0;

        // 2. Hitung berapa yang sudah diselesaikan student di roadmap ini
        // Keberadaan record di user_progress = step sudah selesai
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as completed 
            FROM user_progress up
            JOIN steps s ON up.step_id = s.id
            WHERE up.student_id = ? AND s.roadmap_id = ?
        ");
        $stmt->execute([$student_id, $roadmap_id]);
        $completedSteps = $stmt->fetch()['completed'];

        // Rumus: (selesai / total) * 100
        return round(($completedSteps / $totalSteps) * 100);
    }
}