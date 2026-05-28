<?php
include 'header.php';

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// Query ambil data dan hitung rating sekaligus
$res = mysqli_query($conn, "SELECT d.*, AVG(r.rating) as avg_r, COUNT(r.id_review) as total_r 
                            FROM destinasi d 
                            LEFT JOIN review r ON d.id_destinasi = r.id_destinasi 
                            WHERE d.id_destinasi = '$id' GROUP BY d.id_destinasi");
$data = mysqli_fetch_array($res);

if (!$data) { echo "<script>window.location='index.php';</script>"; exit; }
$rating_angka = round($data['avg_r'], 1) ?: '0.0';
?>
<style>

/* ===== FONT ===== */
*{
    font-family: 'Poppins', sans-serif;
}

/* ===== BACKGROUND ===== */
body{
    background: url('foto/bg.jpg') no-repeat center center fixed;
    background-size: cover;
    animation: bgZoom 18s ease-in-out infinite alternate;
    overflow-x: hidden;
    position: relative;
}

/* overlay */
body::before{
    content: "";
    position: fixed;
    inset: 0;
    background:
        radial-gradient(circle at center,
        rgba(255,255,255,0.10),
        rgba(0,0,0,0.78));
    z-index: -1;
    animation: glowMove 10s ease-in-out infinite alternate;
}

/* sparkle */
body::after{
    content: "";
    position: fixed;
    inset: 0;
    background:
        radial-gradient(circle,
        rgba(255,255,255,0.08) 2px,
        transparent 3px);
    background-size: 120px 120px;
    animation: sparkle 20s linear infinite;
    opacity: .5;
    z-index: -1;
}

/* animasi */
@keyframes bgZoom{
    0%{ background-size:100%; }
    100%{ background-size:110%; }
}

@keyframes glowMove{
    0%{
        opacity:.5;
        filter: blur(0px);
    }
    100%{
        opacity:1;
        filter: blur(8px);
    }
}

@keyframes sparkle{
    from{ background-position:0 0; }
    to{ background-position:300px 300px; }
}

/* ===== TEXT ===== */
h1,h2,h3,h4,h5,h6{
    color: white !important;
    font-weight: 700;
    text-shadow: 0 0 12px rgba(255,255,255,0.35);
}

p,
span,
small,
label{
    color: rgba(255,255,255,0.85) !important;
}

.text-muted,
.text-secondary{
    color: rgba(255,255,255,0.65) !important;
}

/* ===== IMAGE ===== */
.img-main{
    width: 100%;
    height: 420px;
    object-fit: cover;
    border-radius: 25px;
    border: 1px solid rgba(255,255,255,0.12);
    box-shadow: 0 0 25px rgba(255,255,255,0.08);
}

/* ===== CARD ===== */
.card{
    background: rgba(255,255,255,0.10) !important;
    backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,0.10) !important;
    border-radius: 25px !important;
    color: white;
    transition: .3s;
}

.card:hover{
    transform: translateY(-4px);
    box-shadow: 0 0 25px rgba(255,255,255,0.12);
}

/* ===== REVIEW CARD ===== */
.review-card{
    background: rgba(255,255,255,0.08) !important;
}

/* ===== INPUT ===== */
.form-control,
.form-select,
textarea{
    background: rgba(255,255,255,0.08) !important;
    border: 1px solid rgba(255,255,255,0.12) !important;
    color: white !important;
    border-radius: 18px !important;
    padding: 12px !important;
}

.form-control::placeholder,
textarea::placeholder{
    color: rgba(255,255,255,0.5);
}

.form-control:focus,
.form-select:focus,
textarea:focus{
    background: rgba(255,255,255,0.12) !important;
    box-shadow: 0 0 15px rgba(255,255,255,0.10) !important;
    border-color: rgba(255,255,255,0.25) !important;
    color: white !important;
}

/* option select */
option{
    background: #1f1f1f;
    color: white;
}

/* ===== BUTTON ===== */
.btn-pink{
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.15);
    color: white !important;
    border-radius: 18px;
    padding: 12px;
    font-weight: 700;
    transition: .3s;
    backdrop-filter: blur(10px);
}

