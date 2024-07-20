<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Transaction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            margin-top: 0;
            text-align: center;
        }

        .form-group {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .form-group label {
            flex: 1;
            margin-right: 10px;
            min-width: 100px;
        }

        .form-group input,
        .form-group select {
            flex: 2;
            min-width: 200px;
            padding: 5px;
        }

        .form-group input[type="date"],
        .form-group input[type="number"] {
            max-width: 300px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            overflow-x: auto;
            display: block;
        }

        table,
        th,
        td {
            border: 1px solid #dee2e6;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #e9ecef;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .form-group {
                flex-direction: column;
            }

            .form-group label,
            .form-group input,
            .form-group select {
                width: 100%;
                margin-right: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>New Transaction</h2>
        <form action="transaction_save.php" method="post">
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="customer">Kode:</label>
                <input list="customerList" id="customer" name="customer_id" oninput="updateCustomerInfo('kode')"
                    onchange="updateCustomerInfo('kode')">
                <datalist id="customerList">
                    <?php
                    include 'db_connection.php';
                    $sql = "SELECT id, kode, name, telp FROM m_customer";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["kode"] . "' data-id='" . $row["id"] . "' data-name='" . $row["name"] . "' data-telp='" . $row["telp"] . "'>" . $row["kode"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No customers available</option>";
                    }
                    ?>
                </datalist>
            </div>
            <div class="form-group">
                <label for="customer_name">Nama:</label>
                <input list="customerNameList" type="text" id="customer_name" name="customer_name"
                    oninput="updateCustomerInfo('name')" onchange="updateCustomerInfo('name')">
                <datalist id="customerNameList">
                    <?php
                    $result->data_seek(0);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["name"] . "' data-id='" . $row["id"] . "' data-kode='" . $row["kode"] . "' data-telp='" . $row["telp"] . "'>" . $row["name"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No customers available</option>";
                    }
                    ?>
                </datalist>
            </div>
            <div class="form-group">
                <label for="customer_telp">Telp:</label>
                <input list="customerTelpList" type="text" id="customer_telp" name="customer_telp"
                    oninput="updateCustomerInfo('telp')" onchange="updateCustomerInfo('telp')">
                <datalist id="customerTelpList">
                    <?php
                    $result->data_seek(0);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["telp"] . "' data-id='" . $row["id"] . "' data-kode='" . $row["kode"] . "' data-name='" . $row["name"] . "'>" . $row["telp"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No customers available</option>";
                    }
                    ?>
                </datalist>
            </div>
            <h3>Items</h3>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Harga Bandrol</th>
                            <th>Diskon (%)</th>
                            <th>Diskon (Rp)</th>
                            <th>Harga Diskon</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="items">
                        <tr>
                            <td>1</td>
                            <td>
                                <select name="item_id[]" required onchange="updateItemName(this)">
                                    <option value="">Pilih Kode</option>
                                    <?php
                                    $sql = "SELECT id, kode, nama, harga FROM m_barang";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row["id"] . "' data-nama='" . $row["nama"] . "' data-harga='" . $row["harga"] . "'>" . $row["kode"] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No items available</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td class="item-name">-</td>
                            <td><input type="number" name="quantity[]" min="1" required oninput="calculateTotal(this)">
                            </td>
                            <td><input type="number" name="price[]" min="0" required oninput="calculateTotal(this)"
                                    readonly>
                            </td>
                            <td><input type="number" name="discount[]" min="0" max="100" oninput="calculateTotal(this)">
                            </td>
                            <td class="discount-rp">0</td>
                            <td class="discount-price">0</td>
                            <td class="total-price">0</td>
                            <td><button type="button" onclick="removeRow(this)">Remove</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn" onclick="addItem()">Add Item</button>

            <div class="form-group text-right">
                <label for="subtotal">Sub Total:</label>
                <input type="number" id="subtotal" name="subtotal" readonly>
            </div>
            <div class="form-group text-right">
                <label for="total_discount">Diskon:</label>
                <input type="number" id="total_discount" name="total_discount" oninput="calculateGrandTotal()">
            </div>
            <div class="form-group text-right">
                <label for="shipping_cost">Ongkir:</label>
                <input type="number" id="shipping_cost" name="shipping_cost" min="0"
                    oninput="calculateGrandTotal()">
            </div>
            <div class="form-group text-right">
                <label for="total">Total Bayar:</label>
                <input type="number" id="total" name="total" readonly>
            </div>
            <div class="form-group text-center">
                <input type="submit" value="Simpan" class="btn">
            </div>
            <input type="hidden" id="customer_id" name="customer_id">
            <input type="hidden" id="js_subtotal" name="js_subtotal" value="">
            <input type="hidden" id="js_total_discount" name="js_total_discount" value="">
            <input type="hidden" id="js_total_bayar" name="js_total_bayar" value="">

        </form>
        <div class="form-group text-right">
            <a href="index.php">Batal</a>
        </div>
    </div>

    <script>
        function updateCustomerInfo(field) {
            var customerInput = document.getElementById('customer');
            var customerNameInput = document.getElementById('customer_name');
            var customerTelpInput = document.getElementById('customer_telp');
            var customerIdInput = document.getElementById('customer_id');
            var customerList, selectedOption;

            if (field === 'kode') {
                customerList = document.getElementById('customerList').options;
            } else if (field === 'name') {
                customerList = document.getElementById('customerNameList').options;
            } else if (field === 'telp') {
                customerList = document.getElementById('customerTelpList').options;
            }

            for (var i = 0; i < customerList.length; i++) {
                if (customerList[i].value === (field === 'kode' ? customerInput.value : (field === 'name' ? customerNameInput.value : customerTelpInput.value))) {
                    selectedOption = customerList[i];
                    break;
                }
            }

            if (selectedOption) {
                var customerId = selectedOption.getAttribute('data-id');
                var customerKode = selectedOption.getAttribute('data-kode');
                var customerName = selectedOption.getAttribute('data-name');
                var customerTelp = selectedOption.getAttribute('data-telp');

                if (field !== 'kode') {
                    customerInput.value = customerKode;
                }
                if (field !== 'name') {
                    customerNameInput.value = customerName;
                }
                if (field !== 'telp') {
                    customerTelpInput.value = customerTelp;
                }

                customerIdInput.value = customerId;
            }
        }


        function updateItemName(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var itemName = selectedOption.getAttribute('data-nama');
            var itemNameCell = selectElement.parentNode.nextElementSibling;
            itemNameCell.textContent = itemName;
        }

        function addItem() {
            const itemsTable = document.getElementById('items');
            const row = itemsTable.rows[0].cloneNode(true);
            row.querySelectorAll('input').forEach(input => input.value = '');
            row.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
            itemsTable.appendChild(row);
            updateRowNumbers();
        }

        function removeRow(button) {
            const row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
            calculateGrandTotal();
            updateRowNumbers();
        }

        function calculateTotal(input) {
            const row = input.parentNode.parentNode;
            const quantity = row.querySelector('input[name="quantity[]"]').value;
            const priceInput = row.querySelector('input[name="price[]"]');
            const select = row.querySelector('select[name="item_id[]"]');
            const selectedOption = select.options[select.selectedIndex];
            const itemPrice = parseFloat(selectedOption.getAttribute('data-harga')) || 0;

            const price = itemPrice * quantity;
            priceInput.value = price.toFixed(2);

            const discountPercent = row.querySelector('input[name="discount[]"]').value || 0;
            const discountRp = (price * (discountPercent / 100));
            const discountPrice = price - discountRp;

            const totalPrice = discountPrice;

            const discountRpCell = row.querySelector('.discount-rp');
            const discountPriceCell = row.querySelector('.discount-price');
            const totalPriceCell = row.querySelector('.total-price');

            if (discountRpCell) discountRpCell.textContent = discountRp.toFixed(2);
            if (discountPriceCell) discountPriceCell.textContent = discountPrice.toFixed(2);
            if (totalPriceCell) totalPriceCell.textContent = totalPrice.toFixed(2);

            console.log(`Item Price: ${itemPrice}, Quantity: ${quantity}, Discount: ${discountPercent}`);
            console.log(`Discount Amount: ${discountRp.toFixed(2)}, Price After Discount: ${discountPrice.toFixed(2)}`);

            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let grandTotal = 0;
            let subtotal = 0;

            const rows = document.querySelectorAll('#items tr');
            rows.forEach(row => {
                const totalPriceCell = row.querySelector('.total-price');
                if (totalPriceCell) {
                    const totalPrice = parseFloat(totalPriceCell.textContent) || 0;
                    subtotal += totalPrice;
                }
            });

            const totalDiscount = parseFloat(document.getElementById('total_discount').value) || 0;
            const shippingCost = parseFloat(document.getElementById('shipping_cost').value) || 0;

            grandTotal = subtotal - totalDiscount + shippingCost;

            document.getElementById('total').value = grandTotal.toFixed(2);
            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('js_subtotal').value = subtotal.toFixed(2);
            document.getElementById('js_total_discount').value = totalDiscount.toFixed(2);
            document.getElementById('js_total_bayar').value = grandTotal.toFixed(2);

            console.log(`Subtotal: ${subtotal.toFixed(2)}, Total Discount: ${totalDiscount.toFixed(2)}, Grand Total: ${grandTotal.toFixed(2)}`);
        }


        function updateRowNumbers() {
            const rows = document.querySelectorAll('#items tr');
            rows.forEach((row, index) => {
                row.cells[0].textContent = index + 1;
            });
        }
    </script>

</body>

</html>
