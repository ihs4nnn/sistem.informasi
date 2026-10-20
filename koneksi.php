<?php
$host = 'localhost';
$dbname = 'invetaris_db';
$username = 'root'; // Sesuaikan dengan username database Anda
$password = '';     // Sesuaikan dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set error mode ke exception agar error mudah dilacak
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>