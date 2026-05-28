<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bokwis Ciayumajakuning - Wisata Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { 
            --pink-main: #ff4da6; 
            --pink-dark: #e60073; 
            --pink-light: #ffe6f2; 
        }

        body { 
            font-family: 'Segoe UI', sans-serif; 
            background-color: #f8f9fa; 
            scroll-behavior: smooth; 
        }
        
        /* Navbar Styling */
        /* ===== NAVBAR GLASS NEON ===== */
        .navbar{
            background: rgba(15,15,25,0.75);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 0 20px rgba(0,255,255,0.25);
            z-index: 1050;
            transition: 0.4s;
        }

        /* logo */
        .navbar-brand{
            color: #ffffff !important;
            font-size: 1.5rem;
            text-shadow: 0 0 10px rgba(0,255,255,0.9);
        }

        /* nav link */
        .nav-link{
            color: rgba(255,255,255,0.9) !important;
            font-weight: 600;
            transition: 0.3s;
            position: relative;
        }

        /* hover neon */
        .nav-link:hover{
            color: #00ffff !important;
            text-shadow: 0 0 10px rgba(0,255,255,1);
        }

        /* garis hover bawah */
        .nav-link::after{
            content: "";
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 0%;
            height: 2px;
            background: #00ffff;
            transition: 0.3s;
            box-shadow: 0 0 10px cyan;
        }

        .nav-link:hover::after{
            width: 100%;
        }

        /* tombol daftar */
        .btn-outline-light{
            border: 1px solid rgba(255,255,255,0.5);
            color: white !important;
            transition: 0.3s;
        }

        /* hover tombol */
        .btn-outline-light:hover{
            background: linear-gradient(135deg,#00ffff,#0066ff);
            border: none;
            color: white !important;
            box-shadow: 0 0 15px rgba(0,255,255,0.8);
        }
        .nav-link { 
            color: rgba(255,255,255,0.9) !important; 
            font-weight: 500;
        }
        .nav-link:hover { 
            color: #fff !important; 
        }

        /* Carousel Styling */
        .carousel-item { height: 500px; }
        .carousel-item img { object-fit: cover; height: 100%; filter: brightness(65%); }
        .carousel-caption { 
            bottom: 30%; 
            background: rgba(0,0,0,0.3); 
            border-radius: 20px; 
            padding: 25px; 
            backdrop-filter: blur(5px); 
        }

        /* Global Card Styling */
        .card-kategori { 
            background-color: var(--pink-light); 
            border: none; 
            border-radius: 20px; 
            transition: 0.3s; 
            text-align: center; 
            padding: 20px; 
        }
        .card-kategori:hover { 
            background-color: var(--pink-main); 
            transform: translateY(-5px); 
        }
        .card-kategori:hover h5 { color: white !important; }

        .card-destinasi { 
            border: none; 
            border-radius: 20px; 
            transition: 0.3s; 
            overflow: hidden; 
            background: white; 
        }
        .card-destinasi:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
        }
        .img-card { height: 210px; object-fit: cover; }
        
        /* Buttons */
        .btn-pink { 
            background: var(--pink-main); 
            color: white; 
            border-radius: 25px; 
            border: none; 
            padding: 8px 20px; 
            font-weight: bold; 
        }
        .btn-pink:hover { background: var(--pink-dark); color: white; }

        /* Detail Page Styling */
        .img-main { width: 100%; height: 400px; object-fit: cover; border-radius: 25px; }
        .sticky-wrapper { 
            position: -webkit-sticky; 
            position: sticky; 
            top: 90px; 
            z-index: 10; 
        }
        .badge-hot { 
            position: absolute; 
            top: 15px; 
            right: 15px; 
            background: var(--pink-dark); 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 11px; 
            font-weight: bold; 
            z-index: 5;
        }

        /* ===== STYLING DROPDOWN AKUN PROFILE ===== */
        .dropdown-menu .dropdown-item {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        .dropdown-menu .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.08) !important;
            color: #00ffff !important;
            text-shadow: 0 0 5px rgba(0,255,255,0.5);
        }
        .dropdown-menu .dropdown-item.text-danger:hover {
            background: rgba(255, 0, 0, 0.15) !important;
            color: #ff4d4d !important;
        }
        /* Menghilangkan tanda panah bawaan bootstrap jika merusak visual */
        .dropdown-toggle::after {
            margin-left: 0.5em;
            vertical-align: 0.255em;
        }

        @media (max-width: 768px) {
            .carousel-item { height: 300px; }
            .sticky-wrapper { position: static; margin-top: 20px; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">💖 BOKWIS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto text-center align-items-center">
        <li class="nav-item">
            <a class="nav-link px-3" href="index.php">Beranda</a>
        </li>
        
        <?php if(isset($_SESSION['admin'])): ?>
            <li class="nav-item">
                <a class="nav-link fw-bold text-warning" href="admin/dashboard.php">Panel Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
            
        <?php elseif(isset($_SESSION['user'])): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 px-3 active" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgba(255,255,255,0.08); border-radius: 20px; box-shadow: 0 0 10px rgba(0,255,255,0.12); outline: none;">
                    <div class="d-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; background: rgba(0, 255, 255, 0.2); border: 1px solid #00ffff; border-radius: 50%; color: #00ffff; font-size: 13px; text-shadow: 0 0 5px cyan;">
                        <?= strtoupper(substr($_SESSION['user']['nama_lengkap'], 0, 1)); ?>
                    </div>
                    <span>Hi, <?= htmlspecialchars($_SESSION['user']['username']); ?></span>
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end p-3 shadow-lg border-0" aria-labelledby="userDropdown" style="width: 290px; background: rgba(20, 20, 30, 0.96); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.15); border-radius: 20px; margin-top: 12px;">
                    <li class="text-center py-2 border-bottom mb-2" style="border-color: rgba(255,255,255,0.1) !important;">
                        <div class="d-flex align-items-center justify-content-center fw-bold mx-auto mb-2" style="width: 52px; height: 52px; background: rgba(0, 255, 255, 0.15); border: 1px solid #00ffff; border-radius: 50%; color: #00ffff; font-size: 20px; text-shadow: 0 0 8px cyan;">
                            <?= strtoupper(substr($_SESSION['user']['nama_lengkap'], 0, 1)); ?>
                        </div>
                        <h6 class="fw-bold mb-0 text-white" style="font-size: 15px; text-shadow: 0 0 5px rgba(255,255,255,0.2);"><?= htmlspecialchars($_SESSION['user']['nama_lengkap']); ?></h6>
                        <small class="text-white-50 d-block text-truncate" style="font-size: 12px;"><?= htmlspecialchars($_SESSION['user']['email']); ?></small>
                    </li>
                    
                    <li>
                        <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="profil.php?pajangan=edit_akun" style="border-radius: 10px; font-size: 14px;">
                            <i class="bi bi-person-gear"></i> Kelola Akun Wisata
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="profil.php?pajangan=riwayat" style="border-radius: 10px; font-size: 14px;">
                            <i class="bi bi-clock-history"></i> Riwayat Pemesanan
                        </a>
                    </li>
                    <li class="border-top mt-2 pt-2" style="border-color: rgba(255,255,255,0.1) !important;">
                        <a class="dropdown-item py-2 px-3 text-danger fw-bold d-flex align-items-center gap-2" href="logout.php" onclick="return confirm('Yakin ingin logout dari akun BOKWIS?')" style="border-radius: 10px; font-size: 14px;">
                            <i class="bi bi-box-arrow-right"></i> Logout dari Akun
                        </a>
                    </li>
                </ul>
            </li>
            
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link px-3" href="login.php">Login</a>
            </li>
            <li class="nav-item ms-lg-2">
                <a class="nav-link fw-bold text-white btn btn-outline-light btn-sm px-4" href="register.php" style="border-radius:20px;">Daftar</a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div style="margin-top: 60px;"></div>