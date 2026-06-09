# WEBSITE TUYỂN DỤNG VIỆC LÀM TRỰC TUYẾN
## Đồ án môn học Công nghệ Web — PHP + MySQL MVC

---

## 📁 Cấu trúc thư mục

```
Internetvacongngheweb/
├── config/
│   └── database.php          ← Cấu hình kết nối DB & hằng số ứng dụng
├── core/
│   ├── Database.php          ← PDO Singleton — kết nối database
│   ├── Model.php             ← Lớp Model cơ sở
│   ├── Controller.php        ← Lớp Controller cơ sở
│   └── Router.php            ← Front Controller Router
├── models/
│   ├── User.php              ← Model người dùng
│   ├── Category.php          ← Model ngành nghề
│   ├── Job.php               ← Model tin tuyển dụng
│   └── Application.php       ← Model hồ sơ ứng tuyển
├── controllers/
│   ├── HomeController.php    ← Trang chủ
│   ├── AuthController.php    ← Đăng ký / Đăng nhập / Đăng xuất
│   ├── JobController.php     ← Danh sách, tìm kiếm, ứng tuyển
│   ├── ProfileController.php ← Hồ sơ cá nhân
│   ├── ApplicationController.php ← Lịch sử ứng tuyển
│   └── admin/
│       ├── AdminDashboardController.php
│       ├── AdminUserController.php
│       ├── AdminJobController.php
│       ├── AdminCategoryController.php
│       └── AdminApplicationController.php
├── middleware/
│   ├── AuthMiddleware.php    ← Kiểm tra đăng nhập
│   └── AdminMiddleware.php   ← Kiểm tra quyền Admin
├── views/
│   ├── layouts/
│   │   ├── header.php        ← Header dùng chung (User)
│   │   └── footer.php        ← Footer dùng chung (User)
│   ├── home/index.php        ← Trang chủ
│   ├── auth/
│   │   ├── login.php         ← Form đăng nhập
│   │   └── register.php      ← Form đăng ký
│   ├── jobs/
│   │   ├── index.php         ← Danh sách việc làm + tìm kiếm
│   │   ├── detail.php        ← Chi tiết việc làm
│   │   └── apply.php         ← Form nộp hồ sơ
│   ├── profile/index.php     ← Hồ sơ cá nhân
│   ├── applications/history.php ← Lịch sử ứng tuyển
│   └── admin/
│       ├── layouts/
│       │   ├── header.php    ← Header Admin (có sidebar)
│       │   └── footer.php    ← Footer Admin
│       ├── dashboard/index.php
│       ├── users/            ← index, create, edit
│       ├── jobs/             ← index, create, edit
│       ├── categories/       ← index, create, edit
│       └── applications/index.php
├── public/
│   ├── css/style.css         ← CSS tùy chỉnh
│   └── js/main.js            ← JavaScript tùy chỉnh
├── uploads/cv/               ← Thư mục lưu file CV PDF (cần quyền ghi)
├── index.php                 ← Front Controller (điểm vào duy nhất)
├── .htaccess                 ← URL Rewriting rules
├── database.sql              ← Schema database + seed data
├── install.php               ← Script cài đặt ban đầu
└── README.md                 ← File này
```

---

## ⚙️ Yêu cầu hệ thống

| Thành phần | Phiên bản |
|------------|-----------|
| PHP        | 8.0+      |
| MySQL      | 5.7+      |
| Apache     | mod_rewrite enabled |
| XAMPP      | 8.x (khuyến nghị) |

---

## 🚀 Hướng dẫn cài đặt trên XAMPP

### Bước 1: Copy source code

1. Mở thư mục `C:\xampp\htdocs\` (Windows) hoặc `/Applications/XAMPP/htdocs/` (macOS)
2. Copy toàn bộ thư mục dự án vào trong `htdocs/`
3. Đặt tên thư mục là `Internetvacongngheweb`
4. Kết quả: `htdocs/Internetvacongngheweb/`

### Bước 2: Bật Apache và MySQL

1. Mở **XAMPP Control Panel**
2. Nhấn **Start** cho **Apache** và **MySQL**
3. Đảm bảo cả hai đều hiển thị màu xanh (Running)

### Bước 3: Bật mod_rewrite (nếu chưa bật)

1. Trong XAMPP Control Panel, nhấn **Config** → **Apache (httpd.conf)**
2. Tìm dòng: `#LoadModule rewrite_module modules/mod_rewrite.so`
3. Xóa dấu `#` ở đầu để uncomment
4. Tìm `AllowOverride None` (trong thẻ `<Directory "...htdocs...">`) → đổi thành `AllowOverride All`
5. Lưu file và **Restart Apache**

