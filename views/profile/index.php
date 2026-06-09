<?php
/**
 * VIEW: views/profile/index.php — Trang hồ sơ cá nhân
 * Biến: $user
 */
$pageTitle = 'Hồ sơ cá nhân - JobRecruitment';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-4">
    <div class="row g-4">

        <!-- ── Cột trái: Avatar + thông tin tóm tắt ──────────────── -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="mb-3">
                    <div class="avatar-circle mx-auto">
                        <?= mb_strtoupper(mb_substr($user['fullname'], 0, 1, 'UTF-8'), 'UTF-8') ?>
                    </div>
                </div>
                <h4 class="fw-bold"><?= htmlspecialchars($user['fullname']) ?></h4>
                <p class="text-muted mb-1">
                    <i class="bi bi-envelope me-1"></i><?= htmlspecialchars($user['email']) ?>
                </p>
                <?php if ($user['phone']): ?>
                <p class="text-muted mb-1">
                    <i class="bi bi-phone me-1"></i><?= htmlspecialchars($user['phone']) ?>
                </p>
                <?php endif; ?>
                <?php if ($user['address']): ?>
                <p class="text-muted mb-1">
                    <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($user['address']) ?>
                </p>
                <?php endif; ?>
                <hr>
                <span class="badge bg-primary">
                    <i class="bi bi-person-badge me-1"></i>
                    <?= $user['role'] === 'admin' ? 'Quản trị viên' : 'Thành viên' ?>
                </span>
                <p class="text-muted small mt-2 mb-0">
                    Thành viên từ: <?= date('d/m/Y', strtotime($user['created_at'])) ?>
                </p>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-2"><i class="bi bi-lightning-fill text-warning me-2"></i>Truy cập nhanh</h6>
                    <div class="d-grid gap-2">
                        <a href="<?= BASE_URL ?>/my-applications" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-file-earmark-text me-2"></i>Hồ sơ đã nộp
                        </a>
                        <a href="<?= BASE_URL ?>/jobs" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-search me-2"></i>Tìm việc làm
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Cột phải: Form chỉnh sửa ───────────────────────────── -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>Cập nhật hồ sơ
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?= BASE_URL ?>/profile/update" method="POST">

                        <h6 class="fw-bold text-muted mb-3 border-bottom pb-2">Thông tin cá nhân</h6>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fullname"
                                       value="<?= htmlspecialchars($user['fullname']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Số điện thoại</label>
                                <input type="tel" class="form-control" name="phone"
                                       value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Địa chỉ</label>
                            <input type="text" class="form-control" name="address"
                                   value="<?= htmlspecialchars($user['address'] ?? '') ?>"
                                   placeholder="Địa chỉ của bạn">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Giới thiệu bản thân</label>
                            <textarea class="form-control" name="bio" rows="4"
                                      placeholder="Viết vài dòng giới thiệu về bản thân, kinh nghiệm và kỹ năng của bạn..."><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                        </div>

                        <h6 class="fw-bold text-muted mb-3 border-bottom pb-2">
                            <i class="bi bi-shield-lock me-2"></i>Đổi mật khẩu
                            <small class="text-muted fw-normal">(để trống nếu không đổi)</small>
                        </h6>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Mật khẩu hiện tại</label>
                                <input type="password" class="form-control" name="old_password"
                                       placeholder="Mật khẩu cũ" autocomplete="current-password">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" name="new_password"
                                       placeholder="Tối thiểu 6 ký tự" autocomplete="new-password">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email (không thể đổi)</label>
                                <input type="email" class="form-control bg-light"
                                       value="<?= htmlspecialchars($user['email']) ?>" readonly>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary fw-bold px-5">
                            <i class="bi bi-check-lg me-2"></i>Lưu thay đổi
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
