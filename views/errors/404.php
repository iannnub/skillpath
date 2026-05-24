<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6 col-lg-5">
        <div class="text-center mb-5">
            <div class="display-1 fw-bold text-primary mb-3" style="font-size: 8rem; text-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);">404</div>
            <h2 class="fw-bolder text-light mb-3">Halaman Tidak Ditemukan</h2>
            <p class="text-muted fs-5 mb-5 lh-lg">
                <?= isset($data['message']) ? htmlspecialchars($data['message']) : 'Oops! Sepertinya Anda tersesat. Halaman atau roadmap yang Anda cari tidak tersedia di sistem kami.'; ?>
            </p>
            <a href="<?= BASEURL; ?>" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-lg fs-5 d-inline-flex align-items-center">
                <i class="bi bi-house-door-fill me-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
