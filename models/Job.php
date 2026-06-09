<?php
/**
 * =============================================================
 * FILE: models/Job.php
 * MỤC ĐÍCH: Thao tác với bảng `jobs` (tin tuyển dụng)
 * =============================================================
 */
class Job extends Model
{
    protected string $table = 'jobs';

    /**
     * Lấy danh sách việc làm có phân trang, tìm kiếm và lọc
     *
     * @param int    $page       Trang hiện tại (bắt đầu từ 1)
     * @param int    $perPage    Số bản ghi mỗi trang
     * @param string $keyword    Từ khóa tìm kiếm (tiêu đề, công ty)
     * @param int    $categoryId Lọc theo ngành nghề (0 = tất cả)
     * @return array
     */
    public function getList(int $page = 1, int $perPage = 9, string $keyword = '', int $categoryId = 0): array
    {
        $offset = ($page - 1) * $perPage;
        $params = [];

        // Xây dựng điều kiện WHERE động
        $where = ["j.status = 'active'"];

        if ($keyword !== '') {
            $where[]  = "(j.title LIKE ? OR j.company LIKE ? OR j.location LIKE ?)";
            $like     = '%' . $keyword . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        if ($categoryId > 0) {
            $where[]  = "j.category_id = ?";
            $params[] = $categoryId;
        }

        $whereClause = 'WHERE ' . implode(' AND ', $where);

        // Query lấy danh sách
        $sql = "SELECT j.*, c.name AS category_name
                FROM `jobs` j
                LEFT JOIN `categories` c ON c.id = j.category_id
                {$whereClause}
                ORDER BY j.created_at DESC
                LIMIT {$perPage} OFFSET {$offset}";

        return $this->query($sql, $params);
    }

    /**
     * Đếm tổng số việc làm theo bộ lọc (dùng tính phân trang)
     */
    public function countList(string $keyword = '', int $categoryId = 0): int
    {
        $params = [];
        $where  = ["status = 'active'"];

        if ($keyword !== '') {
            $where[]  = "(title LIKE ? OR company LIKE ? OR location LIKE ?)";
            $like     = '%' . $keyword . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        if ($categoryId > 0) {
            $where[]  = "category_id = ?";
            $params[] = $categoryId;
        }

        $whereClause = 'WHERE ' . implode(' AND ', $where);
        return $this->count("SELECT COUNT(*) FROM `jobs` {$whereClause}", $params);
    }

    /**
     * Lấy chi tiết 1 việc làm (kèm tên ngành nghề)
     */
    public function findById(int $id): array|false
    {
        return $this->queryOne(
            "SELECT j.*, c.name AS category_name
             FROM `jobs` j
             LEFT JOIN `categories` c ON c.id = j.category_id
             WHERE j.id = ?",
            [$id]
        );
    }

    /**
     * Lấy tất cả việc làm (cho admin, bao gồm cả closed)
     */
    public function getAll(): array
    {
        return $this->query(
            "SELECT j.*, c.name AS category_name
             FROM `jobs` j
             LEFT JOIN `categories` c ON c.id = j.category_id
             ORDER BY j.created_at DESC"
        );
    }

    /**
     * Đếm tổng số việc làm (active)
     */
    public function countAll(): int
    {
        return $this->count("SELECT COUNT(*) FROM `jobs` WHERE status = 'active'");
    }

    /**
     * Tạo tin tuyển dụng mới
     */
    public function create(array $data): bool
    {
        return $this->execute(
            "INSERT INTO `jobs`
                (`category_id`,`title`,`company`,`salary`,`location`,`description`,`requirements`,`benefits`,`deadline`,`status`)
             VALUES (?,?,?,?,?,?,?,?,?,?)",
            [
                $data['category_id'],
                $data['title'],
                $data['company'],
                $data['salary']       ?? null,
                $data['location']     ?? null,
                $data['description']  ?? null,
                $data['requirements'] ?? null,
                $data['benefits']     ?? null,
                $data['deadline']     ?? null,
                $data['status']       ?? 'active',
            ]
        );
    }

    /**
     * Cập nhật tin tuyển dụng
     */
    public function update(int $id, array $data): bool
    {
        return $this->execute(
            "UPDATE `jobs`
             SET `category_id`=?, `title`=?, `company`=?, `salary`=?,
                 `location`=?, `description`=?, `requirements`=?,
                 `benefits`=?, `deadline`=?, `status`=?
             WHERE `id` = ?",
            [
                $data['category_id'],
                $data['title'],
                $data['company'],
                $data['salary']       ?? null,
                $data['location']     ?? null,
                $data['description']  ?? null,
                $data['requirements'] ?? null,
                $data['benefits']     ?? null,
                $data['deadline']     ?? null,
                $data['status']       ?? 'active',
                $id,
            ]
        );
    }

    /**
     * Xóa việc làm
     */
    public function delete(int $id): bool
    {
        return $this->execute("DELETE FROM `jobs` WHERE `id` = ?", [$id]);
    }

    /**
     * Lấy việc làm liên quan cùng ngành nghề
     */
    public function getRelated(int $jobId, int $categoryId, int $limit = 3): array
    {
        return $this->query(
            "SELECT j.*, c.name AS category_name
             FROM `jobs` j
             LEFT JOIN `categories` c ON c.id = j.category_id
             WHERE j.category_id = ? AND j.id != ? AND j.status = 'active'
             ORDER BY j.created_at DESC
             LIMIT ?",
            [$categoryId, $jobId, $limit]
        );
    }
}
