<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Ambil ID booking dari URL
$id_booking = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// Query ambil data booking dikawinkan dengan data destinasi
$query = mysqli_query($conn, "SELECT b.*, d.nama_wisata, d.harga_tiket 
                              FROM booking b 
                              JOIN destinasi d ON b.id_destinasi = d.id_destinasi 
                              WHERE b.id_booking = '$id_booking'");
$data = mysqli_fetch_assoc($query);

// Validasi jika data tidak ada atau nama user di struk beda dengan yang login
if (!$data || $data['nama_user'] !== $_SESSION['user']['nama_lengkap']) {
    echo "<script>alert('Data transaksi tidak ditemukan atau akses dilarang!'); window.location='index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Booking - #<?= $data['id_booking']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: url('foto/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        body::before {
            content: ""; position: fixed; inset: 0;
            background: radial-gradient(circle at center, rgba(170,0,255,0.2), rgba(0,0,0,0.8));
            z-index: -1;
        }
        .struk-card {
            width: 100%; max-width: 500px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 25px;
            color: white;
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.2);
            padding: 30px;
        }
        .line-dash {
            border-top: 2px dashed rgba(255, 255, 255, 0.25);
            margin: 20px 0;
        }
        .text-neon { text-shadow: 0 0 10px rgba(0,255,255,0.8); color: #00ffff; }
        .btn-custom { border-radius: 15px; font-weight: 600; }
        
        /* CSS Khusus Cetak Kertas */
        @media print {
            body, body::before { background: white !important; color: black !important; }
            .struk-card { background: white !important; color: black !important; box-shadow: none !important; border: none !important; backdrop-filter: none !important; }
            .btn-area, title { display: none !important; }
            .text-neon { color: black !important; text-shadow: none !important; }
            .line-dash { border-top: 2px dashed black !important; }
        }
    </style>
</head>
<body>

<div class="struk-card">
    <div class="text-center">
        <h4 class="fw-bold mb-1">💖 BOKWIS TIKET</h4>
        <small class="text-white-50">Ciayumajakuning Tour & Travel</small>
        <h5 class="mt-3 fw-bold text-neon">STRUK PEMESANAN</h5>
    </div>
    
    <div class="line-dash"></div>
    
    <div class="row g-2 small">
        <div class="col-5 text-white-50">No. Booking</div>
        <div class="col-7 text-end fw-bold">#<?= $data['id_booking']; ?></div>
        
        <div class="col-5 text-white-50">Waktu Transaksi</div>
        <div class="col-7 text-end"><?= date('d M Y H:i', strtotime($data['waktu_transaksi'])); ?></div>
        
        <div class="col-5 text-white-50">Nama Pemesan</div>
        <div class="col-7 text-end fw-bold"><?= htmlspecialchars($data['nama_user']); ?></div>
        
        <div class="col-5 text-white-50">Email</div>
        <div class="col-7 text-end"><?= htmlspecialchars($data['email']); ?></div>
    </div>
    
    <div class="line-dash"></div>
    
    <div class="row g-2 small">
        <div class="col-12"><small class="text-white-50">Detail Destinasi:</small></div>
        <div class="col-7 fw-bold fs-6 text-neon"><?= htmlspecialchars($data['nama_wisata']); ?></div>
        <div class="col-5 text-end text-white-50">@ Rp <?= number_format($data['harga_tiket']); ?></div>
        
        <div class="col-5 text-white-50 mt-2">Tanggal Wisata</div>
        <div class="col-7 text-end fw-bold mt-2"><?= date('d F Y', strtotime($data['tanggal_wisata'])); ?></div>
        
        <div class="col-5 text-white-50">Jumlah Tiket</div>
        <div class="col-7 text-end fw-bold"><?= $data['jumlah_tiket']; ?> Pcs</div>
        
        <div class="col-5 text-white-50">Status Bayar</div>
        <div class="col-7 text-end"><span class="badge bg-success"><?= $data['status_bayar']; ?></span></div>
    </div>
    
    <div class="line-dash"></div>
    
    <div class="d-flex justify-content-between align-items-center">
        <span class="fw-bold text-white-50">TOTAL BAYAR</span>
        <span class="fs-4 fw-bold text-neon">Rp <?= number_format($data['total_bayar'], 0, ',', '.'); ?></span>
    </div>
    
    <div class="line-dash"></div>
    
    <div class="text-center small text-white-50 mb-4">
        Terima kasih telah mempercayai BOKWIS.<br>Selamat menikmati liburan Anda!
    </div>
    
    <div class="d-flex gap-2 btn-area">
        <a href="index.php" class="btn btn-sm btn-outline-light w-50 btn-custom">← Beranda</a>
        <button onclick="window.print()" class="btn btn-sm btn-info text-white w-50 btn-custom">🖨️ Cetak Struk</button>
    </div>
</div>

</body>
</html>