<?php
/**
 * VIEW: views/admin/applications/index.php — Quản lý hồ sơ ứng tuyển
 * Biến: $applications
 */
$pageTitle = 'Quản lý hồ sơ ứng tuyển - Admin';
require_once __DIR__ . '/../../admin/layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-file-earmark-person me-2 text-primary"></i>Quản lý hồ sơ ứng tuyển
    </h4>
    <span class="badge bg-primary fs-6"><?= count($applications) ?> hồ sơ</span>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Ứng viên</th>
                        <th>Vị trí ứng tuyển</th>
                        <th>Công ty</th>
                        <th>Ngày nộp</th>
                        <th>CV</th>
                        <th>Trạng thái</th>
                        <th class="text-center" style="min-width: 180px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($applications)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Chưa có hồ sơ ứng tuyển nào.
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($applications as $i => $app): ?>
                    <tr>
                        <td class="text-muted"><?= $i + 1 ?></td>
                        <td>
                            <div class="fw-semibold"><?= htmlspecialchars($app['user_name']) ?></div>
                            <small class="text-muted"><?= htmlspecialchars($app['user_email']) ?></small>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/jobs/detail?id=<?= $app['job_id'] ?>"
                               target="_blank" class="text-decoration-none fw-semibold">
                                <?= htmlspecialchars($app['job_title']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($app['company']) ?></td>
                        <td>
                            <small class="text-muted">
                                <?= date('d/m/Y H:i', strtotime($app['created_at'])) ?>
                            </small>
                        </td>
                        <td>
                            <?php if ($app['cv_file']): ?>
                            <a href="<?= BASE_URL ?>/uploads/cv/<?= htmlspecialchars($app['cv_file']) ?>"
                               target="_blank" class="btn btn-sm btn-outline-danger" title="Xem CV PDF">
                                <i class="bi bi-file-earmark-pdf"></i> CV
                            </a>
                            <?php else: ?>
                            <span class="text-muted small">Không có</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php [$badgeClass, $label] = match($app['status']) {
                                'approved' => ['bg-success', 'Đã duyệt'],
                                'rejected' => ['bg-danger',  'Từ chối'],
                                default    => ['bg-warning text-dark', 'Chờ duyệt'],
                            }; ?>
                            <span class="badge <?= $badgeClass ?>"><?= $label ?></span>
                        </td>
                        <td class="text-center">
                            <!-- Form duyệt/từ chối — dùng POST để an toàn -->
                            <form method="POST" action="<?= BASE_URL ?>/admin/applications/update-status"
                                  class="d-inline-flex gap-1">
                                <input type="hidden" name="id" value="<?= $app['id'] ?>">

                                <?php if ($app['status'] !== 'approved'): ?>
                                <button type="submit" name="status" value="approved"
                                        class="btn btn-sm btn-success" title="Duyệt hồ sơ">
                                    <i class="bi bi-check-circle me-1"></i>Duyệt
                                </button>
                                <?php endif; ?>

                                <?php if ($app['status'] !== 'rejected'): ?>
                                <button type="submit" name="status" value="rejected"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Xác nhận từ chối hồ sơ này?')"
                                        title="Từ chối hồ sơ">
                                    <i class="bi bi-x-circle me-1"></i>Từ chối
                                </button>
                                <?php endif; ?>

                                <?php if ($app['status'] !== 'pending'): ?>
                                <button type="submit" name="status" value="pending"
                                        class="btn btn-sm btn-outline-secondary" title="Đặt lại chờ duyệt">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>