### Bước 4: Cài đặt database

**Cách 1 (Khuyến nghị):** Dùng install.php
```
http://localhost/Internetvacongngheweb/install.php
```
Script sẽ tự động:
- Tạo database `jobrecruitment`
- Tạo tất cả các bảng
- Chèn dữ liệu mẫu
- Tạo tài khoản Admin và User demo

**Cách 2:** Import file SQL
1. Mở `http://localhost/phpmyadmin`
2. Tạo database tên `jobrecruitment` (charset: utf8mb4)
3. Chọn database → tab **Import** → chọn file `database.sql` → nhấn **Go**

### Bước 5: Kiểm tra cấu hình

Mở `config/database.php` và kiểm tra:
```php
define('DB_HOST', 'localhost');   // Thường giữ nguyên
define('DB_NAME', 'jobrecruitment');
define('DB_USER', 'root');        // XAMPP mặc định
define('DB_PASS', '');            // XAMPP mặc định (rỗng)
define('BASE_PATH', '/Internetvacongngheweb'); // Tên thư mục dự án
```

### Bước 6: Chạy thử

Truy cập: **http://localhost/Internetvacongngheweb/**

---

## 🔑 Tài khoản mặc định

| Loại  | Email                        | Mật khẩu  | Quyền |
|-------|------------------------------|-----------|-------|
| Admin | admin@jobrecruitment.com     | Admin@123 | admin |
| User  | user@example.com             | User@123  | user  |

> ⚠️ **Bảo mật:** Đổi mật khẩu Admin sau khi cài đặt và **xóa file `install.php`**!

---

## 🔗 Danh sách URL

### Giao diện User

| URL | Mô tả |
|-----|-------|
| `/` | Trang chủ |
| `/jobs` | Danh sách việc làm |
| `/jobs?keyword=php` | Tìm kiếm theo từ khóa |
| `/jobs?category=1` | Lọc theo ngành nghề |
| `/jobs?page=2` | Trang 2 |
| `/jobs/detail?id=1` | Chi tiết việc làm |
| `/jobs/apply?id=1` | Form nộp hồ sơ |
| `/login` | Đăng nhập |
| `/register` | Đăng ký |
| `/logout` | Đăng xuất |
| `/profile` | Hồ sơ cá nhân |
| `/my-applications` | Lịch sử ứng tuyển |

### Giao diện Admin

| URL | Mô tả |
|-----|-------|
| `/admin/dashboard` | Dashboard thống kê |
| `/admin/users` | Danh sách người dùng |
| `/admin/users/create` | Thêm người dùng |
| `/admin/users/edit?id=X` | Sửa người dùng |
| `/admin/jobs` | Danh sách tin tuyển dụng |
| `/admin/jobs/create` | Thêm tin tuyển dụng |
| `/admin/jobs/edit?id=X` | Sửa tin tuyển dụng |
| `/admin/categories` | Danh sách ngành nghề |
| `/admin/categories/create` | Thêm ngành nghề |
| `/admin/applications` | Quản lý hồ sơ ứng tuyển |

---

## ✅ Danh sách chức năng kiểm thử

### A. Chức năng User

- [ ] **Đăng ký:** Vào `/register` → điền form → submit → chuyển về `/login`
- [ ] **Đăng nhập:** Vào `/login` → nhập `user@example.com` / `User@123` → đăng nhập thành công
- [ ] **Trang chủ:** Hiển thị 6 job mới nhất và danh sách ngành nghề
- [ ] **Xem danh sách job:** Vào `/jobs` → thấy danh sách và phân trang
- [ ] **Tìm kiếm:** Nhập từ khóa "PHP" → lọc đúng kết quả
- [ ] **Lọc ngành:** Chọn "Công nghệ thông tin" → chỉ hiện jobs CNTT
- [ ] **Chi tiết job:** Click vào job → xem mô tả, yêu cầu, quyền lợi
- [ ] **Nộp hồ sơ:** Upload CV PDF (< 5MB) + thư xin việc → nộp thành công
- [ ] **Xem lịch sử:** Vào `/my-applications` → thấy danh sách đã nộp + trạng thái
- [ ] **Cập nhật profile:** Vào `/profile` → sửa thông tin → lưu thành công
- [ ] **Đổi mật khẩu:** Điền mật khẩu cũ + mới → đổi thành công
- [ ] **Đăng xuất:** Click Đăng xuất → session bị xóa → về trang login

