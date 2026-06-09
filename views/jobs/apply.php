<?php
/**
 * VIEW: views/jobs/apply.php — Form nộp hồ sơ ứng tuyển
 * Biến: $job
 */
$pageTitle = 'Ứng tuyển: ' . htmlspecialchars($job['title']) . ' - JobRecruitment';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/jobs">Việc làm</a></li>
                    <li class="breadcrumb-item">
                        <a href="<?= BASE_URL ?>/jobs/detail?id=<?= $job['id'] ?>">
                            <?= htmlspecialchars($job['title']) ?>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Nộp hồ sơ</li>
                </ol>
            </nav>

            <!-- Thông tin job -->
            <div class="alert alert-primary border-0 mb-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-briefcase-fill fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 fw-bold"><?= htmlspecialchars($job['title']) ?></h5>
                        <span class="text-muted">
                            <i class="bi bi-building me-1"></i><?= htmlspecialchars($job['company']) ?>
                            <?php if ($job['location']): ?>
                            &nbsp;|&nbsp;<i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($job['location']) ?>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Form nộp hồ sơ -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-send me-2"></i>Nộp hồ sơ ứng tuyển
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?= BASE_URL ?>/jobs/apply" method="POST"
                          enctype="multipart/form-data" id="applyForm">
                        <!-- Job ID ẩn -->
                        <input type="hidden" name="job_id" value="<?= $job['id'] ?>">

                        <!-- Upload CV PDF -->
                        <div class="mb-4">
                            <label for="cv_file" class="form-label fw-semibold">
                                <i class="bi bi-file-earmark-pdf me-1 text-danger"></i>
                                Upload CV (PDF) <span class="text-muted fw-normal">— tối đa 5MB</span>
                            </label>
                            <input type="file" class="form-control" id="cv_file" name="cv_file"
                                   accept=".pdf" onchange="validatePDF(this)">
                            <div class="form-text">
                                Chỉ chấp nhận file <strong>.pdf</strong>, tối đa <strong>5MB</strong>.
                            </div>
                            <div id="fileError" class="text-danger small d-none"></div>
                        </div>

                        <!-- Thư xin việc -->
                        <div class="mb-4">
                            <label for="cover_letter" class="form-label fw-semibold">
                                <i class="bi bi-pencil-square me-1 text-primary"></i>
                                Thư xin việc
                            </label>
                            <textarea class="form-control" id="cover_letter" name="cover_letter"
                                      rows="6" placeholder="Viết vài dòng giới thiệu bản thân và lý do bạn muốn ứng tuyển vị trí này..."></textarea>
                            <div class="form-text">Thư xin việc giúp bạn nổi bật hơn so với các ứng viên khác.</div>
                        </div>

                        <!-- Xác nhận -->
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="confirmCheck" required>
                            <label class="form-check-label" for="confirmCheck">
                                Tôi xác nhận thông tin trong hồ sơ là trung thực và đồng ý với
                                <a href="#" class="text-primary">điều khoản dịch vụ</a>.
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold px-5">
                                <i class="bi bi-send me-2"></i>Nộp hồ sơ
                            </button>
                            <a href="<?= BASE_URL ?>/jobs/detail?id=<?= $job['id'] ?>"
                               class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-arrow-left me-1"></i>Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
