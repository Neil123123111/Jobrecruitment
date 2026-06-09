<?php
$pageTitle = 'Thêm ngành nghề - Admin';
require_once __DIR__ . '/../../admin/layouts/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-tag-fill me-2 text-primary"></i>Thêm ngành nghề</h4>
    <a href="<?= BASE_URL ?>/admin/categories" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Quay lại
    </a>
</div>
<div class="card border-0 shadow-sm" style="max-width: 450px;">
    <div class="card-body p-4">
        <form action="<?= BASE_URL ?>/admin/categories/create" method="POST">
            <div class="mb-4">
                <label class="form-label fw-semibold">Tên ngành nghề <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" required
                       placeholder="VD: Công nghệ thông tin" maxlength="100">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-bold px-4">
                    <i class="bi bi-check-lg me-2"></i>Thêm ngành nghề
                </button>
                <a href="<?= BASE_URL ?>/admin/categories" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>
