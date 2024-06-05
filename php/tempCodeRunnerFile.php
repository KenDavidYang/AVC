//$firstName = $_POST['first-name'];
//$lastName = $_POST['last-name'];
//$email = $_POST['email'];
//$password = $_POST['password'];



// function login($password, $hashedPassword) {
//     if(password_verify($password, $hashedPassword)) {
//         header("Location: http://localhost:8080");
//     } else {
//         $alert_message = "wrong password!";
//         header("Location: http://localhost:8080/html/login.html?alert=" . urlencode($alert_message));
//     }
// }

// //database connection
// // if value=sign-up button pressed go here
// if(isset($_POST['sign-up'])){

//     $firstName = $_POST['first-name'];
//     $lastName = $_POST['last-name'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     $options = [
//         'cost' => 12,
//     ];
//     $hash = password_hash($password, PASSWORD_BCRYPT, $options);

//     $query_signup = "INSERT INTO account(firstName, lastName, email, password) VALUES('$firstName','$lastName','$email','$hash')";
//     $query_signup = mysqli_query($connect, $query_signup);

//     if($query_signup){
//         header("Location: http://localhost:8080");
//     } else {
//         echo "data not inserted";
//     }
// }

// // if html value=login button pressed go here
// if(isset($_POST['login'])){

//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $query_login = "SELECT password FROM account WHERE email='$email'";

//     // takes a row with the email and fetches the database password
//     $query_login = mysqli_query($connect, $query_login);
//     $row = mysqli_fetch_row($query_login);
//     $databasePassword = $row[0];
//     login($password, $databasePassword);
// }