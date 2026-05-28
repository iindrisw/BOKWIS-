<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    // =========================
    // LOGIN ADMIN
    // =========================
    $cek_admin = mysqli_query($conn, "
        SELECT * FROM admin 
        WHERE username='$username' 
        AND password='$password'
    ");

    if (mysqli_num_rows($cek_admin) > 0) {

        $data_admin = mysqli_fetch_assoc($cek_admin);

        $_SESSION['admin'] = [
            'id_admin' => $data_admin['id_admin'],
            'username' => $data_admin['username'],
			'nama_lengkap'  => $data_admin['nama_lengkap']
        ];

        header("Location: admin/dashboard.php");
        exit();
    }

    // =========================
    // LOGIN USER
    // =========================
    $cek_user = mysqli_query($conn, "
        SELECT * FROM users 
        WHERE (username='$username' OR email='$username')
        AND password='$password'
    ");

    if (mysqli_num_rows($cek_user) > 0) {

        $data_user = mysqli_fetch_assoc($cek_user);

        $_SESSION['user'] = [
            'id_user'       => $data_user['id_user'],
            'nama_lengkap'  => $data_user['nama_lengkap'],
            'username'      => $data_user['username'],
            'email'         => $data_user['email'],
            'foto_profil'   => $data_user['foto_profil']
        ];

        header("Location: index.php");
        exit();
    }

    // =========================
    // JIKA LOGIN GAGAL
    // =========================
    $error = "Akun tidak ditemukan atau password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login BOKWIS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

   <style>

/* ===== FONT ===== */
*{
    font-family: 'Poppins', sans-serif;
}

/* ===== BACKGROUND ===== */
body{
    background: url('foto/bg.jpg') no-repeat center center fixed;
    background-size: cover;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
    animation: bgZoom 18s ease-in-out infinite alternate;
}

/* overlay glow */
body::before{
    content: "";
    position: fixed;
    inset: 0;
    background:
        radial-gradient(circle at center,
        rgba(255,255,255,0.12),
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
        rgba(255,255,255,0.10) 2px,
        transparent 3px);
    background-size: 120px 120px;
    animation: sparkle 20s linear infinite;
    opacity: 0.5;
    z-index: -1;
}

/* animasi */
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
        opacity: .6;
        filter: blur(0px);
    }
    100%{
        opacity: 1;
        filter: blur(8px);
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

/* ===== CARD LOGIN ===== */
.card{
    width: 420px;
    border-radius: 30px;
    border: 1px solid rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.10);
    backdrop-filter: blur(15px);
    padding: 35px;
    box-shadow:
        0 0 25px rgba(255,255,255,0.08);
    transition: .4s;
}

.card:hover{
    transform: translateY(-5px);
    box-shadow:
        0 0 35px rgba(255,255,255,0.18);
}

/* ===== TITLE ===== */
h2{
    color: white !important;
    font-weight: 800;
    text-shadow: 0 0 12px rgba(255,255,255,0.5);
}

p,
.small{
    color: rgba(255,255,255,0.75) !important;
}

/* ===== INPUT ===== */
.form-control{
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 18px;
    padding: 14px;
    color: white !important;
    backdrop-filter: blur(10px);
}

.form-control::placeholder{
    color: rgba(255,255,255,0.55);
}

.form-control:focus{
    background: rgba(255,255,255,0.12);
    border-color: rgba(255,255,255,0.4);
    box-shadow:
        0 0 15px rgba(255,255,255,0.15);
    color: white;
}

/* ===== BUTTON ===== */
.btn-pink{
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.18);
    color: white;
    border-radius: 18px;
    padding: 13px;
    font-weight: 700;
    letter-spacing: .5px;
    transition: .3s;
    backdrop-filter: blur(10px);
}

.btn-pink:hover{
    transform: translateY(-2px);
    background: rgba(255,255,255,0.18);
    box-shadow:
        0 0 18px rgba(255,255,255,0.18);
    color: white;
}

/* ===== ALERT ===== */
.alert-danger{
    background: rgba(255,0,0,0.12);
    border: 1px solid rgba(255,255,255,0.1);
    color: white;
    border-radius: 15px;
}

/* ===== LINK ===== */
a{
    color: white !important;
    font-weight: 600;
    text-decoration: none;
    transition: .3s;
}

a:hover{
    text-shadow: 0 0 10px rgba(255,255,255,0.8);
}

/* ===== RESPONSIVE ===== */
@media(max-width:576px){

    .card{
        width: 92%;
        padding: 25px;
    }

    h2{
        font-size: 28px;
    }

}

</style>
</head>

<body>

<div class="card shadow-lg">

    <div class="text-center mb-4">
        <h2 class="fw-bold" style="color: #e60073;">Login</h2>
        <p class="text-muted small">
            Masuk ke akun BOKWIS kamu
        </p>
    </div>

    <?php if(isset($error)) : ?>
        <div class="alert alert-danger small">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">

        <div class="mb-3">
            <input 
                type="text" 
                name="username" 
                class="form-control"
                placeholder="Username atau Email"
                required
            >
        </div>

        <div class="mb-4">
            <input 
                type="password" 
                name="password" 
                class="form-control"
                placeholder="Password"
                required
            >
        </div>

        <button 
            type="submit" 
            name="login"
            class="btn btn-pink w-100 mb-3"
        >
            MASUK
        </button>

        <p class="text-center small">
            Belum punya akun?
            <a href="register.php" style="color:#ff4da6;">
                Daftar di sini
            </a>
        </p>

    </form>

</div>

</body>
</html>