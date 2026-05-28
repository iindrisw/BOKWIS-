<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>alam Indah - Wisata Alam Online</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root{
    --pink-main: #ff4da6;
    --pink-dark: #e60073;
    --pink-light: #ffe6f2;
}

body {
    scroll-behavior: smooth;
    font-family: 'Segoe UI', sans-serif;
}

/* NAVBAR */
.navbar {
    background: linear-gradient(90deg, var(--pink-dark), var(--pink-main));
}

/* HERO TEXT */
.hero-text {
    background: rgba(255, 77, 166, 0.8);
    padding: 25px;
    border-radius: 15px;
}

/* BUTTON CUSTOM */
.btn-pink {
    background: var(--pink-main);
    color: white;
    border: none;
    border-radius: 30px;
    padding: 10px 25px;
    transition: 0.3s;
}

.btn-pink:hover {
    background: var(--pink-dark);
    transform: scale(1.05);
}

/* CARD */
.card {
    border-radius: 20px;
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(255, 77, 166, 0.3);
}

.alam-img {
    width: 100%;
    height: 250px;  /* tinggi fix biar semua sama */
    object-fit: cover;
}


.card-video {
  width: 100%;
  height: 250px;       /* pakai 100% supaya mengikuti ratio parent */
  object-fit: cover;   /* fill card, crop otomatis kalau perlu */
  border-radius: 20px; /* sama seperti card gambar */
}


/* SECTION TITLE */
h2 {
    font-weight: bold;
    color: var(--pink-dark);
}

/* BOOKING */
#booking-alam {
    background: var(--pink-light);
}

/* INPUT */
.form-control {
    border-radius: 30px;
    padding: 12px;
}

/* FOOTER */
footer {
    background: linear-gradient(90deg, var(--pink-main), var(--pink-dark));
    color: white;
    padding: 25px 0;
}

/* CAROUSEL IMAGE */
.carousel-item img, .galeri img {
    border-radius: 20px;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Bokwis Ciayumajakuning</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">

        <li class="nav-item">
          <a class="nav-link active" href="index.php">Beranda</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            Destinasi
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="pantai.php">Pantai</a></li>
            <li><a class="dropdown-item" href="gunung.php">Gunung</a></li>
            <li><a class="dropdown-item" href="alam.php">Alam</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>

      </ul>
    </div>
  </div>
</nav>

<!-- PILIH gunug -->
<section id="alam" class="container my-5 pt-5">
  <h2 class="text-center mb-4"><br>ALAM POPULER</h2>

  <!-- ROW 1: alam 1-3 -->
  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card shadow">
        <img src="https://picsum.photos/400/300?4" class="card-img-top">
        <div class="card-body text-center">
          <h5 class="card-title">Curug Cilengkrang</h5>
          <p>Curug Cilengkrang.</p>
          <a href="cilengkrang.php" class="btn btn-pink">Lihat Detail</a>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card shadow">
        <img src="https://picsum.photos/400/300?5" class="card-img-top">
        <div class="card-body text-center">
          <h5 class="card-title">Cibuntu</h5>
          <p>Udara segar dan pemandangan indah.</p>
          <a href="cibuntu.php" class="btn btn-pink">Lihat Detail</a>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card shadow">
        <img src="https://picsum.photos/400/300?6" class="card-img-top">
        <div class="card-body text-center">
          <h5 class="card-title">Terasering Panyaweuyan</h5>
          <p>Petualangan alam yang menenangkan.</p>
          <a href="panyaweuyan.php" class="btn btn-pink">Lihat Detail</a>
        </div>
      </div>
    </div>
  </div>

  <!-- ROW 2: alam 4-6 -->
  <div class="row mt-4">
    <div class="col-md-4 mb-4">
      <div class="card shadow">
        <img src="https://picsum.photos/400/300?7" class="card-img-top">
        <div class="card-body text-center">
          <h5 class="card-title">Curug Ibun Pelangi</h5>
          <p>Air jernih dan pemandangan menawan.</p>
          <a href="ibun.php" class="btn btn-pink">Lihat Detail</a>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card shadow">
        <img src="https://picsum.photos/400/300?8" class="card-img-top">
        <div class="card-body text-center">
          <h5 class="card-title">Situ Cipanten</h5>
          <p>Suasana tenang dan nyaman.</p>
          <a href="cipanten.php" class="btn btn-pink">Lihat Detail</a>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card shadow">
        <img src="https://picsum.photos/400/300?9" class="card-img-top">
        <div class="card-body text-center">
          <h5 class="card-title">Curug Muara Jaya</h5>
          <p>alam eksotis dengan pasir putih bersih.</p>
          <a href="muara.php" class="btn btn-pink">Lihat Detail</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="text-center mt-5">
  <p>© 2026 Wisata Pink | All Rights Reserved</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>