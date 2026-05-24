<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="mb-4">
            <a href="<?= BASEURL; ?>/<?= $_SESSION['role']; ?>/dashboard" class="text-decoration-none text-muted small fw-bold mb-3 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
            <h2 class="fw-bold text-light mb-1">Profil Saya</h2>
            <p class="text-muted">Kelola informasi pribadi akun Anda.</p>
        </div>

        <div class="card glass-card border-0 rounded-4 p-4 p-md-5 text-center">
            <div class="mb-4">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold shadow-lg mb-3" style="width: 100px; height: 100px; font-size: 3rem; border: 4px solid var(--bg-card);">
                    <?= strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                </div>
                <h3 class="fw-bold text-light mb-1"><?= htmlspecialchars($_SESSION['username']); ?></h3>
                <span class="badge <?= $_SESSION['role'] == 'mentor' ? 'bg-emerald' : ($_SESSION['role'] == 'admin' ? 'bg-danger' : 'bg-primary') ?> px-3 py-2 rounded-pill shadow-sm text-uppercase" style="letter-spacing: 1px;">
                    <?= htmlspecialchars($_SESSION['role']); ?>
                </span>
            </div>

            <hr class="border-secondary my-4 opacity-25">

            <div class="text-start">
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase mb-1" style="letter-spacing: 1px;">Username</label>
                    <div class="fs-5 fw-semibold text-light bg-dark p-3 rounded-3 border border-secondary"><?= htmlspecialchars($_SESSION['username']); ?></div>
                </div>
                <div class="mb-4">
                    <label class="text-muted small fw-bold text-uppercase mb-1" style="letter-spacing: 1px;">Status Akun</label>
                    <div class="fs-5 fw-semibold text-light bg-dark p-3 rounded-3 border border-secondary d-flex align-items-center">
                        <i class="bi bi-shield-check text-emerald me-2"></i> Aktif Terverifikasi
                    </div>
                </div>
                
                <!-- Placeholder untuk fitur update profil mendatang -->
                <button class="btn btn-outline-light w-100 rounded-pill py-3 fw-bold opacity-50" disabled>
                    <i class="bi bi-pencil-square me-1"></i> Edit Profil (Segera Hadir)
                </button>
            </div>
        </div>
    </div>
</div>