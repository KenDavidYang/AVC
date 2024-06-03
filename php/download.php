<?php
ob_start();
session_start();
        $connect = mysqli_connect(
            "db", #service name
            "php_docker", #username
            "password", #password
            "php_docker" #db table
        );

        $sql = "SELECT *FROM orders";
        $result = $connect->query($sql);    
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
    <link rel="website icon" type="jpg" href="../image/logo.jpg">
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
            <a href="login.html">
                <button class="button-sign-up">Log In</button>
            </a>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <main>

    <div class="container mt-5">
        <h2>Uploaded Files</h2>
        <table class="download-table">
            <thead>
                <tr>
                    <th>Order Id</th>
                    <th>File Name</th>
                    <th>File Type</th>
                    <th>File Size</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display the uploaded files and download links
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $file_path = "uploads/" . $row['filename'];
                        ?>
                        <tr>
                            <td><?php echo $row['ID']; ?></td>
                            <td><?php echo $row['filename']; ?></td>
                            <td><?php echo $row['filetype']; ?></td>
                            <td><?php echo $row['filesize']; ?> bytes</td>
                            <td><a href="<?php echo $file_path; ?>" class="download" download>Download</a></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5">No files uploaded yet.</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
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