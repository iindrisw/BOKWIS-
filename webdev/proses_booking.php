<?php
session_start();
include 'koneksi.php';

// 1. Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    echo "
    <script>
        alert('Silakan login terlebih dahulu untuk memesan tiket!');
        window.location='login.php';
    </script>
    ";
    exit;
}

// 2. Cek apakah data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Ambil data user dari session untuk dimasukkan ke tabel booking
    $nama_user      = mysqli_real_escape_string($conn, $_SESSION['user']['nama_lengkap']);
    $email          = mysqli_real_escape_string($conn, $_SESSION['user']['email']);
    
    // Ambil data dari form detail.php
    $id_destinasi   = mysqli_real_escape_string($conn, $_POST['id_destinasi']);
    $tanggal_wisata = mysqli_real_escape_string($conn, $_POST['tanggal']); // menangkap name="tanggal" dari form
    $jumlah_tiket   = (int)$_POST['jumlah']; // menangkap name="jumlah" dari form

    // Validasi input jumlah tiket
    if ($jumlah_tiket < 1) {
        echo "
        <script>
            alert('Jumlah tiket minimal 1!');
            window.history.back();
        </script>
        ";
        exit;
    }

    // 3. Ambil harga tiket dari database untuk menghitung total bayar
    $query_wisata = mysqli_query($conn, "SELECT harga_tiket FROM destinasi WHERE id_destinasi = '$id_destinasi'");
    $data_wisata  = mysqli_fetch_assoc($query_wisata);

    if (!$data_wisata) {
        echo "
        <script>
            alert('Destinasi tidak ditemukan!');
            window.location='index.php';
        </script>
        ";
        exit;
    }

    $harga_tiket = $data_wisata['harga_tiket'];
    $total_bayar = $harga_tiket * $jumlah_tiket;

    // Set nilai default untuk status bayar
    $status_bayar = "Lunas"; 

    // Set waktu transaksi saat ini (Format: YYYY-MM-DD HH:MM:SS)
    $waktu_transaksi = date('Y-m-d H:i:s'); 

    // 4. Query INSERT disesuaikan 100% dengan kolom databasemu
    $query_insert = "INSERT INTO booking 
                     (id_destinasi, nama_user, email, tanggal_wisata, jumlah_tiket, total_bayar, status_bayar, waktu_transaksi) 
                     VALUES 
                     ('$id_destinasi', '$nama_user', '$email', '$tanggal_wisata', '$jumlah_tiket', '$total_bayar', '$status_bayar', '$waktu_transaksi')";

    if (mysqli_query($conn, $query_insert)) {
        // Mengambil ID booking yang baru saja digenerate oleh auto_increment
        $id_booking_baru = mysqli_insert_id($conn);
        
        echo "
        <script>
            alert('Booking berhasil dilakukan!');
            window.location='struk.php?id=" . $id_booking_baru . "'; 
        </script>
        ";
    } else {
        // Jika query gagal dieksekusi oleh MySQL, langsung tampilkan error aslinya untuk debugging
        echo "Gagal menyimpan ke database! Error: " . mysqli_error($conn);
        exit;
    }
} else {
    // Jika file diakses langsung tanpa melalui form POST, tendang ke index
    header("Location: index.php");
    exit;
}
?>