<?php
    ob_start();
    session_start();
    $connect = mysqli_connect(
        "db", // service name 
        "php_docker", // username
        "password", // password
        "php_docker" // db table
    );

    // Check if user is logged in
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Fetch user email
        $query_account = "SELECT email FROM account WHERE ID = $user_id";
        $result_account = $connect->query($query_account);

        if ($result_account) {
            if ($result_account->num_rows > 0) {
                $row_account = $result_account->fetch_assoc();
                $email = $row_account['email'];
            } else {
                echo "No email found for this user.";
            }
        } else {
            echo "Error executing query to fetch user email: " . $connect->error;
        }   

        // Fetch orders for the logged-in user
        $query_order_input = "SELECT o.*, a.ID as user_id FROM orders o
                      INNER JOIN account a ON o.email = a.email
                      WHERE a.ID = $user_id";    
        $result_order_input = $connect->query($query_order_input);

        if ($result_order_input) {
            if ($result_order_input->num_rows > 0) {
                $orders = [];
                while($row_orders = $result_order_input->fetch_assoc()) {
                    // Add the pricing formula here
                    $pagePrice = $row_orders['pageAmount'] * 0.25; // Price per page in PHP
                    $itemPrice = $row_orders['quantity'] * 10.00; // Base price per item in PHP
                    $colorPrice = ($row_orders['color'] == 'color') ? ($row_orders['pageAmount'] * 0.15) : 0; // Color printing price in PHP
                    $paperPrice = ($row_orders['paperType'] == 'premium') ? ($row_orders['quantity'] * 5.00) : 0; // Premium paper price in PHP
                    
                    // Calculate total price in PHP
                    $totalPricePhp = $pagePrice + $itemPrice + $colorPrice + $paperPrice;

                    // Add the total price to the row_orders array
                    $row_orders['totalPricePhp'] = $totalPricePhp;
                    // Add the row_orders array to the orders array
                    $orders[] = $row_orders;
                }
            } else {
                echo "No orders found for this user.";
            }
        } else {
            echo "Error executing query to fetch user orders: " . $connect->error;
        }
    } else {
        // Redirect the user to the login page if they are not logged in
        header("Location: login.php");
        exit;
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
                <a class="order-nav" href="./html/orders.html">Checkout</a>
                <a class="order-nav-select" href="#">Orders</a>
                <a class="order-nav" href="http:/orders-profile.php">Profile</a>
                <div class="order-nav">Logout</div>
            </div>
        </aside>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
                background-color: #000000; /* Set background color to black */
                color: #ffffff; /* Set text color to white */
            }
        </style>
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
                <th>Total Price (PHP)</th>
            </tr>
            <?php if(isset($orders)): ?>
                <?php foreach($orders as $row_orders): ?>
                    <tr>
                        <td><?php echo $row_orders['ID']; ?></td>
                        <td><?php echo $row_orders['serviceType']; ?></td>
                        <td><?php echo $row_orders['paperSize']; ?></td>
                        <td><?php echo $row_orders['paperType']; ?></td>
                        <td><?php echo $row_orders['color']; ?></td>
                        <td><?php echo $row_orders['pageAmount']; ?></td>
                        <td><?php echo $row_orders['quantity']; ?></td>
                        <td><?php echo $row_orders['finish']; ?></td>
                        <td><?php echo $row_orders['coverType']; ?></td>
                        <td><?php echo number_format($row_orders['totalPricePhp'], 2); ?></td> <!-- Display total price in PHP -->
                    </tr>
                <?php endforeach; ?>
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
</html>