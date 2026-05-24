<?php 
    $url = $_GET['url'] ?? 'home';
    $url = explode('/', $url);
    $current_page = $url[0];

    $unreadNotif = [];
    $countNotif = 0;

    // Inisialisasi model notifikasi jika user sudah login
    if (isset($_SESSION['user_id'])) {
        // Karena navbar di-require di header, kita bisa memanggil model langsung
        // Pastikan Controller.php memiliki akses ke model NotificationModel
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM notifications WHERE user_id = :user_id AND is_read = 0 ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $_SESSION['user_id']]);
        $unreadNotif = $stmt->fetchAll();
        $countNotif = count($unreadNotif);
    }
?>
<nav class="navbar navbar-expand-lg sticky-top glass-navbar">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold text-primary" href="<?= BASEURL; ?>" style="letter-spacing: 0.5px;">
            <i class="bi bi-layers-fill me-1"></i> SkillPath
        </a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <?php if(isset($_SESSION['role'])) : ?>
                    <li class="nav-item me-2">
                        <a class="nav-link <?= ($current_page == $_SESSION['role']) ? 'active' : ''; ?>" 
                           href="<?= BASEURL; ?>/<?= $_SESSION['role']; ?>/dashboard">
                           <i class="bi bi-grid-1x2"></i> Dashboard
                        </a>
                    </li>

                    <?php if($_SESSION['role'] == 'student') : ?>
                    <li class="nav-item me-2">
                        <a class="nav-link <?= ($current_page == 'student' && isset($url[1]) && $url[1] == 'catalog') ? 'active' : ''; ?>" 
                           href="<?= BASEURL; ?>/student/catalog">
                           <i class="bi bi-compass"></i> Explore
                        </a>
                    </li>
                    <?php endif; ?>

                    <li class="nav-item dropdown me-3">
                        <a class="nav-link position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell fs-5"></i>
                            <?php if($countNotif > 0) : ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; padding: 0.35em 0.65em;">
                                    <?= $countNotif; ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 rounded-4 glass-card p-2" aria-labelledby="notifDropdown" style="width: 300px; max-height: 400px; overflow-y: auto;">
                            <li class="dropdown-header text-light fw-bold border-bottom border-secondary mb-2 pb-2">Notifikasi</li>
                            <?php if($countNotif == 0) : ?>
                                <li><span class="dropdown-item small text-muted text-center py-3">Tidak ada notifikasi baru</span></li>
                            <?php else : ?>
                                <?php foreach($unreadNotif as $n) : ?>
                                    <li>
                                        <div class="dropdown-item rounded-3 mb-1 p-3" style="white-space: normal; background: rgba(255,255,255,0.03);">
                                            <div class="fw-bold text-primary small mb-1"><?= htmlspecialchars($n['title']); ?></div>
                                            <div class="text-light small mb-1" style="line-height: 1.4;"><?= htmlspecialchars($n['message']); ?></div>
                                            <div class="text-muted" style="font-size: 0.7rem;"><?= date('d M, H:i', strtotime($n['created_at'])); ?></div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 35px; height: 35px;">
                                <?= strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                            </div>
                            <span class="fw-semibold"><?= htmlspecialchars($_SESSION['username']); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 rounded-4 glass-card p-2" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item py-2 rounded-3 text-muted" href="<?= BASEURL; ?>/profile"><i class="bi bi-person me-2"></i> Profil Saya</a></li>
                            <li><hr class="dropdown-divider border-secondary opacity-25 my-2"></li>
                            <li><a class="dropdown-item py-2 rounded-3 text-danger fw-bold" href="<?= BASEURL; ?>/auth/logout"><i class="bi bi-box-arrow-right me-2"></i> Keluar</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item me-3">
                        <a class="nav-link fw-semibold <?= ($current_page == 'auth' && isset($url[1]) && $url[1] == 'login') ? 'active text-primary' : ''; ?>" 
                           href="<?= BASEURL; ?>/auth/login">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary rounded-pill px-4 py-2 shadow-sm" href="<?= BASEURL; ?>/auth/register">Mulai Belajar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>