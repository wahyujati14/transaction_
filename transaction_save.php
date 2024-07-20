<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $customer_id = (int) $_POST['customer_id'];
    $shipping_cost = floatval($_POST['shipping_cost']);
    $subtotal = floatval($_POST['js_subtotal']);
    $total_discount = floatval($_POST['js_total_discount']);
    $total_bayar = floatval($_POST['js_total_bayar']);

    // Insert a new transaction record into t_sales
    $sql = "INSERT INTO t_sales (kode, tgl, cust_id, subtotal, diskon, ongkir, total_bayar) VALUES ('', '$date', $customer_id, $subtotal, $total_discount, $shipping_cost, $total_bayar)";
    if ($conn->query($sql) === TRUE) {
        $sales_id = $conn->insert_id;

        $item_ids = $_POST['item_id'];
        $quantities = $_POST['quantity'];
        $discounts = $_POST['discount'];
        $prices = $_POST['price'];

        for ($i = 0; $i < count($item_ids); $i++) {
            $item_id = (int) $item_ids[$i];
            $quantity = intval($quantities[$i]);
            $discount = floatval($discounts[$i]);
            $price = floatval($prices[$i]);

            $discount_amount = ($price * $quantity) * ($discount / 100);
            $price_after_discount = ($price * $quantity) - $discount_amount;

            $sql = "INSERT INTO t_sales_det (sales_id, barang_id, harga_bandrol, qty, diskon_pct, diskon_nilai, harga_diskon, total) VALUES ($sales_id, $item_id, $price, $quantity, $discount, $discount_amount, $price_after_discount, $price_after_discount)";
            $conn->query($sql);
        }

        // Generate the transaction code in format YYYYMM-XXXX
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $kode = $year . $month . '-' . str_pad($sales_id, 4, '0', STR_PAD_LEFT);

        // Update the transaction record with the generated code
        $sql = "UPDATE t_sales SET kode='$kode' WHERE id=$sales_id";
        $conn->query($sql);

        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
