<?php
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $tanggal = $_POST['tanggal_masuk'];

    $sql = "UPDATE barang SET 
            nama_barang = :nama, 
            kategori = :kategori, 
            jumlah = :jumlah, 
            harga = :harga, 
            tanggal_masuk = :tanggal 
            WHERE id = :id";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nama' => $nama,
        ':kategori' => $kategori,
        ':jumlah' => $jumlah,
        ':harga' => $harga,
        ':tanggal' => $tanggal,
        ':id' => $id
    ]);
    
    header("Location: index.php?sukses=edit#data-barang");
    exit();
}
?>
    exit();
}
?>