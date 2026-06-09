<?php
/**
 * VIEW: views/applications/history.php — Lịch sử hồ sơ ứng tuyển
 * Biến: $applications
 */
$pageTitle = 'Hồ sơ đã nộp - JobRecruitment';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-4">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-file-earmark-text me-2 text-primary"></i>Hồ sơ đã nộp
    </h2>

    <?php if (empty($applications)): ?>
    <div class="text-center py-5">
        <i class="bi bi-inbox fs-1 text-muted"></i>
        <h5 class="mt-3 text-muted">Bạn chưa nộp hồ sơ nào</h5>
        <p class="text-muted">Hãy tìm kiếm và ứng tuyển việc làm phù hợp!</p>
        <a href="<?= BASE_URL ?>/jobs" class="btn btn-primary">
            <i class="bi bi-search me-2"></i>Tìm việc làm ngay
        </a>
    </div>
    <?php else: ?>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Vị trí ứng tuyển</th>
                            <th>Công ty</th>
                            <th>Địa điểm</th>
                            <th>Ngày nộp</th>
                            <th>CV</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $i => $app): ?>
                        <tr>
                            <td class="text-muted"><?= $i + 1 ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>/jobs/detail?id=<?= $app['job_id'] ?>"
                                   class="text-decoration-none fw-semibold">
                                    <?= htmlspecialchars($app['job_title']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($app['company']) ?></td>
                            <td>
                                <small class="text-muted">
                                    <?= htmlspecialchars($app['location'] ?? '') ?>
                                </small>
                            </td>
                            <td>
                                <small><?= date('d/m/Y H:i', strtotime($app['created_at'])) ?></small>
                            </td>
                            <td>
                                <?php if ($app['cv_file']): ?>
                                    <a href="<?= BASE_URL ?>/uploads/cv/<?= htmlspecialchars($app['cv_file']) ?>"
                                       target="_blank" class="btn btn-outline-danger btn-sm" title="Xem CV">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                // Badge màu theo trạng thái
                                [$badgeClass, $label, $icon] = match($app['status']) {
                                    'approved' => ['bg-success', 'Đã duyệt',   'bi-check-circle-fill'],
                                    'rejected' => ['bg-danger',  'Từ chối',    'bi-x-circle-fill'],
                                    default    => ['bg-warning text-dark', 'Chờ duyệt', 'bi-clock-fill'],
                                };
                                ?>
                                <span class="badge <?= $badgeClass ?>">
                                    <i class="bi <?= $icon ?> me-1"></i><?= $label ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3 text-muted small">
        <i class="bi bi-info-circle me-1"></i>
        Tổng cộng <strong><?= count($applications) ?></strong> hồ sơ đã nộp.
    </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
