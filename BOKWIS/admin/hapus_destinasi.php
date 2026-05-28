<?php
include '../koneksi.php';

// cek apakah ada id
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // ambil data gambar dulu
    $query = mysqli_query($conn, "
        SELECT gambar 
        FROM destinasi 
        WHERE id_destinasi='$id'
    ");

    $data = mysqli_fetch_assoc($query);

    // hapus file gambar dari folder foto
    if ($data && file_exists("../foto/" . $data['gambar'])) {
        unlink("../foto/" . $data['gambar']);
    }

    // hapus data dari database
    $hapus = mysqli_query($conn, "
        DELETE FROM destinasi 
        WHERE id_destinasi='$id'
    ");

    // cek berhasil
    if ($hapus) {

        echo "
        <script>
            alert('Destinasi berhasil dihapus!');
            window.location='dashboard.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Gagal menghapus destinasi!');
            window.location='dashboard.php';
        </script>
        ";
    }

} else {

    header("Location: dashboard.php");
    exit();
}
?>