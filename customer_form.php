<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Form</title>
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
        input[type="text"], input[type="tel"] {
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
        <h2><?php echo isset($_GET['id']) ? 'Edit Customer' : 'Add New Customer'; ?></h2>
        <?php
        include 'db_connection.php';

        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $kode = '';
        $name = '';
        $telp = '';

        if ($id) {
            $sql = "SELECT * FROM m_customer WHERE id = $id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $kode = $row['kode'];
                $name = $row['name'];
                $telp = $row['telp'];
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $kode = $_POST['kode'];
            $name = $_POST['name'];
            $telp = $_POST['telp'];

            if ($id) {
                $sql = "UPDATE m_customer SET kode='$kode', name='$name', telp='$telp' WHERE id=$id";
            } else {
                $sql = "INSERT INTO m_customer (kode, name, telp) VALUES ('$kode', '$name', '$telp')";
            }

            if ($conn->query($sql) === TRUE) {
                header('Location: customers.php');
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . ($id ? '?id=' . $id : '')); ?>" method="post">
            <label for="kode">Code:</label>
            <input type="text" id="kode" name="kode" value="<?php echo $kode; ?>" required>
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
            
            <label for="telp">Phone:</label>
            <input type="number" id="telp" name="telp" value="<?php echo $telp; ?>" required>
            
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
