<?php
ob_start();
$connect = mysqli_connect (
    "db", #service name 
    "php_docker", # username
    "password", #password
    "php_docker" #db table
);



function login($password, $hashedPassword) {
    if(password_verify($password, $hashedPassword)) {
        header("Location: http://localhost:8080");
    } else {
        $alert_message = "wrong password!";
        header("Location: http://localhost:8080/html/login.html?alert=" . urlencode($alert_message));
    }
}

//database connection
// if value=sign-up button pressed go here
if(isset($_POST['sign-up'])){

    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $options = [
        'cost' => 12,
    ];
    $hash = password_hash($password, PASSWORD_BCRYPT, $options);

    $query_signup = "INSERT INTO account(firstName, lastName, email, password) VALUES('$firstName','$lastName','$email','$hash')";
    $query_signup = mysqli_query($connect, $query_signup);

    if($query_signup){
        header("Location: http://localhost:8080");
    } else {
        echo "data not inserted";
    }
}

// if html value=login button pressed go here
if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $query_login = "SELECT password FROM account WHERE email='$email'";

    // takes a row with the email and fetches the database password
    $query_login = mysqli_query($connect, $query_login);
    $row = mysqli_fetch_row($query_login);
    $databasePassword = $row[0];
    login($password, $databasePassword);
}

if(isset($_POST['order'])){
    // putting input from order.html and puts it in a variable
    $serviceType = $_POST['service-type'];
    $paperSize = $_POST['paper-size'];
    $paperType = $_POST['paper-type'];
    $color = $_POST['color'];
    $pageAmount = $_POST['number-of-pages'];
    $quantity = $_POST['quantity'];
    $finish = $_POST['finish'];
    $coverType = $_POST['cover-type'];

    // declares mysql query and runs it
    $query_order_input = "INSERT INTO orders(service_type, paper_size, paper_type, color, number_of_pages, quantity, finish, cover_type) 
    VALUES('$serviceType','$paperSize' ,'$paperType' ,'$color' ,'$pageAmount' ,'$quantity' ,'$finish' ,'$coverType')";
    $query_order_input = mysqli_query($connect, $query_order_input);

    // redirect to main page if no problem
    if($query_order_input){
        header("Location: http://localhost:8080");
    } else {
        echo "data not inserted";
    }
}



#$stmt = $connect->prepare("INSERT INTO registration(firstName, lastName, email, password) values(:firstname,:lastName,:email,:password)");
#$stmt->bindParam(":firstname", $firstName, PDO::PARAM_STR);

?>