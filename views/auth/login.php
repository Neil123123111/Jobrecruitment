<?php
/**
 * VIEW: views/auth/login.php — Form đăng nhập
 */
$pageTitle = 'Đăng nhập - JobRecruitment';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle text-primary" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold mt-2 mb-0">Đăng nhập</h3>
                        <p class="text-muted small">Chào mừng bạn trở lại!</p>
                    </div>

                    <form action="<?= BASE_URL ?>/login" method="POST" novalidate>
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="example@email.com" required autocomplete="email">
                            </div>
                        </div>

                        <!-- Mật khẩu -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Mật khẩu <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Nhập mật khẩu" required autocomplete="current-password">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                    <i class="bi bi-eye" id="eyeIcon_password"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Nút đăng nhập -->
                        <button type="submit" class="btn btn-primary w-100 btn-lg fw-bold mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập
                        </button>
                    </form>

                    <p class="text-center text-muted mb-0">
                        Chưa có tài khoản?
                        <a href="<?= BASE_URL ?>/register" class="text-primary fw-semibold">Đăng ký ngay</a>
                    </p>
                </div>
            </div>

            <!-- Tài khoản demo -->
            <div class="card border-info mt-3">
                <div class="card-body p-3 small">
                    <strong><i class="bi bi-info-circle me-1 text-info"></i>Tài khoản demo:</strong><br>
                    🔑 <strong>Admin:</strong> admin@jobrecruitment.com / Admin@123<br>
                    👤 <strong>User:</strong> user@example.com / User@123
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
