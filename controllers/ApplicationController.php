<?php
/**
 * =============================================================
 * FILE: controllers/ApplicationController.php
 * MỤC ĐÍCH: Xử lý lịch sử ứng tuyển của người dùng
 * =============================================================
 */
class ApplicationController extends Controller
{
    /**
     * Lịch sử ứng tuyển [GET /my-applications]
     */
    public function history(): void
    {
        AuthMiddleware::handle();

        $appModel    = new Application();
        $applications = $appModel->getByUser($_SESSION['user_id']);

        $this->render('applications/history', [
            'applications' => $applications,
            'flash'        => $this->getFlash(),
        ]);
    }
}
