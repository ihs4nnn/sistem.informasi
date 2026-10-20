<?php
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_barang = $_POST['id_barang'];
    $jenis_transaksi = $_POST['jenis_transaksi'];
    $jumlah = (int)$_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];

    try {
        // Mulai transaksi database agar aman (jika salah satu gagal, semua dibatalkan)
        $pdo->beginTransaction();

        // Cek stok saat ini
        $stmtCek = $pdo->prepare("SELECT jumlah FROM barang WHERE id = :id");
        $stmtCek->execute([':id' => $id_barang]);
        $barang = $stmtCek->fetch(PDO::FETCH_ASSOC);

        if ($jenis_transaksi == 'keluar' && $barang['jumlah'] < $jumlah) {
            // Jika stok tidak cukup untuk barang keluar, batalkan
            header("Location: transaksi.php?error=" . urlencode("Stok tidak mencukupi! Sisa stok saat ini hanya " . $barang['jumlah']));
            exit();
        }

        // 1. Masukkan data ke riwayat_transaksi
        $sqlRiwayat = "INSERT INTO riwayat_transaksi (id_barang, jenis_transaksi, jumlah, tanggal, keterangan) 
                       VALUES (:id_barang, :jenis, :jumlah, :tanggal, :keterangan)";
        $stmtRiwayat = $pdo->prepare($sqlRiwayat);
        $stmtRiwayat->execute([
            ':id_barang' => $id_barang,
            ':jenis' => $jenis_transaksi,
            ':jumlah' => $jumlah,
            ':tanggal' => $tanggal,
            ':keterangan' => $keterangan
        ]);

        // 2. Update jumlah di tabel barang
        if ($jenis_transaksi == 'masuk') {
            $sqlUpdate = "UPDATE barang SET jumlah = jumlah + :jumlah WHERE id = :id_barang";
        } else {
            $sqlUpdate = "UPDATE barang SET jumlah = jumlah - :jumlah WHERE id = :id_barang";
        }
        
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([
            ':jumlah' => $jumlah,
            ':id_barang' => $id_barang
        ]);

        // Simpan semua perubahan
        $pdo->commit();
        
        // Arahkan ke halaman riwayat setelah berhasil
        header("Location: riwayat.php");
        exit();

    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Terjadi kesalahan: " . $e->getMessage());
    }
}
?>