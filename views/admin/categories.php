<div class="row g-4">
    <!-- Sidebar Kiri -->
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
                <a class="nav-link active d-flex align-items-center" href="<?= BASEURL; ?>/admin/categories">
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
        <div class="mb-4">
            <h2 class="fw-bold text-light"><i class="bi bi-grid-3x3-gap-fill text-emerald me-2"></i> Kategori Roadmap</h2>
            <p class="text-muted">Kelola struktur kategori untuk mengelompokkan roadmap pembelajaran.</p>
        </div>

        <div class="row g-4">
            <!-- Form Tambah Kategori -->
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 rounded-4 p-4 p-md-5 h-100 position-sticky" style="top: 100px;">
                    <div class="text-center mb-4">
                        <div class="bg-emerald bg-opacity-10 text-emerald p-3 rounded-circle d-inline-block mb-3">
                            <i class="bi bi-plus-lg fs-2"></i>
                        </div>
                        <h4 class="fw-bold text-light mb-1">Tambah Kategori</h4>
                        <p class="text-muted small">Buat kategori baru untuk roadmap.</p>
                    </div>

                    <form action="<?= BASEURL; ?>/admin/add_category" method="POST">
                        <div class="form-floating mb-4">
                            <input type="text" name="name" class="form-control border-secondary" id="categoryName" placeholder="Nama Kategori" required>
                            <label for="categoryName">Nama Kategori</label>
                        </div>
                        <button type="submit" class="btn btn-emerald w-100 rounded-pill py-3 fw-bold shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Kategori
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabel Daftar Kategori -->
            <div class="col-md-7 col-lg-8">
                <div class="card border-0 rounded-4 p-4 p-md-5 h-100">
                    <h5 class="fw-bold mb-4 text-light">Daftar Kategori Tersedia</h5>
                    
                    <?php if(empty($data['categories'])) : ?>
                        <div class="text-center py-5 text-muted border border-secondary rounded-4" style="border-style: dashed !important;">
                            <i class="bi bi-tags fs-1 d-block mb-3 opacity-50"></i>
                            <p class="mb-0">Belum ada kategori yang ditambahkan.</p>
                        </div>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover align-middle mb-0">
                                <thead class="text-muted small text-uppercase" style="letter-spacing: 1px;">
                                    <tr>
                                        <th class="py-3 px-4">No</th>
                                        <th class="py-3 px-4">Nama Kategori</th>
                                        <th class="py-3 px-4 text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($data['categories'] as $cat) : ?>
                                    <tr style="border-bottom: 1px solid var(--border-color);">
                                        <td class="px-4 py-3 text-muted"><?= $no++; ?></td>
                                        <td class="px-4 py-3 fw-bold text-light fs-5"><?= htmlspecialchars($cat['name']); ?></td>
                                        <td class="px-4 py-3 text-end">
                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold" onclick="confirmDeleteCat(<?= $cat['id']; ?>, '<?= htmlspecialchars($cat['name']); ?>')">
                                                <i class="bi bi-trash me-1"></i> Hapus
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
    </div>
</div>

<script>
function confirmDeleteCat(id, name) {
    Swal.fire({
        title: 'Hapus Kategori?',
        html: `Apakah Anda yakin ingin menghapus kategori <strong>${name}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        background: '#181b21',
        color: '#f8f9fa',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#4b5563',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-4 border border-secondary',
            confirmButton: 'rounded-pill px-4 fw-bold',
            cancelButton: 'rounded-pill px-4 fw-bold'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= BASEURL; ?>/admin/delete_category/' + id;
        }
    })
}
</script>