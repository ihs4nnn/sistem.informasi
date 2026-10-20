<?php
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $tanggal = $_POST['tanggal_masuk'];

    $sql = "INSERT INTO barang (nama_barang, kategori, jumlah, harga, tanggal_masuk) 
            VALUES (:nama, :kategori, :jumlah, :harga, :tanggal)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':nama' => $nama,
        ':kategori' => $kategori,
        ':jumlah' => $jumlah,
        ':harga' => $harga,
        ':tanggal' => $tanggal
    ]);

    // Kembali ke index
    header("Location: index.php?sukses=tambah#data-barang");
    exit();
}
?>