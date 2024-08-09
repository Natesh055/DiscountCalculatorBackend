<?php
include 'config.php';
session_start();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/signup.css">
    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <h1 class="logintitle">Shopsey</h1>
    <div class="container">
        <div class="login-side">
            <form method="post" action="">
                <h2>Signup</h2>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="cpassword">Confirm Password:</label>
                <input type="password" id="cpassword" name="cpassword" required>
                <button type="submit" name="sub">Submit</button>

                <?php
                if (isset($_POST['sub'])) {
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $cpassword = $_POST['cpassword'];

                    if (empty($username) || empty($email) || empty($password) || empty($cpassword)) {
                        echo "<script>
                        swal({
                            title: 'Fill the proper details',
                            icon: 'error',
                        });
                        </script>";
                    } elseif ($password != $cpassword) {
                        echo "<script>
                        swal({
                            title: 'Passwords do not match',
                            icon: 'error',
                        });
                        </script>";
                    } else {
                        $sql = "SELECT * FROM login WHERE username = '$username'";
                        $result = mysqli_query($conn, $sql);
                        if ($result->num_rows > 0) {
                            echo "<script>
                            swal({
                                title: 'User already exists',
                                icon: 'error',
                            });
                            </script>";
                           
                        } else {
                            $sql = "INSERT INTO login (username, email, password) VALUES ('$username', '$email', '$password')";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                echo "<script>
                                swal({
                                    title: 'Registration Successful',
                                    icon: 'success',
                                }).then(function() {
                                    window.location.href = 'login.php';
                                });
                                </script>";
                                
                                $_SESSION['username'] = $username;
                                // Clear variables after setting session
                                $username = "";
                                $email = "";
                                $password = "";
                                $cpassword = "";
                                exit();
                            } else {
                                echo "<script>
                                swal({
                                    title: 'Registration Failed',
                                    icon: 'error',
                                });
                                </script>";
                            }
                        }
                    }
                }
                ?>
            </form>
        </div>
    </div>
</body>

</html>
