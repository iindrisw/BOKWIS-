<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_destinasi = $_POST['id_destinasi'];
    $nama_user    = mysqli_real_escape_string($conn, $_POST['nama_user']);
    $rating       = $_POST['rating'];
    $komentar     = mysqli_real_escape_string($conn, $_POST['komentar']);
    
    $nama_file = "";
    if ($_FILES['foto_review']['name'] != "") {
        $nama_file = time() . "_" . $_FILES['foto_review']['name'];
        move_uploaded_file($_FILES['foto_review']['tmp_name'], "foto/" . $nama_file);
    }

    $query = "INSERT INTO review (id_destinasi, nama_user, rating, komentar, foto_review) 
              VALUES ('$id_destinasi', '$nama_user', '$rating', '$komentar', '$nama_file')";

    mysqli_query($conn, $query);
    header("Location: detail.php?id=" . $id_destinasi);
}
?>