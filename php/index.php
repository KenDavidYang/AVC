<?php
ob_start();
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

$options = [
    'cost' => 12,
];

$hash = password_hash($password, PASSWORD_BCRYPT, $options);
$query = "INSERT INTO account(firstName, lastName, email, password) VALUES('$firstName','$lastName','$email','$hash')";


//database connection
if(isset($_POST['sign-up'])){
    $query = mysqli_query($connect, $query);
    if($query){
        echo "data inserted";
        header("Location: http://localhost:8080");
        ob_end_flush();
        exit();
       
    } else {
        echo "data not inserted";
    }
}




#$stmt = $connect->prepare("INSERT INTO registration(firstName, lastName, email, password) values(:firstname,:lastName,:email,:password)");
#$stmt->bindParam(":firstname", $firstName, PDO::PARAM_STR);

?>