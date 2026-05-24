<?php

class MentorController extends Controller {

    public function __construct() {
        $this->middleware('mentor');
    }

    public function dashboard() {
        $roadmapModel = $this->model('RoadmapModel');
        $data['title'] = 'Mentor Dashboard';
        $data['roadmaps'] = $roadmapModel->getRoadmapsByMentor($_SESSION['user_id']);
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT COUNT(DISTINCT student_id) as total FROM enrollments e JOIN roadmaps r ON e.roadmap_id = r.id WHERE r.mentor_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $data['total_students'] = $stmt->fetch()['total'];
        $data['total_roadmaps'] = count($data['roadmaps']);

        $this->view('templates/header', $data);
        $this->view('mentor/dashboard', $data);
        $this->view('templates/footer');
    }

    public function add() {
        $roadmapModel = $this->model('RoadmapModel');
        $data['title'] = 'Buat Roadmap Baru';
        $data['categories'] = $roadmapModel->getAllCategories();

        $this->view('templates/header', $data);
        $this->view('mentor/add_roadmap', $data);
        $this->view('templates/footer');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $roadmapModel = $this->model('RoadmapModel');
            $namaFile = 'default.jpg';

            if ($_FILES['thumbnail']['error'] === 0) {
                $fileName = $_FILES['thumbnail']['name'];
                $fileTmp  = $_FILES['thumbnail']['tmp_name'];
                $ekstensi = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $max_size = 2 * 1024 * 1024;
                
                if (!in_array($ekstensi, $allowed) || $_FILES['thumbnail']['size'] > $max_size) {
                    Flasher::setFlash('Thumbnail', 'Harus berupa gambar dan max 2MB', 'danger');
                    header('Location: ' . BASEURL . '/mentor/add');
                    exit;
                }

                if (!is_dir(ROADMAP_UPLOAD_PATH)) {
                    mkdir(ROADMAP_UPLOAD_PATH, 0777, true);
                }

                $namaFileBaru = uniqid() . '.' . $ekstensi;
                $tujuan = ROADMAP_UPLOAD_PATH . '/' . $namaFileBaru;
                
                if (move_uploaded_file($fileTmp, $tujuan)) {
                    $namaFile = $namaFileBaru;
                }
            }

            $data = [
                'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT),
                'mentor_id'   => $_SESSION['user_id'],
                'title'       => htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8'),
                'description' => htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8'),
                'thumbnail'   => $namaFile 
            ];

            if ($roadmapModel->createRoadmap($data)) {
                Flasher::setFlash('Roadmap', 'Berhasil Ditambahkan', 'success');
                header('Location: ' . BASEURL . '/mentor/dashboard');
                exit;
            }
        }
    }

    public function manage($roadmap_id) {
        $roadmapModel = $this->model('RoadmapModel');
        $stepModel = $this->model('StepModel');

        $stmt = Database::getInstance()->getConnection()->prepare("SELECT * FROM roadmaps WHERE id = ? AND mentor_id = ?");
        $stmt->execute([$roadmap_id, $_SESSION['user_id']]);
        $roadmap = $stmt->fetch();

        if (!$roadmap) {
            die("Akses ditolak atau Roadmap tidak ditemukan!");
        }

        $data['title'] = 'Kelola Langkah: ' . $roadmap['title'];
        $data['roadmap'] = $roadmap;
        $data['steps'] = $stepModel->getStepsByRoadmap($roadmap_id);

        $this->view('templates/header', $data);
        $this->view('mentor/manage_steps', $data);
        $this->view('templates/footer');
    }

    public function store_step() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $stepModel = $this->model('StepModel');
            $roadmap_id = $_POST['roadmap_id'];

            $namaFile = null;
            if ($_FILES['attachment']['error'] === 0) {
                if (!is_dir(ATTACHMENT_UPLOAD_PATH)) {
                    mkdir(ATTACHMENT_UPLOAD_PATH, 0777, true);
                }

                $namaFile = uniqid() . '_' . $_FILES['attachment']['name'];
                move_uploaded_file($_FILES['attachment']['tmp_name'], ATTACHMENT_UPLOAD_PATH . '/' . $namaFile);
            }

            $data = [
                'roadmap_id' => $roadmap_id,
                'title'      => htmlspecialchars($_POST['title']),
                'content'    => $_POST['content'], 
                'video_url'  => $_POST['video_url'] ?? null,
                'attachment' => $namaFile
            ];

            if ($stepModel->createStep($data)) {
                Flasher::setFlash('Materi', 'Berhasil Ditambahkan', 'success');
                header('Location: ' . BASEURL . '/mentor/manage/' . $roadmap_id);
                exit;
            }
        }
    }

    public function edit($id) {
        $roadmapModel = $this->model('RoadmapModel');
        $data['roadmap'] = $roadmapModel->getRoadmapById($id);
        
        if ($data['roadmap']['mentor_id'] != $_SESSION['user_id']) {
            Flasher::setFlash('Akses', 'Ditolak', 'danger');
            header('Location: ' . BASEURL . '/mentor/dashboard');
            exit;
        }

        $data['title'] = 'Edit Roadmap';
        $data['categories'] = $roadmapModel->getAllCategories();
        $this->view('templates/header', $data);
        $this->view('mentor/edit_roadmap', $data);
        $this->view('templates/footer');
    }

    /**
     * PERBAIKAN: Fungsi Update dengan Garbage Collection
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $roadmapModel = $this->model('RoadmapModel');
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $namaFile = $_POST['thumbnail_lama'];

            if ($_FILES['thumbnail']['error'] === 0) {
                $ekstensi = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $max_size = 2 * 1024 * 1024;
                
                if (!in_array($ekstensi, $allowed) || $_FILES['thumbnail']['size'] > $max_size) {
                    Flasher::setFlash('Thumbnail', 'Harus berupa gambar dan max 2MB', 'danger');
                    header('Location: ' . BASEURL . '/mentor/edit/' . $id);
                    exit;
                }

                if (!is_dir(ROADMAP_UPLOAD_PATH)) {
                    mkdir(ROADMAP_UPLOAD_PATH, 0777, true);
                }

                // GARBAGE COLLECTION: Hapus file lama jika ada dan bukan default
                if ($namaFile != 'default.jpg' && !empty($namaFile)) {
                    $oldPath = ROADMAP_UPLOAD_PATH . '/' . $namaFile;
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                
                $namaFile = uniqid() . '.' . $ekstensi;
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], ROADMAP_UPLOAD_PATH . '/' . $namaFile);
            }

            $data = [
                'id'          => $id,
                'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT),
                'title'       => htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8'),
                'description' => htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8'),
                'thumbnail'   => $namaFile
            ];

            if ($roadmapModel->updateRoadmap($data)) {
                Flasher::setFlash('Roadmap', 'Berhasil Diperbarui', 'success');
                header('Location: ' . BASEURL . '/mentor/dashboard');
                exit;
            }
        }
    }

    /**
     * PERBAIKAN: Fungsi Delete dengan File Removal
     */
    public function delete($id) {
        $roadmapModel = $this->model('RoadmapModel');
        $roadmap = $roadmapModel->getRoadmapById($id);

        if ($roadmap && $roadmap['mentor_id'] == $_SESSION['user_id']) {
            if ($roadmap['thumbnail'] != 'default.jpg' && !empty($roadmap['thumbnail'])) {
                $path = ROADMAP_UPLOAD_PATH . '/' . $roadmap['thumbnail'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $roadmapModel->deleteRoadmap($id);
            Flasher::setFlash('Roadmap', 'Berhasil Dihapus', 'success');
        }
        header('Location: ' . BASEURL . '/mentor/dashboard');
    }

    public function edit_step($id) {
        $stepModel = $this->model('StepModel');
        $data['step'] = $stepModel->getStepById($id);
        $data['title'] = 'Edit Langkah: ' . $data['step']['title'];

        $this->view('templates/header', $data);
        $this->view('mentor/edit_step', $data);
        $this->view('templates/footer');
    }

    public function update_step() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $stepModel = $this->model('StepModel');
            $roadmap_id = filter_input(INPUT_POST, 'roadmap_id', FILTER_SANITIZE_NUMBER_INT);
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            // Ambil data lama untuk cek file attachment
            $oldStep = $stepModel->getStepById($id);
            $namaFile = $oldStep['attachment'];

            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === 0) {
                if (!is_dir(ATTACHMENT_UPLOAD_PATH)) {
                    mkdir(ATTACHMENT_UPLOAD_PATH, 0777, true);
                }

                // Hapus attachment lama jika ada
                if (!empty($namaFile)) {
                    $oldPath = ATTACHMENT_UPLOAD_PATH . '/' . $namaFile;
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $namaFile = uniqid() . '_' . $_FILES['attachment']['name'];
                move_uploaded_file($_FILES['attachment']['tmp_name'], ATTACHMENT_UPLOAD_PATH . '/' . $namaFile);
            }

            $data = [
                'id'         => $id,
                'title'      => htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8'),
                'content'    => $_POST['content'], 
                'video_url'  => $_POST['video_url'] ?? null,
                'attachment' => $namaFile
            ];

            if ($stepModel->updateStep($data)) {
                Flasher::setFlash('Langkah', 'Berhasil Diperbarui', 'success');
                header('Location: ' . BASEURL . '/mentor/manage/' . $roadmap_id);
                exit;
            }
        }
    }

    public function delete_step($id, $roadmap_id) {
        $stepModel = $this->model('StepModel');
        $step = $stepModel->getStepById($id);

        if ($step) {
            if (!empty($step['attachment'])) {
                $path = ATTACHMENT_UPLOAD_PATH . '/' . $step['attachment'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $stepModel->deleteStep($id);
            Flasher::setFlash('Langkah', 'Berhasil Dihapus', 'success');
        }
        header('Location: ' . BASEURL . '/mentor/manage/' . $roadmap_id);
        exit;
    }

    public function quiz($step_id) {
        $stepModel = $this->model('StepModel');
        $quizModel = $this->model('QuizModel');
        $data['step'] = $stepModel->getStepById($step_id);
        
        $roadmap = $this->model('RoadmapModel')->getRoadmapById($data['step']['roadmap_id']);
        if ($roadmap['mentor_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASEURL . '/mentor/dashboard');
            exit;
        }

        $data['title'] = 'Kelola Kuis: ' . $data['step']['title'];
        $data['quiz'] = $quizModel->getQuizByStep($step_id);
        if ($data['quiz']) {
            $data['questions'] = $quizModel->getQuestionsByQuiz($data['quiz']['id']);
        }

        $this->view('templates/header', $data);
        $this->view('mentor/quiz', $data);
        $this->view('templates/footer');
    }

    public function store_quiz() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $quizModel = $this->model('QuizModel');
            $step_id = $_POST['step_id'];
            $data = [
                'step_id' => $step_id,
                'title' => htmlspecialchars($_POST['title']),
                'description' => htmlspecialchars($_POST['description']),
                'min_score' => $_POST['min_score']
            ];
            if ($quizModel->addQuiz($data)) {
                Flasher::setFlash('Kuis', 'Berhasil Dibuat', 'success');
                header('Location: ' . BASEURL . '/mentor/quiz/' . $step_id);
                exit;
            }
        }
    }

    public function store_question() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $quizModel = $this->model('QuizModel');
            $quiz_id = $_POST['quiz_id'];
            $step_id = $_POST['step_id'];
            $data = [
                'quiz_id' => $quiz_id,
                'question_text' => htmlspecialchars($_POST['question_text']),
                'option_a' => htmlspecialchars($_POST['option_a']),
                'option_b' => htmlspecialchars($_POST['option_b']),
                'option_c' => htmlspecialchars($_POST['option_c']),
                'option_d' => htmlspecialchars($_POST['option_d']),
                'correct_answer' => $_POST['correct_answer']
            ];
            if ($quizModel->addQuestion($data)) {
                Flasher::setFlash('Pertanyaan', 'Berhasil Ditambahkan', 'success');
                header('Location: ' . BASEURL . '/mentor/quiz/' . $step_id);
                exit;
            }
        }
    }
}