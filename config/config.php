<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$requestUri = str_replace('\\', '/', $requestUri);

$scriptDir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
if ($scriptDir === '/' || $scriptDir === '\\') {
    $scriptDir = '';
}

$basePath = $scriptDir;
$isPublicRequest = $requestUri === '/public' || strpos($requestUri, '/public/') === 0;

if ($basePath !== '' && preg_match('#/public$#', $basePath)) {
    if (!$isPublicRequest) {
        $basePath = preg_replace('#/public$#', '', $basePath);
    }
}

if ($basePath === '/' || $basePath === '\\') {
    $basePath = '';
}

define('BASEURL', $protocol . '://' . $host . $basePath);
define('ASSET_BASEURL', str_ends_with(BASEURL, '/public') ? BASEURL : BASEURL . '/public');

define('APP_ROOT', dirname(__DIR__));
define('PUBLIC_PATH', APP_ROOT . '/public');
define('UPLOAD_PATH', PUBLIC_PATH . '/assets');
define('ROADMAP_UPLOAD_PATH', UPLOAD_PATH . '/img/roadmaps');
define('ATTACHMENT_UPLOAD_PATH', UPLOAD_PATH . '/uploads');

if (!is_dir(ROADMAP_UPLOAD_PATH)) {
    mkdir(ROADMAP_UPLOAD_PATH, 0777, true);
}

if (!is_dir(ATTACHMENT_UPLOAD_PATH)) {
    mkdir(ATTACHMENT_UPLOAD_PATH, 0777, true);
}

// Database Credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'skillpath_db');