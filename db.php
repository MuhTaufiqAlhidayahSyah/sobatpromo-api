<?php
$host = "sql111.infinityfree.com";
$user = "if0_40162373";      // ganti jika hosting
$pass = "Taufiq123456789";
$db   = "if0_40162373_sobatpromo";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
