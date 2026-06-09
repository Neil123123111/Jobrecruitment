<?php
/**
 * =============================================================
 * FILE: core/Router.php
 * MỤC ĐÍCH: Điều phối request đến đúng Controller và Action
 *
 * Cách hoạt động:
 *   1. Đọc REQUEST_URI và REQUEST_METHOD
 *   2. So khớp với danh sách routes đã đăng ký
 *   3. Khởi tạo Controller và gọi Action tương ứng
 * =============================================================
 */
class Router
{
    /**
     * Danh sách routes đã đăng ký
     * Cấu trúc: $routes[METHOD]['/path'] = ['controller' => ..., 'action' => ...]
     */
    private array $routes = [];

    /**
     * Đăng ký route GET
     */
    public function get(string $path, string $controller, string $action): void
    {
        $this->routes['GET'][$path] = compact('controller', 'action');
    }

    /**
     * Đăng ký route POST
     */
    public function post(string $path, string $controller, string $action): void
    {
        $this->routes['POST'][$path] = compact('controller', 'action');
    }

    /**
     * Phân tích request và chuyển đến Controller/Action phù hợp
     */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // Lấy đường dẫn URI (bỏ phần query string ?key=value)
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Loại bỏ BASE_PATH khỏi URI
        // Ví dụ: /Internetvacongngheweb/jobs → /jobs
        $basePath = BASE_PATH;
        if ($basePath !== '' && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        // Chuẩn hóa: đảm bảo có dấu / ở đầu, không có ở cuối (trừ root)
        $uri = '/' . ltrim($uri, '/');
        if ($uri !== '/') {
            $uri = rtrim($uri, '/');
        }

        // Hỗ trợ truy cập trực tiếp /index.php hoặc /index.php/... khi không có rewrite
        if ($uri === '/index.php') {
            $uri = '/';
        } elseif (str_starts_with($uri, '/index.php/')) {
            $uri = substr($uri, strlen('/index.php'));
            if ($uri === '') {
                $uri = '/';
            }
        }

        // Tìm route khớp
        if (isset($this->routes[$method][$uri])) {
            $route          = $this->routes[$method][$uri];
            $controllerName = $route['controller'];
            $actionName     = $route['action'];

            // Kiểm tra class tồn tại
            if (!class_exists($controllerName)) {
                $this->sendError(500, "Controller '{$controllerName}' không tồn tại.");
                return;
            }

            // Khởi tạo Controller và gọi Action
            $controller = new $controllerName();

            if (!method_exists($controller, $actionName)) {
                $this->sendError(500, "Action '{$actionName}' không tồn tại trong '{$controllerName}'.");
                return;
            }

            $controller->$actionName();
        } else {
            // Không tìm thấy route phù hợp → 404
            $this->sendError(404, "Trang không tồn tại: {$uri}");
        }
    }

    /**
     * Hiển thị trang lỗi đơn giản
     */
    private function sendError(int $code, string $message): void
    {
        http_response_code($code);
        echo "<!DOCTYPE html><html lang='vi'><head><meta charset='UTF-8'>
              <title>Lỗi {$code}</title>
              <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
              </head><body class='bg-light'>
              <div class='container text-center mt-5'>
                  <h1 class='display-1 text-danger'>{$code}</h1>
                  <p class='lead'>" . htmlspecialchars($message) . "</p>
                  <a href='" . BASE_URL . "/' class='btn btn-primary'>🏠 Về trang chủ</a>
              </div></body></html>";
    }
}
