<?PHP
session_start();
if (!(isset($_SESSION['login']))) {

header ("Location: index.php");

}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">

</head>
<body>
<?php
        $currentPage ='contact_student';
        require_once "./header_prof_lgd.php"
?>



</body>
</html>