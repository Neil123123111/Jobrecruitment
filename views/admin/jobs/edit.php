<?php
/**
 * VIEW: views/admin/jobs/edit.php — Form chỉnh sửa tin tuyển dụng
 * Biến: $job, $categories
 */
$pageTitle = 'Sửa tin tuyển dụng - Admin';
require_once __DIR__ . '/../../admin/layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-pencil me-2 text-warning"></i>Sửa tin tuyển dụng</h4>
    <a href="<?= BASE_URL ?>/admin/jobs" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Quay lại
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="<?= BASE_URL ?>/admin/jobs/edit" method="POST">
            <input type="hidden" name="id" value="<?= $job['id'] ?>">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Tiêu đề <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title" required
                           value="<?= htmlspecialchars($job['title']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Ngành nghề <span class="text-danger">*</span></label>
                    <select class="form-select" name="category_id" required>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"
                                <?= $cat['id'] == $job['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tên công ty <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="company" required
                           value="<?= htmlspecialchars($job['company']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Mức lương</label>
                    <input type="text" class="form-control" name="salary"
                           value="<?= htmlspecialchars($job['salary'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Trạng thái</label>
                    <select class="form-select" name="status">
                        <option value="active" <?= $job['status'] === 'active' ? 'selected' : '' ?>>Đang tuyển</option>
                        <option value="closed" <?= $job['status'] === 'closed' ? 'selected' : '' ?>>Đã đóng</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Địa điểm</label>
                    <input type="text" class="form-control" name="location"
                           value="<?= htmlspecialchars($job['location'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Hạn nộp hồ sơ</label>
                    <input type="date" class="form-control" name="deadline"
                           value="<?= htmlspecialchars($job['deadline'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Mô tả công việc</label>
                    <textarea class="form-control" name="description" rows="5"><?= htmlspecialchars($job['description'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Yêu cầu ứng viên</label>
                    <textarea class="form-control" name="requirements" rows="5"><?= htmlspecialchars($job['requirements'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Quyền lợi</label>
                    <textarea class="form-control" name="benefits" rows="5"><?= htmlspecialchars($job['benefits'] ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-warning fw-bold px-5">
                        <i class="bi bi-check-lg me-2"></i>Lưu thay đổi
                    </button>
                    <a href="<?= BASE_URL ?>/admin/jobs" class="btn btn-outline-secondary ms-2">Hủy</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>
