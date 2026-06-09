<?php
/**
 * VIEW: views/admin/dashboard/index.php — Dashboard Admin
 * Biến: $stats (array thống kê), $recentApplications
 */
$pageTitle = 'Dashboard - Admin Panel';
require_once __DIR__ . '/../../admin/layouts/header.php';
?>

<!-- ── Thống kê tổng quan ──────────────────────────────────────── -->
<div class="row g-3 mb-4">
    <!-- Tổng người dùng -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center p-4">
                <div class="rounded-3 p-3 bg-primary bg-opacity-10 me-3">
                    <i class="bi bi-people-fill text-primary fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small">Người dùng</div>
                    <div class="fs-3 fw-bold text-primary"><?= number_format($stats['total_users']) ?></div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-4">
                <a href="<?= BASE_URL ?>/admin/users" class="text-primary small text-decoration-none">
                    Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Tổng việc làm -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center p-4">
                <div class="rounded-3 p-3 bg-success bg-opacity-10 me-3">
                    <i class="bi bi-briefcase-fill text-success fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small">Việc làm đang tuyển</div>
                    <div class="fs-3 fw-bold text-success"><?= number_format($stats['total_jobs']) ?></div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-4">
                <a href="<?= BASE_URL ?>/admin/jobs" class="text-success small text-decoration-none">
                    Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Tổng hồ sơ -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center p-4">
                <div class="rounded-3 p-3 bg-warning bg-opacity-10 me-3">
                    <i class="bi bi-file-earmark-person-fill text-warning fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small">Hồ sơ ứng tuyển</div>
                    <div class="fs-3 fw-bold text-warning"><?= number_format($stats['total_applications']) ?></div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-4">
                <a href="<?= BASE_URL ?>/admin/applications" class="text-warning small text-decoration-none">
                    Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Chờ duyệt -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center p-4">
                <div class="rounded-3 p-3 bg-danger bg-opacity-10 me-3">
                    <i class="bi bi-hourglass-split text-danger fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small">Chờ duyệt</div>
                    <div class="fs-3 fw-bold text-danger"><?= number_format($stats['pending']) ?></div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-4">
                <a href="<?= BASE_URL ?>/admin/applications" class="text-danger small text-decoration-none">
                    Xử lý ngay <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ── Row: Biểu đồ trạng thái + Hành động nhanh ─────────────── -->
<div class="row g-3 mb-4">
    <!-- Thống kê trạng thái hồ sơ -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent fw-bold">
                <i class="bi bi-bar-chart-fill me-2 text-primary"></i>Thống kê hồ sơ ứng tuyển
            </div>
            <div class="card-body">
                <?php
                $total = $stats['total_applications'] ?: 1; // Tránh chia cho 0
                $pendingPct  = round($stats['pending']  / $total * 100);
                $approvedPct = round($stats['approved'] / $total * 100);
                $rejectedPct = round($stats['rejected'] / $total * 100);
                ?>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span><i class="bi bi-clock-fill text-warning me-2"></i>Chờ duyệt</span>
                        <strong><?= $stats['pending'] ?> (<?= $pendingPct ?>%)</strong>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-warning" style="width: <?= $pendingPct ?>%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span><i class="bi bi-check-circle-fill text-success me-2"></i>Đã duyệt</span>
                        <strong><?= $stats['approved'] ?> (<?= $approvedPct ?>%)</strong>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: <?= $approvedPct ?>%"></div>
                    </div>
                </div>
                <div class="mb-0">
                    <div class="d-flex justify-content-between mb-1">
                        <span><i class="bi bi-x-circle-fill text-danger me-2"></i>Từ chối</span>
                        <strong><?= $stats['rejected'] ?> (<?= $rejectedPct ?>%)</strong>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-danger" style="width: <?= $rejectedPct ?>%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hành động nhanh -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent fw-bold">
                <i class="bi bi-lightning-fill me-2 text-warning"></i>Thao tác nhanh
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6">
                        <a href="<?= BASE_URL ?>/admin/jobs/create" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                            <i class="bi bi-plus-circle fs-3 mb-2"></i>
                            <span>Thêm việc làm</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= BASE_URL ?>/admin/users/create" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                            <i class="bi bi-person-plus fs-3 mb-2"></i>
                            <span>Thêm người dùng</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= BASE_URL ?>/admin/categories/create" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                            <i class="bi bi-tag fs-3 mb-2"></i>
                            <span>Thêm ngành nghề</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= BASE_URL ?>/admin/applications" class="btn btn-outline-danger w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                            <i class="bi bi-hourglass fs-3 mb-2"></i>
                            <span>Duyệt hồ sơ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── Hồ sơ gần đây ──────────────────────────────────────────── -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
        <span class="fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Hồ sơ ứng tuyển gần đây</span>
        <a href="<?= BASE_URL ?>/admin/applications" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($recentApplications)): ?>
        <p class="text-center text-muted py-4">Chưa có hồ sơ nào.</p>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Ứng viên</th>
                        <th>Vị trí</th>
                        <th>Công ty</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentApplications as $app): ?>
                    <tr>
                        <td>
                            <div class="fw-semibold"><?= htmlspecialchars($app['user_name']) ?></div>
                            <small class="text-muted"><?= htmlspecialchars($app['user_email']) ?></small>
                        </td>
                        <td><?= htmlspecialchars($app['job_title']) ?></td>
                        <td><?= htmlspecialchars($app['company']) ?></td>
                        <td><small class="text-muted"><?= date('d/m/Y H:i', strtotime($app['created_at'])) ?></small></td>
                        <td>
                            <?php [$cls, $lbl] = match($app['status']) {
                                'approved' => ['bg-success', 'Đã duyệt'],
                                'rejected' => ['bg-danger',  'Từ chối'],
                                default    => ['bg-warning text-dark', 'Chờ duyệt'],
                            }; ?>
                            <span class="badge <?= $cls ?>"><?= $lbl ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>
