<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup']) && $_POST['signup'] == 1) {
    // Escape user inputs for security
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists
    $emailquery = "SELECT * FROM `users` WHERE email='$email'";
    $query = mysqli_query($conn, $emailquery);

    $email_count = mysqli_num_rows($query);

    if ($email_count > 0) {
        echo 'Email already exists';
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, contact, city, address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $hashed_password, $contact, $city, $address);

        // Execute the statement
        if ($stmt->execute()) {
            echo 'Registration successful!';
        } else {
            echo 'Error: ' . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
    die;
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="shortcut icon" href="img/homepage.jpg" />
    <title>Website of a Store</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <!-- jQuery library -->
    <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <!-- External CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <div>
        <?php
        require 'header.php';
        ?>
        <br><br>
        <div class="container">
            <div class="row">
                <div class="col-xs-4 col-xs-offset-4">
                    <h1><b>SIGN UP</b></h1>
                    <form id="signupForm">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" placeholder="Name" required="true">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" required="true"
                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password"
                                placeholder="Password (min. 6 characters)" required="true" pattern=".{6,}">
                        </div>
                        <div class="form-group">
                            <input type="tel" class="form-control" name="contact" placeholder="Contact" required="true">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="city" placeholder="City" required="true">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="address" placeholder="Address"
                                required="true">
                        </div>
                        <div class="form-group">
                            <input type="button" class="btn btn-primary" value="Sign Up" onclick="sign_in()">
                        </div>
                    </form>
                    <div class="panel-footer">If you have an account, please <a href="log_in.php">Log in</a></div>
                </div>
            </div>
        </div>
        <br><br><br><br><br><br>
        <footer class="footer">
            <div class="container">
                <center>
                    <p>Copyright &copy; All Rights Reserved.</p>
                    <p>This website is developed by Kalyan Dey</p>
                </center>
            </div>
        </footer>
    </div>

    <script>
        function sign_in() {
            var formData = new FormData($("#signupForm")[0]);
            formData.append('signup', 1);

            $.ajax({
                url: location.href,
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response);
                    if (response === 'Registration successful!') {
                        window.location.href = 'index.php';
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
