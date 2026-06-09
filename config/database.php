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
// Thông tin kết nối MySQL (ưu tiên env để chạy cloud như Railway)
// ---------------------------------------------------------------
$env = static function (string $key, $default = null) {
	$value = getenv($key);
	return ($value === false || $value === '') ? $default : $value;
};

$dbHost = (string) $env('MYSQLHOST', '127.0.0.1');
$dbPort = (int) $env('MYSQLPORT', 3306);
$dbName = (string) $env('MYSQLDATABASE', 'jobrecruitment');
$dbUser = (string) $env('MYSQLUSER', 'root');
$dbPass = (string) $env('MYSQLPASSWORD', '');
$dbCharset = (string) $env('DB_CHARSET', 'utf8mb4');

// Hỗ trợ chuỗi kết nối dạng DATABASE_URL/MYSQL_URL
$databaseUrl = $env('DATABASE_URL', $env('MYSQL_URL', null));
if ($databaseUrl) {
	$parts = parse_url($databaseUrl);
	if (is_array($parts)) {
		$dbHost = $parts['host'] ?? $dbHost;
		$dbPort = isset($parts['port']) ? (int) $parts['port'] : $dbPort;
		$dbName = isset($parts['path']) ? ltrim($parts['path'], '/') : $dbName;
		$dbUser = $parts['user'] ?? $dbUser;
		$dbPass = $parts['pass'] ?? $dbPass;

		if (isset($parts['query'])) {
			parse_str($parts['query'], $queryParams);
			if (!empty($queryParams['charset'])) {
				$dbCharset = (string) $queryParams['charset'];
			}
		}
	}
}

// Biến DB_* là override cao nhất để dễ chỉnh riêng trên Railway.
$dbHost = (string) $env('DB_HOST', $dbHost);
$dbPort = (int) $env('DB_PORT', $dbPort);
$dbName = (string) $env('DB_NAME', $dbName);
$dbUser = (string) $env('DB_USER', $dbUser);
$dbPass = (string) $env('DB_PASS', $dbPass);

define('DB_HOST', $dbHost);
define('DB_NAME', $dbName);
define('DB_PORT', $dbPort);
define('DB_USER', $dbUser);
define('DB_PASS', $dbPass);
define('DB_CHARSET', $dbCharset);

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

$basePathFromEnv = (string) $env('BASE_PATH', null);
if ($basePathFromEnv === '') {
	$basePathFromEnv = '/';
}
$finalBasePath = $basePathFromEnv !== null ? $basePathFromEnv : $detectedBasePath;
if ($finalBasePath === '/' || $finalBasePath === '.') {
	$finalBasePath = '';
}
define('BASE_PATH', rtrim($finalBasePath, '/'));

$forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '';
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $forwardedProto === 'https';
$scheme = $isHttps ? 'https' : 'http';
$host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('BASE_URL', $scheme . '://' . $host . BASE_PATH);

// ---------------------------------------------------------------
// Cấu hình Upload file CV
// ---------------------------------------------------------------
define('UPLOAD_DIR', __DIR__ . '/../uploads/cv/');  // Thư mục lưu CV
define('MAX_FILE_SIZE', 5 * 1024 * 1024);           // Giới hạn 5MB
define('ALLOWED_MIME', 'application/pdf');           // Chỉ chấp nhận PDF
