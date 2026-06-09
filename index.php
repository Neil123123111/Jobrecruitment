<?php
/**
 * =============================================================
 * FILE: index.php  (Front Controller)
 * MỤC ĐÍCH: Điểm vào duy nhất của ứng dụng — nhận mọi request,
 *            tải các class cần thiết rồi chuyển cho Router xử lý.
 * =============================================================
 */

// ── 1. Khởi động session ────────────────────────────────────────
session_start();

// ── 2. Load cấu hình ───────────────────────────────────────────
require_once __DIR__ . '/config/database.php';

// ── 3. Load các class lõi (core) ───────────────────────────────
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Router.php';

// ── 4. Load Middleware ──────────────────────────────────────────
require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/middleware/AdminMiddleware.php';

// ── 5. Load Models ─────────────────────────────────────────────
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Category.php';
require_once __DIR__ . '/models/Job.php';
require_once __DIR__ . '/models/Application.php';

// ── 6. Load User Controllers ───────────────────────────────────
require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/JobController.php';
require_once __DIR__ . '/controllers/ProfileController.php';
require_once __DIR__ . '/controllers/ApplicationController.php';

// ── 7. Load Admin Controllers ──────────────────────────────────
require_once __DIR__ . '/controllers/admin/AdminDashboardController.php';
require_once __DIR__ . '/controllers/admin/AdminUserController.php';
require_once __DIR__ . '/controllers/admin/AdminJobController.php';
require_once __DIR__ . '/controllers/admin/AdminCategoryController.php';
require_once __DIR__ . '/controllers/admin/AdminApplicationController.php';

// ── 8. Khởi tạo Router và đăng ký các route ────────────────────
$router = new Router();

// == Trang chủ ==
$router->get('/',     'HomeController', 'index');
$router->get('/home', 'HomeController', 'index');

// == Xác thực (Auth) ==
$router->get( '/login',    'AuthController', 'loginForm');
$router->post('/login',    'AuthController', 'login');
$router->get( '/register', 'AuthController', 'registerForm');
$router->post('/register', 'AuthController', 'register');
$router->get( '/logout',   'AuthController', 'logout');

// == Việc làm (Jobs) ==
$router->get( '/jobs',        'JobController', 'index');   // Danh sách + tìm kiếm
$router->get( '/jobs/detail', 'JobController', 'detail');  // Chi tiết ?id=X
$router->get( '/jobs/apply',  'JobController', 'applyForm'); // Form ứng tuyển ?id=X
$router->post('/jobs/apply',  'JobController', 'apply');   // Xử lý nộp hồ sơ

// == Hồ sơ cá nhân (Profile) ==
$router->get( '/profile',        'ProfileController', 'index');
$router->post('/profile/update', 'ProfileController', 'update');

// == Lịch sử ứng tuyển ==
$router->get('/my-applications', 'ApplicationController', 'history');

// == Admin: Dashboard ==
$router->get('/admin',           'AdminDashboardController', 'index');
$router->get('/admin/dashboard', 'AdminDashboardController', 'index');

// == Admin: Quản lý người dùng ==
$router->get( '/admin/users',        'AdminUserController', 'index');
$router->get( '/admin/users/create', 'AdminUserController', 'createForm');
$router->post('/admin/users/create', 'AdminUserController', 'create');
$router->get( '/admin/users/edit',   'AdminUserController', 'editForm');   // ?id=X
$router->post('/admin/users/edit',   'AdminUserController', 'edit');
$router->post('/admin/users/delete', 'AdminUserController', 'delete');     // ?id=X

// == Admin: Quản lý việc làm ==
$router->get( '/admin/jobs',        'AdminJobController', 'index');
$router->get( '/admin/jobs/create', 'AdminJobController', 'createForm');
$router->post('/admin/jobs/create', 'AdminJobController', 'create');
$router->get( '/admin/jobs/edit',   'AdminJobController', 'editForm');
$router->post('/admin/jobs/edit',   'AdminJobController', 'edit');
$router->post('/admin/jobs/delete', 'AdminJobController', 'delete');

// == Admin: Quản lý ngành nghề ==
$router->get( '/admin/categories',        'AdminCategoryController', 'index');
$router->get( '/admin/categories/create', 'AdminCategoryController', 'createForm');
$router->post('/admin/categories/create', 'AdminCategoryController', 'create');
$router->get( '/admin/categories/edit',   'AdminCategoryController', 'editForm');
$router->post('/admin/categories/edit',   'AdminCategoryController', 'edit');
$router->post('/admin/categories/delete', 'AdminCategoryController', 'delete');

// == Admin: Quản lý hồ sơ ứng tuyển ==
$router->get( '/admin/applications',               'AdminApplicationController', 'index');
$router->post('/admin/applications/update-status', 'AdminApplicationController', 'updateStatus');

// ── 9. Chạy Router ─────────────────────────────────────────────
$router->dispatch();
