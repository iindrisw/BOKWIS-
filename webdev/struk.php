<?php
session_start();
include 'koneksi.php';

// ===============================
// CEK LOGIN
// ===============================

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// ===============================
// AMBIL ID BOOKING
// ===============================

$id_booking = isset($_GET['id'])
    ? mysqli_real_escape_string($conn, $_GET['id'])
    : '';

// ===============================
// QUERY BOOKING + DESTINASI
// ===============================

$query = mysqli_query($conn, "
    SELECT b.*, d.nama_wisata,
           d.harga_tiket,
           d.maps
    FROM booking b
    JOIN destinasi d
    ON b.id_destinasi = d.id_destinasi
    WHERE b.id_booking='$id_booking'
");

$data = mysqli_fetch_assoc($query);

// ===============================
// VALIDASI AKSES
// ===============================

if (!$data || $data['nama_user'] !== $_SESSION['user']['nama_lengkap']) {

    echo "
    <script>
        alert('Data transaksi tidak ditemukan atau akses dilarang!');
        window.location='index.php';
    </script>
    ";

    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
    Struk Booking #<?= $data['id_booking']; ?>
</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

/* ===============================
   BODY
================================= */

body{
    background:url('foto/bg.jpg') no-repeat center center fixed;
    background-size:cover;
    min-height:100vh;
    overflow-x:hidden;
    position:relative;
    font-family:'Poppins',sans-serif;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
    animation:bgZoom 18s ease-in-out infinite alternate;
}

body::before{
    content:"";
    position:fixed;
    inset:0;
    background:
        radial-gradient(circle at center,
        rgba(255,255,255,0.08),
        rgba(0,0,0,0.78));
    z-index:-1;
}

body::after{
    content:"";
    position:fixed;
    inset:0;
    background:
        radial-gradient(circle, rgba(255,255,255,0.08) 2px, transparent 3px);
    background-size:120px 120px;
    animation:sparkle 20s linear infinite;
    opacity:0.4;
    z-index:-1;
}

@keyframes bgZoom{
    from{
        background-size:100%;
    }
    to{
        background-size:110%;
    }
}

@keyframes sparkle{
    from{
        background-position:0 0;
    }
    to{
        background-position:300px 300px;
    }
}

/* ===============================
   CARD
================================= */

.ticket-card{
    width:100%;
    max-width:700px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(15px);
    border-radius:30px;
    padding:30px;
    border:1px solid rgba(255,255,255,0.10);
    box-shadow:0 0 30px rgba(0,0,0,0.4);
    color:white;
}

/* ===============================
   LOGO
================================= */

.logo{
    text-align:center;
    margin-bottom:20px;
}

.logo h1{
    font-size:34px;
    font-weight:700;
    margin-bottom:5px;
}

.logo small{
    color:rgba(255,255,255,0.7);
}

/* ===============================
   TITLE
================================= */

.title{
    text-align:center;
    color:#00ffff;
    font-weight:700;
    margin-bottom:20px;
    text-shadow:0 0 12px rgba(0,255,255,0.7);
}

/* ===============================
   GARIS
================================= */

.line{
    border-top:2px dashed rgba(255,255,255,0.2);
    margin:22px 0;
}

/* ===============================
   TEXT
================================= */

.label{
    color:rgba(255,255,255,0.7);
    font-size:14px;
}

.value{
    text-align:right;
    font-weight:600;
    font-size:14px;
}

.destinasi{
    color:#00ffff;
    font-size:24px;
    font-weight:700;
    text-shadow:0 0 10px rgba(0,255,255,0.6);
}

.total{
    color:#00ffff;
    font-size:32px;
    font-weight:700;
    text-shadow:0 0 12px rgba(0,255,255,0.7);
}

/* ===============================
   GLASS BOX
================================= */

.glass-box{
    background:rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:25px;
    padding:20px;
    height:100%;
    backdrop-filter:blur(12px);
    transition:0.3s;
}

.glass-box:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(0,255,255,0.12);
}

/* ===============================
   QR BOX
================================= */

.qr-box{
    background:white;
    border-radius:20px;
    padding:12px;
    display:inline-block;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

/* ===============================
   MAPS
================================= */

.maps-box{
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.25);
}

/* ===============================
   BUTTON
================================= */

.btn-custom{
    border:none;
    border-radius:15px;
    padding:12px;
    font-weight:600;
    width:100%;
}

.btn-home{
    background:transparent;
    border:1px solid rgba(255,255,255,0.3);
    color:white;
    text-decoration:none;
    display:block;
    text-align:center;
}

.btn-home:hover{
    color:white;
    background:rgba(255,255,255,0.08);
}

.btn-print{
    background:linear-gradient(135deg,#00e5ff,#00bcd4);
    color:white;
}

.btn-print:hover{
    opacity:0.9;
}

/* ===============================
   FOOTER
================================= */

.footer-text{
    color:rgba(255,255,255,0.65);
    font-size:13px;
}

/* ===============================
   RESPONSIVE
================================= */

@media(max-width:768px){

    .ticket-card{
        padding:20px;
    }

    .maps-box iframe{
        height:220px;
    }

    .destinasi{
        font-size:20px;
    }

    .total{
        font-size:26px;
    }

}

/* ===============================
   PRINT
================================= */

@media print{

    body{
        background:white !important;
    }

    body::before,
    body::after{
        display:none !important;
    }

    .ticket-card{
        background:white !important;
        color:black !important;
        box-shadow:none !important;
        border:none !important;
    }

    .title,
    .destinasi,
    .total{
        color:black !important;
        text-shadow:none !important;
    }

    .btn-area{
        display:none !important;
    }

}

</style>
</head>

<body>

<div class="ticket-card">

    <!-- LOGO -->
    <div class="logo">

        <h1>
            💖 BOKWIS TIKET
        </h1>

        <small>
            Ciayumajakuning Tour & Travel
        </small>

    </div>

    <!-- TITLE -->
    <h2 class="title">
        STRUK PEMESANAN
    </h2>

    <div class="line"></div>

    <!-- DETAIL -->
    <div class="row mb-3">

        <div class="col-6 label">
            No. Booking
        </div>

        <div class="col-6 value">
            #<?= $data['id_booking']; ?>
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-6 label">
            Waktu Transaksi
        </div>

        <div class="col-6 value">
            <?= date('d F Y H:i', strtotime($data['waktu_transaksi'])); ?>
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-6 label">
            Nama Pemesan
        </div>

        <div class="col-6 value">
            <?= htmlspecialchars($data['nama_user']); ?>
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-6 label">
            Email
        </div>

        <div class="col-6 value">
            <?= htmlspecialchars($data['email']); ?>
        </div>

    </div>

    <div class="line"></div>

    <!-- DESTINASI -->
    <div class="mb-4">

        <small class="label">
            Detail Destinasi:
        </small>

        <div class="d-flex justify-content-between align-items-center mt-2">

            <div class="destinasi">
                <?= htmlspecialchars($data['nama_wisata']); ?>
            </div>

            <div class="label fw-bold">
                @ Rp <?= number_format($data['harga_tiket']); ?>
            </div>

        </div>

    </div>

    <div class="row mb-3">

        <div class="col-6 label">
            Tanggal Wisata
        </div>

        <div class="col-6 value">
            <?= date('d F Y', strtotime($data['tanggal_wisata'])); ?>
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-6 label">
            Jumlah Tiket
        </div>

        <div class="col-6 value">
            <?= $data['jumlah_tiket']; ?> Pcs
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-6 label">
            Status Bayar
        </div>

        <div class="col-6 value">

            <span class="badge bg-success px-3 py-2">
                <?= $data['status_bayar']; ?>
            </span>

        </div>

    </div>

    <div class="line"></div>

    <!-- QR + MAPS -->
    <div class="row mt-4 g-4 align-items-start">

        <!-- QR -->
        <div class="col-md-4">

            <div class="glass-box text-center">

                <h5 class="fw-bold text-info mb-3">
                    QR Tiket
                </h5>

                <div class="qr-box">

                    <img
                        src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=BOOKING-<?= $data['id_booking']; ?>"
                        width="160"
                        class="img-fluid">

                </div>

                <small class="d-block mt-3 footer-text">
                    Scan QR saat masuk wisata
                </small>

            </div>

        </div>

        <!-- MAPS -->
        <div class="col-md-8">

            <div class="glass-box">

                <h5 class="fw-bold text-info mb-3">
                    Lokasi Wisata
                </h5>

                <div class="maps-box">

                    <iframe
                        src="<?= $data['maps']; ?>"
                        width="100%"
                        height="250"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>

                </div>

            </div>

        </div>

    </div>

    <div class="line"></div>

    <!-- TOTAL -->
    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h4 class="label fw-bold">
                TOTAL BAYAR
            </h4>
        </div>

        <div class="total">
            Rp <?= number_format($data['total_bayar'],0,',','.'); ?>
        </div>

    </div>

    <div class="line"></div>

    <!-- FOOTER -->
    <div class="text-center py-3">

        <p class="footer-text mb-0">
            Terima kasih telah mempercayai BOKWIS 💖
        </p>

        <p class="footer-text">
            Selamat menikmati liburan Anda!
        </p>

    </div>

    <!-- BUTTON -->
    <div class="row mt-4 btn-area">

        <div class="col-md-5 mb-3">

            <a href="index.php"
               class="btn-home btn-custom">

               ← Beranda

            </a>

        </div>

        <div class="col-md-7">

            <button onclick="window.print()"
                    class="btn btn-custom btn-print">

                🖨 Cetak Struk

            </button>

        </div>

    </div>

</div>

</body>
</html>