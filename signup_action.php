<?php
session_start(); // Inițializare sesiune
include("config.php");
$username = mysqli_real_escape_string($db, $_POST['uname']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$pass = mysqli_real_escape_string($db, $_POST['password']);
$statut =  mysqli_real_escape_string($db,$_POST['status']);

switch ($statut) {
  case 'student':
      $student_check_query = "SELECT * FROM student WHERE email='$email' LIMIT 1";
      $result = mysqli_query($db, $student_check_query);
      $user_student = mysqli_fetch_assoc($result);
      break;
  case 'prof':
  case 'prof_coord':
      $prof_check_query = "SELECT * FROM profesori_depcie WHERE email='$email' LIMIT 1";
      $result2 = mysqli_query($db, $prof_check_query);
      $user_prof = mysqli_fetch_assoc($result2);
      break;
  case 'secretara':
      // Cod pentru înregistrare secretară
      break;
  default:
      // Cod pentru manipulare caz neașteptat
      break;
}


$user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
$result3 = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($result3);


if ($user) 
{ // if user already exists
    if ($user['username'] === $username) {
        header("Location: index.php?username=gresit");
        exit();
    }
    if ($user['email'] === $email) {
        header("Location: index.php?email=gresit");
        exit();
    }
} 
else if($user_student || $user_prof) { // if user does not exist, insert new user, only if it s a student or a professor
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    if($statut=='student' && $user_student){
    $sql = "INSERT INTO users (username, email, pass, statut ) VALUES ('$username', '$email', '$hashedPassword', 0)";
    }
    else if($statut=='prof' && $user_prof){
      $sql = "INSERT INTO users (username, email, pass, statut ) VALUES ('$username', '$email', '$hashedPassword', 1)";
    }
    else if($statut=='prof_coord' && $user_prof){
      $sql = "INSERT INTO users (username, email, pass, statut ) VALUES ('$username', '$email', '$hashedPassword', 2)";
    }
    if ($db->query($sql) === TRUE) {
        // Setează variabilele de sesiune necesare
        $_SESSION['login'] = true;
        $_SESSION['email'] = $email; // Asumând că folosești email-ul pentru identificarea sesiunii
        if($statut=='student'){
          header("Location: index_logged.php");
        }
        else if($statut=='prof' || $statut=='prof_coord' ){
          header("Location: index_prof_logged.php");
        }
        
        exit();
    } else {
        header("Location: index.php?formular=NOK");
        exit();
    }
}
else 
{
  header("Location: index.php?formular=NOKK");
  exit();
}

$db->close();
?>
