<?php
require './../config/db.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}


// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $_POST['peserta'];
    $no_telepon = $_POST['no_telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];
    $peringkat = $_POST['peringkat'];
    $jenis_lomba = $_POST['jenis_lomba'];
    $id_kegiatan = $_GET['id'];  // ID kegiatan dari URL

    // Membuat objek Peserta dan menyimpan data
    require_once 'Peserta.php';
    $peserta = new Peserta($nama, $no_telepon, $email, $alamat, $status, $peringkat, $jenis_lomba, $id_kegiatan);

    if ($peserta->simpanDataPeserta($db_connect)) {
        // Redirect ke halaman yang sesuai setelah berhasil
        header("Location: ../up_peserta.php?id=$id_kegiatan");
    } else {
        echo "<script>alert('Gagal menyimpan data peserta'); window.location.href='../tambah_peserta.php?id=$id_kegiatan';</script>";
    }
}
?>
