<?php
ob_start();
session_start();
$connect = mysqli_connect (
    "db", # service name 
    "php_docker", # username
    "password", # password
    "php_docker" # db table
);

# Access table
if(isset($_SESSION['user_id'])) {
    $query_order_input = "SELECT * FROM orders WHERE ID = $user_id";
    $result_order_input = $connect->query($query_order_input); // Connect to table

    if ($result_order_input) {
        // Check if any row is returned
        if ($result_order_input->num_rows > 0) {
            $row_orders = $result_order_input->fetch_assoc(); // Fetch from table

            $serviceType = $row_orders['serviceType'];
            $paperSize = $row_orders['paperSize'];
            $paperType = $row_orders['paperType'];
            $color = $row_orders['color'];
            $pageAmount = $row_orders['pageAmount'];
            $quantity = $row_orders['quantity'];
            $finish = $row_orders['finish'];
            $coverType = $row_orders['coverType'];
        } else {
            // No rows returned
            echo "No orders found for this user.";
        }
    } else {
        // Query failed
        echo "Error executing query: " . $connect->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>

    <link rel="stylesheet" href="../css/navigation-bar.css">
    <link rel="stylesheet" href="../css/orders-order.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/footer-bar.css">
    <link rel="stylesheet" href="../css/orders-nav-bar.css">
    <link rel="website icon" type="jpg"
    href="../image/logo.jpg">
</head>
<body>
    <div class="navigation-bar">
        <a href="./index.html">
            <img class="navigation-bar-img" src="../image/logo.jpg" alt="img">
        </a>

        <div class="navigation-bar-middle">
            <a class="navigation-bar-middle-sub" href="http:/html/about.html">About</a>
            <a class="navigation-bar-middle-sub" href="http:/html/services.html">Services</a>
            <a class="navigation-bar-middle-sub" href="http:/html/orders.html">Orders</a>
        </div>

        <div>
            <a href="sign-up.html">
                <button class="button-sign-up">Sign Up</button>
            </a>
        </div>
    </div>

    <br>
    <br>
    <br>
    <br>
    <main>
        <aside>
            <div>
                <a class="order-nav" href="./orders.html">Checkout</a>
                <a class="order-nav-select" href="./orders-orders.html">Orders</a>
                <a class="order-nav" href="http:/orders-profile.php">Profile</a>
                <div class="order-nav">Logout</div>
            </div>
        </aside>

        
        <table>
    <tr>
        <th>Order ID</th>
        <th>Print Type</th>
        <th>Paper Size</th>
        <th>Paper Type</th>
        <th>Color</th>
        <th>Number of Pages</th>
        <th>Quantity</th>
        <th>Finish</th>
        <th>Cover Type</th>
    </tr>
    <?php if(isset($serviceType)): ?>
    <tr>
        <td><?php echo $row_orders['ID']; ?></td>
        <td><?php echo $serviceType; ?></td>
        <td><?php echo $paperSize; ?></td>
        <td><?php echo $paperType; ?></td>
        <td><?php echo $color; ?></td>
        <td><?php echo $pageAmount; ?></td>
        <td><?php echo $quantity; ?></td>
        <td><?php echo $finish; ?></td>
        <td><?php echo $coverType; ?></td>
    </tr>
    <?php endif; ?>
</table>

        <!--footer-->
        <div class="footer-bar">
            <div class="footer-bar-con">
                <div class="footer-col">
                    <h3>Address</h3>
                    <p>46A Tandang Sora Avenue </p>
                    <p>Sangandaaan 2, Quezon City,</p>
                    <p>Philippines, 1116</p>
                </div>
                <div class="footer-col">                  
                    <h3>Contact Us</h3> 
                    <p>8252-0299 . 7791-1557</p>
                    <p>+63 - 0920 915 7875</p>
                    <p>avcprinting@yahoo.com</p>
                </div>         
                <div class="footer-col">
                    <h3>Follow Us</h3> 
                    <a class="follow-us" href="https://www.facebook.com/1AVCPrinting" class="link-modifier" target="blank">
                        Facebook
                    </a>
                </div>
                <div class="footer-col">
                    <h3>Our Services</h3> 
                    <p>Book</p>
                    <p>Yearbook</p>
                    <p>Journal</p>
                    <p>Magazine</p>
                    <p>Calendar</p>
                </div>
            </div>
        </div> 

    </main>
</body>