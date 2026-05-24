<div class="row justify-content-center">
    <div class="col-lg-10">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent px-0 m-0">
                <li class="breadcrumb-item"><a href="<?= BASEURL; ?>/student/catalog" class="text-muted text-decoration-none"><i class="bi bi-house me-1"></i>Katalog</a></li>
                <li class="breadcrumb-item active text-light fw-bold" aria-current="page"><?= htmlspecialchars($data['roadmap']['title']); ?></li>
            </ol>
        </nav>

        <div class="card border-0 rounded-4 shadow-lg mb-5 overflow-hidden" style="background: linear-gradient(135deg, var(--bg-card), #121419);">
            <div class="row g-0 align-items-center">
                <div class="col-md-5 position-relative">
                    <img src="<?= ASSET_BASEURL; ?>/assets/img/roadmaps/<?= $data['roadmap']['thumbnail']; ?>" class="img-fluid w-100 object-fit-cover" style="min-height: 100%; aspect-ratio: 4/3;" alt="Thumbnail">
                </div>
                <div class="col-md-7 p-4 p-md-5 d-flex flex-column justify-content-center h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h1 class="fw-bolder display-6 mb-0 text-light" style="line-height: 1.2;"><?= htmlspecialchars($data['roadmap']['title']); ?></h1>
                        <?php 
                            $stats = $this->model('RoadmapModel')->getAverageRating($data['roadmap']['id']);
                            if($stats['total_reviews'] > 0) : 
                        ?>
                            <div class="badge bg-warning text-dark rounded-pill px-3 py-2 d-flex align-items-center fw-bold">
                                <i class="bi bi-star-fill me-1"></i> <?= round($stats['avg_rating'], 1); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <p class="text-muted fs-6 mb-4 lh-lg"><?= htmlspecialchars($data['roadmap']['description']); ?></p>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-light rounded-circle d-flex align-items-center justify-content-center fs-5 fw-bold me-3" style="width: 48px; height: 48px;">
                            <?= strtoupper(substr($data['roadmap']['mentor_name'] ?? 'M', 0, 1)); ?>
                        </div>
                        <div>
                            <p class="text-muted small mb-0">Disusun oleh Mentor</p>
                            <p class="fw-bold text-light mb-0"><?= htmlspecialchars($data['roadmap']['mentor_name'] ?? 'SkillPath Expert'); ?></p>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <?php if($data['isEnrolled']) : ?>
                            <a href="<?= BASEURL; ?>/student/learn/<?= $data['roadmap']['id']; ?>" class="btn btn-success rounded-pill px-5 py-3 fw-bold shadow-sm d-inline-flex align-items-center w-100 w-md-auto justify-content-center fs-5">
                                <i class="bi bi-play-fill me-2 fs-4"></i> Lanjut Belajar
                            </a>
                        <?php else : ?>
                            <a href="<?= BASEURL; ?>/student/enroll/<?= $data['roadmap']['id']; ?>" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm d-inline-flex align-items-center w-100 w-md-auto justify-content-center fs-5">
                                <i class="bi bi-rocket-takeoff-fill me-2 fs-4"></i> Ikuti Roadmap Ini
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="fw-bold mb-4 text-light"><i class="bi bi-card-list text-primary me-2"></i> Kurikulum Belajar</h4>
        <div class="card border-0 rounded-4 p-4 p-md-5 mb-5">
            <?php if(empty($data['steps'])) : ?>
                <div class="text-center py-5 text-muted border border-secondary rounded-4" style="border-style: dashed !important;">
                    <i class="bi bi-journal-x fs-1 d-block mb-3 opacity-50"></i>
                    <p class="mb-0">Materi belum ditambahkan ke dalam roadmap ini.</p>
                </div>
            <?php else : ?>
                <div class="list-group list-group-flush">
                    <?php $i=1; foreach($data['steps'] as $step) : ?>
                        <div class="list-group-item bg-transparent border-bottom border-secondary py-4 px-0 d-flex align-items-center">
                            <div class="bg-dark text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center me-4 shadow-sm border border-secondary" style="width: 45px; height: 45px; min-width: 45px;">
                                <?= $i++; ?>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1 fw-bold text-light"><?= htmlspecialchars($step['title']); ?></h5>
                                <p class="mb-0 text-muted small">Materi Teori & Praktek</p>
                            </div>
                            <div class="ms-3 text-muted d-none d-md-block fs-4">
                                <?= $data['isEnrolled'] ? '<i class="bi bi-unlock-fill text-success"></i>' : '<i class="bi bi-lock-fill"></i>'; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <h4 class="fw-bold mb-4 text-light mt-5"><i class="bi bi-star-fill text-warning me-2"></i> Apa Kata Mereka?</h4>
        <div class="row g-4 mb-5">
            <?php 
                $reviews = $this->model('RoadmapModel')->getReviewsByRoadmap($data['roadmap']['id']);
                if(empty($reviews)) : 
            ?>
                <div class="col-12 text-center py-4 card glass-card border-secondary border-opacity-25">
                    <p class="text-muted fst-italic mb-0">Belum ada ulasan untuk roadmap ini. Jadilah yang pertama memberikan kesan!</p>
                </div>
            <?php else : ?>
                <?php foreach($reviews as $rev) : ?>
                    <div class="col-md-6">
                        <div class="card glass-card border-secondary p-4 h-100 shadow-sm border-opacity-25">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                        <?= strtoupper(substr($rev['username'], 0, 1)); ?>
                                    </div>
                                    <div>
                                        <div class="text-light fw-bold small"><?= htmlspecialchars($rev['username']); ?></div>
                                        <div class="text-muted" style="font-size: 0.7rem;"><?= date('d M Y', strtotime($rev['created_at'])); ?></div>
                                    </div>
                                </div>
                                <div class="text-warning small">
                                    <?php for($i=1; $i<=5; $i++) : ?>
                                        <i class="bi bi-star<?= ($i <= $rev['rating']) ? '-fill' : ''; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="text-light small mb-0" style="line-height: 1.6; font-style: italic;">"<?= htmlspecialchars($rev['comment']); ?>"</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>