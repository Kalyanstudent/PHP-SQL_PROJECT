<?php
session_start();

?>
<!DOCTYPE html>
<html>

<head>

    <head>

        <link rel="shortcut icon" href="img/homepage.jpg" />
        <title>website of a store</title>
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
</head>

<body>
    <div>
        <?php
        require 'header.php';
        ?>
        <div id="bannerImage">
            <div class="container">
                <center>
                    <div id="bannerContent">
                        <h1>sell sell sell</h1>
                        <p>Flat 40% off on all premium brands</p>
                        <a href="products.php" class="btn btn-danger">Shop Now</a>
                    </div>
                </center>
            </div>
        </div>
        <div id="content" class="container">
            <!-- Products will be loaded here -->
        </div>


        <div class="container">
            <div class="row">
                <div class="col-xs-4">
                    <div class="thumbnail">
                        <a href="various_product.php?p_id=1">
                            <img src="img/camera.jpg" alt="Camera" >
                        </a>
                        <center>
                            <div class="caption">
                                <p id="autoResize">Cameras</p>
                                <p>Choose among the best available in the world.</p>
                            </div>
                        </center>

                    </div>

                </div>
                <div class="col-xs-4">
                    <div class="thumbnail">
                        <a href="various_product.php?p_id=2">
                            <img src="img\watch.jpg" alt="Watch" >
                        </a>
                        <center>
                            <div class="caption">
                                <p id="autoResize">Watches</p>
                                <p>Choose among the best available in the world.</p>
                            </div>
                        </center>

                    </div>

                </div>

                <div class="col-xs-4">
                    <div class="thumbnail">
                        <a href="various_product.php?p_id=3">
                            <img src="img/laptop.jpg" alt="Laptop" >
                        </a>
                        <center>
                            <div class="caption">
                                <p id="autoResize">Laptops</p>
                                <p>Choose among the best available in the world.</p>
                            </div>
                        </center>

                    </div>

                </div>
                <div class="col-xs-4">
                    <div class="thumbnail">
                        <a href="various_product.php?p_id=4">
                            <img src="img/phone.jpg" alt="phone" >
                        </a>
                        <center>
                            <div class="caption">
                                <p id="autoResize">phones</p>
                                <p>Choose among the best available in the world.</p>
                            </div>
                        </center>

                    </div>

                </div>
                <div class="col-xs-4">
                    <div class="thumbnail">
                        <a href="various_product.php?p_id=5">
                            <img src="img/headphone.jpg" alt="headphone" >
                        </a>
                        <center>
                            <div class="caption">
                                <p id="autoResize">headphones</p>
                                <p>Choose among the best available in the world.</p>
                            </div>
                        </center>

                    </div>

                </div>
            </div>

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
<!-- <script type="text/javascript">
function redirectToProduct(p_id) {
    $.ajax({
        url: 'various_product.php',
        type: 'GET',
        data: { p_id: p_id },
        success: function(response) {
            $('#content').html(response);
        },
        error: function() {
            alert('An error occurred while loading the products.');
        }
    });
}
</script> -->
