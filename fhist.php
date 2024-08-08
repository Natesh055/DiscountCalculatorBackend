<?php
include 'config.php';
session_start();

if (!isset($_GET['id']) || !isset($_GET['username'])) {
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_GET['username']); // Sanitize the username
$date_added = htmlspecialchars($_GET['id']); // Sanitize the date

// Check if the username from the URL matches the session username
if ($username !== $_SESSION['username']) {
    echo 'Invalid access.';
    exit();
}

// Query to get the items for the given date and username
$sql = "SELECT * FROM items WHERE username = '$username' AND date_added = '$date_added'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/disp.css">
    <link rel="stylesheet" href="CSS/logout.css">

    <title>Display List</title>

    <style>
        .logout-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>

<div class="logout-container">
    <form action="" method="post">
        <button type="submit" name="logout">Logout</button>
    </form>
</div>
    <h1>Items Purchased on <?php echo htmlspecialchars($date_added); ?></h1>

    <?php
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: login.php");
        exit();
    }
    if ($result && mysqli_num_rows($result) > 0) {
        $tsum = 0; // Total original price
        $dsum = 0; // Total discounted price

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
            $original_price = (float) $row['original_price'];
            $discounted_price = (float) $row['discounted_price'];

            // Update totals
            $tsum += $original_price;
            $dsum += $discounted_price;

            $price_difference = $original_price - $discounted_price;
            $percentage_discount = ($price_difference / $original_price) * 100;

            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['itemname']) . '</td>';
            echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
            echo '<td>INR ' . number_format($original_price, 2) . '</td>';
            echo '<td>INR ' . number_format($discounted_price, 2) . '</td>';
            echo '<td>INR ' . number_format($price_difference, 2) . '</td>';
            echo '<td>' . number_format($percentage_discount, 2) . '%</td>';
            echo '</tr>';
        }

        $total_discount = $tsum - $dsum;
        $total_discount_percentage = ($total_discount / $tsum) * 100;

        echo '</tbody>';
        echo '<tfoot>';
        echo '<tr class="total">';
        echo '<td colspan="4">Total Discount:</td>';
        echo '<td>INR ' . number_format($total_discount, 2) . '</td>';
        echo '<td>' . number_format($total_discount_percentage, 2) . '%</td>';
        echo '</tr>';
        echo '</tfoot>';
        echo '</table>';
    } else {
        echo '<p>No items found for this date.</p>';
    }

    // Close the database connection
    // mysqli_close($conn);
    ?>
</body>
</html>
