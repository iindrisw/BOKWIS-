<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include '../koneksi.php';

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

$sql_rekap = "SELECT d.nama_wisata, d.kategori, d.harga_tiket,
                COUNT(b.id_booking) AS total_booking,
                SUM(b.jumlah_tiket) AS total_tiket,
                SUM(b.total_bayar) AS total_pendapatan
              FROM destinasi d
              LEFT JOIN booking b ON b.id_destinasi = d.id_destinasi
                AND MONTH(b.waktu_transaksi) = '$bulan'
                AND YEAR(b.waktu_transaksi) = '$tahun'
              GROUP BY d.id_destinasi
              ORDER BY total_pendapatan DESC";
$res_rekap = mysqli_query($conn, $sql_rekap);

$sql_total = "SELECT COUNT(id_booking) AS total_booking,
                     SUM(jumlah_tiket) AS total_tiket,
                     SUM(total_bayar) AS total_pendapatan
              FROM booking
              WHERE MONTH(waktu_transaksi)='$bulan' AND YEAR(waktu_transaksi)='$tahun'";
$res_total = mysqli_query($conn, $sql_total);
$total     = mysqli_fetch_assoc($res_total);

$sql_kat = "SELECT d.kategori,
                   COUNT(b.id_booking) AS jml_booking,
                   SUM(b.total_bayar) AS pendapatan
            FROM booking b
            JOIN destinasi d ON b.id_destinasi = d.id_destinasi
            WHERE MONTH(b.waktu_transaksi)='$bulan' AND YEAR(b.waktu_transaksi)='$tahun'
            GROUP BY d.kategori";
$res_kat = mysqli_query($conn, $sql_kat);

