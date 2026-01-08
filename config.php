<?php
$host = 'localhost';       // ganti sesuai host DomaiNesia
$user = 'root';         // username database
$pass = '';     // password database
$db   = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>