<?php
ob_start();
session_start();
$connect = mysqli_connect (
    "db", #service name 
    "php_docker", # username
    "password", #password
    "php_docker" #db table
);


// If sign-up button is pressed
if(isset($_POST['sign-up'])){
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $houseNum = $_POST['house-num'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $zipCode = intval($_POST['zip-code']);
    $phoneNum = intval($_POST['phone-num']);

    // Check if email already exists
    $email_check_query = "SELECT email FROM account WHERE email='$email'";
    $result = mysqli_query($connect, $email_check_query);

    if (mysqli_num_rows($result) > 0) {
        // Email already exists
        $alert_message = "Email already used!";
        header("Location: http://localhost/html/sign-up.html?alert=" . urlencode($alert_message));
        exit();
    } else {
        // Proceed with sign-up
        $options = ['cost' => 12];
        $hash = password_hash($password, PASSWORD_BCRYPT, $options);

        $query_signup = "INSERT INTO account(firstName, lastName, email, password) VALUES('$firstName','$lastName','$email','$hash')";
        $query_address = "INSERT INTO address(email, houseNumber, street, barangay, province, city, zipCode, phoneNumber) VALUES('$email', '$houseNum', '$street', '$barangay', '$province', '$city', '$zipCode', '$phoneNum')";

        $query_signup = mysqli_query($connect, $query_signup);
        $query_address = mysqli_query($connect, $query_address);

        if($query_signup && $query_address){
            header("Location: http://localhost/html/index.html");
            exit();
        } else {
            echo "Data not inserted";
        }
    }
}

// if html value=login button pressed go here
if(isset($_POST['login'])){

    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    $password = $_POST['password'];
    $query_login = "SELECT ID, password FROM account WHERE email='$email'";

    // takes a row with the email and fetches the database password
    $query_login = mysqli_query($connect, $query_login);
    $row = mysqli_fetch_row($query_login);
    $databasePassword = $row[1];
    
    if(password_verify($password, $databasePassword)){
        $_SESSION['user_id'] = intval($row[0]);
        header("Location: http://localhost/html/index.html");
        exit();
    } else {
        $alert_message = "wrong password!";
        header("Location: http://localhost/index.html/html/login.html?alert=" . urlencode($alert_message));
        exit();
    }
}

if(isset($_POST['order'])){
    // Retrieve email from session
    $email = $_SESSION['email']; // Assuming you stored the email in the session during login or sign-up

    // Check if email is available in session
    if(!isset($email) || empty($email)) {
        echo "Email not found in session.";
        exit(); // Exit if email is not available
    }

    // Retrieve other order details
    $serviceType = $_POST['service-type'];
    $paperSize = $_POST['paper-size'];
    $paperType = $_POST['paper-type'];
    $color = $_POST['color'];
    $pageAmount = $_POST['number-of-pages'];
    $quantity = $_POST['quantity'];
    $finish = $_POST['finish'];
    $coverType = $_POST['cover-type'];

    // Declare MySQL query and run it
    $query_order_input = "INSERT INTO orders(email, serviceType, paperSize, paperType, color, pageAmount, quantity, finish, coverType) 
    VALUES('$email', '$serviceType','$paperSize' ,'$paperType' ,'$color' ,'$pageAmount' ,'$quantity' ,'$finish' ,'$coverType')";

    $query_order_input = mysqli_query($connect, $query_order_input);

    // Redirect to main page if no problem
    if($query_order_input){
        header("Location: http://localhost/html/orderspayment.html");
        exit();
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
#$stmt = $connect->prepare("INSERT INTO registration(firstName, lastName, email, password) values(:firstname,:lastName,:email,:password)");
#$stmt->bindParam(":firstname", $firstName, PDO::PARAM_STR);
?>