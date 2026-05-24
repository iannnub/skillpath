<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="mb-4">
            <a href="<?= BASEURL; ?>/mentor/manage/<?= $data['step']['roadmap_id']; ?>" class="text-decoration-none text-muted small fw-bold mb-3 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Materi
            </a>
            <h2 class="fw-bold text-light mb-1">Edit Materi</h2>
            <p class="text-muted">Perbarui konten, video, dan lampiran materi untuk langkah ini.</p>
        </div>

        <div class="card border-0 rounded-4 p-4 p-md-5">
            <form action="<?= BASEURL; ?>/mentor/update_step" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['step']['id']; ?>">
                <input type="hidden" name="roadmap_id" value="<?= $data['step']['roadmap_id']; ?>">
                
                <div class="form-floating mb-4">
                    <input type="text" name="title" class="form-control border-secondary" id="titleInput" placeholder="Judul Langkah" value="<?= htmlspecialchars($data['step']['title']); ?>" required>
                    <label for="titleInput">Judul Langkah Materi</label>
                </div>

                <div class="mb-4">
                    <label for="video_url" class="form-label text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">URL Video (YouTube/Vimeo)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-primary"><i class="bi bi-play-btn"></i></span>
                        <input type="url" name="video_url" class="form-control border-secondary bg-dark text-light" id="video_url" placeholder="https://www.youtube.com/watch?v=..." value="<?= htmlspecialchars($data['step']['video_url'] ?? ''); ?>">
                    </div>
                    <div class="form-text text-muted">Kosongkan jika materi ini hanya berupa teks/artikel.</div>
                </div>

                <div class="mb-4">
                    <label for="attachment" class="form-label text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">Update File Pendukung</label>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-dark border-secondary text-emerald"><i class="bi bi-cloud-arrow-up"></i></span>
                        <input type="file" name="attachment" class="form-control border-secondary bg-dark text-light" id="attachment">
                    </div>
                    <?php if(!empty($data['step']['attachment'])): ?>
                        <div class="d-flex align-items-center p-2 rounded-3 bg-primary bg-opacity-10 border border-primary border-opacity-25">
                            <i class="bi bi-file-earmark-check text-primary fs-5 me-2"></i>
                            <span class="text-light small">File saat ini: <strong><?= htmlspecialchars($data['step']['attachment']); ?></strong></span>
                        </div>
                    <?php else: ?>
                        <div class="form-text text-muted">Belum ada file terlampir. Dukungan format: PDF, ZIP, Source Code (Maks 5MB).</div>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-3" style="letter-spacing: 1px;">Konten Materi (Rich Text Editor)</label>
                    <textarea name="content" id="editor" required><?= htmlspecialchars($data['step']['content']); ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-4 border-top border-secondary">
                    <a href="<?= BASEURL; ?>/mentor/manage/<?= $data['step']['roadmap_id']; ?>" class="btn btn-outline-light rounded-pill px-4 fw-bold">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Inisialisasi CKEditor sesuai tema dark mode
    CKEDITOR.replace('editor', {
        height: 400,
        uiColor: '#1e1e1e',
        skin: 'moono-lisa',
        removeButtons: 'Print,NewPage,Preview,ExportPdf,Save'
    });
});
</script>