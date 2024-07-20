<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = $_POST["kode"];
    $tgl = $_POST["tgl"];
    $cust_id = $_POST["cust_id"];
    $subtotal = $_POST["subtotal"];
    $diskon = $_POST["diskon"];
    $ongkir = $_POST["ongkir"];
    $total_bayar = $_POST["total_bayar"];

    $sql = "INSERT INTO t_sales (kode, tgl, cust_id, subtotal, diskon, ongkir, total_bayar)
    VALUES ('$kode', '$tgl', '$cust_id', '$subtotal', '$diskon', '$ongkir', '$total_bayar')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
