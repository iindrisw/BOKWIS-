<?php
include 'header.php';

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// ===============================
// QUERY DESTINASI + RATING
// ===============================

$res = mysqli_query($conn, "
    SELECT d.*, 
           AVG(r.rating) as avg_r, 
           COUNT(r.id_review) as total_r 
    FROM destinasi d 
    LEFT JOIN review r 
    ON d.id_destinasi = r.id_destinasi 
    WHERE d.id_destinasi = '$id' 
    GROUP BY d.id_destinasi
");

$data = mysqli_fetch_array($res);

if (!$data) {
    echo "<script>window.location='index.php';</script>";
    exit;
}

$rating_angka = round($data['avg_r'], 1) ?: '0.0';
?>

<style>

/* ===============================
   FONT
================================= */

*{
    font-family:'Poppins',sans-serif;
}

/* ===============================
   BACKGROUND
================================= */

body{
    background:url('foto/bg.jpg') no-repeat center center fixed;
    background-size:cover;
    animation:bgZoom 18s ease-in-out infinite alternate;
    overflow-x:hidden;
    position:relative;
}

/* overlay */

body::before{
    content:"";
    position:fixed;
    inset:0;
    background:
        radial-gradient(circle at center,
        rgba(255,255,255,0.10),
        rgba(0,0,0,0.80));
    z-index:-1;
}

/* sparkle */

body::after{
    content:"";
    position:fixed;
    inset:0;
    background:
        radial-gradient(circle,
        rgba(255,255,255,0.08) 2px,
        transparent 3px);

    background-size:120px 120px;
    animation:sparkle 20s linear infinite;
    opacity:.5;
    z-index:-1;
}

/* ===============================
   ANIMATION
================================= */

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
   TEXT
================================= */

h1,h2,h3,h4,h5,h6{
    color:white !important;
    font-weight:700;
    text-shadow:0 0 12px rgba(255,255,255,0.25);
}

p,
span,
small,
label{
    color:rgba(255,255,255,0.85) !important;
}

.text-muted,
.text-secondary{
    color:rgba(255,255,255,0.65) !important;
}

/* ===============================
   IMAGE
================================= */

.img-main{
    width:100%;
    height:430px;
    object-fit:cover;
    border-radius:25px;
    border:1px solid rgba(255,255,255,0.12);
    box-shadow:0 0 25px rgba(255,255,255,0.08);
    transition:.3s;
}

.img-main:hover{
    transform:scale(1.01);
}

/* ===============================
   CARD
================================= */

.card{
    background:rgba(255,255,255,0.10) !important;
    backdrop-filter:blur(15px);
    border:1px solid rgba(255,255,255,0.10) !important;
    border-radius:25px !important;
    color:white;
    transition:.3s;
}

.card:hover{
    transform:translateY(-4px);
    box-shadow:0 0 25px rgba(255,255,255,0.10);
}

/* ===============================
   REVIEW CARD
================================= */

.review-card{
    background:rgba(255,255,255,0.08) !important;
}

/* ===============================
   INPUT
================================= */

.form-control,
.form-select,
textarea{
    background:rgba(255,255,255,0.08) !important;
    border:1px solid rgba(255,255,255,0.12) !important;
    color:white !important;
    border-radius:18px !important;
    padding:12px !important;
}

.form-control::placeholder,
textarea::placeholder{
    color:rgba(255,255,255,0.5);
}

.form-control:focus,
.form-select:focus,
textarea:focus{
    background:rgba(255,255,255,0.12) !important;
    box-shadow:0 0 15px rgba(255,255,255,0.10) !important;
    border-color:rgba(255,255,255,0.20) !important;
    color:white !important;
}

/* select option */

option{
    background:#1f1f1f;
    color:white;
}

/* ===============================
   BUTTON
================================= */

.btn-pink{
    background:rgba(255,255,255,0.12);
    border:1px solid rgba(255,255,255,0.15);
    color:white !important;
    border-radius:18px;
    padding:12px;
    font-weight:700;
    transition:.3s;
    backdrop-filter:blur(10px);
}

.btn-pink:hover{
    background:rgba(255,255,255,0.18);
    transform:translateY(-2px);
    box-shadow:0 0 18px rgba(255,255,255,0.15);
}

/* ===============================
   RATING
================================= */

.text-warning{
    color:#ffffff !important;
    text-shadow:0 0 10px rgba(255,255,255,0.5);
}

/* ===============================
   STICKY
================================= */

.sticky-wrapper{
    position:sticky;
    top:100px;
}

/* ===============================
   MAPS
================================= */

.maps-container{
    overflow:hidden;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.25);
}

.maps-container iframe{
    display:block;
    border:none;
}

/* ===============================
   HR
================================= */

hr{
    border-color:rgba(255,255,255,0.12);
}

/* ===============================
   RESPONSIVE
================================= */

@media(max-width:768px){

    .img-main{
        height:280px;
    }

    .sticky-wrapper{
        position:relative;
        top:0;
        margin-top:20px;
    }

}

</style>

