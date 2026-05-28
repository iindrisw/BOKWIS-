<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: ../login.php"); exit; }
include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Bokwis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { width: 250px; height: 100vh; background: #212529; color: white; position: fixed; }
        .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 15px 20px; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #343a40; color: #ff4da6; border-left: 4px solid #ff4da6; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card-stat { border: none; border-radius: 15px; border-left: 5px solid #ff4da6; }
        .table-custom { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .btn-action { border-radius: 10px; padding: 5px 15px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="p-4"><h4 class="fw-bold text-white">ADMIN PANEL</h4><hr></div>
    <a href="dashboard.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="kelola_destinasi.php"><i class="bi bi-map"></i> Kelola Destinasi</a>
    <a href="kelola_galeri.php"><i class="bi bi-images"></i> Galeri Foto</a>
    <a href="laporan_booking.php"><i class="bi bi-journal-text"></i> Rekap Booking</a>
    <div style="position: absolute; bottom: 20px; width: 100%;">
        <a href="../logout.php" class="text-danger"><i class="bi bi-box-arrow-left"></i> Logout</a>
    </div>
</div>