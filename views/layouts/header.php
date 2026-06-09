<?php
/**
 * VIEW: views/layouts/header.php
 * Layout header dùng chung cho giao diện User
 * Biến $pageTitle được truyền từ Controller
 */
$pageTitle = $pageTitle ?? 'JobRecruitment - Tìm việc làm dễ dàng';
$flash     = $flash ?? null;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= BASE_URL ?>/public/css/style.css" rel="stylesheet">
</head>
<body>

<!-- ── Thanh điều hướng chính ──────────────────────────────────── -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold fs-4" href="<?= BASE_URL ?>/">
            <i class="bi bi-briefcase-fill me-2"></i>JobRecruitment
        </a>

        <!-- Toggle button (mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu links -->
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/">
                        <i class="bi bi-house-door me-1"></i>Trang chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/jobs">
                        <i class="bi bi-search me-1"></i>Tìm việc làm
                    </a>
                </li>
            </ul>

            <!-- Phần bên phải: đăng nhập / thông tin user -->
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Đã đăng nhập -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            <?= htmlspecialchars($_SESSION['user_name'] ?? 'Tài khoản') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/profile">
                                    <i class="bi bi-person me-2"></i>Hồ sơ cá nhân
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/my-applications">
                                    <i class="bi bi-file-earmark-text me-2"></i>Hồ sơ đã nộp
                                </a>
                            </li>
                            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?= BASE_URL ?>/admin/dashboard">
                                    <i class="bi bi-shield-lock me-2"></i>Trang Admin
                                </a>
                            </li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Chưa đăng nhập -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/login">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm ms-2 mt-1" href="<?= BASE_URL ?>/register">
                            <i class="bi bi-person-plus me-1"></i>Đăng ký
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- ── Thông báo Flash (hiển thị 1 lần) ─────────────────────────── -->
<?php if ($flash): ?>
<div class="container mt-3">
    <?php
    $alertClass = match($flash['type']) {
        'success' => 'alert-success',
        'error'   => 'alert-danger',
        'warning' => 'alert-warning',
        default   => 'alert-info',
    };
    ?>
    <div class="alert <?= $alertClass ?> alert-dismissible fade show" role="alert">
        <?= $flash['message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>

<!-- Nội dung chính sẽ được chèn vào đây -->
