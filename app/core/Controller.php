<?php

class Controller {
    public function view($view, $data = []) {
        $viewPath = __DIR__ . '/../../views/' . $view . '.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Error: View <b>$view</b> tidak ditemukan di path: <b>$viewPath</b>");
        }
    }

    public function model($model) {
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model;
    }

    public function middleware($role = null) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        if ($role && $_SESSION['role'] !== $role) {
            die("Akses Ditolak: Anda bukan $role!");
        }
    }
}