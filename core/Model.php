<?php
/**
 * =============================================================
 * FILE: core/Model.php
 * MỤC ĐÍCH: Lớp Model cơ sở — cung cấp PDO và các phương thức
 *            query tiện lợi cho các Model con kế thừa.
 * =============================================================
 */
abstract class Model
{
    /** @var PDO Kết nối database */
    protected PDO $db;

    /** @var string Tên bảng — mỗi Model con khai báo lại */
    protected string $table = '';

    public function __construct()
    {
        // Lấy kết nối PDO từ singleton
        $this->db = Database::getInstance();
    }

    /**
     * Thực thi câu lệnh SELECT và trả về nhiều dòng
     *
     * @param string $sql   Câu lệnh SQL có placeholders
     * @param array  $params Mảng tham số binding
     * @return array
     */
    protected function query(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Thực thi câu lệnh SELECT và trả về 1 dòng duy nhất
     */
    protected function queryOne(string $sql, array $params = []): array|false
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    /**
     * Thực thi câu lệnh INSERT/UPDATE/DELETE
     *
     * @return bool
     */
    protected function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Lấy ID của bản ghi vừa INSERT
     */
    protected function lastInsertId(): string
    {
        return $this->db->lastInsertId();
    }

    /**
     * Đếm số dòng kết quả của một câu query
     */
    protected function count(string $sql, array $params = []): int
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }
}
