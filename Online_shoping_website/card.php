<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'db_connection.php';

if (!isset($_SESSION['email'])) {
    header('location: login.php');
    exit();
}

$user_id = $_SESSION['id'];
$records_per_page = 5; // Number of products per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number, default to 1
$offset = ($page - 1) * $records_per_page; // Calculate offset for SQL query

$user_products_query = "SELECT it.id, it.pname, it.price, it.image FROM user_products ut INNER JOIN products it ON it.id = ut.products_id WHERE ut.user_id = ? LIMIT ?, ?";
$stmt = $conn->prepare($user_products_query);
$stmt->bind_param("iii", $user_id, $offset, $records_per_page);
$stmt->execute();
$user_products_result = $stmt->get_result();
$no_of_user_products = $user_products_result->num_rows;
$sum = 0;

if ($no_of_user_products == 0) {
    echo '<script>window.alert("No items in the cart!!");</script>';
}

$total_query = "SELECT COUNT(*) AS total FROM user_products WHERE user_id = ?";
$total_stmt = $conn->prepare($total_query);
$total_stmt->bind_param("i", $user_id);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $records_per_page);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="img/homepage.jpg" />
    <title>Projectworlds Store</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        /* Ensure the pagination is centered within its container */
        .pagination-container {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div>
        <?php require 'header.php'; ?>
        <br>
        <div class="container">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>Item Number</th>
                        <th>Image</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                    <?php
                    $counter = 1 + $offset;
                    while ($row = $user_products_result->fetch_assoc()) {
                        $sum += $row['price'];
                    ?>
                    <tr>
                        <th><?php echo $counter; ?></th>
                        <td><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['pname']); ?>" class="img-thumbnail" width="100"></td>
                        <th><?php echo htmlspecialchars($row['pname']); ?></th>
                        <th><?php echo $row['price']; ?></th>
                        <th><button class="btn btn-danger remove" onclick="handleRemove(<?php echo $row['id']; ?>)">Remove</button></th>
                    </tr>
                    <?php
                        $counter++;
                    }
                    ?>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Total</th>
                        <th>Rs <?php echo $sum; ?>/-</th>
                        <th><a href="confirm_order.php?id=<?php echo $user_id; ?>" class="btn btn-primary">Confirm Order</a></th>
                    </tr>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="pagination-container">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page-1; ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php endfor; ?>
                    <?php if($page < $total_pages): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page+1; ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            </div>
        </div>
        <br><br><br><br><br><br>
        <footer class="footer">
            <div class="container">
                <center>
                    <p>Copyright &copy; Store. All Rights Reserved.</p>
                    <p>This website is developed by Kalyan Dey</p>
                </center>
            </div>
        </footer>
    </div>
</body>
</html>
<script>
function handleRemove(itemId) {
    if (confirm("Are you sure you want to delete this item?")) {
        $.ajax({
            url: 'cart_remove.php',
            type: 'GET',
            data: { id: itemId },
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                alert("An error occurred while removing the item.");
                console.error(error);
            }
        });
    }
}
</script>
