<?php
require 'db_connection.php';
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="shortcut icon" href="img/homepage.jpg" />
    <title>Projectworlds Store</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <nav class="navbar navbar-inverse navabar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="index.php" class="navbar-brand">Home</a>
            </div>

            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <form class="navbar-form" role="search" action="products.php" method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search" name="query">
                            </div>
                            <button type="submit" class="btn btn-default"><span
                                    class="glyphicon glyphicon-search"></span></button>
                        </form>
                    </li>
                    <?php
                    if (isset($_SESSION['email'])) {
                        ?>
                        <li><a href="card.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
                        <li><a href="#" onclick="confirmLogout()"><span class="glyphicon glyphicon-log-out"></span>
                                Logout</a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="sign_in.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                        <li><a href="log_in.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                        <?php
                    }
                    ?>
                    >
                    <?php
                    if (isset($_SESSION['email'])) {
                        $email = $_SESSION['email'];
                        $query = "SELECT name FROM users WHERE email='$email'";
                        $res = mysqli_query($conn, $query);
                        $user = mysqli_fetch_assoc($res);
                        $name = $user['name'];
                        ?>
                        <li><a data-toggle="tooltip" data-placement="right" title="<?php echo $name; ?>"><span
                                    class="glyphicon glyphicon-user"></span></a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        function confirmLogout() {
            if (confirm("Do you want to log out?")) {
                $.ajax({
                    url: 'log_out.php',
                    type: 'POST',
                    data: { logout: 'yes' },
                    success: function (response) {
                        if (response.trim() === 'success') {
                            window.location.href = 'index.php'; // Redirect to index.php after logout
                        } else {
                            alert('Logout failed. Please try again.');
                        }
                    }
                });
            } else {
                window.location.href = 'index.php'; // Redirect to index.php if user chooses not to logout
            }
        }
    </script>
</body>

</html>