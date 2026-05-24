<div class="row g-4">
    <div class="col-lg-3 col-xl-2 d-none d-lg-block">
        <div class="sidebar rounded-4 p-3 shadow-sm sticky-top" style="top: 100px;">
            <div class="text-muted small fw-bold mb-3 ms-2 text-uppercase" style="letter-spacing: 1px;">Admin Panel</div>
            <div class="nav flex-column nav-pills">
                <a class="nav-link d-flex align-items-center" href="<?= BASEURL; ?>/admin/dashboard">
                    <i class="bi bi-speedometer2 me-3 fs-5"></i> Dashboard
                </a>
                <a class="nav-link d-flex align-items-center" href="<?= BASEURL; ?>/admin/users">
                    <i class="bi bi-people me-3 fs-5"></i> Kelola User
                </a>
                <a class="nav-link d-flex align-items-center" href="<?= BASEURL; ?>/admin/categories">
                    <i class="bi bi-grid-3x3-gap me-3 fs-5"></i> Kategori
                </a>
                <a class="nav-link active d-flex align-items-center" href="<?= BASEURL; ?>/admin/moderation">
                    <i class="bi bi-shield-check me-3 fs-5"></i> Moderasi
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-xl-10">
        <div class="mb-4">
            <h2 class="fw-bold text-light"><i class="bi bi-shield-check text-warning me-2"></i> Moderasi Roadmap</h2>
            <p class="text-muted">Tinjau roadmap yang dikirim mentor sebelum dipublikasikan.</p>
        </div>

        <div class="card border-0 rounded-4 p-4 p-md-5">
            <div class="table-responsive">
                <table class="table table-borderless table-hover align-middle mb-0">
                    <thead class="text-muted small text-uppercase" style="letter-spacing: 1px;">
                        <tr>
                            <th class="py-3 px-4">Mentor</th>
                            <th class="py-3 px-4">Judul Roadmap</th>
                            <th class="py-3 px-4">Tanggal Dibuat</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($data['pending_roadmaps'])) : ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Tidak ada roadmap yang perlu ditinjau.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach($data['pending_roadmaps'] as $rm) : ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td class="px-4 py-3 text-light fw-bold"><?= htmlspecialchars($rm['mentor_name']); ?></td>
                                <td class="px-4 py-3 text-light"><?= htmlspecialchars($rm['title']); ?></td>
                                <td class="px-4 py-3 text-muted"><?= date('d M Y', strtotime($rm['created_at'])); ?></td>
                                <td class="px-4 py-3 text-center">
                                    <a href="<?= BASEURL; ?>/admin/approve/<?= $rm['id']; ?>" class="btn btn-sm btn-emerald rounded-pill px-3 fw-bold me-2">Setujui</a>
                                    <a href="<?= BASEURL; ?>/admin/reject/<?= $rm['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">Tolak</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>