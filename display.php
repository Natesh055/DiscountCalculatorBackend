<?php

include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not, redirect to the login page
    header("Location: login.php");
    exit();
}

// Proceed with the rest of your code here
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/disp.css">

    <title>Display List</title>
    
</head>
<body>

<h1>Today's Items</h1>

<?php
$today_date = date("Y-m-d"); // Get today's date
$sql = "SELECT * FROM ITEMS WHERE date_added = '$today_date' AND username = '$username'";
$result = mysqli_query($conn, $sql);

// Initialize totals
$tsum = 0; // Total original price
$dsum = 0; // Total discounted price

if ($result && mysqli_num_rows($result) > 0) {
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Item Name</th>';
    echo '<th>Quantity</th>';
    echo '<th>Original Price</th>';
    echo '<th>Discounted Price</th>';
    echo '<th>Price Difference</th>';
    echo '<th>Discount Percentage</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        $original_price = (float) $row['original_price']; // Convert to float for calculation
        $discounted_price = (float) $row['discounted_price']; // Convert to float for calculation

        // Update totals
        $tsum += $original_price;
        $dsum += $discounted_price;

        // Calculate price difference and discount percentage
        $price_difference = $original_price - $discounted_price;
        $percentage_discount = ($price_difference / $original_price) * 100; // Calculate percentage discount

        // Display item details
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['itemname']) . '</td>';
        echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
        echo '<td>$' . number_format($original_price, 2) . '</td>';
        echo '<td>$' . number_format($discounted_price, 2) . '</td>';
        echo '<td>$' . number_format($price_difference, 2) . '</td>';
        echo '<td>' . number_format($percentage_discount, 2) . '%</td>';
        echo '</tr>';
    }

    // Display total discount
    $total_discount = $tsum - $dsum;
    echo '</tbody>';
    echo '<tfoot>';
    echo '<tr class="total">';
    echo '<td colspan="5">Total Discount:</td>';
    echo '<td>$' . number_format($total_discount, 2) . '</td>';
    echo '</tr>';
    echo '</tfoot>';
    echo '</table>';
} else {
    echo '<p>No items found for today.</p>';
}


?>

</body>
</html>
