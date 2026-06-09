<?php
/**
 * =============================================================
 * FILE: middleware/AuthMiddleware.php
 * MỤC ĐÍCH: Kiểm tra người dùng đã đăng nhập chưa
 *
 * Cách dùng trong Controller:
 *   AuthMiddleware::handle();  // Redirect về /login nếu chưa đăng nhập
 * =============================================================
 */
class AuthMiddleware
{
    /**
     * Yêu cầu đăng nhập — nếu chưa đăng nhập thì redirect về trang login
     */
    public static function handle(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = [
                'type'    => 'error',
                'message' => 'Vui lòng đăng nhập để tiếp tục.',
            ];
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }
}
