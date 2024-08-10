<?php
include 'config.php';
// connecting to database
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/login.css"> <!-- Optional: You can customize this -->
    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>

</head>
   <h1 class="logintitle">Shopsey Login Page</h1>
    <div class="container">
        
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="login-side p-4 border rounded shadow">
            <h2 class="text-center mb-4">Sign In</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="submitdetails" class="btn btn-primary btn-block">Log In</button>
            </form>
        </div>
    </div>
    <form action="" method="post">
        <p>
            Don't Have an account
        </p>
        <button type="submit" name="signin" style="padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #4CAF50;
    color: white;
    font-size: 16px;
    cursor: pointer;">Sign In</button>
    </form>

        <!-- handling request -->
         
            <?php
            if (isset($_POST['signin'])) {
                header("Location: signup.php");
                exit(); // Ensure no further code is executed after redirect
            }

            if (isset($_POST['submitdetails'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
            
                if (empty($username) || empty($password)) {
                    echo "<script>
                            swal({
                                title: 'Fill all the fields',
                                icon: 'error',
                            });
                          </script>";

                } else {
                    // SQL query to check user credentials
                    $sql = "SELECT * FROM login WHERE username ='$username' AND PASSWORD = '$password'";
                    $result = mysqli_query($conn, $sql);
                    
                    if ($result->num_rows > 0) {
                            $_SESSION['username'] = $username;
                              header("Location: home.php");
                              exit();
                    }
                     else {

                        $newquery = "SELECT * FROM LOGIN WHERE username ='$username'";
                        $newr = mysqli_query($conn,$newquery);
                        // if username exist but password is incorrect
                        if($newr->num_rows > 0)
                        {
                            echo "<script>
                                swal({
                                    title: 'Incorrect Password',
                                    icon: 'error',});
                              </script>";
                        }
                        else
                        {

                            echo "<script>
                            swal({
                                title: 'Username Does Not Exists',
                                icon: 'error',});
                                </script>";
                                }
                    }

                }
            }
            ?>

</body>
 <!-- Include SweetAlert library -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>
</html>
