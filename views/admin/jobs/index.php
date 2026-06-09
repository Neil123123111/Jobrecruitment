<?php
/**
 * VIEW: views/admin/jobs/index.php — Danh sách tin tuyển dụng
 */
$pageTitle = 'Quản lý việc làm - Admin';
require_once __DIR__ . '/../../admin/layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-briefcase me-2 text-primary"></i>Quản lý tin tuyển dụng</h4>
    <a href="<?= BASE_URL ?>/admin/jobs/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Thêm tin tuyển dụng
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Tiêu đề</th>
                        <th>Công ty</th>
                        <th>Ngành nghề</th>
                        <th>Địa điểm</th>
                        <th>Hạn nộp</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($jobs)): ?>
                    <tr><td colspan="8" class="text-center text-muted py-4">Chưa có tin tuyển dụng nào.</td></tr>
                    <?php else: ?>
                    <?php foreach ($jobs as $i => $job): ?>
                    <tr>
                        <td class="text-muted"><?= $i + 1 ?></td>
                        <td>
                            <div class="fw-semibold" style="max-width:200px;">
                                <?= htmlspecialchars($job['title']) ?>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($job['company']) ?></td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary">
                                <?= htmlspecialchars($job['category_name'] ?? '') ?>
                            </span>
                        </td>
                        <td><small><?= htmlspecialchars($job['location'] ?? '—') ?></small></td>
                        <td>
                            <small>
                                <?= $job['deadline'] ? date('d/m/Y', strtotime($job['deadline'])) : '—' ?>
                            </small>
                        </td>
                        <td>
                            <?php if ($job['status'] === 'active'): ?>
                            <span class="badge bg-success">Đang tuyển</span>
                            <?php else: ?>
                            <span class="badge bg-secondary">Đã đóng</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="<?= BASE_URL ?>/jobs/detail?id=<?= $job['id'] ?>"
                               target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="Xem">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/admin/jobs/edit?id=<?= $job['id'] ?>"
                               class="btn btn-sm btn-outline-primary me-1" title="Sửa">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="<?= BASE_URL ?>/admin/jobs/delete"
                                  class="d-inline" onsubmit="return confirmDelete('tin tuyển dụng này')">
                                <input type="hidden" name="id" value="<?= $job['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted small">
        Tổng: <strong><?= count($jobs) ?></strong> tin tuyển dụng
    </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>
