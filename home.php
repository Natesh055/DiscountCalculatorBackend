<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$today_date = date("Y-m-d");

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['add'])) {
//         $itemname = mysqli_real_escape_string($conn, $_POST['itemname']);
//         $qty = (int)$_POST['qty'];
//         $orprice = (float)$_POST['orprice'];
//         $tprice = (float)$_POST['tprice'];

//         $sql = "INSERT INTO ITEMS (itemname, quantity, original_price, discounted_price, date_added, username) 
//                 VALUES ('$itemname', $qty, $orprice, $tprice, '$today_date', '$username')";
//         if (mysqli_query($conn, $sql)) {
//             echo '<div class="alert alert-success">Item added successfully.</div>';
//         } else {
//             echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
//         }
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Items - Shopsey</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/home.css">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Add Items for Today's Shopping</h1>
        <form method="post">
            <div class="form-group">
                <label for="itemname">Item Name</label>
                <input type="text" name="itemname" class="form-control" id="itemname" placeholder="Enter item" required>
            </div>
            <div class="form-group">
                <label for="qty">Enter Quantity</label>
                <input type="number" name="qty" class="form-control" id="qty" required>
            </div>
            <div class="form-group">
                <label for="orprice">Enter Original Price</label>
                <input type="number" step="0.01" name="orprice" class="form-control" id="orprice" required>
            </div>
            <div class="form-group">
                <label for="tprice">Enter Price You Got</label>
                <input type="number" step="0.01" name="tprice" class="form-control" id="tprice" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add">Add</button>
        </form>
            <?php
                if (isset($_POST['add'])) {
                    $itemname = mysqli_real_escape_string($conn, $_POST['itemname']);
                    $qty = (int)$_POST['qty'];
                    $orprice = (float)$_POST['orprice'];
                    $tprice = (float)$_POST['tprice'];

                    $sql = "INSERT INTO ITEMS (itemname, quantity, original_price, discounted_price, date_added, username) 
                            VALUES ('$itemname', $qty, $orprice, $tprice, '$today_date', '$username')";
                    if (mysqli_query($conn, $sql)) {
                        echo '<div class="alert alert-success">Item added successfully.</div>';
                    } else {
                        echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
                    }
                }
            ?>
        <?php
        $sql = "SELECT * FROM ITEMS WHERE date_added = '$today_date' AND username = '$username'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered mt-4">';
            echo '<thead><tr><th>Item Name</th><th>Quantity</th><th>Original Price</th><th>Discounted Price</th><th>Price Difference</th><th>Discount Percentage</th></tr></thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_assoc($result)) {
                $original_price = (float) $row['original_price'];
                $discounted_price = (float) $row['discounted_price'];

                $price_difference = $original_price - $discounted_price;
                $percentage_discount = ($price_difference / $original_price) * 100;

                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['itemname']) . '</td>';
                echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
                echo '<td>$' . number_format($original_price, 2) . '</td>';
                echo '<td>$' . number_format($discounted_price, 2) . '</td>';
                echo '<td>$' . number_format($price_difference, 2) . '</td>';
                echo '<td>' . number_format($percentage_discount, 2) . '%</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div class="alert alert-info mt-4">No items found for today.</div>';
        }
        ?>

    </div>

    <div class="flist">
    <form action="" method = "post">
        <button type="submit" name="vlist">View Full List</button>
    </form>
</div>

<?php
if(isset($_POST['vlist']))
{
    $_SESSION['username'] = $username;
    header("Location: display.php");
}
?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>