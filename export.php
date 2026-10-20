<?php
require_once 'koneksi.php';

// Atur header agar browser mengunduh file sebagai CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Laporan_Inventaris_' . date('Ymd') . '.csv');

// Buka output stream
$output = fopen('php://output', 'w');

// Tambahkan judul kolom ke baris pertama CSV
fputcsv($output, ['ID', 'Nama Barang', 'Kategori', 'Jumlah', 'Harga Satuan (Rp)', 'Total Nilai Aset (Rp)', 'Tanggal Masuk']);

// Ambil semua data barang
$stmt = $pdo->query("SELECT * FROM barang ORDER BY id ASC");
$barangs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Masukkan data ke CSV
foreach ($barangs as $row) {
    $totalNilai = $row['jumlah'] * $row['harga'];
    fputcsv($output, [
        $row['id'],
        $row['nama_barang'],
        $row['kategori'],
        $row['jumlah'],
        $row['harga'],
        $totalNilai,
        $row['tanggal_masuk']
    ]);
}

// Tutup output stream
fclose($output);
exit();
?>