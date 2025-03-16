<?php
require_once './../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Ambil status checkbox saat ini
    $result = $connection->query("SELECT checked FROM tasks WHERE id_tasks='$id'");
    $row = $result->fetch_assoc();

    // Toggle nilai checked (1 jadi 0, 0 jadi 1)
    $checked_baru = ($row['checked'] == 1) ? 0 : 1;

    // Tentukan status berdasarkan checked
    $status_baru = ($checked_baru == 1) ? 'Selesai' : 'Belum';

    // Update checked dan status di database
    $connection->query("UPDATE tasks SET checked='$checked_baru', status='$status_baru' WHERE id_tasks='$id'");

    // Kembali ke halaman sebelumnya
    header("Location: ./../public/index.php");
    exit();
}

$connection->close();
?>