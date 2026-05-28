<?php
include '../koneksi.php';

// cek apakah form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ambil data form
    $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori   = mysqli_real_escape_string($conn, $_POST['kategori']);
    $harga      = mysqli_real_escape_string($conn, $_POST['harga']);

    // upload gambar
    $namaFile   = $_FILES['gambar']['name'];
    $tmpFile    = $_FILES['gambar']['tmp_name'];
    $error      = $_FILES['gambar']['error'];

    // folder upload
    $folder = "../foto/";

    // buat folder jika belum ada
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    // cek upload berhasil
    if ($error === 0) {

        // ambil ekstensi file
        $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        // format yang diizinkan
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {

            // rename file biar unik
            $namaBaru = time() . '_' . rand(100,999) . '.' . $ext;

            // pindahkan file
            move_uploaded_file($tmpFile, $folder . $namaBaru);

            // simpan ke database
            $query = mysqli_query($conn, "
                INSERT INTO destinasi 
                (nama_wisata, kategori, harga_tiket, gambar)
                VALUES
                ('$nama', '$kategori', '$harga', '$namaBaru')
            ");

            if ($query) {

                echo "
                <script>
                    alert('Destinasi berhasil ditambahkan!');
                    window.location='dashboard.php';
                </script>
                ";

            } else {

                echo "
                <script>
                    alert('Gagal menyimpan data!');
                    window.history.back();
                </script>
                ";
            }

        } else {

            echo "
            <script>
                alert('Format gambar tidak didukung!');
                window.history.back();
            </script>
            ";
        }

    } else {

        echo "
        <script>
            alert('Gagal upload gambar!');
            window.history.back();
        </script>
        ";
    }
}
?>