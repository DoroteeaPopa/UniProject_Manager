<?php
include("config.php");
$email=$_POST['email'];
$parola=$_POST['password'];

$err='';
$sql = "SELECT * FROM users WHERE email='$email'";

$result = $db->query($sql);
$user = mysqli_fetch_assoc($result);

$sql2 = "SELECT * FROM management WHERE email='$email'";
$result2 = $db->query($sql2);
$management = mysqli_fetch_assoc($result2);

if ($user) { // if user exists
    $storedHashedPassword=$user['pass'];
    if ($user['email'] === $email && password_verify($parola, $storedHashedPassword)) {
        session_start();
        $_SESSION['login'] = "user";
        $_SESSION['email'] = $email;
        if($user['statut']==0){
            header('Location: index_logged.php');
        }
        else{
            header('Location: index_prof_logged.php');
        }
    }
    else{
        header("Location: index.php?info=NOK");
    }

}
else if($management['email']===$email && $management['parola']===$parola && $management['rol']=="secretara" ){
    session_start();
    $_SESSION['login'] = "user";
    $_SESSION['email'] = $email;
    header("Location: index_secretara_logged.php");
}
else if($management['email']===$email && $management['parola']===$parola && $management['rol']=="admin" ){
    session_start();
    $_SESSION['login'] = "user";
    $_SESSION['email'] = $email;
    header("Location: admin.php");
}
else{
    header("Location: index.php?info=NOKK");
}
?>



