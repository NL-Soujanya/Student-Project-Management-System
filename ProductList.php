<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project List</title>
    <style>
        body {
            background-image: url('https://i.ytimg.com/vi/jLp8-F-ttGE/maxresdefault.jpg');
            background-size: 100% 100%;
            background-attachment: fixed;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #0d5521; /* Gray background for table header */
            color: white;
        }
        td {
            color: black;
        }
        tr:nth-child(even) {
            background-color: pink; /* Pink background for even rows */
        }
        tr:nth-child(odd) {
            background-color: Aqua; /* Aqua background for even rows */
        }
    </style>
</head>
<body>
    <form style="position: absolute; top: 20px; right: 30px;" method="post" action="Login.html">
                <button type="submit" style="background-color:black ; color: red; padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer;">Logout</button>
            </form>

    <h4>List of Products:</h4>

    <?php
    $conn = new mysqli('localhost:3306', 'root', '', 'products');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT * FROM product");

    if ($result->num_rows > 0) {
        echo "<table border='1'><tr><th>Product_Name</th><th>Price</th><th>Quantity</th><th>Expiry_Date</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["Product_Name"] . "</td><td>".$row["Price"] . "</td><td>" . $row["Quantity"] . "</td><td>".$row["Expiry_Date"] . "</td></tr><br>";
        }
        echo "</table>";
    } else {
        echo "No data found.";
    }

    $conn->close();  // Close the database connection
    ?>
</body>
</html>
