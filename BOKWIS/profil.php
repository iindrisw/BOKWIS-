<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['user']['id_user'];

// Proses Update Profil (Username & Password)
if (isset($_POST['update_profil'])) {
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username     = mysqli_real_escape_string($conn, $_POST['username']);
    $email        = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Validasi apakah username/email baru sudah dipakai orang lain
    $cek_database = mysqli_query($conn, "SELECT * FROM users WHERE (username='$username' OR email='$email') AND id_user != '$id_user'");
    
    if (mysqli_num_rows($cek_database) > 0) {
        echo "<script>alert('Username atau Email sudah digunakan!'); window.history.back();</script>";
        exit;
    }

    // Cek apakah ganti password juga
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $query_update = "UPDATE users SET nama_lengkap='$nama_lengkap', username='$username', email='$email', password='$password' WHERE id_user='$id_user'";
    } else {
        $query_update = "UPDATE users SET nama_lengkap='$nama_lengkap', username='$username', email='$email' WHERE id_user='$id_user'";
    }

    if (mysqli_query($conn, $query_update)) {
        // Update data session yang aktif agar sinkron
        $_SESSION['user']['nama_lengkap'] = $nama_lengkap;
        $_SESSION['user']['username']     = $username;
        $_SESSION['user']['email']        = $email;

        echo "<script>alert('Profil berhasil diperbarui!'); window.location='profil.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui profil.'); window.history.back();</script>";
    }
}

