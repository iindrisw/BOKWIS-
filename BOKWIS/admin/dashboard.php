<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include '../koneksi.php';

// Ambil data statistik
$total_destinasi = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM destinasi"));
$total_booking = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM booking"));
$total_ulasan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM review"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - BOKWIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root { --sidebar-bg: #212529; --sidebar-hover: #343a40; --pink-main: #ff4da6; }
        body { background-color: #f4f6f9; overflow-x: hidden; }
		body {
    background: url('../foto/bg.jpg') no-repeat center center fixed;
    background-size: cover;
    overflow-x: hidden;
    position: relative;
    animation: bgZoom 18s ease-in-out infinite alternate;
}

/* overlay glow */
body::before{
    content: "";
    position: fixed;
    inset: 0;
    background:
        radial-gradient(circle at center,
        rgba(170,0,255,0.25),
        rgba(0,0,0,0.7));
    z-index: -1;
    animation: glowMove 10s ease-in-out infinite alternate;
}

/* sparkle neon */
body::after{
    content: "";
    position: fixed;
    inset: 0;
    background:
        radial-gradient(circle, rgba(0,255,255,0.12) 2px, transparent 3px);
    background-size: 120px 120px;
    animation: sparkle 20s linear infinite;
    opacity: 0.6;
    z-index: -1;
}

/* animasi bg */
@keyframes bgZoom{
    0%{
        background-size: 100%;
    }
    100%{
        background-size: 110%;
    }
}

/* glow bergerak */
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

/* sparkle jalan */
@keyframes sparkle{
    from{
        background-position: 0 0;
    }
    to{
        background-position: 300px 300px;
    }
}

        /* Sidebar Styling */
        .sidebar {
            width: 280px;
            height: 100vh;
            background-color: var(--sidebar-bg);
            position: fixed;
            padding: 20px;
            color: white;
            z-index: 1000;
        }
        .sidebar h2 { color: #dc3545; font-weight: bold; font-size: 24px; text-align: center; margin-bottom: 30px; }
        .nav-link-custom {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #adb5bd;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 5px;
            transition: 0.3s;
        }
        .nav-link-custom i { margin-right: 15px; font-size: 18px; }
        .nav-link-custom:hover, .nav-link-custom.active {
            background-color: var(--sidebar-hover);
            color: white;
        }
        .nav-link-custom.active { background-color: #343a40; border-left: 4px solid var(--pink-main); }
        .nav-link-custom.kelola { color: #ffc107; }
        .nav-link-custom.rekap { color: #0dcaf0; }
        .nav-link-custom.logout { color: #dc3545; margin-top: 50px; }

        /* Main Content Styling */
        .main-content {
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
        }
        .card-stat { border: none; border-radius: 15px; transition: 0.3s; color: white; }
        .table-custom { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }

		/* GLASS EFFECT */
.sidebar{
    background: rgba(20,20,30,0.75) !important;
    backdrop-filter: blur(12px);
    border-right: 1px solid rgba(255,255,255,0.1);
}

.table-custom,
.card-stat{
    background: rgba(255,255,255,0.12) !important;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.1);
}

/* hover glow */
.card-stat:hover{
    transform: translateY(-6px);
    transition: 0.4s;
    box-shadow: 0 0 25px rgba(0,255,255,0.6);
}

/* tabel transparan */
.table{
    color: white;
}

.table td,
.table th{
    border-color: rgba(255,255,255,0.1);
}

/* heading glow */
h3,h4,h2{
    color: white;
    text-shadow: 0 0 12px rgba(0,255,255,0.7);
}

/* tombol glow */
.btn{
    transition: 0.3s;
}

.btn:hover{
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(0,255,255,0.8);
}
/* ===== FONT GLOBAL ===== */
*{
    font-family: 'Poppins', sans-serif;
}

/* semua text */
body,
p,
span,
small,
td,
th,
label,
a{
    color: #ffffff !important;
}

/* heading */
h1,h2,h3,h4,h5,h6{
    color: #ffffff !important;
    font-weight: 700;
    text-shadow: 0 0 10px rgba(0,255,255,0.7);
}

/* text muted */
.text-muted,
.opacity-75{
    color: rgba(255,255,255,0.75) !important;
}

/* ===== SIDEBAR ===== */
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


/* ===== CARD STAT ===== */
.card-stat{
    overflow: hidden;
    position: relative;
}

.card-stat::before{
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(255,255,255,0.05),
        rgba(255,255,255,0)
    );
}

/* ===== TABLE ===== */
.table-custom{
    background: rgba(255,255,255,0.08) !important;
    backdrop-filter: blur(15px);
}

.table-dark{
    background: rgba(0,0,0,0.4) !important;
}

.table-hover tbody tr:hover{
    background: rgba(0,255,255,0.08);
}

/* kategori badge */
.badge{
    background: rgba(0,255,255,0.12) !important;
    color: #00ffff !important;
    border: 1px solid rgba(0,255,255,0.3) !important;
}

/* ===== BUTTON TAMBAH WISATA ===== */
.btn-primary{
    background: linear-gradient(135deg,#00c6ff,#0072ff) !important;
    border: none !important;
    color: white !important;
    box-shadow: 0 0 15px rgba(0,198,255,0.4);
}

.btn-primary:hover{
    background: linear-gradient(135deg,#00ffff,#0066ff) !important;
    box-shadow: 0 0 25px rgba(0,255,255,0.8);
}

/* tombol edit */
.btn-warning{
    background: linear-gradient(135deg,#ffb347,#ffcc33) !important;
    border: none;
}

/* tombol hapus */
.btn-danger{
    background: linear-gradient(135deg,#ff416c,#ff4b2b) !important;
    border: none;
}

/* ===== MODAL TAMBAH WISATA ===== */
.modal-content{
    background: rgba(20,20,30,0.92);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 30px rgba(0,255,255,0.2);
}

/* modal header */
.modal-header{
    background: linear-gradient(
        135deg,
        rgba(0,198,255,0.85),
        rgba(0,114,255,0.85)
    ) !important;
}

/* modal body */
.modal-body{
    background: transparent !important;
}

/* modal footer */
.modal-footer{
    background: transparent !important;
}

/* input */
.form-control,
.form-select{
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    color: white !important;
    backdrop-filter: blur(10px);
}

/* placeholder */
.form-control::placeholder{
    color: rgba(255,255,255,0.5);
}

/* focus */
.form-control:focus,
.form-select:focus{
    background: rgba(255,255,255,0.12);
    border-color: #00ffff;
    box-shadow: 0 0 15px rgba(0,255,255,0.5);
    color: white;
}

/* option select */
option{
    background: #111827;
    color: white;
}

/* tombol simpan */
.modal-footer .btn{
    background: linear-gradient(135deg,#00c6ff,#0072ff) !important;
    border: none;
    box-shadow: 0 0 15px rgba(0,255,255,0.4);
}

/* hover tombol simpan */
.modal-footer .btn:hover{
    background: linear-gradient(135deg,#00ffff,#0066ff) !important;
}
        @media (max-width: 768px) {
            .sidebar { width: 70px; padding: 10px; }
            .sidebar h2, .nav-link-custom span { display: none; }
            .main-content { margin-left: 70px; }
        }
		/* ===== BINTANG ULASAN ===== */

/* icon bintang */
.bi-star-fill,
.bi-star,
.fa-star,
.fa-star-half-alt,
.star{
    color: #ffd700 !important;
    text-shadow:
        0 0 5px #ffd700,
        0 0 10px #ffcc00,
        0 0 20px rgba(255,215,0,0.8);
    font-size: 1rem;
}

/* badge rating */
.badge-hot{
    background: linear-gradient(135deg,#ffcc00,#ff8800);
    color: white !important;
    font-weight: bold;
    box-shadow: 0 0 15px rgba(255,200,0,0.8);
    border: none;
}

/* angka rating */
.rating-number{
    color: #ffd700 !important;
    font-weight: bold;
    text-shadow: 0 0 10px gold;
}
    </style>
</head>
<body>

<div class="sidebar shadow">
    <h2>ADMIN PANEL</h2>
    <hr class="text-secondary">
    
    <a href="dashboard.php" class="nav-link-custom active">
        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
    </a>
    <a href="kelola_admin.php" class="nav-link-custom kelola">
        <i class="bi bi-person-plus-fill"></i> <span>Kelola Admin</span>
    </a>
    <a href="rekap_bulanan.php" class="nav-link-custom rekap">
        <i class="bi bi-file-earmark-pdf-fill"></i> <span>Rekap Bulanan</span>
    </a>
    
    <hr class="text-secondary my-4">
    
    <a href="../index.php" class="nav-link-custom">
        <i class="bi bi-globe"></i> <span>Lihat Web</span>
    </a>
    <a href="profil.php" class="nav-link-custom">
        <i class="bi bi-person-circle"></i> <span>Profil Saya</span>
    </a>
    
    <a href="../logout.php" class="nav-link-custom logout" onclick="return confirm('Yakin ingin logout?')">
        <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
    </a>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Selamat Datang, <?= $_SESSION['admin']['nama_lengkap']; ?>!</h3>
        <div class="text-muted small"><?= date('l, d F Y'); ?></div>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="card card-stat bg-primary p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6 class="small opacity-75">DESTINASI</h6><h3><?= $total_destinasi; ?></h3></div>
                    <i class="bi bi-geo-alt fs-1 opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat bg-success p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6 class="small opacity-75">BOOKING</h6><h3><?= $total_booking; ?></h3></div>
                    <i class="bi bi-ticket-perforated fs-1 opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat bg-warning text-dark p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6 class="small opacity-75">ULASAN</h6><h3><?= $total_ulasan; ?></h3></div>
                    <i class="bi bi-star fs-1 opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Manajemen Destinasi</h4>
        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-2"></i> Tambah Wisata
        </button>
    </div>

    <div class="table-responsive table-custom p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="ps-4 py-3">Wisata</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Foto</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM destinasi ORDER BY id_destinasi DESC");
                while($d = mysqli_fetch_assoc($query)):
                ?>
                <tr>
                    <td class="ps-4"><strong><?= $d['nama_wisata']; ?></strong></td>
                    <td><span class="badge bg-light text-dark border"><?= $d['kategori']; ?></span></td>
                    <td>Rp <?= number_format($d['harga_tiket']); ?></td>
                    <td><img src="../foto/<?= $d['gambar']; ?>" width="60" class="rounded shadow-sm"></td>
                    <td class="text-center">
                        <a href="edit_destinasi.php?id=<?= $d['id_destinasi']; ?>" class="btn btn-sm btn-warning text-white rounded-pill px-3">EDIT</a>
                        <a href="hapus_destinasi.php?id=<?= $d['id_destinasi']; ?>" class="btn btn-sm btn-danger rounded-pill px-3" onclick="return confirm('Hapus?')">HAPUS</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">

        <form action="proses_tambah.php"
              method="POST"
              enctype="multipart/form-data"
              class="modal-content border-0 rounded-4 overflow-hidden">

            <!-- HEADER -->
            <div class="modal-header border-0 text-white"
                 style="background: linear-gradient(135deg, #ff4da6, #ff80bf);">

                <div>
                    <h4 class="fw-bold mb-1">
                        🌸 Tambah Destinasi Wisata
                    </h4>

                    <small class="opacity-75">
                        Tambahkan wisata baru ke dalam sistem
                    </small>
                </div>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <!-- BODY -->
            <div class="modal-body p-4"
                 style="background:#fff7fb;">

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Nama Wisata
                    </label>

                    <input type="text"
                           name="nama"
                           class="form-control rounded-3 p-3"
                           placeholder="Masukkan nama wisata"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Kategori Wisata
                    </label>

                    <select name="kategori"
                            class="form-select rounded-3 p-3">

                        <option value="Pantai">🏖 Pantai</option>
                        <option value="Gunung">⛰ Gunung</option>
                        <option value="Alam">🌿 Alam</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Harga Tiket
                    </label>

                    <input type="number"
                           name="harga"
                           class="form-control rounded-3 p-3"
                           placeholder="Masukkan harga tiket"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Upload Gambar
                    </label>

                    <input type="file"
                           name="gambar"
                           class="form-control rounded-3 p-3"
                           required>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer border-0 p-4"
                 style="background:#fff7fb;">

                <button type="submit"
                        class="btn text-white w-100 rounded-pill py-3 fw-bold"
                        style="background: linear-gradient(135deg, #ff4da6, #ff80bf);">

                    💾 Simpan Destinasi

                </button>

            </div>

        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>