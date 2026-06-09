<?php
/**
 * VIEW: views/jobs/index.php — Danh sách việc làm, tìm kiếm, lọc, phân trang
 * Biến được truyền từ JobController::index():
 *   $jobs, $categories, $keyword, $categoryId, $page, $totalPages, $totalJobs
 */
$pageTitle = 'Tìm việc làm - JobRecruitment';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-4">
    <!-- ── Tiêu đề + Tìm kiếm ────────────────────────────────────── -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold mb-3">
                <i class="bi bi-search me-2 text-primary"></i>Tìm kiếm việc làm
            </h2>

            <!-- Form tìm kiếm -->
            <form action="<?= BASE_URL ?>/jobs" method="GET" class="row g-2">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="keyword" class="form-control"
                               placeholder="Từ khóa, chức danh, công ty..."
                               value="<?= htmlspecialchars($keyword) ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="category" class="form-select">
                        <option value="0">-- Tất cả ngành nghề --</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"
                                <?= $categoryId == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="bi bi-filter me-1"></i>Lọc
                    </button>
                </div>
                <?php if ($keyword || $categoryId): ?>
                <div class="col-md-1">
                    <a href="<?= BASE_URL ?>/jobs" class="btn btn-outline-secondary w-100" title="Xóa bộ lọc">
                        <i class="bi bi-x-circle"></i>
                    </a>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- ── Kết quả tìm kiếm ─────────────────────────────────────── -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0">
            Tìm thấy <strong class="text-primary"><?= number_format($totalJobs) ?></strong> việc làm
            <?php if ($keyword): ?>
                cho từ khóa "<em><?= htmlspecialchars($keyword) ?></em>"
            <?php endif; ?>
        </p>
        <small class="text-muted">Trang <?= $page ?> / <?= max(1, $totalPages) ?></small>
    </div>

    <!-- ── Danh sách job ────────────────────────────────────────── -->
    <?php if (empty($jobs)): ?>
    <div class="text-center py-5">
        <i class="bi bi-search fs-1 text-muted"></i>
        <h5 class="mt-3 text-muted">Không tìm thấy việc làm phù hợp</h5>
        <p class="text-muted">Thử thay đổi từ khóa hoặc ngành nghề khác.</p>
        <a href="<?= BASE_URL ?>/jobs" class="btn btn-primary">Xem tất cả việc làm</a>
    </div>
    <?php else: ?>
    <div class="row g-3 mb-4">
        <?php foreach ($jobs as $job): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm job-card">
                <div class="card-body p-4">
                    <!-- Ngành + deadline -->
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-primary-subtle text-primary small">
                            <?= htmlspecialchars($job['category_name'] ?? '') ?>
                        </span>
                        <?php if ($job['deadline']): ?>
                        <small class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            <?= date('d/m/Y', strtotime($job['deadline'])) ?>
                        </small>
                        <?php endif; ?>
                    </div>

                    <!-- Tiêu đề -->
                    <h5 class="card-title fw-bold mb-1 lh-sm">
                        <a href="<?= BASE_URL ?>/jobs/detail?id=<?= $job['id'] ?>"
                           class="text-decoration-none text-dark stretched-link">
                            <?= htmlspecialchars($job['title']) ?>
                        </a>
                    </h5>

                    <!-- Công ty -->
                    <p class="text-muted mb-3 small">
                        <i class="bi bi-building me-1"></i>
                        <?= htmlspecialchars($job['company']) ?>
                    </p>

                    <!-- Tags: lương, địa điểm -->
                    <div class="d-flex flex-wrap gap-1">
                        <?php if ($job['salary']): ?>
                        <span class="badge bg-success-subtle text-success">
                            <i class="bi bi-cash me-1"></i><?= htmlspecialchars($job['salary']) ?>
                        </span>
                        <?php endif; ?>
                        <?php if ($job['location']): ?>
                        <span class="badge bg-info-subtle text-info">
                            <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($job['location']) ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ── Phân trang ───────────────────────────────────────────── -->
    <?php if ($totalPages > 1): ?>
    <nav aria-label="Phân trang">
        <ul class="pagination justify-content-center">
            <!-- Trang trước -->
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= BASE_URL ?>/jobs?keyword=<?= urlencode($keyword) ?>&category=<?= $categoryId ?>&page=<?= $page - 1 ?>">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>

            <!-- Số trang -->
            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="<?= BASE_URL ?>/jobs?keyword=<?= urlencode($keyword) ?>&category=<?= $categoryId ?>&page=<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
            <?php endfor; ?>

            <!-- Trang sau -->
            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= BASE_URL ?>/jobs?keyword=<?= urlencode($keyword) ?>&category=<?= $categoryId ?>&page=<?= $page + 1 ?>">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