// Ambil menu aktif dari URL (default: edit_akun)
$menu = isset($_GET['pajangan']) ? $_GET['pajangan'] : 'edit_akun';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - BOKWIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            background: url('foto/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            color: white;
        }
        body::before {
            content: ""; position: fixed; inset: 0;
            background: radial-gradient(circle at center, rgba(15, 15, 25, 0.65), rgba(0,0,0,0.85));
            z-index: -1;
        }
        .settings-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            overflow: hidden;
            margin-top: 40px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        }
        /* SIDEBAR STYLE (KIRI) */
        .sidebar-menu {
            background: rgba(0, 0, 0, 0.2);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            padding: 20px;
            min-height: 80vh;
        }
        .user-avatar-section {
            padding: 15px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .avatar-circle {
            width: 55px; height: 55px;
            background: rgba(0, 255, 255, 0.15);
            border: 1px solid rgba(0, 255, 255, 0.4);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; font-weight: bold; color: #00ffff;
            text-shadow: 0 0 10px rgba(0,255,255,0.5);
        }
        .nav-settings-link {
            display: flex; align-items: center;
            padding: 12px 16px;
            color: rgba(255,255,255,0.75) !important;
            text-decoration: none;
            border-radius: 12px;
            margin-top: 8px;
            transition: 0.3s;
            font-weight: 500;
        }
        .nav-settings-link i { margin-right: 12px; font-size: 18px; }
        .nav-settings-link:hover {
            background: rgba(255, 255, 255, 0.06);
            color: white !important;
        }
        .nav-settings-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #00ffff !important;
            box-shadow: inset 4px 0 0 #00ffff;
        }
        /* CONTENT STYLE (KANAN) - PERBAIKAN FORM CONTROL */
        .content-display { padding: 35px; }
        .form-control {
            background: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #111111 !important;
            border-radius: 14px;
            padding: 12px;
        }
        .form-control:focus {
            background: #ffffff !important;
            border-color: #00ffff;
            box-shadow: 0 0 12px rgba(0, 255, 255, 0.4);
            color: #111111 !important;
        }
        .form-control::placeholder {
            color: #777777 !important;
        }
        .btn-neon {
            background: linear-gradient(135deg, #ff00cc, #3333ff);
            border: none; color: white !important;
            padding: 12px 25px; border-radius: 14px;
            font-weight: 600; transition: 0.3s;
        }
        .btn-neon:hover {
            transform: scale(1.03);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.7);
            color: white !important;
        }
        .table { color: white !important; }
        .table th, .table td { border-color: rgba(255, 255, 255, 0.08); padding: 15px 10px; }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container my-5">
    <div class="row settings-container">
        
        <div class="col-md-4 col-lg-3 sidebar-menu">
            <div class="user-avatar-section d-flex align-items-center gap-3 mb-4">
                <div class="avatar-circle">
                    <?= strtoupper(substr($_SESSION['user']['nama_lengkap'], 0, 1)); ?>
                </div>
                <div class="overflow-hidden">
                    <h6 class="fw-bold mb-0 text-truncate text-white"><?= htmlspecialchars($_SESSION['user']['nama_lengkap']); ?></h6>
                    <small class="text-white-50 text-truncate d-block"><?= htmlspecialchars($_SESSION['user']['email']); ?></small>
                </div>
            </div>
            
            <a href="profil.php?pajangan=edit_akun" class="nav-settings-link <?= $menu == 'edit_akun' ? 'active' : ''; ?>">
                <i class="bi bi-person-gear"></i> <span>Edit Akun</span>
            </a>
            <a href="profil.php?pajangan=riwayat" class="nav-settings-link <?= $menu == 'riwayat' ? 'active' : ''; ?>">
                <i class="bi bi-clock-history"></i> <span>Riwayat Pesanan</span>
            </a>
            <hr class="text-white-50 my-3">
            <a href="index.php" class="nav-settings-link">
                <i class="bi bi-house-door"></i> <span>Kembali ke Beranda</span>
            </a>
            <a href="logout.php" class="nav-settings-link text-danger" onclick="return confirm('Yakin ingin logout?')">
                <i class="bi bi-box-arrow-right text-danger"></i> <span>Keluar / Logout</span>
            </a>
        </div>

        <div class="col-md-8 col-lg-9 content-display">
            
            <?php if ($menu == 'edit_akun'): ?>
                <h3 class="fw-bold mb-1 text-white" style="text-shadow: 0 0 10px rgba(0,255,255,0.6);">⚙️ Pengaturan Akun</h3>
                <p class="text-white-50 mb-4 small">Perbarui informasi profil dan kredensial login kamu di sini.</p>
                
                <form method="POST" style="max-width: 600px;">
                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-white">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['nama_lengkap']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-white">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['username']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-white">Email Terdaftar</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['email']); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold mb-2 text-white">Password Baru (Opsional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
                    </div>
                    <button type="submit" name="update_profil" class="btn btn-neon">Simpan Perubahan</button>
                </form>

            <?php elseif ($menu == 'riwayat'): ?>
                <h3 class="fw-bold mb-1 text-white" style="text-shadow: 0 0 10px rgba(0,255,255,0.6);">📋 Riwayat Pemesanan Tiket</h3>
                <p class="text-white-50 mb-4 small">Berikut daftar tiket pariwisata yang pernah kamu pesan di BOKWIS.</p>
                
                <div class="table-responsive">
                    <table class="table align-middle text-white">
                        <thead style="background: rgba(0,0,0,0.5);">
                            <tr>
                                <th class="text-white fw-bold py-3">No. Booking</th>
                                <th class="text-white fw-bold py-3">Destinasi Wisata</th>
                                <th class="text-white fw-bold py-3">Tanggal Wisata</th>
                                <th class="text-white fw-bold py-3">Jumlah</th>
                                <th class="text-white fw-bold py-3">Total Bayar</th>
                                <th class="text-white fw-bold py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nama_login = mysqli_real_escape_string($conn, $_SESSION['user']['nama_lengkap']);
                            $riwayat_query = mysqli_query($conn, "SELECT b.*, d.nama_wisata 
                                                                  FROM booking b 
                                                                  JOIN destinasi d ON b.id_destinasi = d.id_destinasi 
                                                                  WHERE b.nama_user = '$nama_login' 
                                                                  ORDER BY b.id_booking DESC");
                            
                            if (mysqli_num_rows($riwayat_query) > 0):
                                while ($r = mysqli_fetch_assoc($riwayat_query)):
                            ?>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                <td class="fw-bold text-info" style="text-shadow: 0 0 5px rgba(0,255,255,0.4);">#<?= $r['id_booking']; ?></td>
                                <td class="text-white"><strong><?= htmlspecialchars($r['nama_wisata']); ?></strong></td>
                                <td class="text-white-50"><?= date('d M Y', strtotime($r['tanggal_wisata'])); ?></td>
                                <td class="text-white"><?= $r['jumlah_tiket']; ?> Pcs</td>
                                <td class="fw-bold text-neon" style="color: #00ffff; text-shadow: 0 0 8px rgba(0,255,255,0.6);">Rp <?= number_format($r['total_bayar'], 0, ',', '.'); ?></td>
                                <td class="text-center">
                                    <a href="struk.php?id=<?= $r['id_booking']; ?>" class="btn btn-sm btn-neon py-1 px-3" style="font-size: 13px; border-radius: 10px;">
                                        👁️ Lihat Struk
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-white-50 py-4">Kamu belum pernah memesan tiket wisata.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>