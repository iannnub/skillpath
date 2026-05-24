<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="mb-4">
            <a href="<?= BASEURL; ?>/mentor/manage/<?= $data['step']['roadmap_id']; ?>" class="text-decoration-none text-muted small fw-bold mb-3 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Materi
            </a>
            <h2 class="fw-bold text-light mb-1">Manajemen Kuis</h2>
            <p class="text-muted">Materi: <strong class="text-primary"><?= htmlspecialchars($data['step']['title']); ?></strong></p>
        </div>

        <?php if (!$data['quiz']) : ?>
            <div class="card glass-card border-0 rounded-4 p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-patch-question text-primary display-4 mb-3 d-block"></i>
                    <h4 class="fw-bold text-light">Belum Ada Kuis</h4>
                    <p class="text-muted">Aktifkan kuis untuk materi ini agar student bisa menguji pemahaman mereka.</p>
                </div>
                <form action="<?= BASEURL; ?>/mentor/store_quiz" method="POST">
                    <input type="hidden" name="step_id" value="<?= $data['step']['id']; ?>">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Judul Kuis</label>
                        <input type="text" name="title" class="form-control bg-dark border-secondary text-light" placeholder="Contoh: Kuis Dasar PHP" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Deskripsi Singkat</label>
                        <textarea name="description" class="form-control bg-dark border-secondary text-light" rows="2"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Skor Kelulusan Minimal (0-100)</label>
                        <input type="number" name="min_score" class="form-control bg-dark border-secondary text-light" value="70" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm">
                        Buat Kuis Sekarang
                    </button>
                </form>
            </div>
        <?php else : ?>
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card border-0 rounded-4 p-4 shadow-sm" style="background: linear-gradient(135deg, #181b21, #121419);">
                        <h6 class="text-muted small fw-bold text-uppercase mb-2">Skor Minimal</h6>
                        <h2 class="text-primary fw-bolder mb-0"><?= $data['quiz']['min_score']; ?>%</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 rounded-4 p-4 shadow-sm" style="background: linear-gradient(135deg, #181b21, #121419);">
                        <h6 class="text-muted small fw-bold text-uppercase mb-2">Total Pertanyaan</h6>
                        <h2 class="text-emerald fw-bolder mb-0"><?= count($data['questions'] ?? []); ?> Soal</h2>
                    </div>
                </div>
            </div>

            <div class="card border-0 rounded-4 p-4 p-md-5 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-light mb-0">Daftar Pertanyaan</h5>
                    <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Soal
                    </button>
                </div>

                <div class="list-group list-group-flush border-top border-secondary pt-2">
                    <?php if (empty($data['questions'])) : ?>
                        <p class="text-center text-muted py-4">Belum ada pertanyaan. Silakan tambah pertanyaan pertama Anda.</p>
                    <?php else : ?>
                        <?php $no = 1; foreach ($data['questions'] as $q) : ?>
                            <div class="list-group-item bg-transparent border-bottom border-secondary py-4 px-0">
                                <h6 class="fw-bold text-light mb-3"><?= $no++; ?>. <?= htmlspecialchars($q['question_text']); ?></h6>
                                <div class="row g-2">
                                    <?php foreach (['A', 'B', 'C', 'D'] as $opt) : 
                                        $isCorrect = ($q['correct_answer'] == $opt);
                                    ?>
                                        <div class="col-md-6">
                                            <div class="p-2 px-3 rounded-3 border <?= $isCorrect ? 'border-emerald bg-emerald bg-opacity-10 text-emerald' : 'border-secondary text-muted'; ?> small">
                                                <strong><?= $opt; ?>.</strong> <?= htmlspecialchars($q['option_'.strtolower($opt)]); ?>
                                                <?= $isCorrect ? '<i class="bi bi-check-circle-fill ms-2"></i>' : ''; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="addQuestionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card border-secondary rounded-4">
            <form action="<?= BASEURL; ?>/mentor/store_question" method="POST">
                <div class="modal-header border-secondary p-4">
                    <h5 class="modal-title fw-bold text-light">Tambah Soal Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="quiz_id" value="<?= $data['quiz']['id']; ?>">
                    <input type="hidden" name="step_id" value="<?= $data['step']['id']; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Pertanyaan</label>
                        <textarea name="question_text" class="form-control bg-dark border-secondary text-light" rows="3" required></textarea>
                    </div>
                    <div class="row g-3 mb-4">
                        <?php foreach (['A', 'B', 'C', 'D'] as $opt) : ?>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Opsi <?= $opt; ?></label>
                                <input type="text" name="option_<?= strtolower($opt); ?>" class="form-control bg-dark border-secondary text-light" required>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div>
                        <label class="form-label text-muted small fw-bold">Jawaban Benar</label>
                        <select name="correct_answer" class="form-select bg-dark border-secondary text-light" required>
                            <option value="A">Opsi A</option>
                            <option value="B">Opsi B</option>
                            <option value="C">Opsi C</option>
                            <option value="D">Opsi D</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-secondary p-4">
                    <button type="button" class="btn btn-outline-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">Simpan Soal</button>
                </div>
            </form>
        </div>
    </div>
</div>