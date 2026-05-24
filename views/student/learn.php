<div class="container-fluid px-0" style="margin-top: -1.5rem;">
    <div class="row g-0" style="min-height: calc(100vh - 76px);">
        <div class="col-lg-3 col-xl-2 border-end border-secondary d-none d-lg-block" style="background-color: var(--bg-card);">
            <div class="d-flex flex-column h-100 position-sticky" style="top: 76px; height: calc(100vh - 76px); overflow-y: auto;">
                <div class="p-4 border-bottom border-secondary">
                    <a href="<?= BASEURL; ?>/student/dashboard" class="text-decoration-none text-muted small fw-bold mb-3 d-inline-block">
                        <i class="bi bi-arrow-left me-1"></i> Dashboard
                    </a>
                    <h6 class="fw-bold text-light mb-3 lh-base"><?= htmlspecialchars($data['roadmap']['title']); ?></h6>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small fw-bold">Progres</span>
                        <span class="fw-bold <?= $data['progress'] == 100 ? 'text-emerald' : 'text-primary' ?> small"><?= $data['progress']; ?>%</span>
                    </div>
                    <div class="progress bg-dark border border-secondary" style="height: 6px;">
                        <div class="progress-bar <?= $data['progress'] == 100 ? 'bg-emerald' : '' ?>" style="width: <?= $data['progress']; ?>%"></div>
                    </div>
                </div>

                <div class="p-3 flex-grow-1">
                    <div class="text-uppercase text-muted small fw-bold mb-3 ps-2" style="letter-spacing: 1px;">Kurikulum</div>
                    <div class="list-group list-group-flush gap-1">
                        <?php $i=1; foreach($data['steps'] as $step) : 
                            $isActive = ($step['id'] == $data['current_step']['id']) ? 'active bg-primary bg-opacity-10 text-primary border border-primary' : 'bg-transparent text-light border border-transparent';
                        ?>
                            <a href="<?= BASEURL; ?>/student/learn/<?= $data['roadmap']['id']; ?>/<?= $step['id']; ?>" 
                               class="list-group-item list-group-item-action rounded-3 p-3 d-flex align-items-start <?= $isActive; ?>" style="transition: all 0.2s;">
                                <div class="me-3 mt-1">
                                    <?php if(isset($step['is_completed']) && $step['is_completed']): ?>
                                        <i class="bi bi-check-circle-fill text-emerald fs-5"></i>
                                    <?php else: ?>
                                        <div class="rounded-circle border border-secondary text-muted d-flex align-items-center justify-content-center small" style="width: 24px; height: 24px;">
                                            <?= $i; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="fw-medium small lh-base"><?= htmlspecialchars($step['title']); ?></div>
                            </a>
                        <?php $i++; endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-xl-10 bg-dark">
            <div class="d-lg-none bg-card p-3 border-bottom border-secondary sticky-top" style="top: 76px; z-index: 1020;">
                <button class="btn btn-outline-light w-100 d-flex justify-content-between align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
                    <span><i class="bi bi-list me-2"></i> Daftar Materi</span>
                    <span class="badge <?= $data['progress'] == 100 ? 'bg-emerald' : 'bg-primary' ?>"><?= $data['progress']; ?>%</span>
                </button>
            </div>

            <div class="p-4 p-md-5 mx-auto" style="max-width: 900px;">
                <div class="mb-5">
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill mb-3 fw-bold">Topik Pembahasan</span>
                    <h1 class="fw-bolder text-light mb-4 display-5" style="letter-spacing: -0.5px;"><?= htmlspecialchars($data['current_step']['title']); ?></h1>
                    <hr class="border-secondary mb-5 opacity-25">
                </div>

                <?php if (!empty($data['current_step']['video_url'])) : 
                    $video_id = "";
                    if (preg_match('/(vx|v=)([^&]+)/', $data['current_step']['video_url'], $matches)) {
                        $video_id = $matches[2];
                    } elseif (preg_match('/embed\/([^?]+)/', $data['current_step']['video_url'], $matches)) {
                        $video_id = $matches[1];
                    } elseif (preg_match('/youtu.be\/([^?]+)/', $data['current_step']['video_url'], $matches)) {
                        $video_id = $matches[1];
                    }
                ?>
                    <?php if ($video_id) : ?>
                        <div class="ratio ratio-16x9 mb-5 shadow-lg rounded-4 overflow-hidden border border-secondary">
                            <iframe src="https://www.youtube.com/embed/<?= $video_id; ?>" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="materi-content text-light fs-5" style="line-height: 1.8; letter-spacing: 0.2px;">
                    <?= $data['current_step']['content']; ?>
                </div>

                <?php if (!empty($data['current_step']['attachment'])) : ?>
                    <div class="card border-primary bg-primary bg-opacity-10 rounded-4 p-4 mt-5 mb-5 border-opacity-25">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-3 p-3 me-3">
                                    <i class="bi bi-file-earmark-arrow-down fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-light mb-1">Materi Pendukung Tersedia</h6>
                                    <p class="text-muted small mb-0">Unduh file lampiran untuk menunjang pembelajaran.</p>
                                </div>
                            </div>
                            <a href="<?= ASSET_BASEURL; ?>/assets/uploads/<?= $data['current_step']['attachment']; ?>" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" download>
                                <i class="bi bi-download me-2"></i> Unduh File
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <hr class="border-secondary my-5 opacity-25">

                <div class="mt-5 mb-5">
                    <h4 class="fw-bold text-light mb-4"><i class="bi bi-chat-left-text text-primary me-2"></i> Diskusi Materi</h4>
                    
                    <div class="card glass-card border-secondary border-opacity-25 p-4 mb-4">
                        <form action="<?= BASEURL; ?>/student/add_comment" method="POST">
                            <input type="hidden" name="step_id" value="<?= $data['current_step']['id']; ?>">
                            <input type="hidden" name="roadmap_id" value="<?= $data['roadmap']['id']; ?>">
                            <div class="mb-3">
                                <textarea name="message" class="form-control bg-dark border-secondary text-light shadow-none" rows="3" placeholder="Tanyakan sesuatu tentang materi ini..." required></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Kirim Pertanyaan</button>
                            </div>
                        </form>
                    </div>

                    <div class="discussion-list">
                        <?php 
                            $comments = $this->model('StepModel')->getCommentsByStep($data['current_step']['id']);
                            if (empty($comments)) : 
                        ?>
                            <div class="text-center py-4 rounded-4 border border-secondary border-opacity-25" style="border-style: dashed !important;">
                                <p class="text-muted small fst-italic mb-0">Belum ada diskusi di materi ini. Jadilah yang pertama bertanya!</p>
                            </div>
                        <?php else : ?>
                            <?php foreach ($comments as $c) : ?>
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0">
                                        <div class="bg-<?= $c['role'] == 'mentor' ? 'emerald' : 'primary'; ?> text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 40px; height: 40px;">
                                            <?= strtoupper(substr($c['username'], 0, 1)); ?>
                                        </div>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <div class="bg-card border border-secondary border-opacity-25 rounded-4 p-3 shadow-sm" style="background-color: rgba(255,255,255,0.02);">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-bold <?= $c['role'] == 'mentor' ? 'text-emerald' : 'text-light'; ?> small">
                                                    <?= htmlspecialchars($c['username']); ?> 
                                                    <?= $c['role'] == 'mentor' ? '<span class="badge bg-emerald bg-opacity-10 text-emerald ms-1" style="font-size: 0.6rem;">Mentor</span>' : ''; ?>
                                                </span>
                                                <span class="text-muted" style="font-size: 0.7rem;"><?= date('d M, H:i', strtotime($c['created_at'])); ?></span>
                                            </div>
                                            <p class="text-muted small mb-0" style="line-height: 1.5;"><?= nl2br(htmlspecialchars($c['message'])); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <hr class="border-secondary my-5 opacity-25">

                <div class="card border-secondary bg-transparent rounded-4 p-4 p-md-5 text-center shadow-sm">
                    <?php 
                        $quizModel = $this->model('QuizModel');
                        $hasQuiz = $quizModel->getQuizByStep($data['current_step']['id']);
                    ?>

                    <?php if($data['is_completed']) : ?>
                        <div class="mb-4">
                            <div class="bg-emerald bg-opacity-10 text-emerald rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-check-lg fs-1"></i>
                            </div>
                            <h4 class="fw-bold text-light">Materi Diselesaikan!</h4>
                            <p class="text-muted">Kamu sudah menguasai materi ini.</p>
                        </div>
                        <a href="<?= BASEURL; ?>/student/dashboard" class="btn btn-outline-light rounded-pill px-5 py-3 fw-bold">
                            Kembali ke Dashboard
                        </a>
                    <?php else : ?>
                        <div class="mb-4">
                            <h4 class="fw-bold text-light"><?= $hasQuiz ? 'Uji Pemahamanmu' : 'Sudah Paham?'; ?></h4>
                            <p class="text-muted"><?= $hasQuiz ? 'Selesaikan kuis untuk menandai materi ini selesai.' : 'Tandai selesai untuk menyimpan progres belajarmu.'; ?></p>
                        </div>

                        <?php if($hasQuiz) : ?>
                            <a href="<?= BASEURL; ?>/student/quiz/<?= $data['current_step']['id']; ?>" 
                               class="btn btn-warning rounded-pill px-5 py-3 fw-bold shadow-lg d-inline-flex align-items-center fs-5 text-dark">
                                <i class="bi bi-pencil-square me-2"></i> Mulai Kuis Materi
                            </a>
                        <?php else : ?>
                            <a href="<?= BASEURL; ?>/student/complete/<?= $data['roadmap']['id']; ?>/<?= $data['current_step']['id']; ?>" 
                               class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-lg d-inline-flex align-items-center fs-5">
                                <i class="bi bi-check-circle-fill me-2"></i> Tandai Selesai & Lanjut
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start bg-dark border-secondary text-light" tabindex="-1" id="sidebarMobile">
    <div class="offcanvas-header border-bottom border-secondary p-4">
        <h5 class="offcanvas-title fw-bold">Daftar Langkah</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-3">
        <div class="list-group list-group-flush gap-2">
            <?php $i=1; foreach($data['steps'] as $step) : 
                $isActive = ($step['id'] == $data['current_step']['id']) ? 'active bg-primary bg-opacity-10 text-primary border border-primary' : 'bg-transparent text-light border border-secondary';
            ?>
                <a href="<?= BASEURL; ?>/student/learn/<?= $data['roadmap']['id']; ?>/<?= $step['id']; ?>" 
                   class="list-group-item list-group-item-action rounded-3 p-3 d-flex align-items-center <?= $isActive; ?>">
                    <?php if(isset($step['is_completed']) && $step['is_completed']): ?>
                        <i class="bi bi-check-circle-fill text-emerald me-3 fs-5"></i>
                    <?php else: ?>
                        <span class="text-muted me-3 fw-bold"><?= $i; ?></span>
                    <?php endif; ?>
                    <span class="fw-medium"><?= htmlspecialchars($step['title']); ?></span>
                </a>
            <?php $i++; endforeach; ?>
        </div>
    </div>
</div>

<style>
    /* Styling khusus materi agar tetap rapi di Dark Mode */
    .materi-content img {
        max-width: 100%;
        height: auto;
        border-radius: 16px;
        margin: 2rem 0;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
    }
    .materi-content h1, .materi-content h2, .materi-content h3 {
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #fff;
    }
    .materi-content a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }
    .materi-content a:hover {
        text-decoration: underline;
    }
    .materi-content pre {
        background-color: #121419;
        padding: 1.5rem;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        overflow-x: auto;
        margin: 1.5rem 0;
    }
    .materi-content code {
        font-family: 'Courier New', Courier, monospace;
        color: #66d9ef;
    }
    .materi-content blockquote {
        border-left: 4px solid var(--primary-color);
        background: rgba(13, 110, 253, 0.05);
        padding: 1rem 1.5rem;
        border-radius: 0 12px 12px 0;
        margin: 1.5rem 0;
        color: var(--text-muted);
        font-style: italic;
    }
    .materi-content ul, .materi-content ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    .materi-content li {
        margin-bottom: 0.5rem;
    }
</style>