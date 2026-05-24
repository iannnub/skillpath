<?php

class EnrollmentModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Cek apakah student sudah terdaftar di roadmap ini
    public function isEnrolled($student_id, $roadmap_id) {
        $stmt = $this->db->prepare("SELECT * FROM enrollments WHERE student_id = :sid AND roadmap_id = :rid");
        $stmt->execute(['sid' => $student_id, 'rid' => $roadmap_id]);
        return $stmt->fetch();
    }

    // Proses pendaftaran (Enroll)
    public function enroll($student_id, $roadmap_id) {
        $query = "INSERT INTO enrollments (student_id, roadmap_id) VALUES (:sid, :rid)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['sid' => $student_id, 'rid' => $roadmap_id]);
    }
    // Tambahkan di dalam class EnrollmentModel

public function getStudentEnrolledRoadmaps($student_id) {
    $query = "SELECT r.*, c.name as category_name, 
              (SELECT COUNT(*) FROM steps WHERE roadmap_id = r.id) as total_steps 
              FROM enrollments e
              JOIN roadmaps r ON e.roadmap_id = r.id
              JOIN categories c ON r.category_id = c.id
              WHERE e.student_id = :sid";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['sid' => $student_id]);
    return $stmt->fetchAll();
}
}