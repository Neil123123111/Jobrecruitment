<?php
/**
 * =============================================================
 * FILE: controllers/admin/AdminDashboardController.php
 * MỤC ĐÍCH: Dashboard Admin — thống kê tổng quan
 * =============================================================
 */
class AdminDashboardController extends Controller
{
    /**
     * Trang dashboard [GET /admin/dashboard]
     */
    public function index(): void
    {
        AdminMiddleware::handle(); // Kiểm tra quyền Admin

        $userModel = new User();
        $jobModel  = new Job();
        $appModel  = new Application();

        // Thống kê tổng quan
        $stats = [
            'total_users'        => $userModel->countAll(),
            'total_jobs'         => $jobModel->countAll(),
            'total_applications' => $appModel->countAll(),
            'pending'            => $appModel->countByStatus('pending'),
            'approved'           => $appModel->countByStatus('approved'),
            'rejected'           => $appModel->countByStatus('rejected'),
        ];

        // 5 hồ sơ ứng tuyển mới nhất
        $recentApplications = (new Application())->getAll();
        $recentApplications = array_slice($recentApplications, 0, 5);

        $this->render('admin/dashboard/index', [
            'stats'              => $stats,
            'recentApplications' => $recentApplications,
            'flash'              => $this->getFlash(),
        ]);
    }
}
