<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Redirect ke login atau index
echo "<script>
    alert('Berhasil Logout!');
    window.location='login.php';
</script>";
exit();
?>