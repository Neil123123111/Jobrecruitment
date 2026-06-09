<?php
/**
 * =============================================================
 * FILE: core/Controller.php
 * MỤC ĐÍCH: Lớp Controller cơ sở — cung cấp các phương thức
 *            render view, redirect và truyền dữ liệu cho view.
 * =============================================================
 */
abstract class Controller
{
    /**
     * Render (hiển thị) một file view
     *
     * @param string $view   Đường dẫn view tương đối, ví dụ: 'jobs/index'
     * @param array  $data   Dữ liệu truyền vào view (dùng extract)
     */
    protected function render(string $view, array $data = []): void
    {
        // extract() chuyển $data['key'] thành biến $key trong view
        extract($data);

        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("View không tồn tại: {$viewPath}");
        }

        require $viewPath;
    }

    /**
     * Chuyển hướng trình duyệt đến URL khác
     *
     * @param string $path Đường dẫn tương đối (không có BASE_PATH)
     */
    protected function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . $path);
        exit;
    }

    /**
     * Lưu thông báo flash vào session (hiển thị 1 lần rồi xóa)
     *
     * @param string $type    Loại thông báo: 'success' | 'error' | 'warning' | 'info'
     * @param string $message Nội dung thông báo
     */
    protected function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    /**
     * Lấy và xóa thông báo flash
     *
     * @return array|null
     */
    protected function getFlash(): ?array
    {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

    /**
     * Làm sạch dữ liệu đầu vào để chống XSS
     * (Encode các ký tự HTML đặc biệt)
     *
     * @param string $input
     * @return string
     */
    protected function sanitize(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Kiểm tra người dùng đã đăng nhập chưa
     */
    protected function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Kiểm tra người dùng có quyền admin không
     */
    protected function isAdmin(): bool
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    /**
     * Yêu cầu người dùng phải đăng nhập, nếu không thì redirect
     */
    protected function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
            $this->setFlash('error', 'Vui lòng đăng nhập để tiếp tục.');
            $this->redirect('/login');
        }
    }

    /**
     * Yêu cầu quyền Admin
     */
    protected function requireAdmin(): void
    {
        if (!$this->isLoggedIn()) {
            $this->setFlash('error', 'Vui lòng đăng nhập để tiếp tục.');
            $this->redirect('/login');
        }
        if (!$this->isAdmin()) {
            $this->setFlash('error', 'Bạn không có quyền truy cập trang này.');
            $this->redirect('/');
        }
    }
}
