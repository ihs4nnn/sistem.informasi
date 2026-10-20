<?php
require_once 'koneksi.php';
// Ambil daftar barang untuk dropdown
$stmt = $pdo->query("SELECT id, nama_barang, jumlah FROM barang ORDER BY nama_barang ASC");
$barangs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Stok - Inventaris</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form-page-layout">
        <div class="glass-panel glow-panel form-panel">
            <h2><i class="fas fa-exchange-alt"></i> Form Transaksi Stok</h2>
            
            <!-- Tampilkan Pesan Error jika stok tidak cukup -->
            <?php if(isset($_GET['error'])): ?>
                <div style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <form action="proses_transaksi.php" method="POST">
                <div class="form-group">
                    <label>Pilih Barang</label>
                    <select name="id_barang" required>
                        <option value="" hidden>-- Pilih Barang --</option>
                        <?php foreach($barangs as $b): ?>
                            <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['nama_barang']) ?> (Sisa Stok: <?= $b['jumlah'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Jenis Transaksi</label>
                    <select name="jenis_transaksi" required>
                        <option value="masuk">Barang Masuk (+)</option>
                        <option value="keluar">Barang Keluar (-)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Jumlah Barang</label>
                    <input type="number" name="jumlah" placeholder="Masukkan jumlah..." required min="1">
                </div>
                
                <div class="form-group">
                    <label>Tanggal Transaksi</label>
                    <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-group">
                    <label>Keterangan (Opsional)</label>
                    <input type="text" name="keterangan" placeholder="Misal: Restock dari supplier / Rusak / Terjual">
                </div>
                
                <div class="form-actions">
                    <a href="index.php" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Proses Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>