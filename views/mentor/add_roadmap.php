<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <a href="<?= BASEURL; ?>/mentor/dashboard" class="text-decoration-none text-muted small fw-bold mb-3 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
            <h2 class="fw-bold text-light mb-1">Buat Roadmap Baru</h2>
            <p class="text-muted">Desain jalur belajar baru untuk membantu siswa mencapai tujuannya.</p>
        </div>

        <div class="card border-0 rounded-4 p-4 p-md-5">
            <form action="<?= BASEURL; ?>/mentor/store" method="POST" enctype="multipart/form-data">
                
                <div class="form-floating mb-4">
                    <input type="text" name="title" class="form-control border-secondary" id="titleInput" placeholder="Judul Roadmap" required>
                    <label for="titleInput">Judul Roadmap</label>
                </div>

                <div class="form-floating mb-4">
                    <select name="category_id" class="form-select border-secondary bg-dark text-light" id="categorySelect" required>
                        <option value="" disabled selected class="bg-dark text-muted">Pilih Kategori</option>
                        <?php foreach($data['categories'] as $cat) : ?>
                            <option value="<?= $cat['id']; ?>" class="bg-dark text-white">
                                <?= htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="categorySelect" class="text-muted">Kategori Roadmap</label>
                </div>

                <div class="form-floating mb-4">
                    <textarea name="description" class="form-control border-secondary" id="descInput" placeholder="Deskripsi" style="height: 120px" required></textarea>
                    <label for="descInput">Deskripsi Singkat</label>
                </div>

                <div class="mb-5">
                    <label class="form-label text-muted small fw-bold mb-2">Upload Thumbnail (Maks 2MB)</label>
                    <input class="form-control border-secondary bg-dark text-light" type="file" name="thumbnail" accept="image/*">
                </div>

                <div class="d-flex justify-content-end gap-3 pt-4 border-top border-secondary">
                    <a href="<?= BASEURL; ?>/mentor/dashboard" class="btn btn-outline-light rounded-pill px-4 fw-bold">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan Roadmap
                    </button>
                </div>
                
            </form>
        </div>
    </div>
</div>