<?php
require_once 'koneksi.php';

// Konfigurasi Paginasi & Pencarian (Sama seperti sebelumnya)
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$whereClause = "";
$params = [];

if ($search != '') {
    $whereClause = "WHERE nama_barang LIKE :search";
    $params[':search'] = "%$search%";
}

$stmtTotal = $pdo->query("SELECT SUM(jumlah) as total_item, COUNT(id) as total_jenis, SUM(jumlah * harga) as total_aset FROM barang");
$summary = $stmtTotal->fetch(PDO::FETCH_ASSOC);
$totalItem = $summary['total_item'] ?? 0;
$totalJenis = $summary['total_jenis'] ?? 0;
$totalAset = $summary['total_aset'] ?? 0;

$stmtCount = $pdo->prepare("SELECT COUNT(id) as total FROM barang $whereClause");
$stmtCount->execute($params);
$totalRows = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalRows / $limit);

$stmt = $pdo->prepare("SELECT * FROM barang $whereClause ORDER BY id DESC LIMIT $limit OFFSET $offset");
$stmt->execute($params);
$barangs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Inventaris Modern</title>
    <!-- Import Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Import FontAwesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="app-layout">
        <!-- Sidebar Navigation -->
        <aside class="sidebar glass-panel">
            <div class="sidebar-profile">
                <div class="avatar"><i class="fas fa-user"></i></div>
                <h3>Muhammad Fikri</h3>
                <p>Administrator</p>
            </div>
          <nav class="sidebar-menu">
    <a href="index.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
    <a href="index.php#data-barang"><i class="fas fa-box-open"></i> Data Barang</a>
    <!-- Menu Baru -->
    <a href="transaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi Stok</a>
    <a href="riwayat.php"><i class="fas fa-history"></i> Riwayat Transaksi</a>
    <!-- Akhir Menu Baru -->
    <a href="#" class="text-danger" style="margin-top: auto;"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="glass-panel glow-panel">
                <h1>Dashboard Inventaris</h1>
                <div class="summary">
                    <div>
                        <p>Total Jenis</p>
                        <h3><?= number_format($totalJenis, 0, ',', '.') ?></h3>
                    </div>
                    <div>
                        <p>Item Fisik</p>
                        <h3><?= number_format($totalItem, 0, ',', '.') ?></h3>
                    </div>
                    <div>
                        <p>Total Nilai Aset</p>
                        <h3>Rp <?= number_format($totalAset, 0, ',', '.') ?></h3>
                    </div>
                </div>
            </div>

            <div class="glass-panel glow-panel">
                <div class="header-action">
                    <h2 class="card-title">Daftar Barang</h2>
                    
                    <div class="action-group">
                        <form action="index.php" method="GET" class="search-form">
                            <div class="input-icon-wrapper">
                                <i class="fas fa-search"></i>
                                <input type="text" name="search" placeholder="Cari barang..." value="<?= htmlspecialchars($search) ?>" class="search-input">
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                            <?php if($search): ?>
                                <a href="index.php" class="btn btn-warning" title="Reset"><i class="fas fa-sync-alt"></i></a>
                            <?php endif; ?>
                        </form>
                        
                        <a href="laporan.php<?= $search ? '?search='.urlencode($search) : '' ?>" target="_blank" class="btn btn-warning"><i class="fas fa-print"></i> Cetak</a>
                        <a href="tambah.php" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah</a>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table>
                     <thead>
                        <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Status Stok</th> <!-- Kolom Baru -->
                                    <th>Harga</th>
                                    <th>Total Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($barangs) > 0): ?>
                                    <?php $no = $offset + 1; foreach ($barangs as $row): 
                                        // LOGIKA STATUS STOK
                                        $stok = $row['jumlah'];
                                        if ($stok == 0) {
                                            $status_class = 'status-habis';
                                            $status_text = '<i class="fas fa-times-circle"></i> Habis';
                                        } elseif ($stok <= 5) { // Angka batas 'menipis' bisa diubah di sini
                                            $status_class = 'status-menipis';
                                            $status_text = '<i class="fas fa-exclamation-triangle"></i> Menipis';
                                        } else {
                                            $status_class = 'status-aman';
                                            $status_text = '<i class="fas fa-check-circle"></i> Aman';
                                        }
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                                        <td><span class="badge"><?= htmlspecialchars($row['kategori']) ?></span></td>
                                        <td style="font-weight: bold; font-size: 1.1rem;"><?= number_format($stok, 0, ',', '.') ?></td>
                                        <!-- Menampilkan Badge Status -->
                                        <td><span class="badge-status <?= $status_class ?>"><?= $status_text ?></span></td>
                                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                        <td class="text-highlight">Rp <?= number_format($row['jumlah'] * $row['harga'], 0, ',', '.') ?></td>
                                        <td>
                                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn-action btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                        <button onclick="konfirmasiHapus(<?= $row['id'] ?>)" class="btn-action btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 30px 0;">
                                        <i class="fas fa-inbox fa-3x" style="color: rgba(255,255,255,0.2); margin-bottom: 15px; display:block;"></i>
                                        Tidak ada data barang ditemukan.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"><i class="fas fa-chevron-left"></i></a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="<?= $i == $page ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"><i class="fas fa-chevron-right"></i></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
    <script src="js/script.js"></script>

    <!-- Elemen Custom Modal Konfirmasi Hapus -->
    <div class="modal-overlay" id="delete-modal">
        <div class="modal-box">
            <div class="modal-icon"><i class="fas fa-exclamation-circle"></i></div>
            <h3 class="modal-title">Hapus Data Barang?</h3>
            <p class="modal-desc">Data yang dihapus tidak dapat dikembalikan. Riwayat transaksi terkait barang ini juga akan ikut terhapus.</p>
            <div class="modal-actions">
                <button class="btn btn-warning" onclick="tutupModal()">Batal</button>
                <button class="btn btn-danger" onclick="prosesHapus()">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>

    <!-- Script PHP untuk menangkap status keberhasilan dari URL -->
    <?php $status = isset($_GET['sukses']) ? $_GET['sukses'] : ''; ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const status = "<?= $status ?>";
            if(status === 'tambah') {
                showToast('Barang baru berhasil ditambahkan!', 'success');
            } else if(status === 'hapus') {
                showToast('Data barang berhasil dihapus!', 'success');
            } else if(status === 'edit') {
                showToast('Data barang berhasil diperbarui!', 'success');
            }
        });
    </script>
</body>
</html>