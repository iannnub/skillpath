<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                <a href="<?= BASEURL; ?>/student/learn/<?= $data['step']['roadmap_id']; ?>/<?= $data['step']['id']; ?>" class="text-decoration-none text-muted small fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Materi
                </a>
                <h2 class="fw-bold text-light mt-2"><?= htmlspecialchars($data['quiz']['title']); ?></h2>
                <p class="text-muted"><?= htmlspecialchars($data['quiz']['description']); ?></p>
            </div>

            <div class="card glass-card border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-light fw-bold"><i class="bi bi-info-circle me-2"></i> Aturan Kuis</span>
                        <span class="badge bg-primary px-3 py-2 rounded-pill">Kriteria Lulus: <?= $data['quiz']['min_score']; ?>%</span>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="<?= BASEURL; ?>/student/submit_quiz" method="POST">
                        <input type="hidden" name="quiz_id" value="<?= $data['quiz']['id']; ?>">
                        <input type="hidden" name="step_id" value="<?= $data['step']['id']; ?>">
                        <input type="hidden" name="roadmap_id" value="<?= $data['step']['roadmap_id']; ?>">

                        <?php $no = 1; foreach ($data['questions'] as $q) : ?>
                            <div class="mb-5">
                                <h5 class="text-light fw-bold mb-4"><?= $no++; ?>. <?= htmlspecialchars($q['question_text']); ?></h5>
                                <div class="row g-3">
                                    <?php foreach (['A', 'B', 'C', 'D'] as $opt) : ?>
                                        <div class="col-12">
                                            <input type="radio" class="btn-check" name="question_<?= $q['id']; ?>" id="q<?= $q['id'] . $opt; ?>" value="<?= $opt; ?>" required>
                                            <label class="btn btn-outline-secondary w-100 text-start p-3 rounded-3 shadow-none border-secondary border-opacity-25 quiz-option" for="q<?= $q['id'] . $opt; ?>">
                                                <span class="fw-bold me-2"><?= $opt; ?>.</span> <?= htmlspecialchars($q['option_' . strtolower($opt)]); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-lg mt-4">
                            Kirim Jawaban Kuis
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .quiz-option:hover {
        background-color: rgba(13, 110, 253, 0.05) !important;
        border-color: var(--primary-color) !important;
        color: white !important;
    }
    .btn-check:checked + .quiz-option {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: white !important;
    }
</style>