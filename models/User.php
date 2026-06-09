<?php
/**
 * =============================================================
 * FILE: models/User.php
 * MỤC ĐÍCH: Thao tác với bảng `users`
 * =============================================================
 */
class User extends Model
{
    protected string $table = 'users';

    // ── Truy vấn ─────────────────────────────────────────────────

    /**
     * Lấy tất cả người dùng (cho admin)
     */
    public function getAll(): array
    {
        return $this->query("SELECT * FROM `users` ORDER BY `created_at` DESC");
    }

    /**
     * Tìm user theo ID
     */
    public function findById(int $id): array|false
    {
        return $this->queryOne("SELECT * FROM `users` WHERE `id` = ?", [$id]);
    }

    /**
     * Tìm user theo email (dùng để đăng nhập)
     */
    public function findByEmail(string $email): array|false
    {
        return $this->queryOne("SELECT * FROM `users` WHERE `email` = ?", [$email]);
    }

    /**
     * Đếm tổng số user (cho dashboard admin)
     */
    public function countAll(): int
    {
        return $this->count("SELECT COUNT(*) FROM `users` WHERE `role` = 'user'");
    }

    // ── Ghi dữ liệu ──────────────────────────────────────────────

    /**
     * Tạo tài khoản người dùng mới
     *
     * @param array $data Mảng chứa: fullname, email, password (plain), phone
     * @return bool
     */
    public function create(array $data): bool
    {
        // Hash mật khẩu trước khi lưu vào DB — KHÔNG BAO GIỜ lưu plain text
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        return $this->execute(
            "INSERT INTO `users` (`fullname`, `email`, `password`, `phone`, `role`)
             VALUES (?, ?, ?, ?, ?)",
            [
                $data['fullname'],
                $data['email'],
                $hashedPassword,
                $data['phone'] ?? null,
                $data['role'] ?? 'user',
            ]
        );
    }

    /**
     * Cập nhật thông tin cá nhân (profile)
     */
    public function updateProfile(int $id, array $data): bool
    {
        return $this->execute(
            "UPDATE `users`
             SET `fullname` = ?, `phone` = ?, `address` = ?, `bio` = ?
             WHERE `id` = ?",
            [
                $data['fullname'],
                $data['phone']   ?? null,
                $data['address'] ?? null,
                $data['bio']     ?? null,
                $id,
            ]
        );
    }

    /**
     * Cập nhật mật khẩu (hash trước khi lưu)
     */
    public function updatePassword(int $id, string $newPassword): bool
    {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->execute(
            "UPDATE `users` SET `password` = ? WHERE `id` = ?",
            [$hash, $id]
        );
    }

    /**
     * Admin cập nhật thông tin user
     */
    public function adminUpdate(int $id, array $data): bool
    {
        return $this->execute(
            "UPDATE `users`
             SET `fullname` = ?, `email` = ?, `phone` = ?, `role` = ?
             WHERE `id` = ?",
            [
                $data['fullname'],
                $data['email'],
                $data['phone'] ?? null,
                $data['role'],
                $id,
            ]
        );
    }

    /**
     * Xóa người dùng theo ID
     */
    public function delete(int $id): bool
    {
        return $this->execute("DELETE FROM `users` WHERE `id` = ?", [$id]);
    }

    /**
     * Kiểm tra email đã tồn tại chưa (dùng khi đăng ký)
     *
     * @param string   $email Email cần kiểm tra
     * @param int|null $excludeId Bỏ qua user có ID này (dùng khi edit)
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        if ($excludeId) {
            return $this->count(
                "SELECT COUNT(*) FROM `users` WHERE `email` = ? AND `id` != ?",
                [$email, $excludeId]
            ) > 0;
        }
        return $this->count(
            "SELECT COUNT(*) FROM `users` WHERE `email` = ?",
            [$email]
        ) > 0;
    }
}
