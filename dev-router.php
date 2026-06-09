<?php
/**
 * Router cho PHP built-in server.
 * Nếu file/tài nguyên tồn tại thật (CSS, JS, ảnh...), trả về trực tiếp.
 * Nếu không, chuyển toàn bộ về index.php để Router MVC xử lý.
 */

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;

if ($path !== '/' && file_exists($file) && !is_dir($file)) {
    return false;
}

require __DIR__ . '/index.php';
