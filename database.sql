CREATE DATABASE IF NOT EXISTS invetaris_db;
USE invetaris_db;

CREATE TABLE IF NOT EXISTS barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(255) NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    jumlah INT NOT NULL,
    harga DECIMAL(15,2) NOT NULL,
    tanggal_masuk DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS riwayat_transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_barang INT NOT NULL,
    jenis_transaksi ENUM('masuk', 'keluar') NOT NULL,
    jumlah INT NOT NULL,
    tanggal DATE NOT NULL,
    keterangan VARCHAR(255),
    FOREIGN KEY (id_barang) REFERENCES barang(id) ON DELETE CASCADE
);