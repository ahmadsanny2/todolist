<?php
require_once './../config/connection.php';

try {
    $id_tasks = $_GET['id'];
    $query = mysqli_query($connection, "DELETE FROM tasks WHERE id_tasks = $id_tasks");
    header("location:./../public/index.php");
} catch (Exception $e) {
    echo 'Error:' . $e->getMessage();
}