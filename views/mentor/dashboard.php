<div class="row g-4">
    <!-- Sidebar Kiri -->
    <div class="col-lg-3 col-xl-2 d-none d-lg-block">
        <div class="sidebar rounded-4 p-3 shadow-sm sticky-top" style="top: 100px;">
            <div class="text-muted small fw-bold mb-3 ms-2 text-uppercase" style="letter-spacing: 1px;">Mentor Studio</div>
            <div class="nav flex-column nav-pills">
                <a class="nav-link active d-flex align-items-center" href="<?= BASEURL; ?>/mentor/dashboard">
                    <i class="bi bi-grid-1x2 me-3 fs-5"></i> Dashboard
                </a>
                <a class="nav-link d-flex align-items-center" href="<?= BASEURL; ?>/mentor/add">
                    <i class="bi bi-plus-circle me-3 fs-5"></i> Buat Roadmap
                </a>
            </div>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="col-lg-9 col-xl-10">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-light">Workspace Mentor</h2>
                <p class="text-muted fs-5 mb-0">Kelola kurikulum dan pantau jumlah siswa Anda.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="<?= BASEURL; ?>/mentor/add" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Roadmap Baru
                </a>
            </div>
        </div>

        <!-- Statistik -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card iconic-card border-0 h-100 p-4 shadow-sm" style="background: linear-gradient(135deg, #181b21, #121419);">
                    <i class="bi bi-journal-code icon-bg text-primary"></i>
                    <div class="position-relative z-1">
                        <div class="text-uppercase text-muted fw-bold small mb-2" style="letter-spacing: 1px;">Total Roadmap Saya</div>
                        <h2 class="display-4 fw-bolder mb-0 text-light"><?= $data['total_roadmaps'] ?? 0; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card iconic-card border-0 h-100 p-4 shadow-sm" style="background: linear-gradient(135deg, #181b21, #121419);">
                    <i class="bi bi-people icon-bg text-emerald"></i>
                    <div class="position-relative z-1">
                        <div class="text-uppercase text-muted fw-bold small mb-2" style="letter-spacing: 1px;">Total Student Belajar</div>
                        <h2 class="display-4 fw-bolder mb-0 text-light"><?= $data['total_students'] ?? 0; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Roadmap -->
        <div class="card border-0 rounded-4 p-4 p-md-5">
            <h5 class="fw-bold text-light mb-4"><i class="bi bi-card-list text-primary me-2"></i> Daftar Roadmap Saya</h5>
            
            <?php if(empty($data['roadmaps'])) : ?>
                <div class="text-center py-5 text-muted border border-secondary rounded-4" style="border-style: dashed !important;">
                    <i class="bi bi-folder-plus fs-1 d-block mb-3 opacity-50"></i>
                    <p class="mb-0">Anda belum membuat roadmap apa pun.</p>
                    <a href="<?= BASEURL; ?>/mentor/add" class="btn btn-outline-primary mt-3 rounded-pill px-4">Mulai Buat Roadmap</a>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-borderless table-hover align-middle mb-0">
                        <thead class="text-muted small text-uppercase" style="letter-spacing: 1px;">
                            <tr>
                                <th class="py-3 px-4">Thumbnail</th>
                                <th class="py-3 px-4">Judul Roadmap</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['roadmaps'] as $rm) : ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td class="px-4 py-3" style="width: 100px;">
                                    <img src="<?= ASSET_BASEURL; ?>/assets/img/roadmaps/<?= $rm['thumbnail']; ?>" class="rounded-3 object-fit-cover" width="80" height="60" alt="Thumbnail">
                                </td>
                                <td class="px-4 py-3 text-light">
                                    <div class="fw-bold fs-6 mb-1"><?= htmlspecialchars($rm['title']); ?></div>
                                    <div class="text-muted small text-truncate" style="max-width: 300px;">
                                        <?= htmlspecialchars($rm['description']); ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="<?= BASEURL; ?>/mentor/manage/<?= $rm['id']; ?>" class="btn btn-sm btn-primary rounded-pill px-3 me-1 fw-bold shadow-sm">
                                        <i class="bi bi-list-check me-1"></i> Kelola Materi
                                    </a>
                                    <a href="<?= BASEURL; ?>/mentor/edit/<?= $rm['id']; ?>" class="btn btn-sm btn-outline-info rounded-circle me-1" style="width: 32px; height: 32px; padding: 0; line-height: 30px;">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle" style="width: 32px; height: 32px; padding: 0; line-height: 30px;" onclick="confirmDeleteRoadmap(<?= $rm['id']; ?>, '<?= htmlspecialchars(addslashes($rm['title'])); ?>')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function confirmDeleteRoadmap(id, title) {
    Swal.fire({
        title: 'Hapus Roadmap?',
        html: `Roadmap <strong>${title}</strong> dan semua materinya akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        background: '#181b21',
        color: '#f8f9fa',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#4b5563',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: { popup: 'rounded-4 border border-secondary', confirmButton: 'rounded-pill px-4 fw-bold', cancelButton: 'rounded-pill px-4 fw-bold' }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= BASEURL; ?>/mentor/delete/' + id;
        }
    })
}
</script>