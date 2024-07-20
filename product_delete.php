<?php
include 'db_connection.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id) {
    $sql = "DELETE FROM m_barang WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header('Location: products.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
