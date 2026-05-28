<?php 
include 'header.php'; 


// 1. Logika Filter & Urutkan Berdasarkan Rating Tertinggi
if (isset($_GET['kategori'])) {
    $kat = mysqli_real_escape_string($conn, $_GET['kategori']);
    $query = mysqli_query($conn, "SELECT d.*, AVG(r.rating) as rata_rating, COUNT(r.id_review) as total_rev 
                                  FROM destinasi d 
                                  LEFT JOIN review r ON d.id_destinasi = r.id_destinasi 
                                  WHERE d.kategori = '$kat'
                                  GROUP BY d.id_destinasi 
                                  ORDER BY rata_rating DESC");
    $title_section = "Wisata " . $kat . " Terbaik";
} else {
    $query = mysqli_query($conn, "SELECT d.*, AVG(r.rating) as rata_rating, COUNT(r.id_review) as total_rev 
                                  FROM destinasi d 
                                  LEFT JOIN review r ON d.id_destinasi = r.id_destinasi 
                                  GROUP BY d.id_destinasi 
                                  ORDER BY rata_rating DESC LIMIT 6");
    $title_section = "⭐ Destinasi Rating Tertinggi";
}
?>

<style>
/* BACKGROUND ANIMASI */
body{
    background: url('foto/bg.jpg') no-repeat center center fixed;
    background-size: cover;
    animation: bgZoom 18s ease-in-out infinite alternate;
    overflow-x: hidden;
    position: relative;
}

/* overlay glow */
body::before{
    content: "";
    position: fixed;
    inset: 0;
    background:
        radial-gradient(circle at center,
        rgba(170,0,255,0.25),
        rgba(0,0,0,0.65));
    animation: glowMove 10s ease-in-out infinite alternate;
    z-index: -1;
}

/* efek partikel glow */
body::after{
    content: "";
    position: fixed;
    inset: 0;
    background:
        radial-gradient(circle, rgba(0,255,255,0.15) 2px, transparent 3px);
    background-size: 120px 120px;
    animation: sparkle 20s linear infinite;
    z-index: -1;
    opacity: 0.6;
}

/* animasi zoom background */
@keyframes bgZoom{
    0%{
        background-size: 100%;
    }
    100%{
        background-size: 110%;
    }
}

/* animasi glow */
@keyframes glowMove{
    0%{
        opacity: 0.5;
        filter: blur(0px);
    }
    100%{
        opacity: 0.9;
        filter: blur(8px);
    }
}

/* animasi sparkle */
@keyframes sparkle{
    from{
        background-position: 0 0;
    }
    to{
        background-position: 300px 300px;
    }
}

/* CARD GLASS EFFECT */
.card{
    background: rgba(255,255,255,0.10);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 20px;
    color: white;
    transition: 0.4s;
}

/* hover card */
.card:hover{
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 0 25px rgba(0,255,255,0.5);
}

/* carousel */
.carousel{
    border-radius: 25px;
    overflow: hidden;
    animation: floatHero 5s ease-in-out infinite;
}

/* hero animasi */
@keyframes floatHero{
    0%{
        transform: translateY(0px);
    }
    50%{
        transform: translateY(-6px);
    }
    100%{
        transform: translateY(0px);
    }
}

/* text glow */
h1, h3, h5{
    text-shadow: 0 0 10px rgba(0,255,255,0.8);
}

/* tombol glow */
.btn-pink{
    box-shadow: 0 0 15px rgba(255,0,255,0.7);
    transition: 0.3s;
}

.btn-pink:hover{
    transform: scale(1.08);
    box-shadow: 0 0 25px rgba(0,255,255,1);
}
/* ===== SEMUA FONT INDEX ===== */

/* font global */
*{
    font-family: 'Poppins', sans-serif;
}

/* semua text */
body,
p,
span,
small,
a,
label,
li,
td,
th{
    color: #ffffff !important;
}

/* heading */
h1,h2,h3,h4,h5,h6{
    color: #ffffff !important;
    font-weight: 700;
    text-shadow: 0 0 12px rgba(0,255,255,0.9);
}

/* text muted bootstrap */
.text-muted{
    color: #f1f1f1 !important;
}

/* harga tiket */
.fs-5{
    color: #00ffff !important;
    font-weight: bold;
    text-shadow: 0 0 10px rgba(0,255,255,0.8);
}

/* navbar link */
.nav-link,
.navbar-brand{
    color: white !important;
    font-weight: 600;
}

/* hover navbar */
.nav-link:hover{
    color: #ffffff !important;
}

/* card text */
.card p,
.card h5,
.card span{
    color: white !important;
}

/* kategori wisata */
.card-kategori h5{
    color: #ffffff !important;
}

/* tombol */
.btn{
    font-weight: 600;
}

/* tombol pink */
.btn-pink{
    background: linear-gradient(135deg, #ff00cc, #3333ff);
    border: none;
    color: white !important;
}

/* tombol hover */
.btn-pink:hover{
    background: linear-gradient(135deg, #00ffff, #0066ff);
    color: white !important;
}

/* carousel caption */
.carousel-caption h1{
    font-size: 3rem;
    font-weight: 800;
    text-shadow: 0 0 20px rgba(0,255,255,1);
}

.carousel-caption p{
    font-size: 1.1rem;
    color: #ffffff !important;
    text-shadow: 0 0 10px rgba(0,0,0,0.9);
}

/* badge rating */
.badge-hot{
    color: white;
    font-weight: bold;
    text-shadow: 0 0 8px rgba(255,255,255,0.9);
}

/* link */
a{
    text-decoration: none;
}

/* carousel ukuran */
#hero{
    max-width: 1200px;
    margin: 30px auto;
    border-radius: 25px;
    overflow: hidden;
}

#hero .carousel-item img{
    height: 500px;
    object-fit: cover;
    filter: brightness(65%);
}

/* responsive */
@media (max-width:768px){

    .carousel-caption h1{
        font-size: 1.8rem;
    }

    .carousel-caption p{
        font-size: 0.9rem;
    }

    #hero .carousel-item img{
        height: 300px;
    }
    /* MENU NAVBAR AKTIF */
    .navbar .nav-link.active,
    .navbar .nav-link:focus,
    .navbar .nav-link:active{
        color: #ffffff !important;
        background: rgba(255,255,255,0.08) !important;
        border-radius: 12px;
        box-shadow: 0 0 12px rgba(255,255,255,0.15);
        text-shadow: 0 0 10px rgba(255,255,255,0.4);
        outline: none !important;
    }

    /* hover navbar */
    .nav-link:hover{
        color: #ffffff !important;
    }

    /* hilangkan cyan bootstrap */
    .navbar-dark .navbar-nav .nav-link.active{
        color: #ffffff !important;
    }
}
</style>

<div id="hero" class="carousel slide shadow" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="foto/p1.JPG" class="d-block w-100" onerror="this.src='https://via.placeholder.com/1200x500?text=Jelajahi+Keindahan+Alam'">
      <div class="carousel-caption">
        <h1 class="fw-bold text-white">Jelajahi Keindahan Alam</h1>
        <p class="text-white">Booking tiket wisata Ciayumajakuning lebih mudah dan cepat.</p>
        <a href="#destinasi" class="btn btn-pink px-4">Cari Wisata</a>
      </div>
    </div>
    <div class="carousel-item">
      <img src="foto/g1.JPG" class="d-block w-100" onerror="this.src='https://via.placeholder.com/1200x500?text=Petualangan+Menantimu'">
      <div class="carousel-caption">
        <h1 class="fw-bold text-white">Petualangan Menantimu</h1>
        <p class="text-white">Nikmati momen tak terlupakan bersama orang tersayang.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#hero" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#hero" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<section id="kategori" class="container my-5">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Pilih Kategori Wisata</h3>
    </div>
    <div class="row g-3 justify-content-center text-center">
        <div class="col-6 col-md-3">
            <a href="index.php?kategori=Pantai#destinasi" class="text-decoration-none">
                <div class="card card-kategori shadow-sm p-3">
                    <h5 class="fw-bold mb-0" style="color: var(--pink-dark);">🏖️ Pantai</h5>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="index.php?kategori=Gunung#destinasi" class="text-decoration-none">
                <div class="card card-kategori shadow-sm p-3">
                    <h5 class="fw-bold mb-0" style="color: var(--pink-dark);">⛰️ Gunung</h5>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="index.php?kategori=Alam#destinasi" class="text-decoration-none">
                <div class="card card-kategori shadow-sm p-3">
                    <h5 class="fw-bold mb-0" style="color: var(--pink-dark);">🌿 Alam</h5>
                </div>
            </a>
        </div>
    </div>
</section>

<div class="container"><hr></div>

<div id="destinasi" class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><?= $title_section; ?></h3>
        <?php if(isset($_GET['kategori'])): ?>
            <a href="index.php" class="btn btn-sm btn-outline-secondary rounded-pill">Lihat Semua</a>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <?php 
        if(mysqli_num_rows($query) > 0) {
            while($d = mysqli_fetch_array($query)): 
                $rating = round($d['rata_rating'], 1) ?: '0.0';
        ?>
        <div class="col-md-4">
            <div class="card card-destinasi shadow-sm h-100 position-relative">
                <div class="badge-hot">
                    ★ <?= $rating; ?> (<?= $d['total_rev']; ?>)
                </div>
                <img src="foto/<?= $d['gambar']; ?>" class="card-img-top img-card" onerror="this.src='https://via.placeholder.com/400x250'">
                <div class="card-body d-flex flex-column">
                    <h5 class="fw-bold mb-2"><?= $d['nama_wisata']; ?></h5>
                    <p class="text-muted small"><?= substr($d['deskripsi'], 0, 80); ?>...</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-5 text-dark">Rp <?= number_format($d['harga_tiket']); ?></span>
                        <a href="detail.php?id=<?= $d['id_destinasi']; ?>" class="btn btn-pink btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; } else { echo "<p class='text-center text-muted'>Belum ada data untuk kategori ini.</p>"; } ?>
    </div>
</div>

<?php include 'footer.php'; ?>