<?php

// Konfigurasi database
$DBHOST = 'localhost';
$DBUSER = 'root';
$DBPASSWORD = 'Syderabin06';
$DBNAME = 'certificate_fp';

// Koneksi menggunakan mysqli
$db_connect = mysqli_connect($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);

if (mysqli_connect_errno()) {
    die("Koneksi ke MySQL gagal: " . mysqli_connect_error());
}
?>