<?php
/**
 * VIEW: views/home/index.php — Trang chủ
 */
$pageTitle = 'JobRecruitment - Tìm việc làm dễ dàng';
require_once __DIR__ . '/../layouts/header.php';
?>

<!-- ── Hero Section ────────────────────────────────────────────────── -->
<section class="hero-section text-white py-5">
    <div class="container text-center py-4">
        <h1 class="display-4 fw-bold mb-3">Tìm Việc Làm Mơ Ước</h1>
        <p class="lead mb-4">Hàng nghìn cơ hội việc làm đang chờ bạn. Hãy bắt đầu hành trình sự nghiệp ngay!</p>

        <!-- Form tìm kiếm nhanh -->
        <form action="<?= BASE_URL ?>/jobs" method="GET" class="d-flex justify-content-center">
            <div class="input-group" style="max-width: 600px;">
                <input type="text" name="keyword" class="form-control form-control-lg"
                       placeholder="Nhập chức danh, công ty, địa điểm...">
                <button class="btn btn-warning btn-lg fw-bold" type="submit">
                    <i class="bi bi-search me-1"></i>Tìm kiếm
                </button>
            </div>
        </form>
    </div>
</section>

<!-- ── Thống kê ─────────────────────────────────────────────────────── -->
<section class="bg-primary text-white py-3">
    <div class="container">
        <div class="row text-center g-2">
            <div class="col-6 col-md-3">
                <div class="p-2">
                    <div class="fs-2 fw-bold"><?= number_format($stats['jobs']) ?>+</div>
                    <div class="small opacity-75">Việc làm</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2">
                    <div class="fs-2 fw-bold"><?= number_format($stats['categories']) ?>+</div>
                    <div class="small opacity-75">Ngành nghề</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2">
                    <div class="fs-2 fw-bold">500+</div>
                    <div class="small opacity-75">Công ty</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2">
                    <div class="fs-2 fw-bold">10K+</div>
                    <div class="small opacity-75">Ứng viên</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── Ngành nghề nổi bật ────────────────────────────────────────────── -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">
            <i class="bi bi-grid-3x3-gap me-2 text-primary"></i>Ngành nghề phổ biến
        </h2>
        <div class="row g-3">
            <?php
            // Định nghĩa icon cho từng ngành
            $categoryIcons = [
                'Công nghệ thông tin'    => 'bi-laptop',
                'Kế toán - Tài chính'    => 'bi-calculator',
                'Marketing - Truyền thông' => 'bi-megaphone',
                'Nhân sự - Hành chính'   => 'bi-people',
                'Kỹ thuật - Cơ khí'      => 'bi-gear',
                'Y tế - Dược phẩm'       => 'bi-heart-pulse',
                'Giáo dục - Đào tạo'     => 'bi-book',
                'Bán hàng - Kinh doanh'  => 'bi-bag',
            ];
            foreach ($categories as $cat):
                $icon = $categoryIcons[$cat['name']] ?? 'bi-briefcase';
            ?>
            <div class="col-6 col-md-4 col-lg-3">
                <a href="<?= BASE_URL ?>/jobs?category=<?= $cat['id'] ?>"
                   class="card h-100 text-decoration-none border-0 shadow-sm category-card">
                    <div class="card-body text-center p-3">
                        <i class="bi <?= $icon ?> fs-2 text-primary mb-2"></i>
                        <h6 class="card-title mb-1 fw-semibold"><?= htmlspecialchars($cat['name']) ?></h6>
                        <span class="badge bg-primary rounded-pill"><?= $cat['job_count'] ?> việc làm</span>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── Việc làm mới nhất ─────────────────────────────────────────────── -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-fire me-2 text-danger"></i>Việc làm mới nhất
            </h2>
            <a href="<?= BASE_URL ?>/jobs" class="btn btn-outline-primary">
                Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <?php if (empty($latestJobs)): ?>
        <div class="text-center text-muted py-5">
            <i class="bi bi-inbox fs-1"></i>
            <p class="mt-2">Chưa có tin tuyển dụng nào.</p>
        </div>
        <?php else: ?>
        <div class="row g-3">
            <?php foreach ($latestJobs as $job): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm job-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary-subtle text-primary">
                                <?= htmlspecialchars($job['category_name'] ?? '') ?>
                            </span>
                            <?php if ($job['deadline']): ?>
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>
                                <?= date('d/m/Y', strtotime($job['deadline'])) ?>
                            </small>
                            <?php endif; ?>
                        </div>
                        <h5 class="card-title fw-bold mb-1">
                            <a href="<?= BASE_URL ?>/jobs/detail?id=<?= $job['id'] ?>"
                               class="text-decoration-none text-dark stretched-link">
                                <?= htmlspecialchars($job['title']) ?>
                            </a>
                        </h5>
                        <p class="text-muted mb-2 small">
                            <i class="bi bi-building me-1"></i><?= htmlspecialchars($job['company']) ?>
                        </p>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <?php if ($job['salary']): ?>
                            <span class="badge bg-success-subtle text-success">
                                <i class="bi bi-cash me-1"></i><?= htmlspecialchars($job['salary']) ?>
                            </span>
                            <?php endif; ?>
                            <?php if ($job['location']): ?>
                            <span class="badge bg-secondary-subtle text-secondary">
                                <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($job['location']) ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ── CTA Section ───────────────────────────────────────────────────── -->
<?php if (!isset($_SESSION['user_id'])): ?>
<section class="py-5 bg-primary text-white text-center">
    <div class="container">
        <h3 class="fw-bold mb-3">Bắt đầu hành trình sự nghiệp của bạn ngay hôm nay!</h3>
        <p class="mb-4 opacity-75">Đăng ký miễn phí để ứng tuyển hàng nghìn việc làm hấp dẫn.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="<?= BASE_URL ?>/register" class="btn btn-light btn-lg fw-bold">
                <i class="bi bi-person-plus me-2"></i>Đăng ký ngay
            </a>
            <a href="<?= BASE_URL ?>/jobs" class="btn btn-outline-light btn-lg">
                <i class="bi bi-search me-2"></i>Khám phá việc làm
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
