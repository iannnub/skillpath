<?php

class QuizModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Ambil kuis berdasarkan ID Step
    public function getQuizByStep($step_id) {
        $stmt = $this->db->prepare("SELECT * FROM quizzes WHERE step_id = :step_id");
        $stmt->execute(['step_id' => $step_id]);
        return $stmt->fetch();
    }

    // Ambil semua soal berdasarkan ID Quiz
    public function getQuestionsByQuiz($quiz_id) {
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE quiz_id = :quiz_id");
        $stmt->execute(['quiz_id' => $quiz_id]);
        return $stmt->fetchAll();
    }

    // Simpan Kuis Baru
    public function addQuiz($data) {
        $query = "INSERT INTO quizzes (step_id, title, description, min_score) 
                  VALUES (:step_id, :title, :description, :min_score)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    // Simpan Soal Baru
    public function addQuestion($data) {
        $query = "INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_answer) 
                  VALUES (:quiz_id, :question_text, :option_a, :option_b, :option_c, :option_d, :correct_answer)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }
}