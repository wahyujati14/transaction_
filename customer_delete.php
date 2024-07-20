<?php
include 'db_connection.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id) {
    $sql = "DELETE FROM m_customer WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header('Location: customers.php');
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
