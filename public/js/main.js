/**
 * FILE: public/js/main.js
 * Mô tả: JavaScript tùy chỉnh cho Website Tuyển Dụng
 */

// ── Toggle hiển thị/ẩn mật khẩu ─────────────────────────────────
/**
 * @param {string} inputId - ID của input password
 */
function togglePassword(inputId) {
    const input   = document.getElementById(inputId);
    const eyeIcon = document.getElementById('eyeIcon_' + inputId);

    if (!input) return;

    if (input.type === 'password') {
        input.type = 'text';
        if (eyeIcon) eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        if (eyeIcon) eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

// ── Xác nhận trước khi xóa ──────────────────────────────────────
/**
 * @param {string} itemName - Tên đối tượng cần xóa
 * @returns {boolean}
 */
function confirmDelete(itemName) {
    return confirm(`⚠️ Bạn có chắc chắn muốn xóa ${itemName}?\nHành động này không thể hoàn tác!`);
}

// ── Validate upload file PDF (phía client) ───────────────────────
/**
 * @param {HTMLInputElement} input - Input file element
 */
function validatePDF(input) {
    const errorDiv  = document.getElementById('fileError');
    const maxSize   = 5 * 1024 * 1024; // 5MB

    if (!input.files || input.files.length === 0) return;

    const file = input.files[0];

    // Kiểm tra extension
    if (!file.name.toLowerCase().endsWith('.pdf')) {
        input.value = '';
        if (errorDiv) {
            errorDiv.textContent = '❌ Chỉ chấp nhận file PDF!';
            errorDiv.classList.remove('d-none');
        }
        return;
    }

    // Kiểm tra kích thước
    if (file.size > maxSize) {
        input.value = '';
        if (errorDiv) {
            errorDiv.textContent = `❌ File quá lớn! Tối đa 5MB (file bạn chọn: ${(file.size / 1024 / 1024).toFixed(2)}MB)`;
            errorDiv.classList.remove('d-none');
        }
        return;
    }

    // Hợp lệ
    if (errorDiv) errorDiv.classList.add('d-none');
}

// ── Kiểm tra khớp mật khẩu ──────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

    // Kiểm tra confirm password khi đăng ký
    const passwordInput  = document.getElementById('password');
    const confirmInput   = document.getElementById('password_confirm');
    const matchMsg       = document.getElementById('passwordMatchMsg');

    if (confirmInput && passwordInput && matchMsg) {
        function checkPasswordMatch() {
            if (confirmInput.value === '') {
                matchMsg.textContent = '';
                return;
            }
            if (passwordInput.value === confirmInput.value) {
                matchMsg.textContent  = '✅ Mật khẩu khớp nhau.';
                matchMsg.className    = 'form-text text-success';
            } else {
                matchMsg.textContent  = '❌ Mật khẩu không khớp.';
                matchMsg.className    = 'form-text text-danger';
            }
        }

        confirmInput.addEventListener('input', checkPasswordMatch);
        passwordInput.addEventListener('input', checkPasswordMatch);
    }

    // Tự động ẩn flash message sau 5 giây
    const flashAlerts = document.querySelectorAll('.alert.fade.show');
    flashAlerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Highlight menu navbar theo URL hiện tại
    const currentPath = window.location.pathname;
    document.querySelectorAll('.navbar .nav-link').forEach(link => {
        const href = link.getAttribute('href');
        if (href && href !== '/' && currentPath.startsWith(href)) {
            link.classList.add('active');
        }
    });
});
