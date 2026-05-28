<?php
session_start();
include '../koneksi.php';

// cek login admin
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

$id_admin = $_SESSION['admin']['id_admin'];

// ambil data admin
$query = mysqli_query($conn, "
    SELECT * FROM admin 
    WHERE id_admin='$id_admin'
");

$admin = mysqli_fetch_assoc($query);

// proses update profil
if (isset($_POST['update'])) {

    $nama       = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username   = mysqli_real_escape_string($conn, $_POST['username']);

    // foto lama
    $foto = $admin['foto'];

    // upload foto baru
    if ($_FILES['foto']['name'] != '') {

        $namaFile  = time() . '_' . $_FILES['foto']['name'];
        $tmp       = $_FILES['foto']['tmp_name'];

        move_uploaded_file($tmp, "upload/" . $namaFile);

        $foto = $namaFile;
    }

    // update password jika diisi
    if (!empty($_POST['password'])) {

        $password = md5($_POST['password']);

        mysqli_query($conn, "
            UPDATE admin SET
                nama_lengkap='$nama',
                username='$username',
                password='$password',
                foto='$foto'
            WHERE id_admin='$id_admin'
        ");

    } else {

        mysqli_query($conn, "
            UPDATE admin SET
                nama_lengkap='$nama',
                username='$username',
                foto='$foto'
            WHERE id_admin='$id_admin'
        ");
    }

    // refresh session
    $_SESSION['admin']['nama_lengkap'] = $nama;
    $_SESSION['admin']['username'] = $username;

    echo "
    <script>
        alert('Profil berhasil diperbarui!');
        window.location='profil.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Admin - BOKWIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* ===== BACKGROUND ===== */
body{
    background: url('../foto/bg.jpg') no-repeat center center fixed;
    background-size: cover;
    min-height: 100vh;
    overflow-x: hidden;
    position: relative;
    font-family: 'Poppins', sans-serif;
    animation: bgZoom 18s ease-in-out infinite alternate;
}

body::before{
    content: "";
    position: fixed;
    inset: 0;
    background:
        radial-gradient(circle at center,
        rgba(255,255,255,0.08),
        rgba(0,0,0,0.78));
    z-index: -1;
    animation: glowMove 10s ease-in-out infinite alternate;
}

body::after{
    content: "";
    position: fixed;
    inset: 0;
    background:
        radial-gradient(circle, rgba(255,255,255,0.10) 2px, transparent 3px);
    background-size: 120px 120px;
    animation: sparkle 20s linear infinite;
    opacity: 0.5;
    z-index: -1;
}

@keyframes bgZoom{
    0%{
        background-size: 100%;
    }
    100%{
        background-size: 110%;
    }
}

@keyframes glowMove{
    0%{
        opacity: 0.5;
        filter: blur(0px);
    }
    100%{
        opacity: 1;
        filter: blur(10px);
    }
}

@keyframes sparkle{
    from{
        background-position: 0 0;
    }
    to{
        background-position: 300px 300px;
    }
}

/* CARD */
.card-profile{
    border: 1px solid rgba(255,255,255,0.10);
    border-radius: 30px;
    overflow: hidden;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(15px);
    box-shadow: 0 0 25px rgba(255,255,255,0.08);
    transition: 0.4s;
}

.card-profile:hover{
    transform: translateY(-5px);
    box-shadow: 0 0 30px rgba(255,255,255,0.15);
}

/* HEADER */
.header-profile{
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(15px);
    border-bottom: 1px solid rgba(255,255,255,0.08);
    padding: 45px 30px;
    text-align: center;
    color: white;
}

.avatar{
    width: 140px;
    height: 140px;
    border-radius: 50%;
    overflow: hidden;
    margin: auto;
    margin-bottom: 18px;
    border: 4px solid rgba(255,255,255,0.2);
    background: white;
    box-shadow: 0 0 25px rgba(255,255,255,0.25);
    display: flex;
    align-items: center;
    justify-content: center;
}

.foto-profile{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* FONT */
h2,h6,label{
    color: rgba(255,255,255,0.95) !important;
    text-shadow: 0 0 8px rgba(255,255,255,0.15);
}

p,
small,
.text-muted{
    color: rgba(255,255,255,0.75) !important;
}

/* INFO BOX */
.info-box{
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 18px;
    backdrop-filter: blur(10px);
}

/* INPUT */
.form-control{
    border-radius: 15px;
    padding: 14px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    color: white;
    backdrop-filter: blur(10px);
}

.form-control::placeholder{
    color: rgba(255,255,255,0.45);
}

.form-control:focus{
    background: rgba(255,255,255,0.10);
    color: white;
    border-color: rgba(255,255,255,0.25);
    box-shadow: 0 0 12px rgba(255,255,255,0.12);
}

/* FILE INPUT */
input[type=file]{
    color: white;
}

/* BUTTON */
.btn-pink{
    background: rgba(255,255,255,0.10);
    border: 1px solid rgba(255,255,255,0.12);
    color: white;
    padding: 14px;
    border-radius: 20px;
    font-weight: 600;
    transition: 0.3s;
    backdrop-filter: blur(10px);
}

.btn-pink:hover{
    transform: translateY(-2px);
    background: rgba(255,255,255,0.16);
    box-shadow: 0 0 20px rgba(255,255,255,0.12);
    color: white;
}

/* BACK BUTTON */
.btn-back{
    text-decoration: none;
    color: rgba(255,255,255,0.85);
    font-weight: 600;
    transition: 0.3s;
}

.btn-back:hover{
    color: white;
    text-shadow: 0 0 10px rgba(255,255,255,0.25);
}

</style>

</head>
<body>

<div class="container py-5">

    <div class="card card-profile shadow-lg mx-auto" style="max-width:700px;">

        <!-- HEADER -->
        <div class="header-profile">

            <div class="avatar">

                <?php if($admin['foto'] != ''){ ?>

                    <img src="upload/<?= $admin['foto']; ?>" 
                         class="foto-profile">

                <?php } else { ?>

                    <?= strtoupper(substr($admin['nama_lengkap'],0,1)); ?>

                <?php } ?>

            </div>

            <h2 class="fw-bold mb-1">
                <?= $admin['nama_lengkap']; ?>
            </h2>

            <p class="mb-0 opacity-75">
                Administrator BOKWIS
            </p>

        </div>

        <!-- BODY -->
        <div class="p-4">

            <div class="info-box mb-4">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Username</small>
                        <h6 class="fw-bold">
                            <?= $admin['username']; ?>
                        </h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">ID Admin</small>
                        <h6 class="fw-bold">
                            #<?= $admin['id_admin']; ?>
                        </h6>
                    </div>

                </div>

            </div>

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Nama Lengkap
                    </label>

                    <input type="text"
                           name="nama_lengkap"
                           value="<?= $admin['nama_lengkap']; ?>"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Username
                    </label>

                    <input type="text"
                           name="username"
                           value="<?= $admin['username']; ?>"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Foto Profil
                    </label>

                    <input type="file"
                           name="foto"
                           class="form-control">

                </div>

                <div class="mb-4">

                    <label class="form-label fw-bold">
                        Password Baru
                    </label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Kosongkan jika tidak ingin mengganti">

                </div>

                <button type="submit"
                        name="update"
                        class="btn btn-pink w-100 mb-3">

                    💾 Simpan Perubahan

                </button>

                <div class="text-center">

                    <a href="dashboard.php" class="btn-back">
                        ← Kembali ke Dashboard
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>