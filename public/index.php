<?php

// 1. Jalankan session di baris paling atas
if (!session_id()) {
    session_start();
}

if (!isset($_GET['url']) && isset($_SERVER['REQUEST_URI'])) {
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
    $basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

    if ($basePath === '/' || $basePath === '\\') {
        $basePath = '';
    }

    if ($basePath !== '' && strpos($requestUri, $basePath) === 0) {
        $requestUri = substr($requestUri, strlen($basePath));
    }

    $requestUri = trim($requestUri, '/');
    if ($requestUri !== '' && $requestUri !== 'index.php') {
        $_GET['url'] = $requestUri;
    }
}

// 2. Panggil file config (Keluar folder public, masuk ke folder config)
require_once __DIR__ . '/../config/config.php';

// 3. Panggil file-file inti di folder app/core
require_once __DIR__ . '/../app/core/App.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Flasher.php';

// 4. Jalankan aplikasi
$app = new App;