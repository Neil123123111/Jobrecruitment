<?php
/**
 * =============================================================
 * FILE: config/database.php
 * MỤC ĐÍCH: Cấu hình kết nối Database và hằng số ứng dụng
 * =============================================================
 *
 * HƯỚNG DẪN THIẾT LẬP:
 * 1. Mở file này và chỉnh sửa DB_USER, DB_PASS cho phù hợp
 * 2. Chỉnh BASE_PATH nếu thư mục dự án khác tên
 *    Ví dụ: đặt tại htdocs/myproject → BASE_PATH = '/myproject'
 */

// ---------------------------------------------------------------
// Thông tin kết nối MySQL
// ---------------------------------------------------------------
define('DB_HOST',    '127.0.0.1');       // Dùng TCP để tránh lỗi socket "No such file or directory"
define('DB_NAME',    'jobrecruitment'); // Tên database
define('DB_PORT',    3306);              // Cổng MySQL (XAMPP mặc định: 3306)
define('DB_USER',    'root');           // Tên người dùng MySQL (XAMPP mặc định: root)
define('DB_PASS',    '');               // Mật khẩu MySQL   (XAMPP mặc định: rỗng)
define('DB_CHARSET', 'utf8mb4');        // Bộ mã ký tự hỗ trợ tiếng Việt

// ---------------------------------------------------------------
// Cấu hình đường dẫn ứng dụng
// ---------------------------------------------------------------
// BASE_PATH được tự nhận diện từ SCRIPT_NAME để dùng được cả:
// - XAMPP:  http://localhost/Internetvacongngheweb
// - PHP built-in server: http://localhost:3000
$detectedBasePath = '';
if (isset($_SERVER['SCRIPT_NAME'])) {
	$detectedBasePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
	if ($detectedBasePath === '/' || $detectedBasePath === '.') {
		$detectedBasePath = '';
	}
}
define('BASE_PATH', rtrim($detectedBasePath, '/'));

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('BASE_URL', $scheme . '://' . $host . BASE_PATH);

// ---------------------------------------------------------------
// Cấu hình Upload file CV
// ---------------------------------------------------------------
define('UPLOAD_DIR', __DIR__ . '/../uploads/cv/');  // Thư mục lưu CV
define('MAX_FILE_SIZE', 5 * 1024 * 1024);           // Giới hạn 5MB
define('ALLOWED_MIME', 'application/pdf');           // Chỉ chấp nhận PDF
