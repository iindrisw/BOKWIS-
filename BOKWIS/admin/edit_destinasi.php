<?php
include '../koneksi.php';

// cek id
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];

// ambil data destinasi
$query = mysqli_query($conn, "
    SELECT * FROM destinasi 
    WHERE id_destinasi='$id'
");

$data = mysqli_fetch_assoc($query);

// proses update
if (isset($_POST['update'])) {

    $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori   = mysqli_real_escape_string($conn, $_POST['kategori']);
    $harga      = mysqli_real_escape_string($conn, $_POST['harga']);

    $gambar = $data['gambar'];

    // cek upload gambar baru
    if ($_FILES['gambar']['name'] != '') {

        $namaFile = $_FILES['gambar']['name'];
        $tmpFile  = $_FILES['gambar']['tmp_name'];

        $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        $allowed = ['jpg','jpeg','png','webp'];

        if (in_array($ext, $allowed)) {

            // hapus gambar lama
            if (file_exists("../foto/" . $gambar)) {
                unlink("../foto/" . $gambar);
            }

            // rename gambar baru
            $gambarBaru = time() . '_' . rand(100,999) . '.' . $ext;

            move_uploaded_file($tmpFile, "../foto/" . $gambarBaru);

            $gambar = $gambarBaru;
        }
    }

    // update database
    $update = mysqli_query($conn, "
        UPDATE destinasi SET
            nama_destinasi='$nama',
            kategori='$kategori',
            harga_tiket='$harga',
            gambar='$gambar'
        WHERE id_destinasi='$id'
    ");

    if ($update) {

        echo "
        <script>
            alert('Destinasi berhasil diupdate!');
            window.location='dashboard.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Gagal update data!');
            window.history.back();
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Destinasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background: linear-gradient(135deg, #ffd6e7, #ffeef5);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-custom{
            border: none;
            border-radius: 30px;
            overflow: hidden;
            background: white;
        }

        .header-pink{
            background: linear-gradient(135deg, #ff4da6, #ff80bf);
            padding: 25px;
            color: white;
            text-align: center;
        }

        .header-pink h2{
            font-weight: bold;
            margin: 0;
        }

        .form-control,
        .form-select{
            border-radius: 15px;
            padding: 12px;
            border: 1px solid #ffc2da;
        }

        .form-control:focus,
        .form-select:focus{
            border-color: #ff4da6;
            box-shadow: 0 0 0 0.2rem rgba(255,77,166,0.2);
        }

        .preview{
            width: 100%;
            height: 240px;
            object-fit: cover;
            border-radius: 20px;
            border: 4px solid #ffd6e7;
        }

        .btn-pink{
            background: linear-gradient(135deg, #ff4da6, #ff80bf);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 20px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-pink:hover{
            transform: translateY(-2px);
            opacity: 0.9;
            color: white;
        }

        .btn-kembali{
            text-decoration: none;
            color: #ff4da6;
            font-weight: 600;
        }

    </style>
</head>
<body>

<div class="container py-5">

    <div class="card card-custom shadow-lg mx-auto" style="max-width:700px;">

        <div class="header-pink">
            <h2>🌸 Edit Destinasi Wisata</h2>
            <p class="mb-0 small">
                Ubah informasi destinasi wisata dengan mudah
            </p>
        </div>

        <div class="p-4">

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Nama Wisata
                    </label>

                    <input type="text"
                           name="nama"
                           value="<?= $data['nama_wisata']; ?>"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Kategori
                    </label>

                    <select name="kategori" class="form-select">

                        <option value="Pantai"
                        <?= $data['kategori']=='Pantai' ? 'selected' : ''; ?>>
                        Pantai
                        </option>

                        <option value="Gunung"
                        <?= $data['kategori']=='Gunung' ? 'selected' : ''; ?>>
                        Gunung
                        </option>

                        <option value="Alam"
                        <?= $data['kategori']=='Alam' ? 'selected' : ''; ?>>
                        Alam
                        </option>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Harga Tiket
                    </label>

                    <input type="number"
                           name="harga"
                           value="<?= $data['harga_tiket']; ?>"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Gambar Saat Ini
                    </label>

                    <img src="../foto/<?= $data['gambar']; ?>"
                         class="preview mb-3">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">
                        Ganti Gambar
                    </label>

                    <input type="file"
                           name="gambar"
                           class="form-control">
                </div>

                <button type="submit"
                        name="update"
                        class="btn btn-pink w-100 mb-3">
                    💾 UPDATE DESTINASI
                </button>

                <div class="text-center">
                    <a href="dashboard.php" class="btn-kembali">
                        ← Kembali ke Dashboard
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>