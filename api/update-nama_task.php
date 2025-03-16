<?php
require_once './../config/connection.php';

$id_tasks = $_POST['id_tasks'];
$nama_tasks = $_POST['nama_tasks'];

try {
    mysqli_query($connection, "UPDATE tasks SET nama_tasks = '$nama_tasks' WHERE id_tasks = $id_tasks");
    header("location: ./../public/index.php");
} catch (Exception $e) {
    echo "Error: getMessage->$e";
}