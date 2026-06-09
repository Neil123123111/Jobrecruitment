<?php
/**
 * VIEW: views/admin/users/edit.php — Form chỉnh sửa người dùng
 * Biến: $user
 */
$pageTitle = 'Sửa người dùng - Admin';
require_once __DIR__ . '/../../admin/layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil me-2 text-warning"></i>Sửa người dùng</h4>
    <a href="<?= BASE_URL ?>/admin/users" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Quay lại
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="<?= BASE_URL ?>/admin/users/edit" method="POST">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <div class="mb-3">
                <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="fullname" required
                       value="<?= htmlspecialchars($user['fullname']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" required
                       value="<?= htmlspecialchars($user['email']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Số điện thoại</label>
                <input type="tel" class="form-control" name="phone"
                       value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Quyền</label>
                <select class="form-select" name="role"
                        <?= $user['id'] === $_SESSION['user_id'] ? 'disabled' : '' ?>>
                    <option value="user"  <?= $user['role'] === 'user'  ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
                <?php if ($user['id'] === $_SESSION['user_id']): ?>
                <input type="hidden" name="role" value="admin">
                <div class="form-text text-warning">Không thể thay đổi quyền của chính bạn.</div>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    Mật khẩu mới
                    <span class="text-muted fw-normal">(để trống nếu không đổi)</span>
                </label>
                <input type="password" class="form-control" name="new_password"
                       placeholder="Tối thiểu 6 ký tự" minlength="6">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning fw-bold px-4">
                    <i class="bi bi-check-lg me-2"></i>Lưu thay đổi
                </button>
                <a href="<?= BASE_URL ?>/admin/users" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>
