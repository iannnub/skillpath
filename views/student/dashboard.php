<div class="row g-4">
    <div class="col-lg-3 col-xl-2 d-none d-lg-block">
        <div class="sidebar rounded-4 p-3 shadow-sm sticky-top" style="top: 100px;">
            <div class="text-muted small fw-bold mb-3 ms-2 text-uppercase" style="letter-spacing: 1px;">Menu Belajar</div>
            <div class="nav flex-column nav-pills">
                <a class="nav-link active d-flex align-items-center" href="<?= BASEURL; ?>/student/dashboard">
                    <i class="bi bi-grid-1x2 me-3 fs-5"></i> Dashboard
                </a>
                <a class="nav-link d-flex align-items-center" href="<?= BASEURL; ?>/student/catalog">
                    <i class="bi bi-compass me-3 fs-5"></i> Katalog
                </a>
                <a class="nav-link d-flex align-items-center mt-4 text-danger" href="<?= BASEURL; ?>/auth/logout">
                    <i class="bi bi-box-arrow-right me-3 fs-5"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-xl-10">
        <div class="card border-0 rounded-4 p-4 p-md-5 mb-5 shadow-sm" style="background: linear-gradient(135deg, var(--bg-card), #121419);">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bolder display-6 mb-2 text-light">Halo, <span class="text-primary"><?= htmlspecialchars($_SESSION['username']); ?></span>! 👋</h2>
                    <p class="text-muted fs-5 mb-0">Lanjutkan belajarmu hari ini dan capai target barumu.</p>
                </div>
                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                    <a href="<?= BASEURL; ?>/student/catalog" class="btn btn-primary rounded-pill px-4 py-3 fw-bold shadow-sm d-inline-flex align-items-center">
                        <i class="bi bi-search me-2"></i> Eksplor Materi Baru
                    </a>
                </div>
            </div>
        </div>

        <h4 class="fw-bold mb-4 text-light"><i class="bi bi-journal-bookmark-fill text-primary me-2"></i> Roadmap yang Saya Ikuti</h4>

        <div class="row g-4">
            <?php if(empty($data['enrolled_roadmaps'])) : ?>
                <div class="col-12">
                    <div class="text-center py-5 text-muted border border-secondary rounded-4" style="border-style: dashed !important;">
                        <i class="bi bi-journal-x fs-1 d-block mb-3 opacity-50"></i>
                        <h5 class="text-light">Kamu belum mengikuti roadmap apapun.</h5>
                        <p class="mb-4">Eksplorasi katalog untuk menemukan alur belajar yang tepat untukmu.</p>
                        <a href="<?= BASEURL; ?>/student/catalog" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Lihat Katalog</a>
                    </div>
                </div>
            <?php else : ?>
                <?php foreach($data['enrolled_roadmaps'] as $rm) : ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-hover border-0 h-100 p-2 pb-0">
                        <div class="position-relative overflow-hidden rounded-4 mb-3">
                            <img src="<?= ASSET_BASEURL; ?>/assets/img/roadmaps/<?= $rm['thumbnail']; ?>" class="w-100 object-fit-cover" alt="Thumbnail" style="aspect-ratio: 16/9;">
                            <?php if($rm['user_progress'] == 100) : ?>
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-emerald px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-check-circle-fill me-1"></i> Selesai</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body px-3 pb-4 d-flex flex-column">
                            <h5 class="fw-bold text-light mb-4 line-clamp-2"><?= htmlspecialchars($rm['title']); ?></h5>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small fw-semibold">Progres Penyelesaian</span>
                                    <span class="fw-bold <?= $rm['user_progress'] == 100 ? 'text-emerald' : 'text-primary'; ?>"><?= $rm['user_progress']; ?>% Selesai</span>
                                </div>
                                <div class="progress mb-4 bg-dark border border-secondary" style="height: 10px;">
                                    <div class="progress-bar <?= $rm['user_progress'] == 100 ? 'bg-emerald' : 'progress-bar-striped progress-bar-animated'; ?>" 
                                         role="progressbar" 
                                         style="width: <?= $rm['user_progress']; ?>%"></div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="<?= BASEURL; ?>/student/learn/<?= $rm['id']; ?>" class="btn btn-primary rounded-pill fw-bold shadow-sm">
                                        Lanjut Belajar <i class="bi bi-arrow-right ms-1"></i>
                                    </a>

                                    <?php if($rm['user_progress'] == 100) : ?>
                                        <a href="<?= BASEURL; ?>/student/certificate/<?= $rm['id']; ?>" target="_blank" class="btn btn-sm btn-emerald w-100 rounded-pill fw-bold">
                                            <i class="bi bi-award me-1"></i> Sertifikat
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>