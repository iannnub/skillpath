<div class="row mb-5 justify-content-center text-center">
    <div class="col-md-8">
        <h1 class="fw-bold display-5 mb-3">Eksplorasi <span class="text-primary">Roadmap</span></h1>
        <p class="text-muted fs-5">Pilih jalur belajarmu dan tingkatkan skill dengan kurikulum terarah dari mentor profesional.</p>
    </div>
</div>

<div class="row justify-content-center mb-5">
    <div class="col-lg-8">
        <form action="<?= BASEURL; ?>/student/catalog" method="GET" class="card glass-card border-0 rounded-pill p-2 shadow-lg">
            <div class="row g-0">
                <div class="col-md-5 border-end border-secondary">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 text-muted ps-4"><i class="bi bi-search"></i></span>
                        <input type="text" name="keyword" class="form-control border-0 bg-transparent text-light shadow-none py-3" placeholder="Cari judul / mentor..." value="<?= htmlspecialchars($data['keyword'] ?? ''); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 text-muted ps-4"><i class="bi bi-funnel"></i></span>
                        <select name="category" class="form-select border-0 bg-transparent text-light shadow-none py-3" style="cursor: pointer;">
                            <option class="bg-dark" value="">Semua Kategori</option>
                            <?php foreach($data['categories'] as $cat) : ?>
                                <option class="bg-dark" value="<?= $cat['id']; ?>" <?= ($data['current_category'] == $cat['id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill h-100 fw-bold shadow-sm">Temukan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    <?php if(empty($data['roadmaps'])) : ?>
        <div class="col-12 text-center py-5">
            <div class="bg-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-4 border border-secondary" style="width: 100px; height: 100px;">
                <i class="bi bi-search text-muted fs-1"></i>
            </div>
            <h4 class="fw-bold text-light">Tidak menemukan hasil.</h4>
            <p class="text-muted">Coba ubah kata kunci pencarian atau filter kategori Anda.</p>
        </div>
    <?php else : ?>
        <?php foreach($data['roadmaps'] as $rm) : ?>
        <div class="col-md-6 col-lg-4">
            <div class="card card-hover border-0 h-100 p-2 pb-0">
                <div class="position-relative overflow-hidden rounded-4 mb-3">
                    <img src="<?= ASSET_BASEURL; ?>/assets/img/roadmaps/<?= $rm['thumbnail']; ?>" class="w-100 object-fit-cover" alt="<?= htmlspecialchars($rm['title']); ?>" style="aspect-ratio: 16/9; transition: transform 0.5s;">
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-tag-fill me-1"></i> <?= htmlspecialchars($rm['category_name']); ?></span>
                    </div>
                </div>
                <div class="card-body px-3 pb-4 d-flex flex-column">
                    <h5 class="fw-bold text-light mb-2 line-clamp-2"><?= htmlspecialchars($rm['title']); ?></h5>
                    <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        <?= htmlspecialchars($rm['description']); ?>
                    </p>
                    
                    <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top border-secondary">
                        <div class="d-flex align-items-center">
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 32px; height: 32px;">
                                <?= strtoupper(substr($rm['mentor_name'], 0, 1)); ?>
                            </div>
                            <span class="text-muted small fw-semibold"><?= htmlspecialchars($rm['mentor_name']); ?></span>
                        </div>
                        <a href="<?= BASEURL; ?>/student/detail/<?= $rm['id']; ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">Detail</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>