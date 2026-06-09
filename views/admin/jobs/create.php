<?php
/**
 * VIEW: views/admin/jobs/create.php — Form thêm tin tuyển dụng
 * Biến: $categories
 */
$pageTitle = 'Thêm tin tuyển dụng - Admin';
require_once __DIR__ . '/../../admin/layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>Thêm tin tuyển dụng</h4>
    <a href="<?= BASE_URL ?>/admin/jobs" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Quay lại
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="<?= BASE_URL ?>/admin/jobs/create" method="POST">
            <div class="row g-3">
                <!-- Tiêu đề -->
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Tiêu đề vị trí <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title" required placeholder="VD: Lập trình viên PHP Backend">
                </div>
                <!-- Ngành nghề -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Ngành nghề <span class="text-danger">*</span></label>
                    <select class="form-select" name="category_id" required>
                        <option value="">-- Chọn ngành nghề --</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Công ty -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tên công ty <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="company" required placeholder="VD: FPT Software">
                </div>
                <!-- Mức lương -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Mức lương</label>
                    <input type="text" class="form-control" name="salary" placeholder="VD: 15-25 triệu">
                </div>
                <!-- Trạng thái -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Trạng thái</label>
                    <select class="form-select" name="status">
                        <option value="active">Đang tuyển</option>
                        <option value="closed">Đã đóng</option>
                    </select>
                </div>
                <!-- Địa điểm -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Địa điểm làm việc</label>
                    <input type="text" class="form-control" name="location" placeholder="VD: Hà Nội">
                </div>
                <!-- Hạn nộp -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Hạn nộp hồ sơ</label>
                    <input type="date" class="form-control" name="deadline" min="<?= date('Y-m-d') ?>">
                </div>
                <!-- Mô tả -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Mô tả công việc</label>
                    <textarea class="form-control" name="description" rows="5"
                              placeholder="Mô tả chi tiết về công việc, nhiệm vụ cụ thể..."></textarea>
                </div>
                <!-- Yêu cầu -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Yêu cầu ứng viên</label>
                    <textarea class="form-control" name="requirements" rows="5"
                              placeholder="Kinh nghiệm, kỹ năng, bằng cấp cần thiết..."></textarea>
                </div>
                <!-- Quyền lợi -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Quyền lợi</label>
                    <textarea class="form-control" name="benefits" rows="5"
                              placeholder="Lương thưởng, bảo hiểm, phúc lợi..."></textarea>
                </div>
                <!-- Nút submit -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary fw-bold px-5">
                        <i class="bi bi-check-lg me-2"></i>Thêm tin tuyển dụng
                    </button>
                    <a href="<?= BASE_URL ?>/admin/jobs" class="btn btn-outline-secondary ms-2">Hủy</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../admin/layouts/footer.php'; ?>
