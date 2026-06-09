<?php
/**
 * =============================================================
 * FILE: models/Category.php
 * MỤC ĐÍCH: Thao tác với bảng `categories` (ngành nghề)
 * =============================================================
 */
class Category extends Model
{
    protected string $table = 'categories';

    /**
     * Lấy tất cả ngành nghề (kèm số lượng job)
     */
    public function getAll(): array
    {
        return $this->query(
            "SELECT c.*, COUNT(j.id) AS job_count
             FROM `categories` c
             LEFT JOIN `jobs` j ON j.category_id = c.id AND j.status = 'active'
             GROUP BY c.id
             ORDER BY c.name ASC"
        );
    }

    /**
     * Lấy tất cả ngành nghề đơn giản (cho dropdown)
     */
    public function getAllSimple(): array
    {
        return $this->query("SELECT `id`, `name` FROM `categories` ORDER BY `name` ASC");
    }

    /**
     * Tìm ngành nghề theo ID
     */
    public function findById(int $id): array|false
    {
        return $this->queryOne("SELECT * FROM `categories` WHERE `id` = ?", [$id]);
    }

    /**
     * Đếm tổng số ngành nghề
     */
    public function countAll(): int
    {
        return $this->count("SELECT COUNT(*) FROM `categories`");
    }

    /**
     * Tạo ngành nghề mới
     */
    public function create(string $name): bool
    {
        return $this->execute(
            "INSERT INTO `categories` (`name`) VALUES (?)",
            [trim($name)]
        );
    }

    /**
     * Cập nhật tên ngành nghề
     */
    public function update(int $id, string $name): bool
    {
        return $this->execute(
            "UPDATE `categories` SET `name` = ? WHERE `id` = ?",
            [trim($name), $id]
        );
    }

    /**
     * Xóa ngành nghề
     */
    public function delete(int $id): bool
    {
        return $this->execute("DELETE FROM `categories` WHERE `id` = ?", [$id]);
    }

    /**
     * Kiểm tra tên ngành nghề đã tồn tại chưa
     */
    public function nameExists(string $name, ?int $excludeId = null): bool
    {
        if ($excludeId) {
            return $this->count(
                "SELECT COUNT(*) FROM `categories` WHERE `name` = ? AND `id` != ?",
                [$name, $excludeId]
            ) > 0;
        }
        return $this->count(
            "SELECT COUNT(*) FROM `categories` WHERE `name` = ?",
            [$name]
        ) > 0;
    }
}
