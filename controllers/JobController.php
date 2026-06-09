<?php
/**
 * =============================================================
 * FILE: controllers/JobController.php
 * MỤC ĐÍCH: Xử lý danh sách, chi tiết và nộp hồ sơ ứng tuyển
 * =============================================================
 */
class JobController extends Controller
{
    /**
     * Danh sách việc làm, có tìm kiếm và phân trang [GET /jobs]
     *
     * Query params:
     *   ?keyword=php  — tìm kiếm theo từ khóa
     *   ?category=1   — lọc theo ngành nghề
     *   ?page=2       — trang số 2
     */
    public function index(): void
    {
        $jobModel      = new Job();
        $categoryModel = new Category();

        // Lấy tham số tìm kiếm từ URL (lọc XSS bằng htmlspecialchars trong view)
        $keyword    = trim($_GET['keyword']  ?? '');
        $categoryId = (int) ($_GET['category'] ?? 0);
        $page       = max(1, (int) ($_GET['page'] ?? 1)); // Trang tối thiểu là 1
        $perPage    = 9; // Số job mỗi trang

        // Lấy danh sách job và tổng số để phân trang
        $jobs      = $jobModel->getList($page, $perPage, $keyword, $categoryId);
        $totalJobs = $jobModel->countList($keyword, $categoryId);
        $totalPages = (int) ceil($totalJobs / $perPage);

        // Lấy danh sách ngành nghề cho dropdown lọc
        $categories = $categoryModel->getAllSimple();

        $this->render('jobs/index', [
            'jobs'        => $jobs,
            'categories'  => $categories,
            'keyword'     => $keyword,
            'categoryId'  => $categoryId,
            'page'        => $page,
            'totalPages'  => $totalPages,
            'totalJobs'   => $totalJobs,
            'flash'       => $this->getFlash(),
        ]);
    }

    /**
     * Chi tiết việc làm [GET /jobs/detail?id=X]
     */
    public function detail(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $jobModel = new Job();
        $job      = $jobModel->findById($id);

        if (!$job) {
            $this->setFlash('error', 'Không tìm thấy tin tuyển dụng này.');
            $this->redirect('/jobs');
        }

        // Kiểm tra user đã ứng tuyển chưa (nếu đã đăng nhập)
        $hasApplied = false;
        if ($this->isLoggedIn()) {
            $appModel   = new Application();
            $hasApplied = $appModel->hasApplied($_SESSION['user_id'], $id);
        }

        // Lấy việc làm liên quan cùng ngành
        $relatedJobs = $jobModel->getRelated($id, $job['category_id']);

        $this->render('jobs/detail', [
            'job'         => $job,
            'hasApplied'  => $hasApplied,
            'relatedJobs' => $relatedJobs,
            'flash'       => $this->getFlash(),
        ]);
    }

    /**
     * Form nộp hồ sơ [GET /jobs/apply?id=X]
     */
    public function applyForm(): void
    {
        AuthMiddleware::handle(); // Yêu cầu đăng nhập

        $id = (int) ($_GET['id'] ?? 0);

        $jobModel = new Job();
        $job      = $jobModel->findById($id);

        if (!$job) {
            $this->setFlash('error', 'Không tìm thấy tin tuyển dụng.');
            $this->redirect('/jobs');
        }

        // Kiểm tra đã ứng tuyển chưa
        $appModel = new Application();
        if ($appModel->hasApplied($_SESSION['user_id'], $id)) {
            $this->setFlash('warning', 'Bạn đã nộp hồ sơ cho việc làm này rồi.');
            $this->redirect('/jobs/detail?id=' . $id);
        }

        $this->render('jobs/apply', [
            'job'   => $job,
            'flash' => $this->getFlash(),
        ]);
    }

    /**
     * Xử lý nộp hồ sơ [POST /jobs/apply]
     */
    public function apply(): void
    {
        AuthMiddleware::handle();

        $jobId       = (int) ($_POST['job_id']      ?? 0);
        $coverLetter = trim($_POST['cover_letter']  ?? '');

        $jobModel = new Job();
        $job      = $jobModel->findById($jobId);

        if (!$job) {
            $this->setFlash('error', 'Không tìm thấy tin tuyển dụng.');
            $this->redirect('/jobs');
        }

        // Kiểm tra đã ứng tuyển chưa (double-check)
        $appModel = new Application();
        if ($appModel->hasApplied($_SESSION['user_id'], $jobId)) {
            $this->setFlash('warning', 'Bạn đã nộp hồ sơ cho việc làm này rồi.');
            $this->redirect('/jobs/detail?id=' . $jobId);
        }

        // ── Xử lý upload file CV ──────────────────────────────────
        $cvFileName = null;

        if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['cv_file'];

            // Kiểm tra lỗi upload
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $this->setFlash('error', 'Lỗi khi upload file CV.');
                $this->redirect('/jobs/apply?id=' . $jobId);
            }

            // Kiểm tra kích thước (tối đa 5MB)
            if ($file['size'] > MAX_FILE_SIZE) {
                $this->setFlash('error', 'File CV không được vượt quá 5MB.');
                $this->redirect('/jobs/apply?id=' . $jobId);
            }

            // Kiểm tra loại file (chỉ chấp nhận PDF)
            // Dùng finfo để kiểm tra MIME type thực sự, không tin vào extension
            $finfo    = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($file['tmp_name']);

            if ($mimeType !== ALLOWED_MIME) {
                $this->setFlash('error', 'Chỉ chấp nhận file PDF.');
                $this->redirect('/jobs/apply?id=' . $jobId);
            }

            // Tạo tên file ngẫu nhiên để tránh ghi đè
            $ext        = '.pdf';
            $cvFileName = 'cv_' . $_SESSION['user_id'] . '_' . time() . '_' . bin2hex(random_bytes(4)) . $ext;
            $destPath   = UPLOAD_DIR . $cvFileName;

            // Tạo thư mục nếu chưa có
            if (!is_dir(UPLOAD_DIR)) {
                mkdir(UPLOAD_DIR, 0755, true);
            }

            // Di chuyển file từ thư mục tạm sang thư mục đích
            if (!move_uploaded_file($file['tmp_name'], $destPath)) {
                $this->setFlash('error', 'Không thể lưu file CV. Vui lòng thử lại.');
                $this->redirect('/jobs/apply?id=' . $jobId);
            }
        }

        // ── Lưu hồ sơ vào database ───────────────────────────────
        $result = $appModel->create([
            'user_id'      => $_SESSION['user_id'],
            'job_id'       => $jobId,
            'cv_file'      => $cvFileName,
            'cover_letter' => $coverLetter,
        ]);

        if ($result) {
            $this->setFlash('success', 'Nộp hồ sơ thành công! Chúng tôi sẽ liên hệ bạn sớm nhất.');
            $this->redirect('/my-applications');
        } else {
            $this->setFlash('error', 'Nộp hồ sơ thất bại. Vui lòng thử lại.');
            $this->redirect('/jobs/apply?id=' . $jobId);
        }
    }
}
