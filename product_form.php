<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Form</title>
    <style>
        form {
            max-width: 400px;
            margin: auto;
            padding: 10px;
            background: #f4f4f4;
            border-radius: 8px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background: #333;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2><?php echo isset($_GET['id']) ? 'Edit Product' : 'Add New Product'; ?></h2>
        <?php
        include 'db_connection.php';

        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $kode = '';
        $nama = '';
        $harga = '';

        if ($id) {
            $sql = "SELECT * FROM m_barang WHERE id = $id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $kode = $row['kode'];
                $nama = $row['nama'];
                $harga = $row['harga'];
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $kode = $_POST['kode'];
            $nama = $_POST['nama'];
            $harga = $_POST['harga'];

            if ($id) {
                $sql = "UPDATE m_barang SET kode='$kode', nama='$nama', harga='$harga' WHERE id=$id";
            } else {
                $sql = "INSERT INTO m_barang (kode, nama, harga) VALUES ('$kode', '$nama', '$harga')";
            }

            if ($conn->query($sql) === TRUE) {
                header('Location: products.php');
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . ($id ? '?id=' . $id : '')); ?>" method="post">
            <label for="kode">Code:</label>
            <input type="text" id="kode" name="kode" value="<?php echo $kode; ?>" required>

            <label for="nama">Name:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>" required>

            <label for="harga">Price:</label>
            <input type="number" id="harga" name="harga" step="0.01" value="<?php echo $harga; ?>" required>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>