<div class="container mt-5 pt-5">

    <div class="row g-4">

        <!-- LEFT -->
        <div class="col-md-7">

            <!-- IMAGE -->
            <img src="foto/<?= $data['gambar']; ?>" class="img-main mb-4">

            <!-- TITLE -->
            <div class="d-flex justify-content-between align-items-center">

                <h2 class="fw-bold">
                    <?= strtoupper($data['nama_wisata']); ?>
                </h2>

                <div class="text-end">

                    <span class="fs-3 fw-bold text-warning">
                        ★ <?= $rating_angka; ?>
                    </span>

                    <p class="small text-muted mb-0">
                        <?= $data['total_r']; ?> Ulasan
                    </p>

                </div>

            </div>

            <!-- DESCRIPTION -->
            <p class="text-muted mt-3" style="text-align:justify; line-height:1.8;">
                <?= $data['deskripsi']; ?>
            </p>

            <!-- MAPS -->
            <div class="card border-0 shadow-sm p-4 mt-4">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h4 class="fw-bold mb-0">
                        📍 Lokasi Wisata
                    </h4>

                    <span class="small text-info">
                        Google Maps
                    </span>

                </div>

                <div class="maps-container">

                    <iframe
                        src="<?= $data['maps']; ?>"
                        width="100%"
                        height="320"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>

                </div>

            </div>

            <hr class="my-4">

            <!-- REVIEW -->
            <h4 class="fw-bold mb-4">
                Ulasan Bintang
            </h4>

            <?php
            $reviews = mysqli_query($conn, "
                SELECT * FROM review 
                WHERE id_destinasi = '$id' 
                ORDER BY tanggal_review DESC
            ");

            if(mysqli_num_rows($reviews) > 0):

                while($rev = mysqli_fetch_assoc($reviews)):
            ?>

            <div class="card review-card p-3 mb-3 shadow-sm border-0">

                <div class="d-flex justify-content-between">

                    <h6 class="fw-bold mb-1">
                        <?= $rev['nama_user']; ?>
                    </h6>

                    <span class="text-warning">

                        <?php
                        for($i=1; $i<=5; $i++){
                            echo ($i <= $rev['rating']) ? '★' : '☆';
                        }
                        ?>

                    </span>

                </div>

                <p class="small text-secondary mb-0">
                    "<?= $rev['komentar']; ?>"
                </p>

            </div>

            <?php
                endwhile;

            else:

                echo "<p class='text-muted'>Belum ada ulasan bintang.</p>";

            endif;
            ?>

        </div>

        <!-- RIGHT -->
        <div class="col-md-5">

            <div class="sticky-wrapper">

                <!-- BOOKING -->
                <div class="card shadow-sm p-4 mb-4 border-0">

                    <h4 class="fw-bold text-center mb-4">
                        Booking Tiket
                    </h4>

                    <?php if(isset($_SESSION['user'])): ?>

                    <form action="proses_booking.php" method="POST">

                        <input type="hidden"
                               name="id_destinasi"
                               value="<?= $id; ?>">

                        <label class="small fw-bold mb-2">
                            Pemesan:
                        </label>

                        <input type="text"
                               class="form-control mb-3"
                               value="<?= $_SESSION['user']['nama_lengkap']; ?>"
                               readonly>

                        <div class="row g-2">

                            <div class="col-6">

                                <input type="date"
                                       name="tanggal"
                                       class="form-control"
                                       required>

                            </div>

                            <div class="col-6">

                                <input type="number"
                                       name="jumlah"
                                       class="form-control"
                                       min="1"
                                       value="1">

                            </div>

                        </div>

                        <button type="submit"
                                class="btn btn-pink w-100 mt-3">

                            PESAN SEKARANG

                        </button>

                    </form>

                    <?php else: ?>

                    <div class="text-center">

                        <p class="small">
                            Login untuk booking tiket
                        </p>

                        <a href="login_user.php"
                           class="btn btn-pink w-100">

                           Login

                        </a>

                    </div>

                    <?php endif; ?>

                </div>

                <!-- REVIEW FORM -->
                <div class="card border-0 shadow-sm p-4">

                    <h4 class="fw-bold mb-3">
                        Kasih Bintang
                    </h4>

                    <?php if(isset($_SESSION['user'])): ?>

                    <form action="simpan_review.php" method="POST">

                        <input type="hidden"
                               name="id_destinasi"
                               value="<?= $id; ?>">

                        <select name="rating"
                                class="form-select mb-3">

                            <option value="5">
                                ⭐⭐⭐⭐⭐ (Sangat Bagus)
                            </option>

                            <option value="4">
                                ⭐⭐⭐⭐ (Bagus)
                            </option>

                            <option value="3">
                                ⭐⭐⭐ (Cukup)
                            </option>

                            <option value="2">
                                ⭐⭐ (Buruk)
                            </option>

                            <option value="1">
                                ⭐ (Sangat Buruk)
                            </option>

                        </select>

                        <textarea
                            name="komentar"
                            class="form-control mb-3"
                            rows="4"
                            placeholder="Apa komentarmu?"></textarea>

                        <button type="submit"
                                class="btn btn-pink w-100">

                            KIRIM BINTANG

                        </button>

                    </form>

                    <?php else: ?>

                    <p class="small text-center">
                        Login dulu untuk kasih bintang!
                    </p>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>