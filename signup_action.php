<?php
session_start(); // Inițializare sesiune
include("config.php");
$username = mysqli_real_escape_string($db, $_POST['uname']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$pass = mysqli_real_escape_string($db, $_POST['password']);

$user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
$result = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($result);

if ($user) { // if user exists
    if ($user['username'] === $username) {
        header("Location: index.php?username=gresit");
        exit();
    }
    if ($user['email'] === $email) {
        header("Location: index.php?email=gresit");
        exit();
    }
} else { // if user does not exist, insert new user
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, pass) VALUES ('$username', '$email', '$hashedPassword')";
    if ($db->query($sql) === TRUE) {
        // Setează variabilele de sesiune necesare
        $_SESSION['login'] = true;
        $_SESSION['email'] = $email; // Asumând că folosești email-ul pentru identificarea sesiunii
        header("Location: index_logged.php");
        exit();
    } else {
        header("Location: index.php?formular=NOK");
        exit();
    }
}

$db->close();
?>
