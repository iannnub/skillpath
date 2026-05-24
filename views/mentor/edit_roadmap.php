<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <a href="<?= BASEURL; ?>/mentor/dashboard" class="text-decoration-none text-muted small fw-bold mb-3 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
            <h2 class="fw-bold text-light mb-1">Edit Roadmap</h2>
            <p class="text-muted">Perbarui informasi dan detail roadmap Anda.</p>
        </div>

        <div class="card border-0 rounded-4 p-4 p-md-5">
            <form action="<?= BASEURL; ?>/mentor/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['roadmap']['id']; ?>">
                <input type="hidden" name="thumbnail_lama" value="<?= $data['roadmap']['thumbnail']; ?>">
                
                <div class="form-floating mb-4">
                    <input type="text" name="title" class="form-control border-secondary" id="titleInput" placeholder="Judul Roadmap" value="<?= htmlspecialchars($data['roadmap']['title']); ?>" required>
                    <label for="titleInput">Judul Roadmap</label>
                </div>

                <div class="form-floating mb-4">
                    <select name="category_id" class="form-select border-secondary" id="categorySelect" required>
                        <?php foreach($data['categories'] as $cat) : ?>
                            <option value="<?= $cat['id']; ?>" <?= ($cat['id'] == $data['roadmap']['category_id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="categorySelect">Kategori Roadmap</label>
                </div>

                <div class="form-floating mb-4">
                    <textarea name="description" class="form-control border-secondary" id="descInput" placeholder="Deskripsi" style="height: 120px" required><?= htmlspecialchars($data['roadmap']['description']); ?></textarea>
                    <label for="descInput">Deskripsi Singkat</label>
                </div>

                <div class="mb-5 row align-items-center">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <img src="<?= ASSET_BASEURL; ?>/assets/img/roadmaps/<?= $data['roadmap']['thumbnail']; ?>" class="img-thumbnail bg-dark border-secondary rounded-3 w-100 object-fit-cover" style="max-height: 100px;" alt="Current Thumbnail">
                    </div>
                    <div class="col-md-9">
                        <label class="form-label text-muted small fw-bold mb-2">Ganti Thumbnail Baru (Opsional, Maks 2MB)</label>
                        <input class="form-control border-secondary bg-dark text-light" type="file" name="thumbnail" accept="image/*">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-4 border-top border-secondary">
                    <a href="<?= BASEURL; ?>/mentor/dashboard" class="btn btn-outline-light rounded-pill px-4 fw-bold">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
                
            </form>
        </div>
    </div>
</div>