<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['title'] ?? 'SkillPath'); ?> - Modern LMS Platform</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= ASSET_BASEURL; ?>/assets/css/style.css">
</head>
<body>
    <!-- Navbar Component -->
    <?php require_once __DIR__ . '/navbar.php'; ?>

    <!-- Flash Messages -->
    <div class="container-fluid mt-3 px-4 position-relative" style="z-index: 1050;">
        <?php Flasher::flash(); ?> 
    </div>

    <!-- Main Content Wrapper -->
    <main class="py-3 px-4 min-vh-100">