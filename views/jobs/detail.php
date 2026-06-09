<?php
/**
 * VIEW: views/jobs/detail.php — Chi tiết việc làm
 * Biến: $job, $hasApplied, $relatedJobs
 */
$pageTitle = htmlspecialchars($job['title']) . ' - JobRecruitment';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-4">
    <div class="row g-4">

        <!-- ── Cột trái: Chi tiết công việc ───────────────────────── -->
        <div class="col-lg-8">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/jobs">Việc làm</a></li>
                    <li class="breadcrumb-item active"><?= htmlspecialchars($job['title']) ?></li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <!-- Tiêu đề & công ty -->
                    <div class="mb-3">
                        <span class="badge bg-primary mb-2"><?= htmlspecialchars($job['category_name'] ?? '') ?></span>
                        <h2 class="fw-bold"><?= htmlspecialchars($job['title']) ?></h2>
                        <h5 class="text-muted">
                            <i class="bi bi-building me-2"></i><?= htmlspecialchars($job['company']) ?>
                        </h5>
                    </div>

                    <!-- Thông tin nhanh -->
                    <div class="row g-3 mb-4">
                        <?php if ($job['salary']): ?>
                        <div class="col-sm-6 col-md-3">
                            <div class="text-center p-3 bg-success-subtle rounded">
                                <i class="bi bi-cash text-success fs-4"></i>
                                <div class="small text-muted mt-1">Mức lương</div>
                                <div class="fw-semibold small"><?= htmlspecialchars($job['salary']) ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if ($job['location']): ?>
                        <div class="col-sm-6 col-md-3">
                            <div class="text-center p-3 bg-info-subtle rounded">
                                <i class="bi bi-geo-alt text-info fs-4"></i>
                                <div class="small text-muted mt-1">Địa điểm</div>
                                <div class="fw-semibold small"><?= htmlspecialchars($job['location']) ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if ($job['deadline']): ?>
                        <div class="col-sm-6 col-md-3">
                            <div class="text-center p-3 bg-warning-subtle rounded">
                                <i class="bi bi-calendar-event text-warning fs-4"></i>
                                <div class="small text-muted mt-1">Hạn nộp</div>
                                <div class="fw-semibold small"><?= date('d/m/Y', strtotime($job['deadline'])) ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-sm-6 col-md-3">
                            <div class="text-center p-3 bg-secondary-subtle rounded">
                                <i class="bi bi-clock text-secondary fs-4"></i>
                                <div class="small text-muted mt-1">Đăng ngày</div>
                                <div class="fw-semibold small"><?= date('d/m/Y', strtotime($job['created_at'])) ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Mô tả công việc -->
                    <?php if ($job['description']): ?>
                    <div class="mb-4">
                        <h5 class="fw-bold border-bottom pb-2">
                            <i class="bi bi-file-text me-2 text-primary"></i>Mô tả công việc
                        </h5>
                        <div class="job-content"><?= nl2br(htmlspecialchars($job['description'])) ?></div>
                    </div>
                    <?php endif; ?>

                    <!-- Yêu cầu ứng viên -->
                    <?php if ($job['requirements']): ?>
                    <div class="mb-4">
                        <h5 class="fw-bold border-bottom pb-2">
                            <i class="bi bi-person-check me-2 text-warning"></i>Yêu cầu ứng viên
                        </h5>
                        <div class="job-content"><?= nl2br(htmlspecialchars($job['requirements'])) ?></div>
                    </div>
                    <?php endif; ?>

                    <!-- Quyền lợi -->
                    <?php if ($job['benefits']): ?>
                    <div class="mb-4">
                        <h5 class="fw-bold border-bottom pb-2">
                            <i class="bi bi-gift me-2 text-success"></i>Quyền lợi
                        </h5>
                        <div class="job-content"><?= nl2br(htmlspecialchars($job['benefits'])) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Việc làm liên quan -->
            <?php if (!empty($relatedJobs)): ?>
            <h5 class="fw-bold mb-3">Việc làm liên quan</h5>
            <div class="row g-3">
                <?php foreach ($relatedJobs as $rJob): ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-1">
                                <a href="<?= BASE_URL ?>/jobs/detail?id=<?= $rJob['id'] ?>"
                                   class="text-decoration-none text-dark">
                                    <?= htmlspecialchars($rJob['title']) ?>
                                </a>
                            </h6>
                            <p class="text-muted small mb-1"><?= htmlspecialchars($rJob['company']) ?></p>
                            <?php if ($rJob['salary']): ?>
                            <span class="badge bg-success-subtle text-success small"><?= htmlspecialchars($rJob['salary']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- ── Cột phải: Sidebar ứng tuyển ────────────────────────── -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 80px;">
                <div class="card-body p-4 text-center">
                    <h5 class="fw-bold mb-3">Ứng tuyển ngay</h5>

                    <?php if ($hasApplied): ?>
                        <!-- Đã ứng tuyển -->
                        <div class="alert alert-success mb-3">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Bạn đã nộp hồ sơ cho vị trí này!
                        </div>
                        <a href="<?= BASE_URL ?>/my-applications" class="btn btn-outline-primary w-100">
                            <i class="bi bi-file-earmark-text me-2"></i>Xem hồ sơ đã nộp
                        </a>

                    <?php elseif (isset($_SESSION['user_id'])): ?>
                        <!-- Đã đăng nhập, chưa ứng tuyển -->
                        <p class="text-muted small mb-3">Cơ hội tuyệt vời đang chờ bạn!</p>
                        <a href="<?= BASE_URL ?>/jobs/apply?id=<?= $job['id'] ?>"
                           class="btn btn-primary btn-lg w-100 fw-bold">
                            <i class="bi bi-send me-2"></i>Nộp hồ sơ ngay
                        </a>

                    <?php else: ?>
                        <!-- Chưa đăng nhập -->
                        <p class="text-muted small mb-3">Đăng nhập để ứng tuyển việc làm này.</p>
                        <a href="<?= BASE_URL ?>/login" class="btn btn-primary w-100 mb-2 fw-bold">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập để ứng tuyển
                        </a>
                        <a href="<?= BASE_URL ?>/register" class="btn btn-outline-primary w-100">
                            <i class="bi bi-person-plus me-2"></i>Đăng ký tài khoản
                        </a>
                    <?php endif; ?>

                    <hr>
                    <div class="text-start small text-muted">
                        <p class="mb-1"><i class="bi bi-building me-2"></i><strong>Công ty:</strong> <?= htmlspecialchars($job['company']) ?></p>
                        <?php if ($job['location']): ?>
                        <p class="mb-1"><i class="bi bi-geo-alt me-2"></i><strong>Địa điểm:</strong> <?= htmlspecialchars($job['location']) ?></p>
                        <?php endif; ?>
                        <?php if ($job['deadline']): ?>
                        <p class="mb-0"><i class="bi bi-calendar-event me-2"></i><strong>Hạn:</strong> <?= date('d/m/Y', strtotime($job['deadline'])) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