.btn-pink:hover{
    background: rgba(255,255,255,0.18);
    transform: translateY(-2px);
    box-shadow: 0 0 18px rgba(255,255,255,0.15);
}

/* ===== RATING ===== */
.text-warning{
    color: #ffffff !important;
    text-shadow: 0 0 10px rgba(255,255,255,0.6);
}

/* ===== STICKY ===== */
.sticky-wrapper{
    position: sticky;
    top: 100px;
}

/* ===== HR ===== */
hr{
    border-color: rgba(255,255,255,0.12);
}

</style>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-7">
            <img src="foto/<?= $data['gambar']; ?>" class="img-main shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold" style="color: var(--pink-dark);"><?= strtoupper($data['nama_wisata']); ?></h2>
                <div class="text-end">
                    <span class="fs-3 fw-bold text-warning">★ <?= $rating_angka; ?></span>
                    <p class="small text-muted mb-0"><?= $data['total_r']; ?> Ulasan</p>
                </div>
            </div>
            <p class="text-muted mt-3" style="text-align: justify;"><?= $data['deskripsi']; ?></p>
            <hr>
            
            <h4 class="fw-bold mb-4">Ulasan Bintang</h4>
            <?php
            $reviews = mysqli_query($conn, "SELECT * FROM review WHERE id_destinasi = '$id' ORDER BY tanggal_review DESC");
            if(mysqli_num_rows($reviews) > 0):
                while($rev = mysqli_fetch_assoc($reviews)):
            ?>
                <div class="card review-card p-3 mb-3 shadow-sm border-0">
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-bold mb-1"><?= $rev['nama_user']; ?></h6>
                        <span class="text-warning">
                            <?php for($i=1; $i<=5; $i++) echo ($i <= $rev['rating'] ? '★' : '☆'); ?>
                        </span>
                    </div>
                    <p class="small text-secondary mb-0">"<?= $rev['komentar']; ?>"</p>
                </div>
            <?php endwhile; else: echo "<p class='text-muted'>Belum ada ulasan bintang.</p>"; endif; ?>
        </div>

        <div class="col-md-5">
            <div class="sticky-wrapper">
                <div class="card shadow-sm p-4 mb-4 border-0" style="background: var(--pink-light); border-radius:20px;">
                    <h5 class="fw-bold text-center">Booking Tiket</h5>
                    <?php if(isset($_SESSION['user'])): ?>
                        <form action="proses_booking.php" method="POST">
                            <input type="hidden" name="id_destinasi" value="<?= $id; ?>">
                            <label class="small fw-bold">Pemesan:</label>
                            <input type="text" class="form-control mb-2" value="<?= $_SESSION['user']['nama_lengkap']; ?>" readonly>
                            <div class="row g-2">
                                <div class="col-6"><input type="date" name="tanggal" class="form-control mb-2" required></div>
                                <div class="col-6"><input type="number" name="jumlah" class="form-control mb-2" min="1" value="1"></div>
                            </div>
                            <button type="submit" class="btn btn-pink w-100">PESAN SEKARANG</button>
                        </form>
                    <?php else: ?>
                        <div class="text-center">
                            <p class="small">Login untuk booking tiket</p>
                            <a href="login_user.php" class="btn btn-pink w-100">Login</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card border-0 shadow-sm p-4" style="border-radius: 20px; background: #fff1f8;">
                    <h5 class="fw-bold mb-3">Kasih Bintang</h5>
                    <?php if(isset($_SESSION['user'])): ?>
                        <form action="simpan_review.php" method="POST">
                            <input type="hidden" name="id_destinasi" value="<?= $id; ?>">
                            <select name="rating" class="form-select mb-2">
                                <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                                <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                                <option value="3">⭐⭐⭐ (Cukup)</option>
                                <option value="2">⭐⭐ (Buruk)</option>
                                <option value="1">⭐ (Sangat Buruk)</option>
                            </select>
                            <textarea name="komentar" class="form-control mb-3" placeholder="Apa komentarmu?"></textarea>
                            <button type="submit" class="btn btn-pink btn-sm w-100">KIRIM BINTANG</button>
                        </form>
                    <?php else: ?>
                        <p class="small text-center">Login dulu untuk kasih bintang!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>