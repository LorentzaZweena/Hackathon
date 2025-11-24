<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

$jenis = $_POST['jenis'];
$kategori = $_POST['kategori'];
$deskripsi = $_POST['deskripsi'];

$stmt = $conn->prepare("INSERT INTO tbl_layanan (user_id, jenis_permintaan, kategori, deskripsi) 
                        VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $user_id, $jenis, $kategori, $deskripsi);
$stmt->execute();

header("Location: layananMahasiswa.php?success=1");
exit;
?>
