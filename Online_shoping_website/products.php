<?php
session_start();
require 'db_connection.php';
require 'check_if_added.php';
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        .container{
            text-align: center;
        }
    </style>
    <link rel="shortcut icon" href="img/homepage.jpg" />
    <title>Website of a Store</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <div>
        <?php require 'header.php'; ?>
        <div class="container">
            <div class="jumbotron">
                <h1>Welcome to our Store</h1>
                <p>We have the best cameras, watches, laptops, phones, and headphones for you. No need to hunt around,
                    we have all in one place.</p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <?php
                // Default number of records per page
                $records_per_page = 8;
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
                $offset = ($page - 1) * $records_per_page;

                // Check if search query is set
                $searchQuery = isset($_POST['query']) ? $_POST['query'] : (isset($_GET['query']) ? $_GET['query'] : '');

                if (!empty($searchQuery)) {
                    // Sanitize user input
                    $searchQuery = $conn->real_escape_string($searchQuery);
                    // SQL query to search in the products table
                    $sql = "SELECT * FROM products WHERE pname LIKE '%$searchQuery%' LIMIT $offset, $records_per_page";
                    $count_sql = "SELECT COUNT(*) AS total FROM products WHERE pname LIKE '%$searchQuery%'";
                } else {
                    // Fetch products for the current page
                    $sql = "SELECT * FROM products LIMIT $offset, $records_per_page";
                    $count_sql = "SELECT COUNT(*) AS total FROM products";
                }

                $result = $conn->query($sql);
                $count_result = $conn->query($count_sql);
                $row_count = $count_result->fetch_assoc();
                $total_records = $row_count['total'];
                $total_pages = ceil($total_records / $records_per_page);

                // Display products
                if ($result->num_rows > 0) {
                    echo "<div class='container'>";
                    echo "<div class='row'>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='col-md-3 col-sm-6'>";
                        echo "<div class='thumbnail'>";
                        echo "<a href='card.php'>";
                        echo "<img src='" . $row['image'] . "' alt='" . $row['pname'] . "'>";
                        echo "</a>";
                        echo "<center>";
                        echo "<div class='caption'>";
                        echo "<h3>" . $row['pname'] . "</h3>";
                        echo "<p>Price: Rs. " . $row['price'] . "</p>";
                        echo "<p><a href='" . (isset($_SESSION['email']) ? 'buy_now.php?id=' . $row['id'] : 'log_in.php') . "' role='button' class='btn btn-primary btn-block'>Buy Now</a></p>";
                        if (isset($_SESSION['email'])) {
                            if (check_if_added_to_cart($row['id'])) {
                                echo "<a href='#' class='btn btn-block btn-success disabled'>Added to cart</a>";
                            } else {
                                echo "<a href='cart_added.php?id=" . $row['id'] . "' class='btn btn-block btn-primary'>Add to cart</a>";
                            }
                        } else {
                            echo "<a href='log_in.php' role='button' class='btn btn-primary btn-block'>Add to cart</a>";
                        }
                        echo "</div>";
                        echo "</center>";
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "</div>";

                    // Pagination links
                    echo "<div class='container'>";
                    echo "<div class='row'>";
                    echo "<div class='col-md-12'>";
                    echo "<ul class='pagination'>";

                    if ($page > 1) {
                        echo "<li class='page-item'><a class='page-link' href='products.php?page=" . ($page - 1) . ($searchQuery ? "&query=" . $searchQuery : "") . "'>Previous</a></li>";
                    }

                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='products.php?page=$i" . ($searchQuery ? "&query=" . $searchQuery : "") . "'>$i</a></li>";
                    }

                    if ($page < $total_pages) {
                        echo "<li class='page-item'><a class='page-link' href='products.php?page=" . ($page + 1) . ($searchQuery ? "&query=" . $searchQuery : "") . "'>Next</a></li>";
                    }

                    echo "</ul>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "<div class='container'>";
                    echo "<div class='row'>";
                    echo "<div class='col-md-12'>";
                    echo "<h4>No products found</h4>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }

                $conn->close();
                ?>
            </div>
        </div>
        <br><br><br><br><br><br><br><br>
        <footer class="footer">
            <div class="container">
                <center>
                    <p>Copyright &copy; All Rights Reserved.</p>
                    <p>This website is developed by Kalyan Dey</p>
                </center>
            </div>
        </footer>
    </div>
</body>

</html>
