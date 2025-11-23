<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

if (isset($_POST['jadwal_id'])) {

    $jadwal_id = intval($_POST['jadwal_id']);
    $user_id   = $_SESSION['user_id'];
    $check = $conn->query("SELECT id FROM tbl_absensi WHERE user_id = $user_id AND jadwal_id = $jadwal_id");

    if ($check->num_rows > 0) {
        echo "already";
        exit;
    }

    $query = "INSERT INTO tbl_absensi (user_id, jadwal_id, status) VALUES ($user_id, $jadwal_id, 'Hadir')";

    if ($conn->query($query)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
