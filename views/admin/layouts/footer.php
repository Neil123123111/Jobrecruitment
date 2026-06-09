    </div><!-- /p-4 -->
</div><!-- /admin-content -->
</div><!-- /d-flex -->

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="<?= BASE_URL ?>/public/js/main.js"></script>

<script>
// Tự động highlight menu item đang active trong sidebar
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        const href = link.getAttribute('href');
        if (href && currentPath.startsWith(href) && href !== '<?= BASE_URL ?>/') {
            link.classList.add('active');
        }
    });
});
</script>
</body>
</html>
