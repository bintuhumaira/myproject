<?php
require '../config/db.php'; // Koneksi ke database
require '../vendor/autoload.php'; // Memuat autoload dari PhpSpreadsheet
require './Peserta.php'; // Memuat class Peserta

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['fileUpload']['name'])) {
    $fileName = $_FILES['fileUpload']['name'];
    $fileTmp = $_FILES['fileUpload']['tmp_name'];
    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

    if ($fileExt === 'xlsx') {
        try {
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $id_kegiatan = $_GET['id'];

                // Memeriksa apakah ID kegiatan ada di database
                $kegiatan = mysqli_query($db_connect, "SELECT * FROM kegiatan WHERE id_kegiatan = '$id_kegiatan'");
                if (mysqli_num_rows($kegiatan) > 0) {
                    // Membaca file Excel
                    $spreadsheet = IOFactory::load($fileTmp);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $rows = $worksheet->toArray(null, true, true, true);

                    // Memulai transaksi
                    mysqli_begin_transaction($db_connect);

                    // Menggunakan class Peserta untuk memasukkan data
                    foreach ($rows as $index => $row) {
                        if ($index === 1) continue; // Lewati baris header

                        $namaPeserta = mysqli_real_escape_string($db_connect, $row['A']);
                        $noTelepon = mysqli_real_escape_string($db_connect, $row['B']);
                        $email = mysqli_real_escape_string($db_connect, $row['C']);
                        $alamat = mysqli_real_escape_string($db_connect, $row['D']);
                        $status = mysqli_real_escape_string($db_connect, $row['E']);
                        $peringkat = mysqli_real_escape_string($db_connect, $row['F']);
                        $jenis_lomba = mysqli_real_escape_string($db_connect, $row['G']);

                        // Membuat objek Peserta
                        $peserta = new Peserta($namaPeserta, $noTelepon, $email, $alamat, $status, $peringkat, $jenis_lomba, $id_kegiatan);

                        // Menyimpan data peserta ke database menggunakan class Peserta
                        if (!$peserta->simpanDataPeserta($db_connect)) {
                            throw new Exception("Gagal menyimpan data peserta.");
                        }
                    }

                    // Komit transaksi
                    mysqli_commit($db_connect);

                    // Redirect kembali dengan pesan sukses
                    header('Location: ../up_peserta.php?status=success&id=' . $id_kegiatan);
                    exit();
                } else {
                    throw new Exception("ID kegiatan tidak ditemukan.");
                }
            } else {
                throw new Exception("Parameter ID kegiatan tidak ditemukan di URL.");
            }
        } catch (Exception $e) {
            // Rollback transaksi jika terjadi error
            mysqli_rollback($db_connect);
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Format file tidak valid. Harap unggah file dengan format .xlsx";
    }
} else {
    echo "Harap unggah file terlebih dahulu.";
}
?>
