</main>
    </div>

    <script>
    // Contoh script jQuery jika ada notifikasi dari session
    $(document).ready(function() {
        <?php if(isset($_SESSION['success_message'])): ?>
            Swal.fire({
                title: 'Berhasil!',
                text: '<?php echo $_SESSION['success_message']; ?>',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['error_message'])): ?>
            Swal.fire({
                title: 'Gagal!',
                text: '<?php echo $_SESSION['error_message']; ?>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    });
    </script>
</body>
</html>