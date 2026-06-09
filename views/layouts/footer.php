<!-- VIEW: views/layouts/footer.php — Footer dùng chung -->

<!-- ── Footer ─────────────────────────────────────────────────────── -->
<footer class="bg-light text-dark mt-5 pt-4 pb-3">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="fw-bold">
                    <i class="bi bi-briefcase-fill me-2 text-primary"></i>JobRecruitment
                </h5>
                <p class="text-muted small">
                    Kết nối nhà tuyển dụng và ứng viên tài năng trên toàn quốc.
                    Tìm kiếm cơ hội việc làm phù hợp với bạn ngay hôm nay!
                </p>
            </div>
            <div class="col-md-4">
                <h6 class="fw-bold">Liên kết ngay </h6>
                <ul class="list-unstyled small">
                    <li><a href="<?= BASE_URL ?>/" class="text-muted text-decoration-none">🏠 Trang chủ</a></li>
                    <li><a href="<?= BASE_URL ?>/jobs" class="text-muted text-decoration-none">🔍 Tìm việc làm</a></li>
                    <li><a href="<?= BASE_URL ?>/register" class="text-muted text-decoration-none">📝 Đăng ký tài khoản</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="fw-bold">Liên hệ</h6>
                <ul class="list-unstyled small text-muted">
                    <li><i class="bi bi-envelope me-2"></i>contact@jobrecruitment.com</li>
                    <li><i class="bi bi-telephone me-2"></i>1800 123 456</li>
                    <li><i class="bi bi-geo-alt me-2"></i>Hà Nội, Việt Nam</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="text-center text-muted small">
            <p class="mb-0">© <?= date('Y') ?> JobRecruitment. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="<?= BASE_URL ?>/public/js/main.js"></script>
</body>
</html>
