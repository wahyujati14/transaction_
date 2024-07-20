<?php include 'nav.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        h2 {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            margin-bottom: 20px;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            min-width: 1000px;
            /* Minimum width to trigger horizontal scroll */
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-form input[type="text"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 80%;
            box-sizing: border-box;
        }

        .search-form input[type="submit"] {
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        .search-form input[type="submit"]:hover {
            background-color: #555;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            background-color: #f4f4f4;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
        }

        .pagination a.active {
            background-color: #333;
            color: #fff;
        }

        .pagination a:hover {
            background-color: #555;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Daftar Transaksi</h2>
        <form class="search-form" action="" method="get">
            <input type="text" name="search" placeholder="Cari transaksi..."
                value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <input type="submit" value="Cari">
        </form>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Transaksi</th>
                        <th>Tanggal</th>
                        <th>Nama Customer</th>
                        <th>Jumlah Barang</th>
                        <th>Sub Total</th>
                        <th>Diskon</th>
                        <th>Ongkir</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db_connection.php';

                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                    $limit = 10;
                    $offset = ($page - 1) * $limit;

                    $sql = "SELECT t_sales.*, m_customer.name 
                            FROM t_sales 
                            JOIN m_customer ON t_sales.cust_id = m_customer.id
                            WHERE t_sales.kode LIKE '%$search%' OR m_customer.name LIKE '%$search%' OR t_sales.tgl LIKE '%$search%'
                            LIMIT $limit OFFSET $offset";

                    $result = $conn->query($sql);
                    $total_bayar_all = 0;
                    $no = $offset + 1;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $sql_items = "SELECT SUM(qty) as jumlah_barang FROM t_sales_det WHERE sales_id = " . $row["id"];
                            $result_items = $conn->query($sql_items);
                            $jumlah_barang = $result_items->fetch_assoc()["jumlah_barang"];

                            echo "<tr>
                                    <td>" . $no++ . "</td>
                                    <td>" . $row["kode"] . "</td>
                                    <td>" . $row["tgl"] . "</td>
                                    <td>" . $row["name"] . "</td>
                                    <td>" . $jumlah_barang . "</td>
                                    <td>" . $row["subtotal"] . "</td>
                                    <td>" . $row["diskon"] . "</td>
                                    <td>" . $row["ongkir"] . "</td>
                                    <td>" . $row["total_bayar"] . "</td>
                                  </tr>";

                            $total_bayar_all += $row["total_bayar"];
                        }
                    } else {
                        echo "<tr><td colspan='9'>No results found</td></tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="8" style="text-align:right">Grand Total:</th>
                        <th><?php echo $total_bayar_all; ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="pagination">
            <?php
            $sql_total = "SELECT COUNT(*) as total FROM t_sales 
                          JOIN m_customer ON t_sales.cust_id = m_customer.id
                          WHERE t_sales.kode LIKE '%$search%' OR m_customer.name LIKE '%$search%' OR t_sales.tgl LIKE '%$search%'";
            $result_total = $conn->query($sql_total);
            $total_rows = $result_total->fetch_assoc()['total'];
            $total_pages = ceil($total_rows / $limit);

            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='?page=$i&search=$search' class='" . ($i == $page ? 'active' : '') . "'>$i</a>";
            }

            $conn->close();
            ?>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tableContainer = document.querySelector('.table-container');

            // Detect touch devices
            const isTouchDevice = 'ontouchstart' in window || navigator.msMaxTouchPoints;

            if (isTouchDevice) {
                let startX;
                let scrollLeft;

                tableContainer.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].pageX - tableContainer.offsetLeft;
                    scrollLeft = tableContainer.scrollLeft;
                });

                tableContainer.addEventListener('touchmove', (e) => {
                    const x = e.touches[0].pageX - tableContainer.offsetLeft;
                    const walk = (x - startX) * 3; //scroll-fast
                    tableContainer.scrollLeft = scrollLeft - walk;
                });
            }
        });
    </script>
</body>

</html>