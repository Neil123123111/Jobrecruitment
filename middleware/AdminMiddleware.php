<?php
/**
 * =============================================================
 * FILE: middleware/AdminMiddleware.php
 * MỤC ĐÍCH: Kiểm tra người dùng có quyền Admin không
 *
 * Cách dùng trong Admin Controller:
 *   AdminMiddleware::handle();  // Redirect nếu không phải admin
 * =============================================================
 */
class AdminMiddleware
{
    /**
     * Yêu cầu quyền Admin
     * - Nếu chưa đăng nhập → redirect về /login
     * - Nếu không phải admin → redirect về trang chủ với thông báo lỗi
     */
    public static function handle(): void
    {
        // Kiểm tra đã đăng nhập chưa
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = [
                'type'    => 'error',
                'message' => 'Vui lòng đăng nhập để tiếp tục.',
            ];
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Kiểm tra có quyền admin không
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['flash'] = [
                'type'    => 'error',
                'message' => 'Bạn không có quyền truy cập trang Admin.',
            ];
            header('Location: ' . BASE_URL . '/');
            exit;
        }
    }
}
