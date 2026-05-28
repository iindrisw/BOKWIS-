<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

include '../koneksi.php';

// Statistik
$total_destinasi = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM destinasi"));
$total_booking   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM booking"));
$total_ulasan    = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM review"));
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

:root{
    --sidebar-bg:#212529;
    --sidebar-hover:#343a40;
    --pink-main:#ff4da6;
}

/* ================= BODY ================= */

body{
    background:url('../foto/bg.jpg') no-repeat center center fixed;
    background-size:cover;
    overflow-x:hidden;
    position:relative;
    animation:bgZoom 18s ease-in-out infinite alternate;
    font-family:'Poppins',sans-serif;
}

/* overlay */
body::before{
    content:"";
    position:fixed;
    inset:0;
    background:
    radial-gradient(circle at center,
    rgba(170,0,255,0.25),
    rgba(0,0,0,0.7));
    z-index:-1;
    animation:glowMove 10s ease-in-out infinite alternate;
}

/* sparkle */
body::after{
    content:"";
    position:fixed;
    inset:0;
    background:
    radial-gradient(circle,
    rgba(0,255,255,0.12) 2px,
    transparent 3px);
    background-size:120px 120px;
    animation:sparkle 20s linear infinite;
    opacity:.6;
    z-index:-1;
}

/* animasi */
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

/* ================= TEXT ================= */

body,
p,
span,
small,
td,
th,
label,
a{
    color:white !important;
}

h1,h2,h3,h4,h5,h6{
    color:white !important;
    font-weight:700;
    text-shadow:0 0 10px rgba(0,255,255,0.7);
}

/* ================= SIDEBAR ================= */

.sidebar{
    width:280px;
    height:100vh;
    background:rgba(20,20,30,0.78);
    backdrop-filter:blur(14px);
    border-right:1px solid rgba(255,255,255,0.08);
    position:fixed;
    padding:20px;
    z-index:1000;
}

.sidebar h2{
    font-size:24px;
    text-align:center;
    margin-bottom:30px;
    font-weight:800;
    letter-spacing:1px;
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
    margin-right:14px;
    font-size:18px;
}

.nav-link-custom:hover,
.nav-link-custom.active{
    background:rgba(255,255,255,0.10);
    transform:translateX(4px);
    box-shadow:0 0 15px rgba(95,252,255,0.3);
}

.nav-link-custom.active{
    border-left:4px solid var(--pink-main);
}

.nav-link-custom.logout{
    color:#ff5c5c !important;
    margin-top:50px;
}

/* ================= MAIN ================= */

.main-content{
    margin-left:280px;
    padding:30px;
    min-height:100vh;
}

/* ================= CARD ================= */

.card-stat{
    border:none;
    border-radius:18px;
    overflow:hidden;
    position:relative;
    background:rgba(255,255,255,0.12) !important;
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,0.08);
    transition:.4s;
}

.card-stat:hover{
    transform:translateY(-6px);
    box-shadow:0 0 25px rgba(0,255,255,0.4);
}

/* ================= TABLE ================= */

.table-custom{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(15px);
    border-radius:18px;
    overflow:hidden;
}

.table{
    color:white;
}

.table td,
.table th{
    border-color:rgba(255,255,255,0.08);
}

.table-dark{
    background:rgba(0,0,0,0.4) !important;
}

.table-hover tbody tr:hover{
    background:rgba(0,255,255,0.05);
}

.badge{
    background:rgba(0,255,255,0.12) !important;
    color:#00ffff !important;
    border:1px solid rgba(0,255,255,0.3) !important;
}

/* ================= BUTTON ================= */

.btn{
    transition:.3s;
}

.btn:hover{
    transform:scale(1.03);
}

