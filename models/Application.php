<?php
/**
 * =============================================================
 * FILE: models/Application.php
 * MỤC ĐÍCH: Thao tác với bảng `applications` (hồ sơ ứng tuyển)
 * =============================================================
 */
class Application extends Model
{
    protected string $table = 'applications';

    /**
     * Lấy lịch sử ứng tuyển của một user (kèm thông tin job)
     */
    public function getByUser(int $userId): array
    {
        return $this->query(
            "SELECT a.*, j.title AS job_title, j.company, j.location, j.salary
             FROM `applications` a
             INNER JOIN `jobs` j ON j.id = a.job_id
             WHERE a.user_id = ?
             ORDER BY a.created_at DESC",
            [$userId]
        );
    }

    /**
     * Lấy tất cả hồ sơ ứng tuyển (cho admin, kèm thông tin user & job)
     */
    public function getAll(): array
    {
        return $this->query(
            "SELECT a.*,
                    u.fullname AS user_name, u.email AS user_email,
                    j.title AS job_title, j.company
             FROM `applications` a
             INNER JOIN `users` u ON u.id = a.user_id
             INNER JOIN `jobs`  j ON j.id = a.job_id
             ORDER BY a.created_at DESC"
        );
    }

    /**
     * Lấy chi tiết 1 hồ sơ ứng tuyển
     */
    public function findById(int $id): array|false
    {
        return $this->queryOne(
            "SELECT a.*,
                    u.fullname AS user_name, u.email AS user_email, u.phone AS user_phone,
                    j.title AS job_title, j.company
             FROM `applications` a
             INNER JOIN `users` u ON u.id = a.user_id
             INNER JOIN `jobs`  j ON j.id = a.job_id
             WHERE a.id = ?",
            [$id]
        );
    }

    /**
     * Kiểm tra user đã ứng tuyển job này chưa
     */
    public function hasApplied(int $userId, int $jobId): bool
    {
        return $this->count(
            "SELECT COUNT(*) FROM `applications` WHERE `user_id` = ? AND `job_id` = ?",
            [$userId, $jobId]
        ) > 0;
    }

    /**
     * Nộp hồ sơ ứng tuyển
     */
    public function create(array $data): bool
    {
        return $this->execute(
            "INSERT INTO `applications` (`user_id`, `job_id`, `cv_file`, `cover_letter`)
             VALUES (?, ?, ?, ?)",
            [
                $data['user_id'],
                $data['job_id'],
                $data['cv_file']      ?? null,
                $data['cover_letter'] ?? null,
            ]
        );
    }

    /**
     * Admin cập nhật trạng thái hồ sơ (duyệt/từ chối)
     *
     * @param int    $id     ID hồ sơ
     * @param string $status 'approved' | 'rejected' | 'pending'
     */
    public function updateStatus(int $id, string $status): bool
    {
        // Kiểm tra giá trị hợp lệ
        if (!in_array($status, ['pending', 'approved', 'rejected'], true)) {
            return false;
        }

        return $this->execute(
            "UPDATE `applications` SET `status` = ? WHERE `id` = ?",
            [$status, $id]
        );
    }

    /**
     * Xóa hồ sơ ứng tuyển
     */
    public function delete(int $id): bool
    {
        return $this->execute("DELETE FROM `applications` WHERE `id` = ?", [$id]);
    }

    /**
     * Đếm tổng số hồ sơ (cho dashboard)
     */
    public function countAll(): int
    {
        return $this->count("SELECT COUNT(*) FROM `applications`");
    }

    /**
     * Đếm theo trạng thái
     */
    public function countByStatus(string $status): int
    {
        return $this->count(
            "SELECT COUNT(*) FROM `applications` WHERE `status` = ?",
            [$status]
        );
    }
}
