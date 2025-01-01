<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ./login.php'); // Redirect ke halaman login jika belum login
    exit;
}
require './config/db.php';

// Ambil parameter ID kegiatan dari URL
$id_kegiatan = isset($_GET['id_kegiatan']) ? intval($_GET['id_kegiatan']) : 0;

// Query untuk mendapatkan data kegiatan
$query_kegiatan = mysqli_query($db_connect, "SELECT nama_kegiatan, tanggal_kegiatan FROM kegiatan WHERE id_kegiatan = $id_kegiatan");
$data_kegiatan = mysqli_fetch_assoc($query_kegiatan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peserta | Tivicate-DKM Jamie Su'ada</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="dashboard-style.css">
    
    <!-- Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        body {
            overflow-y: auto;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000; /* Pastikan sidebar selalu berada di atas */
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background: #fff;
        }

        .content {
            flex-grow: 1;
            background: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 0px; /* Tambahkan margin bawah agar tidak menabrak footer */
        }

        .footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px 0;
            margin-top: auto; /* Membuat footer berada di bagian bawah */
            box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
            z-index: 10;
            position: relative;
            width: 100%;
            border-top: 1px solid #ddd;
        }
    </style>
    
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="./images/dkm.jpeg" alt="Tivicate Logo">
            <hr>
        </div>
        <ul>
            <li><a href="dashboard.php"><i class="bi bi-house-door-fill"></i> <b>Dashboard</b></a></li>
            <hr>
            <li><a href="kegiatan.php"><i class="bi bi-calendar3"></i> <b>Data Kegiatan</b></a></li>
            <li><a href="sertifikat.php" class="active"><i class="bi bi-filetype-pdf"></i> <b>Sertifikat</b></a></li>
            <li><a href="javascript:void(0);" onclick="confirmLogout()"><i class="bi bi-box-arrow-left"></i> <b>Logout</b></a></li>
            <hr>
        </ul>
    </div>


    <div class="main-content">
        <div class="topbar">
            <span class="user-name"><?php include './backend/profil_user.php'; ?></span>
            <img src="./images/profil.png" alt="Admin Profile" class="profile-pic">
        </div>
        <div class="content">
            <div class="row mb-2">
                <div class="col-lg-4">
                    <h4 class="page-title">Data Peserta</h4>
                </div>
                <div class="col-lg-8">
                    <div class="d-flex">
                        <a href="sertifikat.php" type="button" class="btn btn-danger ms-auto me-2">Kembali</a>
                    </div>
                </div>
            </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-lg-2">
                                <label for="nama_kegiatan" class="form-label"><b>Nama Kegiatan :</b></label>
                            </div>
                            <div class="col-lg-10">
                                <?php
                                    require './config/db.php';

                                    // Ambil ID kegiatan dari parameter URL 
                                    $id_kegiatan = $_GET['id'];

                                    $kegiatan = mysqli_query($db_connect, "SELECT * FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'");
                                    while($row = mysqli_fetch_assoc($kegiatan)) {
                                ?>
                                    <label><?= $row['nama_kegiatan']; ?></label>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-2">
                                <label for="tema" class="form-label"><b>Tema Kegiatan :</b></label>
                            </div>
                            <div class="col-lg-10">
                                <?php
                                    require './config/db.php';

                                    // Ambil ID kegiatan dari parameter URL 
                                    $id_kegiatan = $_GET['id'];

                                    $kegiatan = mysqli_query($db_connect, "SELECT * FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'");
                                    while($row = mysqli_fetch_assoc($kegiatan)) {
                                ?>
                                    <label><?= $row['tema']; ?></label>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-2">
                                <label for="tanggal_kegiatan" class="form-label"><b>Tanggal Kegiatan</b></label>
                            </div>
                            <div class="col-lg-10">
                                <?php
                                    require './config/db.php';

                                    // Ambil ID kegiatan dari parameter URL 
                                    $id_kegiatan = $_GET['id'];

                                    $kegiatan = mysqli_query($db_connect, "SELECT * FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'");
                                    while($row = mysqli_fetch_assoc($kegiatan)) {
                                ?>
                                    <label><?= $row['tanggal_kegiatan']; ?></label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>  
        <br>
            <!-- Table -->
            <table id="dataPeserta" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>No Hp</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require './config/db.php';

                        // Ambil id_kegiatan dari request (pastikan nilai ini berasal dari input yang valid)
                        $id_kegiatan = $_GET['id']; // Misalnya, id_kegiatan diterima dari URL
                        
                        // Query untuk memfilter peserta berdasarkan id_kegiatan
                        $peserta = mysqli_query($db_connect, "SELECT * FROM peserta WHERE id_kegiatan = '$id_kegiatan'");
                        $no = 1;

                        while($row = mysqli_fetch_assoc($peserta)) {
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['nama_peserta']; ?></td>
                            <td><?= $row['no_telepon']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['alamat']; ?></td>
                            <td><?= $row['status']; ?></td>
                            <td>
                                <a href="generate_certificate.php?id_peserta=<?= $row['id_peserta']; ?>" class="btn btn-success btn-sm"><i class="bi bi-file-pdf"></i></a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="confirmDelete('delete_peserta.php?id_peserta=<?= $row['id_peserta']; ?>&id=<?= $id_kegiatan; ?>')"><i class="bi bi-trash3"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataPeserta').DataTable(); // Mengaktifkan fitur interaktif pada tabel
        });
    </script>

        <!-- SweetAlert -->

    <script>
        function confirmDelete(deleteUrl) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data peserta yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Arahkan ke URL hapus
                    window.location.href = deleteUrl;
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script> 
        function confirmLogout() {
            Swal.fire({
                title: 'Apakah Anda yakin ingin keluar?',
                text: "Anda akan keluar dari sesi ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, keluar!',
                cancelButtonText: 'Batal',
                backdrop: false // Hilangkan overlay abu-abu
            }).then((result) => {
                if (result.isConfirmed) {
                    // Arahkan ke logout.php untuk menghapus session
                    window.location.href = 'logout.php';
                }
            });
        }
    </script>

</body>
</html>