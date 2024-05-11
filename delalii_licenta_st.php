<!DOCTYPE html>
<html lang="en">
<head>
  <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="proiecte.css">

</head>
<body>

<?php
    $currentPage = 'proiecte_student';
    require_once "./header_lgd.php"
?>


<style>
        #archiveInput {
            display: none;  /* Ascunde input-ul original */
        }

        .centered-container {
            margin: 0 auto;
            width: 70%;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 6px 10px rgba(0,0,0,0.1);
        }

        .custom-file-upload {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            display: inline-block;
            margin-top: 10px;
        }

        .custom-file-upload:hover {
            background-color: #0056b3;
        }

        .btn-custom-gray {
        background-color: #6c757d; /* A standard gray color */
        color: white; /* White text color */
        border: 1px solid #6c757d; /* Gray border */
        }

        .btn-custom-gray:hover, .btn-custom-gray:focus {
            background-color: #5a6268; /* A darker shade of gray for hover state */
            border-color: #545b62; /* Darker border on hover */
        }
    
        h2 {
        color: #0D3165; /* Deep blue for headings */
        border-bottom: 2px solid #f8f8f8; /* Subtle underline */
        padding-bottom: 10px;
        }

</style>

<?php
session_start();
include("config.php");
$id_specializare=$_GET['id_specializare'];
$id_student=$_GET['id_student'];

$sql="SELECT tl.*, p.nume
FROM teme_licenta tl
JOIN profesori_depcie pd ON tl.id_profesor_depcie = pd.id_profesor_depcie
JOIN profesori p ON pd.id_profesor = p.id_profesor
WHERE tl.id_specializare = $id_specializare";
$result_teme=$db->query($sql);

$sql2="SELECT * FROM locuri WHERE id_specializare=$id_specializare";
$result_locuri=$db->query($sql2);
$locuri = mysqli_fetch_assoc($result_locuri);
$locuri_ocupate=$locuri['locuri_ocupate'];
$locuri_disponibile=$locuri['locuri_disponibile'];


?>

<div style="padding:20px;" class="container mt-5">
<?php
    if (isset($_GET['id_student']) && isset($_GET['id_specializare'])) {
        echo "<table border='2' style='width: 100%;'>";
        echo "<tr>";
        echo "<th style='width: 15%;'>Profesor</th>";       // Set width to 15%
        echo "<th style='width: 15%;'>Tema</th>";    // Set width to 15%
        echo "<th style='width: 20%;'>Locuri ocupate</th>";      // Set width to 20%
        echo "<th style='width: 20%;'>Locuri disponibile</th>";       // Set width to 20%
        echo "<th style='width: 30%;'>Acțiuni</th>";    // Width already set to 30%
        echo "</tr>";
        while (($details = mysqli_fetch_assoc($result_teme))) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($details['nume']) . "</td>";
            echo "<td>" . htmlspecialchars($details['tema']) . "</td>";
            echo "<td>" . htmlspecialchars($locuri_ocupate) . "</td>";
            echo "<td>" . htmlspecialchars($locuri_disponibile) . "</td>";
                  echo "<td style='padding: 10px;'>";
                  echo "<form action='' method='post'>";
                  echo "<button type='submit'>Trimite cerere</button>";
                  echo "</form>";
                  echo "</td>";
                  echo "</tr>";
        }
        
    }

?>
</div>


</body>
</html>