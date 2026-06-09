<?php
/**
 * VIEW: views/admin/users/create.php — Form tạo người dùng mới
 */
$pageTitle = 'Thêm người dùng - Admin';
require_once __DIR__ . '/../../admin/layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-person-plus me-2 text-primary"></i>Thêm người dùng mới</h4>
    <a href="<?= BASE_URL ?>/admin/users" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Quay lại
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="<?= BASE_URL ?>/admin/users/create" method="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="fullname" required placeholder="Nguyễn Văn An">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" required placeholder="example@email.com">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Số điện thoại</label>
                <input type="tel" class="form-control" name="phone" placeholder="0901234567">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Mật khẩu <span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="password" required
                       placeholder="Tối thiểu 6 ký tự" minlength="6">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Quyền</label>
                <select class="form-select" name="role">
                    <option value="user">User (Thành viên)</option>
                    <option value="admin">Admin (Quản trị)</option>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-bold px-4">
                    <i class="bi bi-check-lg me-2"></i>Tạo người dùng
                </button>
                <a href="<?= BASE_URL ?>/admin/users" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>
