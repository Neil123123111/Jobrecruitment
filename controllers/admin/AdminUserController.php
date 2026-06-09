<?php
/**
 * =============================================================
 * FILE: controllers/admin/AdminUserController.php
 * MỤC ĐÍCH: Quản lý người dùng (CRUD)
 * =============================================================
 */
class AdminUserController extends Controller
{
    // ── Danh sách ─────────────────────────────────────────────────

    /**
     * Danh sách người dùng [GET /admin/users]
     */
    public function index(): void
    {
        AdminMiddleware::handle();

        $userModel = new User();
        $users     = $userModel->getAll();

        $this->render('admin/users/index', [
            'users' => $users,
            'flash' => $this->getFlash(),
        ]);
    }

    // ── Tạo mới ───────────────────────────────────────────────────

    /**
     * Form tạo người dùng [GET /admin/users/create]
     */
    public function createForm(): void
    {
        AdminMiddleware::handle();
        $this->render('admin/users/create', ['flash' => $this->getFlash()]);
    }

    /**
     * Xử lý tạo người dùng [POST /admin/users/create]
     */
    public function create(): void
    {
        AdminMiddleware::handle();

        $fullname = trim($_POST['fullname'] ?? '');
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');
        $phone    = trim($_POST['phone']    ?? '');
        $role     = in_array($_POST['role'] ?? '', ['user', 'admin']) ? $_POST['role'] : 'user';

        // Validate
        if (empty($fullname) || empty($email) || empty($password)) {
            $this->setFlash('error', 'Vui lòng điền đầy đủ thông tin bắt buộc.');
            $this->redirect('/admin/users/create');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setFlash('error', 'Email không hợp lệ.');
            $this->redirect('/admin/users/create');
        }

        $userModel = new User();
        if ($userModel->emailExists($email)) {
            $this->setFlash('error', 'Email đã tồn tại trong hệ thống.');
            $this->redirect('/admin/users/create');
        }

        $result = $userModel->create([
            'fullname' => $fullname,
            'email'    => $email,
            'password' => $password,
            'phone'    => $phone,
            'role'     => $role,
        ]);

        if ($result) {
            $this->setFlash('success', 'Tạo người dùng thành công!');
        } else {
            $this->setFlash('error', 'Tạo người dùng thất bại.');
        }

        $this->redirect('/admin/users');
    }

    // ── Chỉnh sửa ─────────────────────────────────────────────────

    /**
     * Form chỉnh sửa [GET /admin/users/edit?id=X]
     */
    public function editForm(): void
    {
        AdminMiddleware::handle();

        $id   = (int) ($_GET['id'] ?? 0);
        $user = (new User())->findById($id);

        if (!$user) {
            $this->setFlash('error', 'Không tìm thấy người dùng.');
            $this->redirect('/admin/users');
        }

        $this->render('admin/users/edit', [
            'user'  => $user,
            'flash' => $this->getFlash(),
        ]);
    }

    /**
     * Xử lý chỉnh sửa [POST /admin/users/edit]
     */
    public function edit(): void
    {
        AdminMiddleware::handle();

        $id       = (int) ($_POST['id'] ?? 0);
        $fullname = trim($_POST['fullname'] ?? '');
        $email    = trim($_POST['email']    ?? '');
        $phone    = trim($_POST['phone']    ?? '');
        $role     = in_array($_POST['role'] ?? '', ['user', 'admin']) ? $_POST['role'] : 'user';

        if (empty($fullname) || empty($email)) {
            $this->setFlash('error', 'Vui lòng điền đầy đủ thông tin.');
            $this->redirect('/admin/users/edit?id=' . $id);
        }

        $userModel = new User();
        if ($userModel->emailExists($email, $id)) {
            $this->setFlash('error', 'Email đã tồn tại trong hệ thống.');
            $this->redirect('/admin/users/edit?id=' . $id);
        }

        // Ngăn admin tự xóa quyền của chính mình
        if ($id === $_SESSION['user_id'] && $role !== 'admin') {
            $this->setFlash('error', 'Không thể thay đổi quyền của chính bạn.');
            $this->redirect('/admin/users/edit?id=' . $id);
        }

        $result = $userModel->adminUpdate($id, [
            'fullname' => $fullname,
            'email'    => $email,
            'phone'    => $phone,
            'role'     => $role,
        ]);

        // Cập nhật mật khẩu nếu được nhập
        $newPassword = trim($_POST['new_password'] ?? '');
        if (!empty($newPassword)) {
            if (strlen($newPassword) < 6) {
                $this->setFlash('error', 'Mật khẩu phải có ít nhất 6 ký tự.');
                $this->redirect('/admin/users/edit?id=' . $id);
            }
            $userModel->updatePassword($id, $newPassword);
        }

        if ($result) {
            $this->setFlash('success', 'Cập nhật người dùng thành công!');
        } else {
            $this->setFlash('error', 'Cập nhật thất bại.');
        }

        $this->redirect('/admin/users');
    }

    // ── Xóa ───────────────────────────────────────────────────────

    /**
     * Xóa người dùng [POST /admin/users/delete?id=X]
     */
    public function delete(): void
    {
        AdminMiddleware::handle();

        $id = (int) ($_POST['id'] ?? 0);

        // Không cho phép xóa chính mình
        if ($id === $_SESSION['user_id']) {
            $this->setFlash('error', 'Không thể xóa tài khoản của chính bạn.');
            $this->redirect('/admin/users');
        }

        $result = (new User())->delete($id);

        if ($result) {
            $this->setFlash('success', 'Xóa người dùng thành công!');
        } else {
            $this->setFlash('error', 'Xóa thất bại. Người dùng không tồn tại.');
        }

        $this->redirect('/admin/users');
    }
}
