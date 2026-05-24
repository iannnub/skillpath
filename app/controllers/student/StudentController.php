<?php // <--- Pastikan ada tag pembuka ini!

class StudentController extends Controller
{

    public function __construct()
    {
        $this->middleware('student');
    }

    public function dashboard()
    {
        $enrollModel = $this->model('EnrollmentModel');
        $progressModel = $this->model('ProgressModel');

        $data['title'] = 'My Learning Dashboard';

        // 1. Ambil semua roadmap yang di-enroll
        $enrolled = $enrollModel->getStudentEnrolledRoadmaps($_SESSION['user_id']);

        // 2. Tambahkan info progress ke tiap roadmap
        foreach ($enrolled as &$rm) {
            $rm['user_progress'] = $progressModel->getProgress($_SESSION['user_id'], $rm['id']);
        }

        $data['enrolled_roadmaps'] = $enrolled;

        $this->view('templates/header', $data);
        $this->view('student/dashboard', $data);
        $this->view('templates/footer');
    }
    // Tambahkan di dalam class StudentController

    public function catalog()
    {
        $keyword = htmlspecialchars($_GET['keyword'] ?? '', ENT_QUOTES, 'UTF-8');
        $category_id = htmlspecialchars($_GET['category'] ?? '', ENT_QUOTES, 'UTF-8');

        $roadmapModel = $this->model('RoadmapModel');
        $categoryModel = $this->model('CategoryModel');

        $data['title'] = 'Katalog Roadmap';
        $data['roadmaps'] = $roadmapModel->searchRoadmaps($keyword, $category_id);
        $data['categories'] = $categoryModel->getAll();

        // Simpan input user biar gak ilang pas halaman refresh
        $data['keyword'] = $keyword;
        $data['current_category'] = $category_id;

        $this->view('templates/header', $data);
        $this->view('student/catalog', $data);
        $this->view('templates/footer');
    }

    public function detail($id)
    {
        $roadmapModel = $this->model('RoadmapModel');
        $stepModel = $this->model('StepModel');
        $enrollModel = $this->model('EnrollmentModel');

        $data['roadmap'] = $roadmapModel->getRoadmapById($id);

        // Jika roadmap tidak ada, tampilkan 404 kustom
        if (!$data['roadmap']) {
            $this->view('templates/header', ['title' => '404 Not Found']);
            $this->view('errors/404');
            $this->view('templates/footer');
            exit;
        }

        $data['steps'] = $stepModel->getStepsByRoadmap($id);
        $data['isEnrolled'] = $enrollModel->isEnrolled($_SESSION['user_id'], $id);
        $data['title'] = 'Detail Roadmap';

        $this->view('templates/header', $data);
        $this->view('student/detail', $data);
        $this->view('templates/footer');
    }

    public function enroll($id) {
    $enrollModel = $this->model('EnrollmentModel');
    $roadmapModel = $this->model('RoadmapModel');
    $notifModel = $this->model('NotificationModel');

    if ($enrollModel->enroll($_SESSION['user_id'], $id)) {
        $roadmap = $roadmapModel->getRoadmapById($id);
        
        // Notif untuk Student
        $notifModel->add($_SESSION['user_id'], 'Enroll Berhasil', 'Selamat! Kamu telah terdaftar di roadmap: ' . $roadmap['title']);
        
        // Notif untuk Mentor
        $notifModel->add($roadmap['mentor_id'], 'Student Baru', 'Seseorang baru saja mendaftar di roadmap ' . $roadmap['title']);

        header('Location: ' . BASEURL . '/student/learn/' . $id);
        exit;
    } else {
        Flasher::setFlash('Gagal', 'Terjadi kesalahan saat pendaftaran.', 'danger');
        header('Location: ' . BASEURL . '/student/detail/' . $id);
        exit;
    }
}
    // Tambahkan method ini di StudentController

