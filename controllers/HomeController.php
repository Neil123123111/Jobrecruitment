<?php
/**
 * =============================================================
 * FILE: controllers/HomeController.php
 * MỤC ĐÍCH: Xử lý trang chủ
 * =============================================================
 */
class HomeController extends Controller
{
    /**
     * Trang chủ — hiển thị job mới nhất + thống kê tóm tắt
     */
    public function index(): void
    {
        $jobModel      = new Job();
        $categoryModel = new Category();

        // Lấy 6 việc làm mới nhất để hiển thị trên trang chủ
        $latestJobs = $jobModel->getList(1, 6);

        // Lấy danh sách ngành nghề kèm số lượng job
        $categories = $categoryModel->getAll();

        // Thống kê số lượng
        $stats = [
            'jobs'       => $jobModel->countAll(),
            'categories' => $categoryModel->countAll(),
        ];

        $this->render('home/index', [
            'latestJobs' => $latestJobs,
            'categories' => $categories,
            'stats'      => $stats,
            'flash'      => $this->getFlash(),
        ]);
    }
}
