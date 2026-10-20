<?php
require_once 'koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM barang WHERE id = :id");
$stmt->execute([':id' => $id]);
$barang = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$barang) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - Inventaris</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form-page-layout">
        <div class="glass-panel glow-panel form-panel">
            <h2><i class="fas fa-edit"></i> Edit Data Barang</h2>
            
            <form action="proses_edit.php" method="POST">
                <input type="hidden" name="id" value="<?= $barang['id'] ?>">
                
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" value="<?= htmlspecialchars($barang['nama_barang']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="kategori" value="<?= htmlspecialchars($barang['kategori']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" value="<?= $barang['jumlah'] ?>" required min="0">
                </div>
                <div class="form-group">
                    <label>Harga Satuan (Rp)</label>
                    <input type="number" name="harga" value="<?= $barang['harga'] ?>" required min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" value="<?= $barang['tanggal_masuk'] ?>" required>
                </div>
                
                <div class="form-actions">
                    <a href="index.php" class="btn btn-danger"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-check"></i> Update Data</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>