    public function learn($roadmap_id_or_slug, $step_id = null)
{
    $roadmapModel = $this->model('RoadmapModel');
    $stepModel = $this->model('StepModel');
    $progressModel = $this->model('ProgressModel');
    $enrollModel = $this->model('EnrollmentModel');

    // FIX: Pencarian fleksibel — coba ID dulu, lalu slug sebagai fallback
    if (is_numeric($roadmap_id_or_slug)) {
        $data['roadmap'] = $roadmapModel->getRoadmapById($roadmap_id_or_slug);
    } else {
        $data['roadmap'] = $roadmapModel->getRoadmapBySlug($roadmap_id_or_slug);
    }

    // Fallback: jika slug tidak ditemukan, coba cari sebagai ID
    if (!$data['roadmap'] && !is_numeric($roadmap_id_or_slug)) {
        $data['roadmap'] = $roadmapModel->getRoadmapById($roadmap_id_or_slug);
    }

    // Jika roadmap tidak ada, tampilkan 404
    if (!$data['roadmap']) {
        $this->view('templates/header', ['title' => '404 Not Found']);
        $this->view('errors/404');
        $this->view('templates/footer');
        exit;
    }

    $roadmap_id = $data['roadmap']['id'];

    // Security: Pastikan student sudah enroll roadmap ini
    if (!$enrollModel->isEnrolled($_SESSION['user_id'], $roadmap_id)) {
        Flasher::setFlash('Akses Ditolak', 'Silakan daftar roadmap terlebih dahulu!', 'warning');
        header('Location: ' . BASEURL . '/student/detail/' . $roadmap_id);
        exit;
    }

    $data['steps'] = $stepModel->getStepsByRoadmap($roadmap_id);
    $data['progress'] = $progressModel->getProgress($_SESSION['user_id'], $roadmap_id);

    // FIX: Pencarian step berdasarkan ID (karena slug di steps hampir selalu NULL)
    if ($step_id == null && !empty($data['steps'])) {
        // Jika tidak ada step_id di URL, arahkan ke step pertama
        $data['current_step'] = $data['steps'][0];
    } else {
        // Cari step yang spesifik berdasarkan ID
        $data['current_step'] = null;
        foreach ($data['steps'] as $s) {
            if ($s['id'] == $step_id) {
                $data['current_step'] = $s;
                break;
            }
        }
    }

    if (!$data['current_step']) {
        $this->view('templates/header', ['title' => '404 Not Found']);
        $this->view('errors/404', ['message' => 'Langkah belajar tidak ditemukan.']);
        $this->view('templates/footer');
        exit;
    }

    $data['is_completed'] = $progressModel->isCompleted($_SESSION['user_id'], $data['current_step']['id']);
    $data['title'] = 'Belajar: ' . $data['roadmap']['title'];

    $this->view('templates/header', $data);
    $this->view('student/learn', $data);
    $this->view('templates/footer');
}

    public function complete($roadmap_id, $step_id)
    {
        // FIX: Pass 3 argumen ke completeStep (student_id, roadmap_id, step_id)
        $this->model('ProgressModel')->completeStep($_SESSION['user_id'], $roadmap_id, $step_id);
        
        // Cari step selanjutnya
        $steps = $this->model('StepModel')->getStepsByRoadmap($roadmap_id);
        $next_step_id = $step_id; // Default ke step saat ini jika tidak ada next
        $found = false;
        
        foreach ($steps as $step) {
            if ($found) {
                $next_step_id = $step['id'];
                break;
            }
            if ($step['id'] == $step_id) {
                $found = true;
            }
        }
        
        header('Location: ' . BASEURL . '/student/learn/' . $roadmap_id . '/' . $next_step_id);
        exit;
    }

    public function quiz($step_id) {
    $quizModel = $this->model('QuizModel');
    $stepModel = $this->model('StepModel');
    $enrollModel = $this->model('EnrollmentModel');

    $step = $stepModel->getStepById($step_id);
    if (!$step) {
        $this->view('templates/header', ['title' => '404 Not Found']);
        $this->view('errors/404', ['message' => 'Langkah kuis tidak ditemukan.']);
        $this->view('templates/footer');
        exit;
    }

    if (!$enrollModel->isEnrolled($_SESSION['user_id'], $step['roadmap_id'])) {
        Flasher::setFlash('Akses Ditolak', 'Silakan daftar roadmap terlebih dahulu!', 'warning');
        header('Location: ' . BASEURL . '/student/detail/' . $step['roadmap_id']);
        exit;
    }

    $data['quiz'] = $quizModel->getQuizByStep($step_id);
    if (!$data['quiz']) {
        Flasher::setFlash('Kuis Belum Tersedia', 'Mentor belum menambahkan kuis untuk materi ini.', 'warning');
        header('Location: ' . BASEURL . '/student/learn/' . $step['roadmap_id'] . '/' . $step_id);
        exit;
    }

    $data['questions'] = $quizModel->getQuestionsByQuiz($data['quiz']['id']);
    if (empty($data['questions'])) {
        Flasher::setFlash('Kuis Belum Tersedia', 'Tambahkan pertanyaan terlebih dahulu sebelum siswa dapat mengerjakan kuis.', 'warning');
        header('Location: ' . BASEURL . '/student/learn/' . $step['roadmap_id'] . '/' . $step_id);
        exit;
    }

    $data['step'] = $step;
    $data['title'] = 'Ujian Kuis: ' . $data['step']['title'];

    $this->view('templates/header', $data);
    $this->view('student/quiz', $data);
    $this->view('templates/footer');
}

public function submit_quiz() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $quizModel = $this->model('QuizModel');
        $progressModel = $this->model('ProgressModel');
        
        $quiz_id = $_POST['quiz_id'] ?? null;
        $step_id = $_POST['step_id'] ?? null;
        $roadmap_id = $_POST['roadmap_id'] ?? null;

        $quiz = $quizModel->getQuizByStep($step_id);
        if (!$quiz || $quiz['id'] != $quiz_id) {
            Flasher::setFlash('Gagal', 'Kuis tidak valid atau sudah dihapus.', 'danger');
            header('Location: ' . BASEURL . '/student/dashboard');
            exit;
        }

