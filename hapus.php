<?php
require_once 'koneksi.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM barang WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header("Location: index.php?sukses=hapus#data-barang");
exit();
?>