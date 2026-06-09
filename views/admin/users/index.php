<?php
/**
 * VIEW: views/admin/users/index.php — Danh sách người dùng
 */
$pageTitle = 'Quản lý người dùng - Admin';
require_once __DIR__ . '/../../admin/layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-people me-2 text-primary"></i>Quản lý người dùng
    </h4>
    <a href="<?= BASE_URL ?>/admin/users/create" class="btn btn-primary">
        <i class="bi bi-person-plus me-2"></i>Thêm người dùng
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Quyền</th>
                        <th>Ngày tạo</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">Không có người dùng nào.</td></tr>
                    <?php else: ?>
                    <?php foreach ($users as $i => $user): ?>
                    <tr>
                        <td class="text-muted"><?= $i + 1 ?></td>
                        <td>
                            <div class="fw-semibold"><?= htmlspecialchars($user['fullname']) ?></div>
                        </td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['phone'] ?? '—') ?></td>
                        <td>
                            <?php if ($user['role'] === 'admin'): ?>
                            <span class="badge bg-danger">Admin</span>
                            <?php else: ?>
                            <span class="badge bg-secondary">User</span>
                            <?php endif; ?>
                        </td>
                        <td><small><?= date('d/m/Y', strtotime($user['created_at'])) ?></small></td>
                        <td class="text-center">
                            <!-- Nút sửa -->
                            <a href="<?= BASE_URL ?>/admin/users/edit?id=<?= $user['id'] ?>"
                               class="btn btn-sm btn-outline-primary me-1" title="Sửa">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <!-- Nút xóa — sử dụng form POST để an toàn -->
                            <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                            <form method="POST" action="<?= BASE_URL ?>/admin/users/delete"
                                  class="d-inline" onsubmit="return confirmDelete('người dùng này')">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            <?php else: ?>
                            <button class="btn btn-sm btn-outline-secondary" disabled title="Không thể tự xóa">
                                <i class="bi bi-trash"></i>
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted small">
        Tổng: <strong><?= count($users) ?></strong> người dùng
    </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>
