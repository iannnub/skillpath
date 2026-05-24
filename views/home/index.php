<div class="py-5 mb-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-color), #09368e);">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="badge bg-white bg-opacity-20 text-white px-3 py-2 rounded-pill mb-3 fw-bold shadow-sm" style="backdrop-filter: blur(5px);">
                    🚀 Platform Belajar Masa Depan
                </span>
                <h1 class="display-3 fw-800 text-white mb-3 lh-sm" style="letter-spacing: -1px;">
                    Kuasai Skill Baru dengan <span class="text-warning">Roadmap</span> Jelas.
                </h1>
                <p class="lead mb-5 text-white text-opacity-75 fs-4">
                    Jangan bingung mulai dari mana. Pilih jalur belajarmu, ikuti langkah-langkahnya, dan raih karir impianmu bersama mentor ahli.
                </p>
                
                <?php if(!isset($_SESSION['user_id'])) : ?>
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="<?= BASEURL; ?>/auth/register" class="btn btn-light btn-lg px-5 py-3 fw-bold text-primary rounded-pill shadow-lg hover-scale">
                            Mulai Belajar Gratis
                        </a>
                        <a href="<?= BASEURL; ?>/auth/login" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold rounded-pill shadow-sm">
                            Masuk Akun
                        </a>
                    </div>
                <?php else : ?>
                    <a href="<?= BASEURL; ?>/<?= $_SESSION['role']; ?>/dashboard" class="btn btn-light btn-lg px-5 py-3 fw-bold text-primary rounded-pill shadow-lg">
                        <i class="bi bi-speedometer2 me-2"></i> Kembali ke Dashboard
                    </a>
                <?php endif; ?>
            </div>
            <div class="col-lg-6 d-none d-lg-block text-end">
                <img src="https://illustrations.popsy.co/white/working-from-home.svg" alt="Hero Image" class="img-fluid floating-animation" style="max-height: 450px;">
            </div>
        </div>
    </div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background-image: url('data:image/svg+xml,...'); pointer-events: none;"></div>
</div>

<div class="container pb-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-light display-6 mb-2">Roadmap Unggulan 🚀</h2>
        <p class="text-muted fs-5">Kurikulum terbaik yang disusun oleh para ahli di bidangnya.</p>
    </div>

    <div class="row g-4">
        <?php foreach($data['featured_roadmaps'] as $rm) : ?>
            <div class="col-md-6 col-lg-4">
                <div class="card card-hover h-100 border-0 p-2 pb-0 bg-card">
                    <div class="position-relative overflow-hidden rounded-4">
                        <img src="<?= ASSET_BASEURL; ?>/assets/img/roadmaps/<?= $rm['thumbnail']; ?>" class="w-100 object-fit-cover" alt="Thumbnail" style="aspect-ratio: 16/9;">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-primary bg-opacity-75 text-white px-3 py-2 rounded-pill shadow-sm fw-bold" style="backdrop-filter: blur(10px);">
                                <?= $rm['category_name']; ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-body px-3 pt-4 d-flex flex-column">
                        <h5 class="card-title fw-bold text-light mb-3 line-clamp-2 fs-4 lh-base"><?= htmlspecialchars($rm['title']); ?></h5>
                        <p class="card-text text-muted small mb-4 flex-grow-1 lh-lg">
                            <?= substr(htmlspecialchars($rm['description']), 0, 110); ?>...
                        </p>
                        
                        <div class="d-flex align-items-center py-3 border-top border-secondary border-opacity-25 mt-auto">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 32px; height: 32px; font-size: 0.7rem;">
                                <?= strtoupper(substr($rm['mentor_name'], 0, 1)); ?>
                            </div>
                            <span class="text-muted small fw-semibold">Mentor: <?= htmlspecialchars($rm['mentor_name']); ?></span>
                        </div>

                        <div class="pb-3 pt-2">
                            <a href="<?= BASEURL; ?>/auth/login" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">
                                Pelajari Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-5">
        <a href="<?= BASEURL; ?>/auth/login" class="btn btn-outline-primary btn-lg rounded-pill px-5 fw-bold border-2 shadow-sm">
            Eksplor Semua Roadmap <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    
    /* Animasi floating untuk gambar hero */
    .floating-animation {
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }

    .hover-scale:hover {
        transform: scale(1.05);
        transition: all 0.3s ease;
    }

    /* Utilitas tambahan untuk teks rapi */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>