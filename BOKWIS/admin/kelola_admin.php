<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include '../koneksi.php';

// Logika Tambah Admin Baru
if (isset($_POST['tambah_admin'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = md5($_POST['password']);

    $query = "INSERT INTO admin (username, password, nama_lengkap) VALUES ('$user', '$pass', '$nama')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Admin baru berhasil ditambahkan!'); window.location='kelola_admin.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Admin - BOKWIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
:root{
    --sidebar-bg: rgba(20,20,30,0.78);
    --sidebar-hover: rgba(255,255,255,0.08);
    --pink-main: #ff4da6;
    --pink-dark: #ff2e93;
    --cyan-glow: #5ffcff;
    --glass: rgba(255,255,255,0.10);
}

/* BODY */
body{
    background: url('../foto/bg.jpg') no-repeat center center fixed;
    background-size: cover;
    overflow-x: hidden;
    position: relative;
    font-family: 'Poppins', sans-serif;
    animation: bgZoom 18s ease-in-out infinite alternate;
}

/* OVERLAY */
body::before{
    content: "";
    position: fixed;
    inset: 0;
    background:
    radial-gradient(circle at top left,
    rgba(255,0,170,0.25),
    rgba(0,0,0,0.75));
    z-index: -1;
    animation: glowMove 10s ease-in-out infinite alternate;
}

/* SPARKLE */
body::after{
    content: "";
    position: fixed;
    inset: 0;
    background:
    radial-gradient(circle,
    rgba(255,255,255,0.15) 2px,
    transparent 3px);
    background-size: 120px 120px;
    animation: sparkle 25s linear infinite;
    z-index: -1;
    opacity: 0.5;
}

/* ANIMASI */
@keyframes bgZoom{
    0%{ background-size:100%; }
    100%{ background-size:110%; }
}

@keyframes glowMove{
    0%{
        opacity:0.5;
        filter:blur(0px);
    }
    100%{
        opacity:1;
        filter:blur(10px);
    }
}

@keyframes sparkle{
    from{ background-position:0 0; }
    to{ background-position:300px 300px; }
}

/* SIDEBAR */
.sidebar{
    width: 280px;
    height: 100vh;
    background: var(--sidebar-bg);
    backdrop-filter: blur(14px);
    border-right: 1px solid rgba(255,255,255,0.08);
    position: fixed;
    padding: 20px;
    color: white;
}

.sidebar h2{
    color: white;
    font-weight: 800;
	font-size: 24px;
    text-align: center;
    margin-bottom: 30px;
    text-shadow: 0 0 15px rgba(255,255,255,0.5);
    letter-spacing: 1px;
}

.nav-link-custom{
    display:flex;
    align-items:center;
    padding:13px 15px;
    color:#e9e9e9;
    text-decoration:none;
    border-radius:15px;
    margin-bottom:8px;
    transition:0.3s;
    font-weight:500;
}

.nav-link-custom i{
    margin-right:14px;
    font-size:18px;
}

.nav-link-custom:hover,
.nav-link-custom.active{
    background: rgba(255,255,255,0.10);
    color:white;
    transform: translateX(4px);
    box-shadow: 0 0 15px rgba(95,252,255,0.3);
}

.nav-link-custom.active{
    border-left:4px solid var(--pink-main);
}

/* CONTENT */
.main-content{
    margin-left:280px;
    padding:35px;
}

/* TITLE */
h3{
    color:white;
    font-weight:700;
    text-shadow:0 0 15px rgba(95,252,255,0.7);
}

/* BUTTON */
.btn-warning{
    background: linear-gradient(135deg,#ff4da6,#ff80bf);
    border:none;
    color:white !important;
    box-shadow:0 0 18px rgba(255,77,166,0.5);
}

.btn-warning:hover{
    transform:scale(1.04);
    box-shadow:0 0 25px rgba(95,252,255,0.8);
}

/* CARD TABLE */
.card-table{
    background: rgba(255,255,255,0.10);
    backdrop-filter: blur(14px);
    border-radius: 25px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.08);
    box-shadow:0 0 30px rgba(0,0,0,0.2);
}

/* TABLE */
.table{
    color:white;
    margin:0;
}

.table thead{
    background: rgba(0,0,0,0.45);
}

.table-dark{
    background: rgba(0,0,0,0.45) !important;
}

.table td,
.table th{
    border-color: rgba(255,255,255,0.08);
    padding:18px !important;
}

.table-hover tbody tr:hover{
    background: rgba(255,255,255,0.06);
}

/* USERNAME */
code{
    color:#5ffcff !important;
    background:none;
    font-size:15px;
    font-weight:600;
}

/* BADGE */
.badge{
    border-radius:20px;
    padding:8px 14px;
}

/* MODAL */
.modal-content{
    background: rgba(20,20,30,0.95);
    backdrop-filter: blur(16px);
    border-radius:25px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.08);
    color:white;
}

.modal-header{
    background: linear-gradient(135deg,#ff4da6,#ff80bf) !important;
    border:none;
}

.modal-footer{
    background: rgba(255,255,255,0.03);
    border:none;
}

.form-control{
    background: rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.1);
    color:white;
    border-radius:15px;
    padding:12px;
}

.form-control:focus{
    background: rgba(255,255,255,0.12);
    border-color:#5ffcff;
    box-shadow:0 0 15px rgba(95,252,255,0.5);
    color:white;
}

.form-control::placeholder{
    color: rgba(255,255,255,0.5);
}

/* RESPONSIVE */
@media(max-width:768px){

    .sidebar{
        width:75px;
        padding:10px;
    }

    .sidebar h2,
    .nav-link-custom span{
        display:none;
    }

    .main-content{
        margin-left:75px;
        padding:20px;
    }
}
</style>
</head>
<body>

<div class="sidebar">
    <h2>ADMIN PANEL</h2>
    <hr class="text-secondary">
    <a href="dashboard.php" class="nav-link-custom"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
    <a href="kelola_admin.php" class="nav-link-custom active kelola"><i class="bi bi-person-plus-fill"></i> <span>Kelola Admin</span></a>
    <a href="rekap_bulanan.php" class="nav-link-custom rekap"><i class="bi bi-file-earmark-pdf-fill"></i> <span>Rekap Bulanan</span></a>
    <hr class="text-secondary my-4">
    <a href="../logout.php" class="nav-link-custom text-danger"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Manajemen Akun Admin</h3>
        <button class="btn btn-warning fw-bold rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalAdmin">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah Admin
        </button>
    </div>

    <div class="card card-table overflow-hidden">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="ps-4">No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $res = mysqli_query($conn, "SELECT * FROM admin ORDER BY id_admin DESC");
                while($row = mysqli_fetch_assoc($res)):
                ?>
                <tr>
                    <td class="ps-4"><?= $no++; ?></td>
                    <td><strong><?= $row['nama_lengkap']; ?></strong></td>
                    <td><code class="text-primary"><?= $row['username']; ?></code></td>
                    <td class="text-center">
                        <?php if($row['username'] != $_SESSION['admin']['username']): ?>
                            <a href="hapus_admin.php?id=<?= $row['id_admin']; ?>" class="btn btn-sm btn-outline-danger px-3 rounded-pill" onclick="return confirm('Hapus admin ini?')">Hapus</a>
                        <?php else: ?>
                            <span class="badge bg-secondary">Anda</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalAdmin" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="" method="POST" class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold">Tambah Admin Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="small fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Contoh: Admin Baru" required>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="adminbaru" required>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="******" required>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="submit" name="tambah_admin" class="btn btn-warning w-100 fw-bold">Simpan Admin</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>