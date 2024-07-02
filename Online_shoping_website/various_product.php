<?php
session_start();
require 'db_connection.php';
require 'check_if_added.php';

// Pagination setup
$records_per_page = 8; // Number of products per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1; // Current page number, default to 1
$offset = ($page - 1) * $records_per_page; // Calculate offset for SQL query

// Ensure $p_id is an integer
$p_id = isset($_GET['p_id']) ? (int) $_GET['p_id'] : 0;

// Determine category based on $p_id
switch ($p_id) {
    case 1:
        $category = 'Camera';
        break;
    case 2:
        $category = 'Watch';
        break;
    case 3:
        $category = 'Laptop';
        break;
    case 4:
        $category = 'phone';
        break;
    case 5:
        $category = 'headphone';
        break;
    default:
        $category = ''; // All products
}
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        .container {
            text-align: center;
        }
    </style>
    <link rel="shortcut icon" href="img/homepage.jpg" />
    <title>Website of a Store</title>
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
            if ($category != '') {
                // Query to retrieve products based on category with pagination
                $sql = "SELECT * FROM `products` WHERE p_category = '$category' LIMIT $offset, $records_per_page";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    // Display products
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="thumbnail">
                                <a href="card.php">
                                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['pname']; ?>">
                                </a>
                                <center>
                                    <div class="caption">
                                        <h3><?php echo $row['pname']; ?></h3>
                                        <p>Price: Rs. <?php echo $row['price']; ?></p>
                                        <p>
                                            <a href="<?php echo isset($_SESSION['email']) ? 'buy_now.php?id=' . $row['id'] : 'log_in.php'; ?>"
                                                role="button" class="btn btn-primary btn-block">Buy Now</a>
                                        </p>
                                        <?php
                                        if (isset($_SESSION['email'])) {
                                            if (check_if_added_to_cart($row['id'])) {
                                                ?>
                                                <a href="#" class="btn btn-block btn-success disabled">Added to cart</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="cart_added.php?id=<?php echo $row['id']; ?>" class="btn btn-block btn-primary">Add
                                                    to cart</a>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <a href="log_in.php" role="button" class="btn btn-primary btn-block">Add to cart</a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </center>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    // No products found
                    ?>
                    <div class="col-md-12">
                        <h4>No products found</h4>
                    </div>
                    <?php
                }

                // Pagination links
                $sql_count = "SELECT COUNT(*) AS total FROM `products` WHERE p_category = '$category'";
                $count_result = mysqli_query($conn, $sql_count);
                $row_count = mysqli_fetch_assoc($count_result);
                $total_records = $row_count['total'];
                $total_pages = ceil($total_records / $records_per_page);
                ?>
                <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                        <?php
                        if ($page > 1) {
                            ?>
                            <li class="page-item"><a class="page-link"
                                    href="various_product.php?page=<?php echo $page - 1; ?>&p_id=<?php echo $p_id; ?>">Previous</a>
                            </li>
                            <?php
                        }
                        for ($i = 1; $i <= $total_pages; $i++) {
                            ?>
                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>"><a class="page-link"
                                    href="various_product.php?page=<?php echo $i; ?>&p_id=<?php echo $p_id; ?>"><?php echo $i; ?></a>
                            </li>
                            <?php
                        }
                        if ($page < $total_pages) {
                            ?>
                            <li class="page-item"><a class="page-link"
                                    href="various_product.php?page=<?php echo $page + 1; ?>&p_id=<?php echo $p_id; ?>">Next</a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <?php
            } else {
                // No valid category selected
                ?>
                <div class="col-md-12">
                    <h4>No valid category selected</h4>
                </div>
                <?php
            }
            ?>
        </div>
        <br><br> <br><br><br><br>
        <footer class="footer">
            <div class="container">
                <center>
                    <p>Copyright &copy. All Rights Reserved.</p>
                    <p>This website is developed by Kalyan Dey</p>
                </center>
            </div>
        </footer>
    </div>

</body>

</html>