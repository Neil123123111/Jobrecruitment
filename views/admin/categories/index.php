<?php
/**
 * VIEW: views/admin/categories/index.php — Danh sách ngành nghề
 */
$pageTitle = 'Quản lý ngành nghề - Admin';
require_once __DIR__ . '/../../admin/layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-tags me-2 text-primary"></i>Quản lý ngành nghề</h4>
    <a href="<?= BASE_URL ?>/admin/categories/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Thêm ngành nghề
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 700px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Tên ngành nghề</th>
                        <th>Số việc làm</th>
                        <th>Ngày tạo</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categories)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">Chưa có ngành nghề nào.</td></tr>
                    <?php else: ?>
                    <?php foreach ($categories as $i => $cat): ?>
                    <tr>
                        <td class="text-muted"><?= $i + 1 ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($cat['name']) ?></td>
                        <td>
                            <span class="badge bg-primary rounded-pill"><?= $cat['job_count'] ?></span>
                        </td>
                        <td><small><?= date('d/m/Y', strtotime($cat['created_at'])) ?></small></td>
                        <td class="text-center">
                            <a href="<?= BASE_URL ?>/admin/categories/edit?id=<?= $cat['id'] ?>"
                               class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="<?= BASE_URL ?>/admin/categories/delete"
                                  class="d-inline" onsubmit="return confirmDelete('ngành nghề này và tất cả việc làm liên quan')">
                                <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
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
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>
