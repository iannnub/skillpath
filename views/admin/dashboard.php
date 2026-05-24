<div class="row g-4">
    <!-- Sidebar Kiri -->
    <div class="col-lg-3 col-xl-2 d-none d-lg-block">
        <div class="sidebar rounded-4 p-3 shadow-sm sticky-top" style="top: 100px;">
            <div class="text-muted small fw-bold mb-3 ms-2 text-uppercase" style="letter-spacing: 1px;">Admin Panel</div>
            <div class="nav flex-column nav-pills">
                <a class="nav-link active d-flex align-items-center" href="<?= BASEURL; ?>/admin/dashboard">
                    <i class="bi bi-speedometer2 me-3 fs-5"></i> Dashboard
                </a>
                <a class="nav-link d-flex align-items-center" href="<?= BASEURL; ?>/admin/users">
                    <i class="bi bi-people me-3 fs-5"></i> Kelola User
                </a>
                <a class="nav-link d-flex align-items-center" href="<?= BASEURL; ?>/admin/categories">
                    <i class="bi bi-grid-3x3-gap me-3 fs-5"></i> Kategori
                </a>
                <a class="nav-link d-flex align-items-center" href="<?= BASEURL; ?>/admin/moderation">
                    <i class="bi bi-shield-check me-3 fs-5"></i> Moderasi
                </a>
            </div>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="col-lg-9 col-xl-10">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
            <div>
                <h2 class="fw-bold mb-1 text-light">Dashboard Administrator</h2>
                <p class="text-muted fs-5 mb-0">Pantau pertumbuhan ekosistem SkillPath secara real-time.</p>
            </div>
            <div class="text-muted small mt-3 mt-md-0 fw-bold bg-darker p-2 px-3 rounded-pill border border-secondary">
                <i class="bi bi-calendar3 me-2 text-primary"></i> <?= date('d M Y'); ?>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-sm-6 col-xl-3">
                <div class="card iconic-card border-0 h-100 p-4 shadow-sm" style="background: linear-gradient(135deg, #181b21, #121419);">
                    <i class="bi bi-mortarboard-fill icon-bg text-primary"></i>
                    <div class="position-relative z-1">
                        <div class="text-uppercase text-muted fw-bold small mb-2" style="letter-spacing: 1px;">Total Students</div>
                        <h2 class="display-4 fw-bolder mb-0 text-light"><?= $data['total_students']; ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card iconic-card border-0 h-100 p-4 shadow-sm" style="background: linear-gradient(135deg, #181b21, #121419);">
                    <i class="bi bi-person-workspace icon-bg text-emerald"></i>
                    <div class="position-relative z-1">
                        <div class="text-uppercase text-muted fw-bold small mb-2" style="letter-spacing: 1px;">Total Mentors</div>
                        <h2 class="display-4 fw-bolder mb-0 text-light"><?= $data['total_mentors']; ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card iconic-card border-0 h-100 p-4 shadow-sm" style="background: linear-gradient(135deg, #181b21, #121419);">
                    <i class="bi bi-map-fill icon-bg text-warning"></i>
                    <div class="position-relative z-1">
                        <div class="text-uppercase text-muted fw-bold small mb-2" style="letter-spacing: 1px;">Total Roadmaps</div>
                        <h2 class="display-4 fw-bolder mb-0 text-light"><?= $data['total_roadmaps']; ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card iconic-card border-0 h-100 p-4 shadow-sm" style="background: linear-gradient(135deg, #181b21, #121419);">
                    <i class="bi bi-journal-check icon-bg text-info"></i>
                    <div class="position-relative z-1">
                        <div class="text-uppercase text-muted fw-bold small mb-2" style="letter-spacing: 1px;">Total Enrolls</div>
                        <h2 class="display-4 fw-bolder mb-0 text-light"><?= $data['total_enrolls']; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 p-4 p-md-5 rounded-4" style="background-color: var(--bg-card);">
            <h5 class="fw-bold mb-4 text-light"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Aksi Cepat Admin</h5>
            <div class="row g-4">
                <div class="col-md-4">
                    <a href="<?= BASEURL; ?>/admin/users" class="text-decoration-none">
                        <div class="card-hover border border-secondary rounded-4 p-4 text-center d-flex flex-column align-items-center justify-content-center h-100">
                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle mb-3">
                                <i class="bi bi-people-fill fs-2"></i>
                            </div>
                            <h5 class="fw-bold text-light">Kelola Pengguna</h5>
                            <p class="text-muted small mb-0">Ubah role atau hapus akun pengguna yang melanggar ketentuan.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?= BASEURL; ?>/admin/categories" class="text-decoration-none">
                        <div class="card-hover border border-secondary rounded-4 p-4 text-center d-flex flex-column align-items-center justify-content-center h-100">
                            <div class="bg-emerald bg-opacity-10 text-emerald p-3 rounded-circle mb-3">
                                <i class="bi bi-grid-3x3-gap-fill fs-2"></i>
                            </div>
                            <h5 class="fw-bold text-light">Kelola Kategori</h5>
                            <p class="text-muted small mb-0">Tambah atau hapus kategori untuk mengorganisasi roadmap.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?= BASEURL; ?>/admin/moderation" class="text-decoration-none">
                        <div class="card-hover border border-secondary rounded-4 p-4 text-center d-flex flex-column align-items-center justify-content-center h-100">
                            <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle mb-3">
                                <i class="bi bi-shield-check fs-2"></i>
                            </div>
                            <h5 class="fw-bold text-light">Moderasi Konten</h5>
                            <p class="text-muted small mb-0">Tinjau dan setujui roadmap baru dari mentor sebelum dipublikasi.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>