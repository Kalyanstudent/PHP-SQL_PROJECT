<?php
session_start();
require 'db_connection.php';

$response = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['log_in']) && $_POST['log_in'] == 1) {
    // Escape user inputs for security
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the email exists
    $email_search = "SELECT * FROM `users` WHERE email='$email'";
    $query = mysqli_query($conn, $email_search);
    $email_count = mysqli_num_rows($query);

    if ($email_count > 0) {
        $user = mysqli_fetch_assoc($query);
        $hashed_password = $user['password'];

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $user['id'];
            $response = 'Login successful!';
        } else {
            $response = 'Incorrect password.';
        }
    } else {
        $response = 'Email does not exist.';
    }

    // Close the connection
    $conn->close();
    echo $response;
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="img/homepage.jpg" />
    <title>Projectworlds Store</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <!-- jquery library -->
    <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified javascript -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <!-- External CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
    <div>
        <?php require 'header.php'; ?>
        <br><br><br>
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3>LOGIN</h3>
                        </div>
                        <div class="panel-body">
                            <p>Login to make a purchase.</p>
                            <form id="loginForm">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Password(min. 6 characters)" required>
                                </div>
                                <div class="form-group">
                                    <input type="button" value="Login" class="btn btn-primary" onclick="submitLoginForm()">
                                </div>
                            </form>
                        </div>
                        <div class="panel-footer">Don't have an account yet? <a href="sign_in.php">Register</a></div>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br><br><br>
        <footer class="footer">
            <div class="container">
                <center>
                    <p>Copyright &copy. All Rights Reserved.</p>
                    <p>This website is developed by Kalyan Dey</p>
                </center>
            </div>
        </footer>
    </div>

    <script>
        function submitLoginForm() {
            var formData = new FormData($("#loginForm")[0]);
            formData.append('log_in', 1);

            $.ajax({
                url: location.href,
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response);
                    if (response.trim() === 'Login successful!') { // Use trim to avoid any white space issues
                        window.location.href = 'index.php';  // Redirect to the main page after successful login
                    }
                },
                error: function() {
                    alert('There was an error processing your request.');
                }
            });
        }
    </script>
</body>
</html>
