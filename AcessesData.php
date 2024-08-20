<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-around;
        }

        .dashboard {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        .shortage {
            background-color: #e74c3c;
            color: white;
        }

        .expiry-alert {
            background-color: #ffcc00;
            color: white;
        }

        h2 {
            color: #333;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
        <form style="position: absolute; top: 20px; right: 30px;" method="post" action="Login.html">
            <button type="submit" style="background-color:black ; color: red; padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer;">Logout</button>
        </form>

    <div class="dashboard">
        <?php
        // Establish a connection to the database
        $conn = new mysqli('localhost:3306', 'root', '', 'products');

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch all products from the database
        $productResult = $conn->query("SELECT * FROM product");
        $shortageResult = $conn->query("SELECT * FROM product WHERE Quantity < 20");

        // Display list of all products
        echo "<h2>List of All Products</h2>";
        if ($productResult->num_rows > 0) {
            echo "<table><tr><th>Product_Name</th><th>Price</th><th>Quantity</th><th>Expiry_Date</th></tr>";

            while ($row = $productResult->fetch_assoc()) {
                $productName = $row["Product_Name"];
                $price = $row["Price"];
                $quantity = $row["Quantity"];
                $expiryDate = $row["Expiry_Date"];

                echo "<tr><td>$productName</td><td>$price</td><td>$quantity</td><td>$expiryDate</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No products found.</p>";
        }

        // Reset the internal pointer to the beginning
        $productResult->data_seek(0);

        // Display list of products with shortage
        echo "<h2>List of Products with Shortage (Quantity < 20)</h2>";
        if ($shortageResult->num_rows > 0) {
            echo "<table><tr><th>Product_Name</th><th>Price</th><th>Quantity</th><th>Expiry_Date</th></tr>";

            while ($row = $shortageResult->fetch_assoc()) {
                $productName = $row["Product_Name"];
                $price = $row["Price"];
                $quantity = $row["Quantity"];
                $expiryDate = $row["Expiry_Date"];

                echo "<tr class='shortage'><td>$productName</td><td>$price</td><td>$quantity</td><td>$expiryDate</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No products with shortage found.</p>";
        }

        // Reset the internal pointer to the beginning
        $productResult->data_seek(0);

        // Display list of expiry products
        echo "<h2>List of Expiry Products</h2>";
        echo "<table><tr><th>Product_Name</th><th>Price</th><th>Quantity</th><th>Expiry_Date</th></tr>";
        while ($row = $productResult->fetch_assoc()) {
                $productName = $row["Product_Name"];
                $price = $row["Price"];
                $quantity = $row["Quantity"];
                $expiryDate = $row["Expiry_Date"];

                // Check if the product is about to expire (e.g., within the next 30 days)
                $expiryTimestamp = strtotime($expiryDate);
                $currentTimestamp = time();
                $daysUntilExpiry = floor(($expiryTimestamp - $currentTimestamp) / (60 * 60 * 24));

                // Display a warning for products about to expire
                $expiryClass = ($daysUntilExpiry <= 30) ? 'expiry-alert' : '';
            
             echo "<tr class='$expiryClass'><td>$productName</td><td>$price</td><td>$quantity</td><td>$expiryDate</td></tr>";
            }

            echo "</table>";
            echo "</form>";     
        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
