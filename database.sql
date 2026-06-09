-- ================================================================
-- WEBSITE TUYỂN DỤNG VIỆC LÀM TRỰC TUYẾN
-- File: database.sql
-- Mô tả: Tạo cấu trúc database và dữ liệu mẫu (seed data)
--
-- CÁCH SỬ DỤNG:
--   1. Mở phpMyAdmin (http://localhost/phpmyadmin)
--   2. Nhấn "Import" → chọn file này → nhấn "Go"
--   HOẶC chạy: mysql -u root -p < database.sql
--   HOẶC chạy file install.php để tự động tạo (khuyến nghị)
-- ================================================================

-- Tạo database nếu chưa có
CREATE DATABASE IF NOT EXISTS `jobrecruitment`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `jobrecruitment`;

-- ----------------------------------------------------------------
-- Xóa bảng cũ nếu tồn tại (để chạy lại script được)
-- Thứ tự xóa: bảng con trước, bảng cha sau (tránh lỗi foreign key)
-- ----------------------------------------------------------------
DROP TABLE IF EXISTS `applications`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;

-- ================================================================
-- BẢNG 1: users — Thông tin người dùng
-- ================================================================
CREATE TABLE `users` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY    COMMENT 'Khóa chính',
    `fullname`   VARCHAR(100)  NOT NULL            COMMENT 'Họ và tên đầy đủ',
    `email`      VARCHAR(100)  NOT NULL UNIQUE     COMMENT 'Email (dùng để đăng nhập)',
    `password`   VARCHAR(255)  NOT NULL            COMMENT 'Mật khẩu đã hash bằng password_hash()',
    `phone`      VARCHAR(20)   DEFAULT NULL        COMMENT 'Số điện thoại',
    `address`    VARCHAR(255)  DEFAULT NULL        COMMENT 'Địa chỉ',
    `bio`        TEXT          DEFAULT NULL        COMMENT 'Giới thiệu bản thân',
    `role`       ENUM('user', 'admin') NOT NULL DEFAULT 'user' COMMENT 'Phân quyền: user hoặc admin',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời điểm tạo tài khoản'
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Bảng người dùng hệ thống';

-- ================================================================
-- BẢNG 2: categories — Ngành nghề
-- ================================================================
CREATE TABLE `categories` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Khóa chính',
    `name`       VARCHAR(100) NOT NULL          COMMENT 'Tên ngành nghề',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Bảng danh mục ngành nghề';

-- ================================================================
-- BẢNG 3: jobs — Tin tuyển dụng
-- ================================================================
CREATE TABLE `jobs` (
    `id`           INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Khóa chính',
    `category_id`  INT           NOT NULL         COMMENT 'Ngành nghề (FK → categories.id)',
    `title`        VARCHAR(200)  NOT NULL         COMMENT 'Tiêu đề vị trí tuyển dụng',
    `company`      VARCHAR(200)  NOT NULL         COMMENT 'Tên công ty tuyển dụng',
    `salary`       VARCHAR(100)  DEFAULT NULL     COMMENT 'Mức lương (VD: 10-15 triệu)',
    `location`     VARCHAR(200)  DEFAULT NULL     COMMENT 'Địa điểm làm việc',
    `description`  TEXT          DEFAULT NULL     COMMENT 'Mô tả công việc chi tiết',
    `requirements` TEXT          DEFAULT NULL     COMMENT 'Yêu cầu ứng viên',
    `benefits`     TEXT          DEFAULT NULL     COMMENT 'Quyền lợi được hưởng',
    `deadline`     DATE          DEFAULT NULL     COMMENT 'Hạn nộp hồ sơ',
    `status`       ENUM('active', 'closed') NOT NULL DEFAULT 'active' COMMENT 'Trạng thái: active=đang tuyển, closed=đã đóng',
    `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời điểm đăng tin',
    CONSTRAINT `fk_jobs_category`
        FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Bảng tin tuyển dụng việc làm';

-- ================================================================
-- BẢNG 4: applications — Hồ sơ ứng tuyển
-- ================================================================
CREATE TABLE `applications` (
    `id`           INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Khóa chính',
    `user_id`      INT          NOT NULL          COMMENT 'Người ứng tuyển (FK → users.id)',
    `job_id`       INT          NOT NULL          COMMENT 'Việc làm ứng tuyển (FK → jobs.id)',
    `cv_file`      VARCHAR(255) DEFAULT NULL      COMMENT 'Tên file CV PDF đã upload',
    `cover_letter` TEXT         DEFAULT NULL      COMMENT 'Thư xin việc',
    `status`       ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending'
                                                  COMMENT 'Trạng thái: pending=chờ duyệt, approved=đã duyệt, rejected=từ chối',
    `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời điểm nộp hồ sơ',
    CONSTRAINT `fk_app_user`
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_app_job`
        FOREIGN KEY (`job_id`) REFERENCES `jobs`(`id`) ON DELETE CASCADE,
    CONSTRAINT `uq_user_job`
        UNIQUE KEY (`user_id`, `job_id`) COMMENT 'Mỗi user chỉ được nộp 1 lần cho 1 job'
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Bảng hồ sơ ứng tuyển';

-- ================================================================
-- DỮ LIỆU MẪU — SEED DATA
-- ================================================================

-- ── Ngành nghề ──────────────────────────────────────────────────
INSERT INTO `categories` (`name`) VALUES
('Công nghệ thông tin'),
('Kế toán - Tài chính'),
('Marketing - Truyền thông'),
('Nhân sự - Hành chính'),
('Kỹ thuật - Cơ khí'),
('Y tế - Dược phẩm'),
('Giáo dục - Đào tạo'),
('Bán hàng - Kinh doanh');

-- ── Tin tuyển dụng mẫu ──────────────────────────────────────────
INSERT INTO `jobs` (`category_id`, `title`, `company`, `salary`, `location`, `description`, `requirements`, `benefits`, `deadline`) VALUES
(1, 'Lập trình viên PHP Backend',
    'Công ty Cổ phần FPT Software',
    '15 - 25 triệu',
    'Hà Nội',
    'Phát triển và bảo trì các ứng dụng web sử dụng PHP. Làm việc trong môi trường Agile/Scrum, phối hợp với team Frontend và BA để xây dựng sản phẩm.',
    '- Tốt nghiệp CNTT hoặc ngành liên quan\n- Có kinh nghiệm PHP 1-3 năm\n- Biết MySQL, REST API\n- Có kiến thức về Git',
    '- Lương thưởng cạnh tranh\n- BHXH, BHYT đầy đủ\n- Môi trường làm việc quốc tế\n- Thưởng dự án',
    '2025-12-31'),

(1, 'Frontend Developer (React.js)',
    'VNG Corporation',
    '20 - 35 triệu',
    'Hồ Chí Minh',
    'Xây dựng giao diện người dùng với React.js cho các sản phẩm của VNG. Tối ưu hiệu năng và trải nghiệm người dùng.',
    '- Thành thạo React, JavaScript ES6+\n- Biết HTML5/CSS3, Bootstrap hoặc Tailwind\n- Có portfolio cá nhân là lợi thế',
    '- Stock option\n- MacBook cá nhân\n- Flexible working time\n- Du lịch hàng năm',
    '2025-11-30'),

(1, 'DevOps / Cloud Engineer',
    'Tiki Corporation',
    '25 - 40 triệu',
    'Hồ Chí Minh',
    'Quản lý hạ tầng cloud, xây dựng CI/CD pipeline cho hệ thống thương mại điện tử quy mô lớn.',
    '- Kinh nghiệm Docker, Kubernetes\n- AWS/GCP certifications\n- Scripting Python/Bash\n- Hiểu biết về networking',
    '- Thưởng hiệu suất hấp dẫn\n- Đào tạo chứng chỉ quốc tế\n- Xe đưa đón',
    '2025-12-15'),

(2, 'Kế toán tổng hợp',
    'Công ty TNHH Unilever Việt Nam',
    '12 - 18 triệu',
    'Hà Nội',
    'Phụ trách kế toán tổng hợp, lập báo cáo tài chính theo tháng/quý/năm. Hỗ trợ kiểm toán nội bộ.',
    '- Tốt nghiệp ngành Kế toán - Kiểm toán\n- Biết phần mềm kế toán MISA\n- Cẩn thận, trung thực, chịu được áp lực',
    '- Phụ cấp ăn trưa, xăng xe\n- Team building hàng quý\n- Cơ hội thăng tiến rõ ràng',
    '2025-10-31'),

(3, 'Digital Marketing Specialist',
    'Shopee Vietnam',
    '15 - 22 triệu',
    'Hồ Chí Minh',
    'Lên kế hoạch và triển khai các chiến dịch marketing online. Phân tích dữ liệu và tối ưu ROI.',
    '- Kinh nghiệm Google Ads, Facebook Ads\n- Hiểu biết SEO/SEM\n- Sáng tạo, năng động, tư duy phân tích',
    '- Commission hấp dẫn\n- Môi trường startup năng động\n- Được đào tạo các công cụ mới nhất',
    '2025-11-15'),

(4, 'Chuyên viên Tuyển dụng',
    'Tập đoàn Vingroup',
    '13 - 18 triệu',
    'Hà Nội',
    'Thực hiện toàn bộ quy trình tuyển dụng từ lập kế hoạch, đăng tin, sàng lọc hồ sơ đến phỏng vấn.',
    '- Tốt nghiệp ngành Quản trị nhân sự hoặc liên quan\n- Kỹ năng giao tiếp tốt\n- Có ít nhất 1 năm kinh nghiệm tuyển dụng',
    '- Phúc lợi tập đoàn Vingroup\n- Cơ hội làm việc toàn quốc\n- Thưởng tuyển dụng theo KPI',
    '2025-12-01'),

(8, 'Nhân viên Kinh doanh B2B',
    'Công ty CP Thế Giới Di Động',
    '10 - 20 triệu + commission',
    'Toàn quốc',
    'Tìm kiếm và phát triển khách hàng doanh nghiệp, chăm sóc khách hàng hiện tại, đạt chỉ tiêu doanh số.',
    '- Tốt nghiệp Kinh tế/Quản trị kinh doanh\n- Kỹ năng đàm phán, thuyết phục tốt\n- Có xe máy đi lại',
    '- Lương cơ bản + hoa hồng cao\n- Thưởng tháng 13\n- Đào tạo kỹ năng bán hàng chuyên sâu',
    '2025-10-15');

-- ── LƯU Ý: Tài khoản Admin & User mẫu ───────────────────────────
-- Chạy file install.php để tự động tạo tài khoản với mật khẩu đã hash
-- Tài khoản mặc định sau khi chạy install.php:
--   Admin: admin@jobrecruitment.com / Admin@123
--   User:  user@example.com         / User@123
