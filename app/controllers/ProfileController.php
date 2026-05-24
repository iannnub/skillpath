<?php

class ProfileController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) header('Location: ' . BASEURL . '/auth/login');

        $data['title'] = 'My Profile';
        $data['user'] = $this->model('UserModel')->getUserById($_SESSION['user_id']);

        $this->view('templates/header', $data);
        $this->view('profile/index', $data);
        $this->view('templates/footer');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_SESSION['user_id'];
            $username = $_POST['username'];
            $email = $_POST['email'];

            if ($this->model('UserModel')->updateProfile($id, $username, $email)) {
                $_SESSION['username'] = $username; // Update session juga
                Flasher::setFlash('Profil', 'Berhasil Diperbarui', 'success');
            }
            header('Location: ' . BASEURL . '/profile');
            exit;
        }
    }

    public function change_password() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $this->model('UserModel')->getUserById($_SESSION['user_id']);
            
            // Validasi: Apakah password lama benar?
            if (password_verify($_POST['old_password'], $user['password'])) {
                $this->model('UserModel')->updatePassword($_SESSION['user_id'], $_POST['new_password']);
                Flasher::setFlash('Password', 'Berhasil Diganti', 'success');
            } else {
                Flasher::setFlash('Password Lama', 'Salah!', 'danger');
            }
            header('Location: ' . BASEURL . '/profile');
            exit;
        }
    }
}