<?php
/**
 * =============================================================
 * FILE: controllers/ProfileController.php
 * MỤC ĐÍCH: Xử lý xem và cập nhật hồ sơ cá nhân
 * =============================================================
 */
class ProfileController extends Controller
{
    /**
     * Hiển thị trang hồ sơ cá nhân [GET /profile]
     */
    public function index(): void
    {
        AuthMiddleware::handle();

        $userModel = new User();
        $user      = $userModel->findById($_SESSION['user_id']);

        if (!$user) {
            $this->setFlash('error', 'Không tìm thấy thông tin người dùng.');
            $this->redirect('/');
        }

        $this->render('profile/index', [
            'user'  => $user,
            'flash' => $this->getFlash(),
        ]);
    }

    /**
     * Cập nhật hồ sơ cá nhân [POST /profile/update]
     */
    public function update(): void
    {
        AuthMiddleware::handle();

        $userId  = $_SESSION['user_id'];
        $fullname = trim($_POST['fullname'] ?? '');
        $phone    = trim($_POST['phone']    ?? '');
        $address  = trim($_POST['address']  ?? '');
        $bio      = trim($_POST['bio']      ?? '');

        // Validate
        if (empty($fullname)) {
            $this->setFlash('error', 'Họ và tên không được để trống.');
            $this->redirect('/profile');
        }

        $userModel = new User();

        // Cập nhật thông tin
        $result = $userModel->updateProfile($userId, [
            'fullname' => $fullname,
            'phone'    => $phone,
            'address'  => $address,
            'bio'      => $bio,
        ]);

        // Cập nhật mật khẩu nếu người dùng nhập
        $newPassword = trim($_POST['new_password'] ?? '');
        if (!empty($newPassword)) {
            if (strlen($newPassword) < 6) {
                $this->setFlash('error', 'Mật khẩu mới phải có ít nhất 6 ký tự.');
                $this->redirect('/profile');
            }

            $oldPassword = trim($_POST['old_password'] ?? '');
            $currentUser = $userModel->findById($userId);

            if (!password_verify($oldPassword, $currentUser['password'])) {
                $this->setFlash('error', 'Mật khẩu cũ không đúng.');
                $this->redirect('/profile');
            }

            $userModel->updatePassword($userId, $newPassword);
        }

        // Cập nhật tên trong session
        $_SESSION['user_name'] = $fullname;

        if ($result) {
            $this->setFlash('success', 'Cập nhật hồ sơ thành công!');
        } else {
            $this->setFlash('error', 'Cập nhật thất bại. Vui lòng thử lại.');
        }

        $this->redirect('/profile');
    }
}