### B. Chức năng Admin

- [ ] **Đăng nhập Admin:** `admin@jobrecruitment.com` / `Admin@123` → vào `/admin/dashboard`
- [ ] **Dashboard:** Hiển thị số liệu thống kê (users, jobs, applications)
- [ ] **Quản lý User:** Xem/Thêm/Sửa/Xóa người dùng
- [ ] **Quản lý Job:** Thêm tin tuyển dụng mới với đầy đủ thông tin
- [ ] **Sửa Job:** Cập nhật thông tin, thay đổi trạng thái active/closed
- [ ] **Xóa Job:** Xóa tin → thấy confirm dialog → xóa thành công
- [ ] **Quản lý Ngành nghề:** Thêm/Sửa/Xóa danh mục
- [ ] **Duyệt hồ sơ:** Vào `/admin/applications` → nhấn "Duyệt" → badge chuyển xanh
- [ ] **Từ chối hồ sơ:** Nhấn "Từ chối" → badge chuyển đỏ
- [ ] **Middleware:** Thử truy cập `/admin/users` khi chưa đăng nhập → redirect về `/login`

### C. Bảo mật

- [ ] **SQL Injection:** Thử nhập `' OR 1=1 --` vào ô tìm kiếm → không bị lỗi SQL
- [ ] **XSS:** Thử nhập `<script>alert(1)</script>` vào form → được encode, không chạy
- [ ] **File upload:** Thử upload file `.php` hoặc `.exe` → bị từ chối
- [ ] **File size:** Thử upload PDF > 5MB → bị từ chối
- [ ] **CSRF (cơ bản):** Các thao tác xóa dùng form POST (không phải GET link)
- [ ] **Password hash:** Mở phpMyAdmin xem bảng users → password dạng `$2y$...`

---

## 🏗️ Kiến trúc MVC

```
Request URL
    │
    ▼
.htaccess (rewrite)
    │
    ▼
index.php (Front Controller)
    │ Load config, core, models, controllers
    │
    ▼
Router::dispatch()
    │ Khớp METHOD + PATH → Controller + Action
    │
    ▼
Controller (AuthController, JobController, ...)
    │ Gọi Middleware kiểm tra quyền
    │ Gọi Model để lấy/lưu dữ liệu
    │
    ▼
Model (User, Job, Category, Application)
    │ Dùng PDO để query database
    │
    ▼
View (views/*.php)
    │ Hiển thị HTML + dữ liệu (đã escape XSS)
    │
    ▼
Response (HTML trả về trình duyệt)
```

---

## 🛡️ Các biện pháp bảo mật đã áp dụng

| Loại | Cách thực hiện |
|------|----------------|
| SQL Injection | Dùng PDO Prepared Statements với binding params |
| XSS | `htmlspecialchars()` với ENT_QUOTES khi xuất dữ liệu ra HTML |
| Password | `password_hash()` với PASSWORD_DEFAULT (bcrypt) |
| File Upload | Kiểm tra MIME type thực sự bằng `finfo`, giới hạn kích thước |
| Session | `session_start()`, xóa sạch session khi logout |
| Authorization | Middleware kiểm tra `$_SESSION['user_role']` trước mỗi action Admin |
| Delete | Dùng form POST (không phải GET link) để xóa dữ liệu |

---

## 📝 Ghi chú

- Source code có comment tiếng Việt đầy đủ để dễ hiểu
- Không dùng Framework Laravel hay bất kỳ framework nào khác
- Bootstrap 5 được load từ CDN (cần có Internet)
- File CV được lưu trong thư mục `uploads/cv/` (cần quyền ghi `chmod 755`)
