<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #333;
            display: flex;
            justify-content: center;
            /* Centers the navbar items */
            overflow: hidden;
        }

        .navbar a {
            display: block;
            color: #fff;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="index.php">Transaction List</a>
        <a href="transaction_form.php">New Transaction</a>
        <a href="customers.php">Customers</a>
        <a href="products.php">Products</a>
    </div>
</body>

</html>