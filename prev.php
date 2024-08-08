<?php
include 'config.php';
session_start();

$username = $_SESSION['username'];

if (!$username) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/prev.css">
    <link rel="stylesheet" href="CSS/logout.css">

    <title>View Previous Purchases</title>
</head>
<body>
    <div class="logout-container">
    <form action="" method="post">
        <button type="submit" name="logout">Logout</button>
    </form>
</div>
    <h1>View Previous Purchases</h1>
    <?php


if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$a = $_SESSION['username'];

$sql = "SELECT DISTINCT(date_added) FROM items WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if ($result && $result->num_rows > 0) {
    echo '<ul>';
    while ($row = mysqli_fetch_assoc($result)) {
        $date_added = htmlspecialchars($row['date_added']); // Sanitize the date for output
        echo '<li><a href="fhist.php?id=' . urlencode($date_added) . '&username=' . urlencode($a) . '">
                <button class="btn btn-danger">' . $date_added . '</button>
            </a></li>';              
    }
    echo '</ul>';
} else {
    echo '<p>No dates found.</p>';
}

if (isset($_POST[$mydate])) {
    $_SESSION['date_added'] = $_POST[$mydate];
    header("Location: fhist.php");
    exit();
}

// Close the connection (if needed)
// mysqli_close($conn);
?>

</body>
</html>
