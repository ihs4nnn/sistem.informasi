<?php
require_once 'koneksi.php';

// Mengambil riwayat beserta nama barang menggunakan SQL JOIN
$query = "SELECT r.*, b.nama_barang 
          FROM riwayat_transaksi r 
          JOIN barang b ON r.id_barang = b.id 
          ORDER BY r.tanggal DESC, r.id DESC";
$stmt = $pdo->query($query);
$riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Inventaris</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="app-layout">
        <!-- Sidebar -->
        <aside class="sidebar glass-panel">
            <div class="sidebar-profile">
                <div class="avatar"><i class="fas fa-user"></i></div>
                <h3>Muhammad Fikri</h3>
                <p>Administrator</p>
            </div>
            <nav class="sidebar-menu">
                <a href="index.php"><i class="fas fa-home"></i> Dashboard</a>
                <a href="index.php#data-barang"><i class="fas fa-box-open"></i> Data Barang</a>
                <a href="transaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi Stok</a>
                <a href="riwayat.php" class="active"><i class="fas fa-history"></i> Riwayat Transaksi</a>
                <a href="#" class="text-danger" style="margin-top: auto;"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="glass-panel glow-panel">
                <div class="header-action">
                    <h2 class="card-title"><i class="fas fa-history"></i> Riwayat Arus Barang</h2>
                    <div class="action-buttons">
                        <a href="transaksi.php" class="btn btn-primary"><i class="fas fa-plus"></i> Catat Transaksi</a>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($riwayat) > 0): ?>
                                <?php $no = 1; foreach ($riwayat as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                                    <td style="font-weight: 500;"><?= htmlspecialchars($row['nama_barang']) ?></td>
                                    
                                    <td>
                                        <?php if($row['jenis_transaksi'] == 'masuk'): ?>
                                            <span class="badge-status status-aman"><i class="fas fa-arrow-down"></i> Masuk</span>
                                        <?php else: ?>
                                            <span class="badge-status status-habis"><i class="fas fa-arrow-up"></i> Keluar</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Angka diberi warna sesuai jenisnya -->
                                    <td class="<?= $row['jenis_transaksi'] == 'masuk' ? 'text-masuk' : 'text-keluar' ?>">
                                        <?= $row['jenis_transaksi'] == 'masuk' ? '+' : '-' ?><?= number_format($row['jumlah'], 0, ',', '.') ?>
                                    </td>
                                    
                                    <td><?= htmlspecialchars($row['keterangan'] ?: '-') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 30px 0;">
                                        <i class="fas fa-history fa-3x" style="color: rgba(255,255,255,0.2); margin-bottom: 15px; display:block;"></i>
                                        Belum ada riwayat transaksi.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>