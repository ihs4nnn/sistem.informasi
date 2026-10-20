<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Inventaris</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form-page-layout">
        <div class="glass-panel glow-panel form-panel">
            <h2><i class="fas fa-plus-circle"></i> Tambah Barang Baru</h2>
            
            <form action="proses_tambah.php" method="POST">
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" placeholder="Contoh: Laptop Asus VivoBook" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="kategori" placeholder="Contoh: Elektronik" required>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" placeholder="0" required min="0">
                </div>
                <div class="form-group">
                    <label>Harga Satuan (Rp)</label>
                    <input type="number" name="harga" placeholder="0" required min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" required>
                </div>
                
                <div class="form-actions">
                    <a href="index.php" class="btn btn-danger"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>