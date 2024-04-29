<?php
include("config.php");
$email=$_POST['email'];
$parola=$_POST['password'];

$err='';
$sql = "SELECT *FROM users";

$result = $db->query($sql);
$user = mysqli_fetch_assoc($result);

if ($user) { // if user exists
    $storedHashedPassword=$user['pass'];
    if ($user['email'] === $email && password_verify($parola, $storedHashedPassword)) {
        session_start();
        $_SESSION['login'] = "user";
        $_SESSION['email'] = $email;
        header('Location: index_logged.php');
    }
    
    else{
        header("Location: index.php?info=NOK");
    }
}
?>