.btn-primary{
    background:linear-gradient(135deg,#00c6ff,#0072ff) !important;
    border:none !important;
    box-shadow:0 0 15px rgba(0,198,255,0.4);
}

.btn-primary:hover{
    box-shadow:0 0 25px rgba(0,255,255,0.8);
}

.btn-warning{
    background:linear-gradient(135deg,#ffb347,#ffcc33) !important;
    border:none;
}

.btn-danger{
    background:linear-gradient(135deg,#ff416c,#ff4b2b) !important;
    border:none;
}

/* ================= MODAL TAMBAH ================= */

.tambah-modal{
    background:rgba(18,18,28,0.97);
    backdrop-filter:blur(18px);
    border-radius:26px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.08);
    box-shadow:0 0 35px rgba(0,255,255,0.12);
}

.tambah-header{
    background:linear-gradient(135deg,#00c6ff,#0072ff);
    padding:18px 22px;
}

.input-card{
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:18px;
    padding:14px;
}

.input-premium{
    background:rgba(255,255,255,0.08) !important;
    border:1px solid rgba(255,255,255,0.10) !important;
    color:white !important;
    border-radius:14px !important;
    padding:11px !important;
}

.input-premium::placeholder{
    color:rgba(255,255,255,0.5);
}

.input-premium:focus{
    background:rgba(255,255,255,0.12) !important;
    border-color:#00ffff !important;
    box-shadow:0 0 15px rgba(0,255,255,0.25) !important;
}

select.input-premium option{
    background:#111827;
    color:white;
}

/* upload */

.upload-box{
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:20px;
    padding:18px;
    text-align:center;
    height:100%;
}

.upload-icon{
    font-size:40px;
    margin-bottom:10px;
}

.upload-input{
    background:rgba(255,255,255,0.08) !important;
    border:2px dashed rgba(0,255,255,0.25) !important;
    color:white !important;
    border-radius:14px !important;
    padding:10px !important;
}

/* preview */

.preview-box img{
    width:100%;
    height:170px;
    object-fit:cover;
    border-radius:16px;
    border:1px solid rgba(255,255,255,0.08);
}

/* tombol simpan */

.btn-simpan{
    background:linear-gradient(135deg,#00c6ff,#0072ff);
    border:none;
    color:white;
    font-weight:bold;
    box-shadow:0 0 15px rgba(0,198,255,0.35);
}

.btn-simpan:hover{
    color:white;
    transform:translateY(-2px);
    box-shadow:0 0 22px rgba(0,255,255,0.6);
}

/* responsive */

@media(max-width:768px){

    .sidebar{
        width:70px;
        padding:10px;
    }

    .sidebar h2,
    .nav-link-custom span{
        display:none;
    }

    .main-content{
        margin-left:70px;
    }

    .modal-dialog{
        margin:10px;
    }
}

</style>

</head>
<body>

<!-- SIDEBAR -->

<div class="sidebar shadow">

    <h2>ADMIN PANEL</h2>

    <hr class="text-secondary">

    <a href="dashboard.php" class="nav-link-custom active">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>

    <a href="kelola_admin.php" class="nav-link-custom">
        <i class="bi bi-person-plus-fill"></i>
        <span>Kelola Admin</span>
    </a>

    <a href="rekap_bulanan.php" class="nav-link-custom">
        <i class="bi bi-file-earmark-pdf-fill"></i>
        <span>Rekap Bulanan</span>
    </a>

    <hr class="text-secondary my-4">

    <a href="../index.php" class="nav-link-custom">
        <i class="bi bi-globe"></i>
        <span>Lihat Web</span>
    </a>

    <a href="profil.php" class="nav-link-custom">
        <i class="bi bi-person-circle"></i>
        <span>Profil Saya</span>
    </a>

    <a href="../logout.php"
       class="nav-link-custom logout"
       onclick="return confirm('Yakin ingin logout?')">

        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>

    </a>

</div>

<!-- MAIN -->

<div class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="fw-bold">
            Selamat Datang,
            <?= $_SESSION['admin']['nama_lengkap']; ?>!
        </h3>

        <div class="small text-light">
            <?= date('l, d F Y'); ?>
        </div>

    </div>

    <!-- STATISTIK -->

    <div class="row g-3 mb-5">

        <div class="col-md-4">
            <div class="card card-stat p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h6 class="small opacity-75">DESTINASI</h6>
                        <h3><?= $total_destinasi; ?></h3>
                    </div>

                    <i class="bi bi-geo-alt fs-1 opacity-25"></i>

                </div>

            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-stat p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h6 class="small opacity-75">BOOKING</h6>
                        <h3><?= $total_booking; ?></h3>
                    </div>

                    <i class="bi bi-ticket-perforated fs-1 opacity-25"></i>

                </div>

            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-stat p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h6 class="small opacity-75">ULASAN</h6>
                        <h3><?= $total_ulasan; ?></h3>
                    </div>

                    <i class="bi bi-star fs-1 opacity-25"></i>

                </div>

            </div>
        </div>

    </div>

    <!-- HEADER TABLE -->

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="fw-bold">
            Manajemen Destinasi
        </h4>

        <button class="btn btn-primary rounded-pill px-4"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah">

            <i class="bi bi-plus-circle me-2"></i>
            Tambah Wisata

        </button>

    </div>

    <!-- TABLE -->

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

                <td class="ps-4">
                    <strong><?= $d['nama_wisata']; ?></strong>
                </td>

                <td>
                    <span class="badge">
                        <?= $d['kategori']; ?>
                    </span>
                </td>

                <td>
                    Rp <?= number_format($d['harga_tiket']); ?>
                </td>

                <td>
                    <img src="../foto/<?= $d['gambar']; ?>"
                         width="60"
                         class="rounded shadow-sm">
                </td>

                <td class="text-center">

                    <a href="edit_destinasi.php?id=<?= $d['id_destinasi']; ?>"
                       class="btn btn-sm btn-warning text-white rounded-pill px-3">

                       EDIT

                    </a>

                    <a href="hapus_destinasi.php?id=<?= $d['id_destinasi']; ?>"
                       class="btn btn-sm btn-danger rounded-pill px-3"
                       onclick="return confirm('Hapus?')">

                       HAPUS

                    </a>

                </td>

            </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

<!-- MODAL TAMBAH -->

<div class="modal fade" id="modalTambah" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <form action="proses_tambah.php"
              method="POST"
              enctype="multipart/form-data"
              class="modal-content tambah-modal border-0">

            <!-- HEADER -->

            <div class="modal-header tambah-header border-0">

                <div>

                    <h4 class="fw-bold mb-1 text-white">
                        ✨ Tambah Wisata
                    </h4>

                    <small class="text-light opacity-75">
                        Tambahkan destinasi baru
                    </small>

                </div>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <!-- BODY -->

            <div class="modal-body p-4">

                <div class="row g-3">

                    <!-- LEFT -->

                    <div class="col-md-7">

                        <!-- NAMA -->

                        <div class="input-card mb-3">

                            <label class="form-label fw-bold">
                                🌴 Nama Wisata
                            </label>

                            <input type="text"
                                   name="nama"
                                   class="form-control input-premium"
                                   placeholder="Masukkan nama wisata"
                                   required>

                        </div>

                        <!-- KATEGORI -->

                        <div class="input-card mb-3">

                            <label class="form-label fw-bold">
                                🧭 Kategori
                            </label>

                            <select name="kategori"
                                    class="form-select input-premium">

                                <option value="Pantai">🏖 Pantai</option>
                                <option value="Gunung">⛰ Gunung</option>
                                <option value="Alam">🌿 Alam</option>

                            </select>

                        </div>

                        <!-- HARGA -->

                        <div class="input-card mb-3">

                            <label class="form-label fw-bold">
                                💸 Harga Tiket
                            </label>

                            <input type="number"
                                   name="harga"
                                   class="form-control input-premium"
                                   placeholder="Masukkan harga tiket"
                                   required>

                        </div>

                        <!-- MAPS -->

                        <div class="input-card">

                            <label class="form-label fw-bold">
                                📍 Embed Google Maps
                            </label>

                            <textarea name="maps"
                                      rows="3"
                                      class="form-control input-premium"
                                      placeholder="Paste embed maps..."
                                      required></textarea>

                        </div>

                    </div>

                    <!-- RIGHT -->

                    <div class="col-md-5">

                        <div class="upload-box">

                            <div class="upload-icon">
                                🖼️
                            </div>

                            <h6 class="fw-bold">
                                Upload Foto
                            </h6>

                            <small class="opacity-75 d-block mb-3">
                                Preview gambar otomatis
                            </small>

                            <input type="file"
                                   name="gambar"
                                   class="form-control upload-input"
                                   required>

                            <div class="preview-box mt-3">

                                <img id="previewImg"
                                     src="https://via.placeholder.com/250x170/1e1e2f/ffffff?text=Preview"
                                     class="img-fluid">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- FOOTER -->

            <div class="modal-footer border-0 pt-0 px-4 pb-4">

                <button type="button"
                        class="btn btn-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">

                    Tutup

                </button>

                <button type="submit"
                        class="btn btn-simpan rounded-pill px-4">

                    💾 Simpan Destinasi

                </button>

            </div>

        </form>

    </div>

</div>

<!-- SCRIPT PREVIEW -->

<script>

document
.querySelector('input[name="gambar"]')
.addEventListener('change', function(e){

    const reader = new FileReader();

    reader.onload = function(){

        document
        .getElementById('previewImg')
        .src = reader.result;

    }

    reader.readAsDataURL(e.target.files[0]);

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>