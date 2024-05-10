<!DOCTYPE html>
<html lang="en">
<head>
  <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">



</head>

<?php
session_start();
$x = $_SESSION['email'];
if (!(isset($_SESSION['login']))) {
    header("Location: index_lgd.php");
    exit; // Adaugă exit pentru a opri executarea scriptului după redirecționare
}

$idStudent = $_POST['id_student'];
$idMaterie = $_POST['materie'];

?>

<?php
    $currentPage = 'proiecte_student';
    require_once "./header_lgd.php"
?>
  
<br>



<body>





<?php

$uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/uploadedFile/';
$uploadURL = 'http://localhost/uploadedFile/';


// Verifică dacă fișierul a fost încărcat
if ($_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Extensii permise
    $allowedfileExtensions = array('zip', 'rar', '7z');

    if (in_array($fileExtension, $allowedfileExtensions)) {
        // Construiește noua cale a fișierului
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $dest_path = $uploadURL . $newFileName;

        // Mută fișierul în directorul permanent
        if(move_uploaded_file($fileTmpPath, $uploadDirectory . $newFileName)) {
            include("config.php");
            date_default_timezone_set('Europe/Bucharest');
            $date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO arhive (id_student, id_materie, data_incarcarii, arhiva) VALUES ('$idStudent', '$idMaterie', '$date', '$dest_path')";
            $result = $db->query($sql);
            
            header("Location: detalii_proiect_st.php?id_materie=$idMaterie&id_student=$idStudent"); // Redirect după operație
            exit;

        } else {
            echo 'Eroare la mutarea fișierului în directorul destinat.';
        }
    } else {
        echo 'Încărcare eșuată. Tipuri de fișiere permise: ' . implode(',', $allowedfileExtensions);
    }
} else {
    echo 'Eroare la încărcare. Cod eroare: ' . $_FILES['uploadedFile']['error'];
}
?>

</body>


</html>