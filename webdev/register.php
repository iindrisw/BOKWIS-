<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']); // Enkripsi MD5

    // Cek apakah username atau email sudah terdaftar
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$email'");
    
    if (mysqli_num_rows($cek) > 0) {
        $error = "Username atau Email sudah digunakan!";
    } else {
        $query = "INSERT INTO users (nama_lengkap, username, email, password) 
                  VALUES ('$nama', '$username', '$email', '$password')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='login_user.php';</script>";
        } else {
            $error = "Gagal mendaftar, coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - BOKWIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
/* ===== BODY ===== */
body{
    background: url('foto/bg.jpg') no-repeat center center fixed;
    background-size: cover;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow-x: hidden;
    position: relative;
    font-family: 'Poppins', sans-serif;
    animation: bgZoom 18s ease-in-out infinite alternate;
    padding: 20px;
}

/* overlay glow */
body::before{
    content: "";
    position: fixed;
    inset: 0;
    background:
        radial-gradient(circle at center,
        rgba(255,255,255,0.10),
        rgba(0,0,0,0.75));
    z-index: -1;
    animation: glowMove 10s ease-in-out infinite alternate;
}

/* sparkle */
body::after{
    content: "";
    position: fixed;
    inset: 0;
    background:
        radial-gradient(circle, rgba(255,255,255,0.10) 2px, transparent 3px);
    background-size: 120px 120px;
    animation: sparkle 20s linear infinite;
    opacity: 0.5;
    z-index: -1;
}

/* ===== ANIMASI ===== */
@keyframes bgZoom{
    0%{
        background-size: 100%;
    }
    100%{
        background-size: 110%;
    }
}

@keyframes glowMove{
    0%{
        opacity: 0.5;
        filter: blur(0px);
    }
    100%{
        opacity: 1;
        filter: blur(10px);
    }
}

@keyframes sparkle{
    from{
        background-position: 0 0;
    }
    to{
        background-position: 300px 300px;
    }
}

/* ===== CARD ===== */
.card{
    width: 420px;
    border-radius: 28px;
    border: 1px solid rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.10);
    backdrop-filter: blur(15px);
    box-shadow: 0 0 35px rgba(255,255,255,0.08);
    transition: 0.4s;
}

.card:hover{
    transform: translateY(-5px);
    box-shadow: 0 0 40px rgba(255,255,255,0.15);
}

/* ===== FONT ===== */
h3,
label,
.fw-bold{
    color: white !important;
    text-shadow: 0 0 10px rgba(255,255,255,0.3);
}

p,
.small,
.text-muted{
    color: rgba(255,255,255,0.75) !important;
}

a{
    color: white !important;
    font-weight: 600;
    text-decoration: none;
}

a:hover{
    text-shadow: 0 0 10px rgba(255,255,255,0.6);
}

/* ===== INPUT ===== */
.form-control{
    border-radius: 16px;
    padding: 13px;
    border: 1px solid rgba(255,255,255,0.15);
    background: rgba(255,255,255,0.08);
    color: white;
    backdrop-filter: blur(10px);
}

.form-control::placeholder{
    color: rgba(255,255,255,0.5);
}

.form-control:focus{
    background: rgba(255,255,255,0.12);
    color: white;
    border-color: rgba(255,255,255,0.35);
    box-shadow: 0 0 15px rgba(255,255,255,0.15);
}

/* ===== BUTTON ===== */
.btn-pink{
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.18);
    color: white;
    border-radius: 18px;
    padding: 12px;
    font-weight: 600;
    transition: 0.3s;
    backdrop-filter: blur(10px);
}

.btn-pink:hover{
    background: rgba(255,255,255,0.20);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 0 20px rgba(255,255,255,0.15);
}

/* ===== ALERT ===== */
.alert{
    border-radius: 14px;
    border: none;
    background: rgba(255,0,0,0.15);
    color: white;
    backdrop-filter: blur(10px);
}
    </style>
</head>
<body>
    <div class="card shadow-lg p-4 my-4">
        <div class="text-center mb-4">
            <h3 class="fw-bold" style="color: #e60073;">Buat Akun</h3>
            <p class="text-muted small">Daftar untuk mulai booking wisata</p>
        </div>

        <?php if(isset($error)) echo "<div class='alert alert-danger small py-2'>$error</div>"; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="small fw-bold ms-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" placeholder="Contoh: Indri Setiawati" required>
            </div>
            <div class="mb-3">
                <label class="small fw-bold ms-2">Username</label>
                <input type="text" name="username" class="form-control" placeholder="indriset" required>
            </div>
            <div class="mb-3">
                <label class="small fw-bold ms-2">Email</label>
                <input type="email" name="email" class="form-control" placeholder="indri@email.com" required>
            </div>
            <div class="mb-4">
                <label class="small fw-bold ms-2">Password</label>
                <input type="password" name="password" class="form-control" placeholder="******" required>
            </div>
            <button type="submit" name="register" class="btn btn-pink w-100 mb-3">DAFTAR SEKARANG</button>
            <p class="text-center small">Sudah punya akun? <a href="login.php" style="color: #ff4da6;">Login di sini</a></p>
        </form>
    </div>
</body>
</html>