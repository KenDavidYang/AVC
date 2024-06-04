<?php
ob_start();
session_start();
        $connect = mysqli_connect(
            "db", #service name
            "php_docker", #username
            "password", #password
            "php_docker" #db table
        );


        $user_id = $_SESSION['user_id'];    

        #access account
        if(isset($_SESSION['user_id'])) {
            $query_account = "SELECT email, firstName, lastName FROM account WHERE ID = $user_id";
            $result_account = $connect->query($query_account); #connect to table

            if ($result_account-> num_rows > 0) {
                $row_account = $result_account->fetch_assoc(); #fetch from table
            
                $email = $row_account['email'];
                $firstName = $row_account['firstName'];
                $lastName = $row_account['lastName'];
        }
        }

        #access address
        if(isset($email)){
            $query_address = "SELECT * FROM address WHERE ID = $user_id";
            $result_address = $connect->query($query_address);

            if ($result_address->num_rows > 0) {
                $row_address = $result_address->fetch_assoc();

                $houseNumber = $row_address['houseNumber'];
                $street = $row_address['street'];
                $barangay = $row_address['barangay'];
                $province = $row_address['province'];
                $city = $row_address['city'];
                $zipCode = $row_address['zipCode'];
                $phoneNumber = $row_address['phoneNumber'];
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
    <link rel="stylesheet" href="../css/orders-profile.css">
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
            <a class="navigation-bar-middle-sub" href="./html/about.html">About</a>
            <a class="navigation-bar-middle-sub" href="./html/services.html">Services</a>
            <a class="navigation-bar-middle-sub" href="./html/orders.html">Orders</a>
        </div>

        <div>
            <a href="./html/sign-up.html">
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
                <a class="order-nav-select" href="http:/html/orders.html">Checkout</a>
                <a class="order-nav" href="http:/orders-orders.php">Orders</a>
                <a class="order-nav" href="http:/orders-profile.php">Profile</a>
                <a class="order-nav" href="http:/three/three.html" style="background-color: #ccffcc; color: black; font-weight: 400;">3D Viewer</a>
                <form action="http://localhost" method="POST">
                    <button class="order-nav" style="background-color: #111111;" type="submit" name="logout">Logout</button>
                </form>
            </div>
        </aside>



        <section class="sectionCon">
            <div class="profile-con">
                <h1 class="profile-title">Profile</h1>  
                <div class="col">
                    <div class="profile-label">Last&nbsp;Name</div>
                    <?php if (isset($lastName)) {
                        echo "<div class='for'>$lastName</div>";
                    }  ?>
                </div>
                <div class="col">
                    <div class="profile-label">First&nbsp;Name</div>
                    <?php if (isset($firstName)) {
                        echo "<div class='for'>$firstName</div>";
                    }  ?>
                </div>
                <div class="col">
                    <div class="profile-label">E-mail</div>
                     <?php if (isset($email)) {
                      echo "<div class='for'>$email</div>"; 
                    } ?>
                </div>
            </div>
        
            <div class="profile-con">
                <h1 class="profile-title">Password</h1> 
                <div class="col">
                    <div class="form-group">
                        <div class="form-label">Current Password</div>
                        <input type="password" class="form-control mb-1">
                    </div>
                    <div class="form-group">
                        <div class="form-label">New Password</div>
                        <input type="password" class="form-control">
                    </div>
                </div>
                <button class="profile-button">Change Password</button> 
            </div>
            
            <!--Address-->
            <div class="profile-con">
                <h1 class="profile-title">Address</h1>
                <div class="col">
                    <div class="form-group">
                        <div class="form-label">House/Building No.</div>
                        <?php if (isset($houseNumber)) { 
                            echo "<div type='text' class='form-control mb-1'>$houseNumber</div>"; 
                        } ?>
                    </div>
                    <div class="form-group">
                        <div class="form-label">Street</div>
                       <?php if (isset($street)) {
                            echo "<div type='text' class='form-control'>$street</div>";
                        } ?>
                    </div>
                </div>
                        
                <div class="col">
                    <div class="form-group">
                        <div class="form-label">Barangay</div>
                        <?php if (isset($barangay)) {
                            echo "<div type='text' class='form-control'>$barangay</div>"; 
                        } ?>
                        </div>
                    <div class="form-group">
                        <div class="form-label">Province</div>
                        <?php if (isset($province)) {
                            echo "<div type='text' class='form-control mb-1'>$province</div>";
                        } ?>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <div class="form-label">City</div>
                        <?php if(isset($city)) {
                            echo "<div type='text' class='form-control'>$city</div>";
                        } ?>
                    </div>
                    <div class="form-group">
                        <div class="form-label">Zip Code</div>
                        <?php if(isset($zipCode)) {
                            echo "<div type='text' class='form-control'>$zipCode</div>";
                        } ?>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <div class="form-label">Phone/Landline No.</div>
                        <?php if(isset($phoneNumber)) {
                            echo "<div type='tel' class='form-control'>$phoneNumber</div>";
                        } ?>
                    </div>
                </div>
                <button class="profile-button">Edit</button> 
                </div>   
            </div>
        </section>

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
