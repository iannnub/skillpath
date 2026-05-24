<div class="row g-4">
    <div class="col-lg-3 col-xl-2 d-none d-lg-block">
        <div class="sidebar rounded-4 p-3 shadow-sm sticky-top" style="top: 100px;">
            <div class="text-muted small fw-bold mb-3 ms-2 text-uppercase" style="letter-spacing: 1px;">Admin Panel</div>
            <div class="nav flex-column nav-pills">
                <a class="nav-link d-flex align-items-center" href="<?= BASEURL; ?>/admin/dashboard">
                    <i class="bi bi-speedometer2 me-3 fs-5"></i> Dashboard
                </a>
                <a class="nav-link active d-flex align-items-center" href="<?= BASEURL; ?>/admin/users">
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

    <div class="col-lg-9 col-xl-10">
        <div class="mb-4">
            <h2 class="fw-bold text-light"><i class="bi bi-people-fill text-primary me-2"></i> Kelola Pengguna</h2>
            <p class="text-muted">Atur hak akses dan kelola semua akun pengguna terdaftar.</p>
        </div>

        <div class="card border-0 rounded-4 p-4 p-md-5">
            <div class="table-responsive">
                <table class="table table-borderless table-hover align-middle mb-0">
                    <thead class="text-muted small text-uppercase" style="letter-spacing: 1px;">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Username</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Role</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($data['users'] as $user) : ?>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td class="px-4 py-3 text-muted"><?= $no++; ?></td>
                            <td class="px-4 py-3 fw-bold text-light">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px;">
                                        <?= strtoupper(substr($user['username'], 0, 1)); ?>
                                    </div>
                                    <?= htmlspecialchars($user['username']); ?>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-muted"><?= htmlspecialchars($user['email']); ?></td>
                            <td class="px-4 py-3">
                                <?php if($user['role'] == 'admin'): ?>
                                    <span class="badge bg-danger text-white px-3 py-2 rounded-pill shadow-sm">Admin</span>
                                <?php elseif($user['role'] == 'mentor'): ?>
                                    <span class="badge text-white px-3 py-2 rounded-pill shadow-sm" style="background-color: #10b981 !important;">Mentor</span>
                                <?php else: ?>
                                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill shadow-sm">Student</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <?php if($user['id'] != $_SESSION['user_id']): ?>
                                    <button class="btn btn-sm btn-outline-info rounded-pill px-3 me-2 fw-bold" data-bs-toggle="modal" data-bs-target="#editRoleModal<?= $user['id']; ?>">
                                        <i class="bi bi-shield-lock me-1"></i> Role
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold" onclick="confirmDelete(<?= $user['id']; ?>, '<?= htmlspecialchars($user['username']); ?>')">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted small fst-italic">Akun Anda</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <?php if($user['id'] != $_SESSION['user_id']): ?>
                        <div class="modal fade" id="editRoleModal<?= $user['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content glass-card border-secondary text-light">
                                    <form action="<?= BASEURL; ?>/admin/change_role" method="POST">
                                        <div class="modal-header border-secondary p-4">
                                            <h5 class="modal-title fw-bold">Ubah Hak Akses</h5>
                                            <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <p class="text-muted mb-4">Pilih role baru untuk <strong><?= htmlspecialchars($user['username']); ?></strong>.</p>
                                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                            
                                            <div class="mb-3">
                                                <label class="form-label text-muted small fw-bold text-uppercase">Role Pengguna</label>
                                                <select class="form-select bg-white text-dark border-0 fw-bold" name="role" required>
                                                    <option value="student" <?= $user['role'] == 'student' ? 'selected' : ''; ?>>Student</option>
                                                    <option value="mentor" <?= $user['role'] == 'mentor' ? 'selected' : ''; ?>>Mentor</option>
                                                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-secondary p-4">
                                            <button type="button" class="btn btn-outline-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, username) {
    Swal.fire({
        title: 'Hapus Pengguna?',
        html: `Anda akan menghapus akun <strong>${username}</strong> secara permanen.`,
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
            window.location.href = '<?= BASEURL; ?>/admin/delete_user/' + id;
        }
    })
}
</script>