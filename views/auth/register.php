<?php
/**
 * VIEW: views/auth/register.php — Form đăng ký tài khoản
 */
$pageTitle = 'Đăng ký tài khoản - JobRecruitment';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus text-primary" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold mt-2 mb-0">Đăng ký tài khoản</h3>
                        <p class="text-muted small">Tạo tài khoản để ứng tuyển việc làm</p>
                    </div>

                    <form action="<?= BASE_URL ?>/register" method="POST" novalidate id="registerForm">
                        <!-- Họ và tên -->
                        <div class="mb-3">
                            <label for="fullname" class="form-label fw-semibold">
                                Họ và tên <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="fullname" name="fullname"
                                       placeholder="Nguyễn Văn An" required minlength="2" maxlength="100">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                Email <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="example@email.com" required autocomplete="email">
                            </div>
                        </div>

                        <!-- Số điện thoại -->
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">Số điện thoại</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                       placeholder="0901234567" maxlength="20">
                            </div>
                        </div>

                        <!-- Mật khẩu -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Mật khẩu <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Tối thiểu 6 ký tự" required minlength="6"
                                       autocomplete="new-password">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                    <i class="bi bi-eye" id="eyeIcon_password"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Xác nhận mật khẩu -->
                        <div class="mb-4">
                            <label for="password_confirm" class="form-label fw-semibold">
                                Xác nhận mật khẩu <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" id="password_confirm"
                                       name="password_confirm" placeholder="Nhập lại mật khẩu"
                                       required autocomplete="new-password">
                                <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('password_confirm')">
                                    <i class="bi bi-eye" id="eyeIcon_password_confirm"></i>
                                </button>
                            </div>
                            <div id="passwordMatchMsg" class="form-text"></div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg fw-bold mb-3">
                            <i class="bi bi-person-check me-2"></i>Tạo tài khoản
                        </button>
                    </form>

                    <p class="text-center text-muted mb-0">
                        Đã có tài khoản?
                        <a href="<?= BASE_URL ?>/login" class="text-primary fw-semibold">Đăng nhập</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
