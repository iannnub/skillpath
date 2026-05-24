<?php

class AdminController extends Controller {

    public function __construct() {
        $this->middleware('admin');
    }

    public function dashboard() {
        $db = Database::getInstance()->getConnection();
        $categoryModel = $this->model('CategoryModel');

        // 1. Hitung Total Student
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM users WHERE role = 'student'");
        $stmt->execute();
        $data['total_students'] = $stmt->fetch()['total'];

        // 2. Hitung Total Mentor
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM users WHERE role = 'mentor'");
        $stmt->execute();
        $data['total_mentors'] = $stmt->fetch()['total'];

        // 3. Hitung Total Roadmap
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM roadmaps");
        $stmt->execute();
        $data['total_roadmaps'] = $stmt->fetch()['total'];

        // 4. Hitung Total Pendaftaran (Enrollments)
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM enrollments");
        $stmt->execute();
        $data['total_enrolls'] = $stmt->fetch()['total'];

        // 5. Hitung Total Kategori (Untuk ditampilkan di tombol dashboard)
        $data['total_categories'] = count($categoryModel->getAll());

        $data['title'] = 'Admin Control Panel';

        // Panggil template lengkap biar navigasi & flasher muncul
        $this->view('templates/header', $data);
        $this->view('admin/dashboard', $data);
        $this->view('templates/footer');
    }
    // Tambahkan di dalam class AdminController

public function categories() {
        $categoryModel = $this->model('CategoryModel');
        $data['title'] = 'Kelola Kategori';
        $data['categories'] = $categoryModel->getAll();

        $this->view('templates/header', $data);
        $this->view('admin/categories', $data);
        $this->view('templates/footer');
    }

    public function add_category() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
            $this->model('CategoryModel')->add($name);
            Flasher::setFlash('Kategori', 'Berhasil Ditambahkan', 'success');
            header('Location: ' . BASEURL . '/admin/categories');
            exit;
        }
    }

    public function delete_category($id) {
        $this->model('CategoryModel')->delete($id);
        Flasher::setFlash('Kategori', 'Berhasil Dihapus', 'success');
        header('Location: ' . BASEURL . '/admin/categories');
        exit;
    }

    public function users() {
        $userModel = $this->model('UserModel');
        $data['title'] = 'Kelola Pengguna';
        $data['users'] = $userModel->getAllUsers();

        $this->view('templates/header', $data);
        $this->view('admin/users', $data);
        $this->view('templates/footer');
    }

    public function delete_user($id) {
        $userModel = $this->model('UserModel');
        if ($userModel->delete($id)) {
            Flasher::setFlash('Pengguna', 'Berhasil Dihapus', 'success');
        } else {
            Flasher::setFlash('Pengguna', 'Gagal Dihapus', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/users');
        exit;
    }

    public function change_role() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('UserModel');
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $role = $_POST['role'] ?? 'student';
            
            // Validate role
            if (!in_array($role, ['student', 'mentor', 'admin'])) {
                $role = 'student';
            }

            if ($userModel->updateRole($id, $role)) {
                Flasher::setFlash('Role Pengguna', 'Berhasil Diubah', 'success');
            } else {
                Flasher::setFlash('Role Pengguna', 'Gagal Diubah', 'danger');
            }
            header('Location: ' . BASEURL . '/admin/users');
            exit;
        }
    }

    public function moderation() {
    $data['title'] = 'Moderasi Konten';
    $data['pending_roadmaps'] = $this->model('RoadmapModel')->getPendingRoadmaps();
    
    $this->view('templates/header', $data);
    $this->view('admin/moderation', $data);
    $this->view('templates/footer');
}

public function approve($id) {
    if ($this->model('RoadmapModel')->updateStatus($id, 'published')) {
        Flasher::setFlash('Roadmap', 'Berhasil diterbitkan!', 'success');
    }
    header('Location: ' . BASEURL . '/admin/moderation');
    exit;
}

public function reject($id) {
    if ($this->model('RoadmapModel')->updateStatus($id, 'rejected')) {
        Flasher::setFlash('Roadmap', 'Telah ditolak.', 'info');
    }
    header('Location: ' . BASEURL . '/admin/moderation');
    exit;
}

public function index() {
    header('Location: ' . BASEURL . '/admin/dashboard');
    exit;
}
}