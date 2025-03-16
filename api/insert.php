<?php
require_once './../config/connection.php';

try {
    $nama_tasks = $_POST['nama_tasks'];
    $tanggal = $_POST['tanggal'];
    $prioritas = $_POST['prioritas'];
    $status = $_POST['status'];

    $query = mysqli_query($connection, "INSERT INTO tasks (nama_tasks, tanggal, prioritas, status) VALUES ('$nama_tasks', '$tanggal', '$prioritas', '$status')");
    header("location: ./../public/index.php");
} catch (Exception $e) {
    echo 'Error:' . $e->getMessage();
}