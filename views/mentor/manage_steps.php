<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="mb-4">
            <a href="<?= BASEURL; ?>/mentor/dashboard" class="text-decoration-none text-muted small fw-bold mb-3 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <div>
                    <h2 class="fw-bold text-light mb-1">Kelola Materi</h2>
                    <p class="text-muted mb-0">Roadmap: <strong class="text-primary"><?= htmlspecialchars($data['roadmap']['title']); ?></strong></p>
                </div>
                <div class="mt-3 mt-md-0">
                    <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addStepModal">
                        <i class="bi bi-plus-lg me-2"></i> Tambah Langkah Baru
                    </button>
                </div>
            </div>
        </div>

        <div class="card border-0 rounded-4 p-4 p-md-5">
            <?php if(empty($data['steps'])) : ?>
                <div class="text-center py-5 text-muted border border-secondary rounded-4" style="border-style: dashed !important;">
                    <i class="bi bi-journal-plus fs-1 d-block mb-3 opacity-50"></i>
                    <p class="mb-0">Belum ada langkah materi yang ditambahkan.</p>
                    <button class="btn btn-outline-primary mt-3 rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addStepModal">Buat Materi Pertama</button>
                </div>
            <?php else : ?>
                <div class="list-group list-group-flush border-top border-secondary pt-2">
                    <?php $i=1; foreach($data['steps'] as $step) : ?>
                        <div class="list-group-item bg-transparent border-bottom border-secondary py-4 px-0 d-flex flex-column flex-md-row align-items-md-center">
                            <div class="d-flex align-items-center mb-3 mb-md-0 flex-grow-1">
                                <div class="bg-dark text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center me-4 shadow-sm border border-secondary" style="width: 45px; height: 45px; min-width: 45px;">
                                    <?= $i++; ?>
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-bold text-light"><?= htmlspecialchars($step['title']); ?></h5>
                                    <p class="mb-0 text-muted small">ID Langkah: <?= $step['id']; ?></p>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 ms-md-auto ps-5 ps-md-0 align-items-center">
                                <a href="<?= BASEURL; ?>/mentor/quiz/<?= $step['id']; ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold">
                                    <i class="bi bi-patch-question me-1"></i> Kuis
                                </a>
                                
                                <a href="<?= BASEURL; ?>/mentor/edit_step/<?= $step['id']; ?>" class="btn btn-sm btn-outline-info rounded-pill px-3 fw-bold">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>
                                
                                <button class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold" onclick="confirmDeleteStep(<?= $step['id']; ?>, <?= $data['roadmap']['id']; ?>, '<?= htmlspecialchars(addslashes($step['title'])); ?>')">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </div>
                            </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="addStepModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card border-secondary rounded-4">
            <form action="<?= BASEURL; ?>/mentor/store_step" method="post" enctype="multipart/form-data">
                <div class="modal-header border-secondary p-4">
                    <h5 class="modal-title fw-bold text-light">Tambah Langkah Materi Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-light">
                    <input type="hidden" name="roadmap_id" value="<?= $data['roadmap']['id']; ?>">
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Materi</label>
                        <input type="text" class="form-control bg-dark border-secondary text-light" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="video_url" class="form-label">URL Video (YouTube/Vimeo)</label>
                        <input type="url" class="form-control bg-dark border-secondary text-light" id="video_url" name="video_url" placeholder="https://www.youtube.com/watch?v=...">
                        <div class="form-text text-muted small">Kosongkan jika materi hanya berupa teks.</div>
                    </div>

                    <div class="mb-3">
                        <label for="attachment" class="form-label">File Pendukung (PDF/ZIP/Source Code)</label>
                        <input type="file" class="form-control bg-dark border-secondary text-light" id="attachment" name="attachment">
                        <div class="form-text text-muted small">Maksimal 5MB.</div>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Konten Materi</label>
                        <textarea class="form-control" id="editor" name="content"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Simpan Materi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Init CKEditor untuk Modal
document.addEventListener("DOMContentLoaded", function() {
    CKEDITOR.replace('editor', {
        height: 250,
        uiColor: '#1e1e1e',
        skin: 'moono-lisa'
    });
});

function confirmDeleteStep(id, roadmap_id, title) {
    Swal.fire({
        title: 'Hapus Materi?',
        html: `Langkah <strong>${title}</strong> akan dihapus permanen.`,
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
            window.location.href = `<?= BASEURL; ?>/mentor/delete_step/${id}/${roadmap_id}`;
        }
    })
}
</script>