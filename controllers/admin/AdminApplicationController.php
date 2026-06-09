<?php
/**
 * =============================================================
 * FILE: controllers/admin/AdminApplicationController.php
 * MỤC ĐÍCH: Quản lý hồ sơ ứng tuyển — xem và duyệt/từ chối
 * =============================================================
 */
class AdminApplicationController extends Controller
{
    /**
     * Danh sách hồ sơ ứng tuyển [GET /admin/applications]
     */
    public function index(): void
    {
        AdminMiddleware::handle();

        $appModel    = new Application();
        $applications = $appModel->getAll();

        $this->render('admin/applications/index', [
            'applications' => $applications,
            'flash'        => $this->getFlash(),
        ]);
    }

    /**
     * Cập nhật trạng thái hồ sơ [POST /admin/applications/update-status]
     *
     * POST params: id, status (approved|rejected|pending)
     */
    public function updateStatus(): void
    {
        AdminMiddleware::handle();

        $id     = (int) ($_POST['id']     ?? 0);
        $status = trim($_POST['status']   ?? '');

        // Kiểm tra giá trị status hợp lệ
        if (!in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $this->setFlash('error', 'Trạng thái không hợp lệ.');
            $this->redirect('/admin/applications');
        }

        $result = (new Application())->updateStatus($id, $status);

        $statusLabel = match($status) {
            'approved' => 'Duyệt',
            'rejected' => 'Từ chối',
            default    => 'Chờ duyệt',
        };

        if ($result) {
            $this->setFlash('success', "Đã cập nhật: {$statusLabel} hồ sơ thành công!");
        } else {
            $this->setFlash('error', 'Cập nhật trạng thái thất bại.');
        }

        $this->redirect('/admin/applications');
    }
}
