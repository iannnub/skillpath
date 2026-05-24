<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6 col-lg-5 col-xl-4">
        <div class="text-center mb-4">
            <h2 class="fw-bolder text-primary mb-1" style="letter-spacing: -0.5px;">Selamat Datang!</h2>
            <p class="text-muted">Masuk untuk melanjutkan proses belajarmu.</p>
        </div>
        
        <div class="card glass-card border-0 rounded-4">
            <div class="card-body p-4 p-md-5">
                <form action="<?= BASEURL; ?>/auth/login" method="POST">
                    <div class="form-floating mb-4">
                        <input type="email" name="email" class="form-control border-0" id="emailInput" placeholder="name@example.com" required>
                        <label for="emailInput">Alamat Email</label>
                    </div>
                    
                    <div class="form-floating mb-4">
                        <input type="password" name="password" class="form-control border-0" id="passwordInput" placeholder="Password" required>
                        <label for="passwordInput">Password</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm fs-5 mt-2">Masuk Sekarang</button>
                </form>
                
                <div class="text-center mt-4 pt-3 border-top border-secondary">
                    <p class="text-muted mb-0 small">Belum punya akun? 
                        <a href="<?= BASEURL; ?>/auth/register" class="text-primary fw-bold text-decoration-none">Daftar Gratis</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>