$nama_bulan = ['','Januari','Februari','Maret','April','Mei','Juni',
               'Juli','Agustus','September','Oktober','November','Desember'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Bulanan - Admin Panel</title>
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

/* overlay */
body::before{
    content:"";
    position:fixed;
    inset:0;
    background:
    radial-gradient(circle at top left,
    rgba(255,0,170,0.25),
    rgba(0,0,0,0.78));
    z-index:-1;
    animation: glowMove 10s ease-in-out infinite alternate;
}

/* sparkle */
body::after{
    content:"";
    position:fixed;
    inset:0;
    background:
    radial-gradient(circle,
    rgba(255,255,255,0.15) 2px,
    transparent 3px);
    background-size:120px 120px;
    animation:sparkle 25s linear infinite;
    z-index:-1;
    opacity:.5;
}

/* ANIMATION */
@keyframes bgZoom{
    0%{ background-size:100%; }
    100%{ background-size:110%; }
}

@keyframes glowMove{
    0%{
        opacity:.5;
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
    width:280px;
    height:100vh;
    background:var(--sidebar-bg);
    backdrop-filter:blur(14px);
    border-right:1px solid rgba(255,255,255,0.08);
    position:fixed;
    padding:20px;
    color:white;
    z-index:1000;
}

.sidebar h2{
    color:white;
    font-weight:800;
    font-size:24px;
    text-align:center;
    margin-bottom:30px;
    text-shadow:0 0 15px rgba(255,255,255,0.5);
}

.nav-link-custom{
    display:flex;
    align-items:center;
    padding:13px 15px;
    color:#e9e9e9;
    text-decoration:none;
    border-radius:15px;
    margin-bottom:8px;
    transition:.3s;
    font-weight:500;
}

.nav-link-custom i{
    margin-right:15px;
    font-size:18px;
}

.nav-link-custom:hover,
.nav-link-custom.active{
    background:rgba(255,255,255,0.10);
    color:white;
    transform:translateX(4px);
    box-shadow:0 0 15px rgba(95,252,255,.3);
}

.nav-link-custom.active{
    border-left:4px solid var(--pink-main);
}

/* MAIN */
.main-content{
    margin-left:280px;
    padding:35px;
}

/* TITLE */
h3,h6{
    color:white;
    font-weight:700;
    text-shadow:0 0 15px rgba(95,252,255,.7);
}

/* FORM FILTER */
form.bg-white{
    background: rgba(255,255,255,0.10) !important;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 18px !important;
}

/* LABEL */
form.bg-white label{
    color: white !important;
    font-weight: 600;
}

/* SELECT */
form.bg-white .form-select{
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.15);
    color: white;
    border-radius: 10px;
}

/* OPTION */
form.bg-white .form-select option{
    color: black;
}

/* FOCUS */
form.bg-white .form-select:focus{
    border-color: #ff80bf;
    box-shadow: 0 0 12px rgba(255,128,191,0.5);
}

/* BUTTON FILTER */
form.bg-white .btn-primary{
    background: linear-gradient(135deg,#ff4da6,#ff80bf);
    border: none;
    border-radius: 10px;
    font-weight: 600;
}

/* BUTTON CETAK */
form.bg-white .btn-success{
    background: linear-gradient(135deg,#00c6ff,#0072ff);
    border: none;
    border-radius: 10px;
    font-weight: 600;
}

/* HOVER */
form.bg-white .btn:hover{
    transform: translateY(-2px);
    box-shadow: 0 0 15px rgba(255,255,255,0.35);
}

/* TEXT */
form.bg-white,
form.bg-white *{
    color: white;
}

/* BUTTON */
.btn{
    border:none;
    border-radius:14px;
    font-weight:600;
    transition:.3s;
}

.btn-primary{
    background:linear-gradient(135deg,#ff4da6,#ff80bf);
}

.btn-success{
    background:linear-gradient(135deg,#00c896,#00e5a8);
}

.btn:hover{
    transform:scale(1.05);
    box-shadow:0 0 20px rgba(95,252,255,.8);
}

/* SUMMARY CARD */
.sum-card{
    border:none;
    border-radius:24px;
    color:white;
    padding:25px;
    background:rgba(255,255,255,0.10) !important;
    backdrop-filter:blur(14px);
    border:1px solid rgba(255,255,255,0.08);
    box-shadow:0 0 20px rgba(0,0,0,0.2);
    transition:.3s;
}

.sum-card:hover{
    transform:translateY(-6px);
    box-shadow:0 0 25px rgba(95,252,255,.5);
}

/* KATEGORI CARD */
.kat-card{
    background:rgba(255,255,255,0.10);
    backdrop-filter:blur(14px);
    border-radius:22px;
    padding:18px;
    border:1px solid rgba(255,255,255,0.08);
    color:white;
    transition:.3s;
}

.kat-card:hover{
    transform:translateY(-5px);
    box-shadow:0 0 20px rgba(95,252,255,.4);
}

/* TABLE */
.table-card{
    background:rgba(255,255,255,0.10);
    backdrop-filter:blur(14px);
    border-radius:25px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.08);
}

.table{
    color:white;
    margin:0;
}

.table-dark{
    background:rgba(0,0,0,0.45) !important;
}

.table td,
.table th{
    border-color:rgba(255,255,255,0.08);
    padding:16px !important;
}

.table-hover tbody tr:hover{
    background:rgba(255,255,255,0.05);
}

/* BADGE */
.badge{
    background:rgba(255,255,255,0.12) !important;
    color:white !important;
    border:none !important;
    padding:8px 14px;
    border-radius:20px;
}

/* TEXT */
.text-muted{
    color:rgba(255,255,255,0.65) !important;
}

.fw-bold{
    color:white;
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

/* PRINT */
@media print{
    .sidebar,
    form{
        display:none !important;
    }

    .main-content{
        margin-left:0;
    }

    body{
        background:white !important;
    }
	
}
</style>
</head>
<body>

<div class="sidebar shadow">
    <h2>ADMIN PANEL</h2>
    <hr class="text-secondary">
    <a href="dashboard.php" class="nav-link-custom"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a>
    <a href="kelola_admin.php" class="nav-link-custom kelola"><i class="bi bi-person-plus-fill"></i><span>Kelola Admin</span></a>
    <a href="rekap_bulanan.php" class="nav-link-custom rekap active"><i class="bi bi-file-earmark-pdf-fill"></i><span>Rekap Bulanan</span></a>
    <hr class="text-secondary my-4">
    <a href="../index.php" class="nav-link-custom"><i class="bi bi-globe"></i><span>Lihat Web</span></a>
    <a href="profil.php" class="nav-link-custom"><i class="bi bi-person-circle"></i><span>Profil Saya</span></a>
    <a href="../logout.php" class="nav-link-custom logout" onclick="return confirm('Yakin logout?')"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">📅 Rekap Bulanan</h3>
            <small class="text-muted"><?= $nama_bulan[(int)$bulan] . ' ' . $tahun ?></small>
        </div>
    </div>

    <!-- Filter -->
    <form method="GET" class="d-flex gap-2 align-items-center bg-white p-3 rounded-3 shadow-sm mb-4">
        <label class="fw-semibold text-muted small">Bulan:</label>
        <select name="bulan" class="form-select form-select-sm" style="width:auto">
            <?php for ($i = 1; $i <= 12; $i++): ?>
            <option value="<?= str_pad($i,2,'0',STR_PAD_LEFT) ?>" <?= (int)$bulan==$i?'selected':'' ?>><?= $nama_bulan[$i] ?></option>
            <?php endfor; ?>
        </select>
        <label class="fw-semibold text-muted small">Tahun:</label>
        <select name="tahun" class="form-select form-select-sm" style="width:auto">
            <?php for ($y = date('Y'); $y >= 2024; $y--): ?>
            <option value="<?= $y ?>" <?= $tahun==$y?'selected':'' ?>><?= $y ?></option>
            <?php endfor; ?>
        </select>
        <button type="submit" class="btn btn-sm btn-primary px-3">🔍 Filter</button>
        <button type="button" class="btn btn-sm btn-success px-3 ms-auto" onclick="window.print()">🖨 Cetak</button>
    </form>

    <!-- Kartu Ringkasan -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="sum-card bg-primary shadow-sm">
                <div class="small opacity-75">TOTAL BOOKING</div>
                <div class="fs-2 fw-bold"><?= number_format($total['total_booking'] ?? 0) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="sum-card bg-info shadow-sm">
                <div class="small opacity-75">TIKET TERJUAL</div>
                <div class="fs-2 fw-bold"><?= number_format($total['total_tiket'] ?? 0) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="sum-card bg-success shadow-sm">
                <div class="small opacity-75">TOTAL PENDAPATAN</div>
                <div class="fs-2 fw-bold">Rp <?= number_format($total['total_pendapatan'] ?? 0, 0, ',', '.') ?></div>
            </div>
        </div>
    </div>

    <!-- Per Kategori -->
    <?php if ($res_kat && mysqli_num_rows($res_kat) > 0): ?>
    <h6 class="fw-bold mb-3">📊 Per Kategori</h6>
    <div class="row g-3 mb-4">
        <?php while ($k = mysqli_fetch_assoc($res_kat)): ?>
        <div class="col-md-4">
            <div class="kat-card">
                <div class="fw-bold"><?= htmlspecialchars($k['kategori']) ?></div>
                <div class="text-muted small"><?= $k['jml_booking'] ?> booking</div>
                <div class="fw-bold" style="color:#e91e8c;">Rp <?= number_format($k['pendapatan'],0,',','.') ?></div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>

    <!-- Tabel Per Destinasi -->
    <h6 class="fw-bold mb-3">📋 Detail Per Destinasi</h6>
    <div class="table-card">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="ps-3">No</th>
                    <th>Nama Wisata</th>
                    <th>Kategori</th>
                    <th>Harga/Tiket</th>
                    <th>Total Booking</th>
                    <th>Tiket Terjual</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no  = 1;
                $ada = false;
                while ($row = mysqli_fetch_assoc($res_rekap)):
                    $ada = true;
                ?>
                <tr>
                    <td class="ps-3"><?= $no++ ?></td>
                    <td><strong><?= htmlspecialchars($row['nama_wisata']) ?></strong></td>
                    <td><span class="badge bg-light text-dark border"><?= $row['kategori'] ?></span></td>
                    <td>Rp <?= number_format($row['harga_tiket'],0,',','.') ?></td>
                    <td><?= number_format($row['total_booking']) ?></td>
                    <td><?= number_format($row['total_tiket'] ?? 0) ?></td>
                    <td class="fw-bold" style="color:#e91e8c;">Rp <?= number_format($row['total_pendapatan'] ?? 0, 0, ',', '.') ?></td>
                </tr>
                <?php endwhile; ?>
                <?php if (!$ada): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data booking pada bulan ini</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>