<?php

class AuthController extends Controller {
    
    public function login() {
        if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'mentor', 'student'])) {
            header('Location: ' . BASEURL . '/' . $_SESSION['role'] . '/dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            $userModel = $this->model('UserModel');
            $user = $userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password']) && in_array($user['role'], ['admin', 'mentor', 'student'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header('Location: ' . BASEURL . '/' . $user['role'] . '/dashboard');
                exit;
            }

            Flasher::setFlash('Email atau Password', 'Salah', 'danger');
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $data['title'] = 'Login';
        $this->view('templates/header', $data);
        $this->view('auth/login');
        $this->view('templates/footer');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = htmlspecialchars(trim($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8');
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $role = 'student';
            $userModel = $this->model('UserModel');

            if (empty($username) || empty($email) || empty($password)) {
                Flasher::setFlash('Gagal!', 'Semua field wajib diisi', 'error');
                header('Location: ' . BASEURL . '/auth/register');
                exit;
            }

            if (strlen($password) < 6) {
                Flasher::setFlash('Password', 'Minimal 6 karakter ya!', 'warning');
                header('Location: ' . BASEURL . '/auth/register');
                exit;
            }

            if ($userModel->emailExists($email)) {
                Flasher::setFlash('Email sudah terdaftar', 'Gunakan email lain', 'warning');
                header('Location: ' . BASEURL . '/auth/register');
                exit;
            }

            if ($userModel->usernameExists($username)) {
                Flasher::setFlash('Username sudah terdaftar', 'Gunakan username lain', 'warning');
                header('Location: ' . BASEURL . '/auth/register');
                exit;
            }

            $data = [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'role' => $role
            ];

            if ($userModel->register($data)) {
                Flasher::setFlash('Berhasil!', 'Akun kamu sudah jadi, silakan login', 'success');
                header('Location: ' . BASEURL . '/auth/login');
                exit;
            }

            Flasher::setFlash('Gagal!', 'Terjadi kesalahan saat membuat akun', 'danger');
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }

        $data['title'] = 'Register';
        $this->view('templates/header', $data);
        $this->view('auth/register');
        $this->view('templates/footer');
    }

    public function logout() {
    $_SESSION = []; // Kosongkan semua data session
    session_unset();
    session_destroy();
    header('Location: ' . BASEURL . '/auth/login');
    exit;
}
}