<?php
$host = "shinkansen.proxy.rlwy.net";  // Host dari Railway
$port = "32942";                       // Port dari Railway
$dbname = "railway";                   // Nama database
$user = "postgres";                    // Username
$pass = "JzVwGXVjyjYvEfgVgiIOzMleDNlmsXMY";   // Password dari Railway (hapus bintang, salin asli)

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Koneksi gagal: " . $e->getMessage()]);
    exit;
}
?>
