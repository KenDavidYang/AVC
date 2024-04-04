<?php

$connect = mysqli_connect (
    "db", #service name 
    "php_docker", # username
    "password", #password
    "php_docker" #db table
);

$firstName = $_POST['first-name'];
$lastName = $_POST['last-name'];
$email = $_POST['email'];
$password = $_POST['password'];

//database connection
if($connect->connect_error) {
    die("Connection Failed : ".$connect->connect_error);
}
if(isset($_POST['sign-up'])){
    $query = mysqli_query($connect, "INSERT INTO registration(firstName, lastName, email, password) VALUES('$firstName','$lastName','$email','$password')");
    if($query){
        echo "<script>alert (data inserted successfuly)</script>";
    } else {
        echo "<script>alert (data has not been inserted)</script>";
    }
}

#$stmt = $connect->prepare("INSERT INTO registration(firstName, lastName, email, password) values(:firstname,:lastName,:email,:password)");
#$stmt->bindParam(":firstname", $firstName, PDO::PARAM_STR);


?>