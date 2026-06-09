<?php
/**
 * =============================================================
 * FILE: controllers/AuthController.php
 * MỤC ĐÍCH: Xử lý đăng ký, đăng nhập, đăng xuất
 * =============================================================
 */
class AuthController extends Controller
{
    // ── ĐĂNG NHẬP ────────────────────────────────────────────────

    /**
     * Hiển thị form đăng nhập [GET /login]
     */
    public function loginForm(): void
    {
        // Nếu đã đăng nhập thì không cần vào trang này
        if ($this->isLoggedIn()) {
            $this->redirect('/');
        }

        $this->render('auth/login', [
            'flash' => $this->getFlash(),
        ]);
    }

    /**
     * Xử lý đăng nhập [POST /login]
     */
    public function login(): void
    {
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');

        // Validate đầu vào cơ bản
        if (empty($email) || empty($password)) {
            $this->setFlash('error', 'Vui lòng nhập đầy đủ email và mật khẩu.');
            $this->redirect('/login');
        }

        // Tìm user theo email
        $userModel = new User();
        $user      = $userModel->findByEmail($email);

        // Kiểm tra user tồn tại và mật khẩu đúng
        // password_verify() so sánh plain text với hash đã lưu
        if (!$user || !password_verify($password, $user['password'])) {
            $this->setFlash('error', 'Email hoặc mật khẩu không đúng.');
            $this->redirect('/login');
        }

        // Đăng nhập thành công — lưu thông tin vào session
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['fullname'];
        $_SESSION['user_role'] = $user['role'];

        // Chuyển hướng theo role
        if ($user['role'] === 'admin') {
            $this->redirect('/admin/dashboard');
        } else {
            $this->setFlash('success', 'Đăng nhập thành công! Chào mừng ' . $user['fullname']);
            $this->redirect('/');
        }
    }

    // ── ĐĂNG KÝ ──────────────────────────────────────────────────

    /**
     * Hiển thị form đăng ký [GET /register]
     */
    public function registerForm(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/');
        }

        $this->render('auth/register', [
            'flash' => $this->getFlash(),
        ]);
    }

    /**
     * Xử lý đăng ký [POST /register]
     */
    public function register(): void
    {
        $fullname        = trim($_POST['fullname']        ?? '');
        $email           = trim($_POST['email']           ?? '');
        $password        = trim($_POST['password']        ?? '');
        $passwordConfirm = trim($_POST['password_confirm'] ?? '');
        $phone           = trim($_POST['phone']           ?? '');

        // ── Validate ──────────────────────────────────────────────
        $errors = [];

        if (empty($fullname)) {
            $errors[] = 'Họ và tên không được để trống.';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ.';
        }

        if (strlen($password) < 6) {
            $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        if ($password !== $passwordConfirm) {
            $errors[] = 'Mật khẩu xác nhận không khớp.';
        }

        if (!empty($errors)) {
            $this->setFlash('error', implode('<br>', $errors));
            $this->redirect('/register');
        }

        // Kiểm tra email đã tồn tại chưa
        $userModel = new User();
        if ($userModel->emailExists($email)) {
            $this->setFlash('error', 'Email này đã được sử dụng. Vui lòng chọn email khác.');
            $this->redirect('/register');
        }

        // Tạo tài khoản (Model sẽ tự hash password)
        $result = $userModel->create([
            'fullname' => $fullname,
            'email'    => $email,
            'password' => $password,
            'phone'    => $phone,
            'role'     => 'user',
        ]);

        if ($result) {
            $this->setFlash('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
            $this->redirect('/login');
        } else {
            $this->setFlash('error', 'Đăng ký thất bại. Vui lòng thử lại.');
            $this->redirect('/register');
        }
    }

    // ── ĐĂNG XUẤT ────────────────────────────────────────────────

    /**
     * Đăng xuất [GET /logout]
     */
    public function logout(): void
    {
        // Xóa tất cả dữ liệu session
        $_SESSION = [];

        // Xóa cookie session nếu có
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        $this->redirect('/login');
    }
}
