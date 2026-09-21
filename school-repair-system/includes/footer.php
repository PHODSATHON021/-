</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 Trigger -->
<?php if (isset($_SESSION['flash_message'])): ?>
<script>
    Swal.fire({
        icon: '<?= $_SESSION['flash_type'] ?? 'info'; ?>',
        title: 'การแจ้งเตือน',
        text: '<?= htmlspecialchars($_SESSION['flash_message']); ?>',
        confirmButtonColor: '#0d6efd'
    });
</script>
<?php 
    unset($_SESSION['flash_message']);
    unset($_SESSION['flash_type']);
endif; 
?>
</body>
</html>