<?php
/**
 * VIEW: views/admin/layouts/header.php — Header dùng chung cho giao diện Admin
 * Biến $pageTitle được truyền từ Controller
 */
$pageTitle = $pageTitle ?? 'Admin Panel - JobRecruitment';
$flash     = $flash ?? null;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom Admin CSS -->
    <link href="<?= BASE_URL ?>/public/css/style.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; }
        .sidebar .nav-link { color: rgba(255,255,255,.75); border-radius: 6px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,.1); }
        .sidebar .nav-link i { width: 20px; }
        .sidebar .nav-section { color: rgba(255,255,255,.4); font-size: .7rem; text-transform: uppercase; letter-spacing: 1px; padding: 1rem 1rem .3rem; }
        .admin-content { min-height: 100vh; }
        .top-bar { background: #fff; border-bottom: 1px solid #dee2e6; }
    </style>
</head>
<body>
<div class="d-flex">

<!-- ── Sidebar ─────────────────────────────────────────────────── -->
<div class="sidebar d-flex flex-column" style="width: 250px; flex-shrink: 0;">
    <!-- Logo -->
    <div class="p-3 border-bottom border-secondary">
        <a href="<?= BASE_URL ?>/admin/dashboard" class="text-white text-decoration-none d-flex align-items-center">
            <i class="bi bi-shield-lock-fill text-primary fs-4 me-2"></i>
            <span class="fw-bold fs-5">Admin Panel</span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-grow-1 p-2 overflow-auto">
        <div class="nav-section">Tổng quan</div>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/admin/dashboard">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
        </ul>

        <div class="nav-section">Quản lý</div>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/admin/users">
                    <i class="bi bi-people me-2"></i>Người dùng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/admin/jobs">
                    <i class="bi bi-briefcase me-2"></i>Tin tuyển dụng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/admin/categories">
                    <i class="bi bi-tags me-2"></i>Ngành nghề
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/admin/applications">
                    <i class="bi bi-file-earmark-person me-2"></i>Hồ sơ ứng tuyển
                </a>
            </li>
        </ul>

        <div class="nav-section">Khác</div>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/" target="_blank">
                    <i class="bi bi-box-arrow-up-right me-2"></i>Xem website
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="<?= BASE_URL ?>/logout">
                    <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                </a>
            </li>
        </ul>
    </nav>

    <!-- Admin info -->
    <div class="p-3 border-top border-secondary text-white-50 small">
        <i class="bi bi-person-circle me-1"></i>
        <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>
    </div>
</div>

<!-- ── Nội dung chính ─────────────────────────────────────────── -->
<div class="flex-grow-1 admin-content">
    <!-- Thanh trên cùng -->
    <div class="top-bar px-4 py-2 d-flex align-items-center justify-content-between">
        <h6 class="mb-0 text-muted"><?= htmlspecialchars($pageTitle) ?></h6>
        <div class="d-flex align-items-center gap-3">
            <small class="text-muted"><?= date('d/m/Y H:i') ?></small>
            <a href="<?= BASE_URL ?>/logout" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-box-arrow-right me-1"></i>Đăng xuất
            </a>
        </div>
    </div>

    <!-- Thông báo Flash -->
    <?php if ($flash): ?>
    <div class="px-4 pt-3">
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

    <!-- Nội dung trang bắt đầu từ đây -->
    <div class="p-4">