        $questions = $quizModel->getQuestionsByQuiz($quiz_id);
        $total_questions = count($questions);

        if ($total_questions === 0) {
            Flasher::setFlash('Gagal', 'Kuis belum memiliki pertanyaan.', 'danger');
            header('Location: ' . BASEURL . '/student/learn/' . $roadmap_id . '/' . $step_id);
            exit;
        }

        $correct_answers = 0;

        // Hitung jawaban benar
        foreach ($questions as $q) {
            $user_answer = $_POST['question_' . $q['id']] ?? '';
            if ($user_answer == $q['correct_answer']) {
                $correct_answers++;
            }
        }

        // Hitung skor
        $score = ($correct_answers / $total_questions) * 100;

        if ($score >= $quiz['min_score']) {
            // Lulus: Tandai progress selesai
            $progressModel->completeStep($_SESSION['user_id'], $roadmap_id, $step_id);
            Flasher::setFlash('Selamat!', "Anda lulus dengan skor $score. Materi selesai!", 'success');
            header('Location: ' . BASEURL . '/student/learn/' . $roadmap_id . '/' . $step_id);
        } else {
            // Gagal
            Flasher::setFlash('Gagal', "Skor Anda $score. Minimal kelulusan adalah {$quiz['min_score']}. Silakan coba lagi.", 'danger');
            header('Location: ' . BASEURL . '/student/quiz/' . $step_id);
        }
        exit;
    }
}

public function certificate($roadmap_id) {
    $progressModel = $this->model('ProgressModel');
    $roadmapModel = $this->model('RoadmapModel');
    
    // Pastikan progres 100%
    $progress = $progressModel->getProgress($_SESSION['user_id'], $roadmap_id);
    if($progress < 100) {
        Flasher::setFlash('Gagal', 'Selesaikan semua materi untuk klaim sertifikat!', 'warning');
        header('Location: ' . BASEURL . '/student/learn/' . $roadmap_id);
        exit;
    }

    $data['title'] = 'Sertifikat Kelulusan';
    $data['roadmap'] = $roadmapModel->getRoadmapById($roadmap_id);
    $data['user'] = $this->model('UserModel')->getUserById($_SESSION['user_id']);
    
    // Generate kode sertifikat sederhana jika belum ada
    $data['cert_code'] = "SKP-" . strtoupper(substr(md5($_SESSION['user_id'] . $roadmap_id), 0, 8));

    $this->view('student/certificate', $data); // View tanpa template header/footer standar
}

public function submit_review() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $roadmap_id = $_POST['roadmap_id'];
        $student_id = $_SESSION['user_id'];
        $rating = $_POST['rating'];
        $comment = htmlspecialchars(trim($_POST['comment']), ENT_QUOTES, 'UTF-8');

        $db = Database::getInstance()->getConnection();
        
        // Cek apakah user sudah pernah memberi ulasan untuk roadmap ini
        $stmtCheck = $db->prepare("SELECT id FROM reviews WHERE student_id = ? AND roadmap_id = ?");
        $stmtCheck->execute([$student_id, $roadmap_id]);
        
        if ($stmtCheck->fetch()) {
            // Update ulasan jika sudah ada
            $query = "UPDATE reviews SET rating = :rating, comment = :comment WHERE student_id = :sid AND roadmap_id = :rid";
        } else {
            // Input ulasan baru
            $query = "INSERT INTO reviews (student_id, roadmap_id, rating, comment) VALUES (:sid, :rid, :rating, :comment)";
        }

        $stmt = $db->prepare($query);
        $result = $stmt->execute([
            'sid' => $student_id,
            'rid' => $roadmap_id,
            'rating' => $rating,
            'comment' => $comment
        ]);

        if ($result) {
            Flasher::setFlash('Terima Kasih!', 'Ulasan Anda sangat berarti bagi kami.', 'success');
        } else {
            Flasher::setFlash('Gagal', 'Terjadi kesalahan saat mengirim ulasan.', 'danger');
        }
        
        header('Location: ' . BASEURL . '/student/dashboard');
        exit;
    }
}

public function add_comment() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $step_id = $_POST['step_id'];
        $roadmap_id = $_POST['roadmap_id'];
        
        $data = [
            'step_id' => $step_id,
            'user_id' => $_SESSION['user_id'],
            'message' => htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8')
        ];

        if ($this->model('StepModel')->addComment($data)) {
            // Trigger Notifikasi ke Mentor (Opsional/Step 4.1 Integration)
            $step = $this->model('StepModel')->getStepById($step_id);
            $roadmap = $this->model('RoadmapModel')->getRoadmapById($roadmap_id);
            $this->model('NotificationModel')->add(
                $roadmap['mentor_id'], 
                'Diskusi Baru', 
                $_SESSION['username'] . ' mengirim pertanyaan di materi: ' . $step['title']
            );

            Flasher::setFlash('Berhasil', 'Komentar terkirim.', 'success');
        }
        header('Location: ' . BASEURL . '/student/learn/' . $roadmap_id . '/' . $step_id);
        exit;
    }
}

}
