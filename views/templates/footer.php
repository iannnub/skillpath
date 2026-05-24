    </main>

    <footer class="py-4 mt-auto border-top" style="border-color: var(--border-color) !important;">
        <div class="container-fluid px-4 text-center">
            <div class="text-muted small">
                &copy; <?= date('Y'); ?> <span class="fw-bold text-primary">SkillPath</span>. Dirancang untuk Modern Learning.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Init tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</body>
</html>