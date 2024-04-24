<?php
ob_start();
$connect = mysqli_connect (
    "db", #service name 
    "php_docker", # username
    "password", #password
    "php_docker" #db table
);

//$firstName = $_POST['first-name'];
//$lastName = $_POST['last-name'];
//$email = $_POST['email'];
//$password = $_POST['password'];






//database connection
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

function login($password, $hashedPassword) {
    if(password_verify($password, $hashedPassword)) {
        header("Location: http://localhost:8080");
    } else {
        $alert_message = "wrong password!";
        header("Location: http://localhost:8080/html/login.html?alert=" . urlencode($alert_message));
    }
}

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $query_login = "SELECT password FROM account WHERE email='$email'";


    $query_login = mysqli_query($connect, $query_login);
    $row = mysqli_fetch_row($query_login);
    $cellValue = $row[0];
    login($password, $cellValue);
}




#$stmt = $connect->prepare("INSERT INTO registration(firstName, lastName, email, password) values(:firstname,:lastName,:email,:password)");
#$stmt->bindParam(":firstname", $firstName, PDO::PARAM_STR);

?>