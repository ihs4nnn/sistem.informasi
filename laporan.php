<?php
require_once 'koneksi.php';

// Menangkap query pencarian jika user mencetak saat sedang melakukan pencarian
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$whereClause = "";
$params = [];

if ($search != '') {
    $whereClause = "WHERE nama_barang LIKE :search";
    $params[':search'] = "%$search%";
}

// Ambil semua data barang (tanpa limit paginasi agar semua tercetak)
$stmt = $pdo->prepare("SELECT * FROM barang $whereClause ORDER BY id ASC");
$stmt->execute($params);
$barangs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Inventaris</title>
    <style>
        /* Desain khusus cetak: Teks hitam, latar putih bersih */
        body {
            font-family: 'Times New Roman', Times, serif; /* Font standar laporan */
            background-color: #ffffff;
            color: #000000;
            margin: 20px 40px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0 0 5px 0;
            font-size: 24px;
        }
        .header p {
            margin: 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000000;
            padding: 8px 12px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        td:nth-child(1), td:nth-child(4) {
            text-align: center; /* Menengahkan nomor dan jumlah */
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 14px;
        }
        .footer p {
            margin-bottom: 60px;
        }
        /* Menyembunyikan elemen tertentu saat mode print (opsional) */
        @media print {
            @page { margin: 1cm; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN DATA INVENTARIS</h1>
        <p>Sistem Informasi Pendataan Barang</p>
        <?php if($search): ?>
            <p><strong>Filter Pencarian:</strong> "<?= htmlspecialchars($search) ?>"</p>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total Nilai Aset</th>
                <th>Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($barangs) > 0): ?>
                <?php $no = 1; foreach ($barangs as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($row['kategori']) ?></td>
                    <td><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($row['jumlah'] * $row['harga'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['tanggal_masuk']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data barang untuk dicetak.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Bondowoso, <?= date('d F Y') ?></p>
        <strong>Administrator</strong>
    </div>

    <!-- Script untuk memicu dialog print otomatis -->
    <script>
        window.onload = function() {
            // Membuka dialog print (Save as PDF) bawaan browser otomatis setelah halaman dimuat
            window.print();
        };
    </script>
</body>
</html>