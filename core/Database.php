<?php
/**
 * =============================================================
 * FILE: core/Database.php
 * MỤC ĐÍCH: Lớp kết nối PDO — Singleton Pattern
 *
 * Singleton Pattern đảm bảo chỉ tạo 1 kết nối PDO duy nhất
 * trong suốt vòng đời của một request, tránh lãng phí tài nguyên.
 * =============================================================
 */
class Database
{
    /** @var PDO|null Giữ instance PDO duy nhất */
    private static ?PDO $instance = null;

    /**
     * Lấy kết nối PDO (tạo mới nếu chưa tồn tại)
     *
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            // DSN (Data Source Name): chuỗi kết nối MySQL
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                DB_HOST,
                DB_PORT,
                DB_NAME,
                DB_CHARSET
            );

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // Ném exception khi lỗi
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // Trả về mảng kết hợp
                PDO::ATTR_EMULATE_PREPARES   => false,                    // Dùng prepared statements thật
            ];

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                // Ghi log lỗi, không lộ thông tin nhạy cảm ra màn hình
                error_log('Database connection failed: ' . $e->getMessage());
                die('<h3 style="color:red;text-align:center">Không thể kết nối database.<br>Vui lòng kiểm tra cấu hình trong config/database.php</h3>');
            }
        }

        return self::$instance;
    }

    // Ngăn chặn clone instance
    private function __clone() {}

    // Ngăn chặn unserialize instance
    public function __wakeup(): void
    {
        throw new \Exception("Không thể unserialize singleton Database.");
    }
}
