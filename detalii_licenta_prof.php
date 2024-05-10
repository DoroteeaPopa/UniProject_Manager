<!DOCTYPE html>
<html lang="en">
<head>
  <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="proiecte.css">

</head>
<body>

<?php
    $currentPage = 'proiecte_profesor';
    require_once "./header_prof_lgd.php"
?>

<style>
  #archiveInput {
    display: none;  /* Ascunde input-ul original */
  }

  .custom-file-upload {
    display: inline-block;
    padding: 8px 16px;
    cursor: pointer;
    background-color: #f8f8f8;
    color: #0D3165; /* Aplică stilul dorit aici */
    border: 1px solid #ccc;
    border-radius: 8px;
  }
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Modern font */
  }

  h2 {
    color: #0D3165; /* Deep blue for headings */
    border-bottom: 2px solid #f8f8f8; /* Subtle underline */
    padding-bottom: 10px;
  }

  table {
    width: 100%;
    background-color: #ffffff;
    border-collapse: collapse;
    margin-top: 20px;
  }

  th, td {
    border: 1px solid #dee2e6; /* Bootstrap-like table borders */
    padding: 8px;
    text-align: left;
  }

  th {
    background-color: #f8f8f8; /* Light grey background for headers */
  }

  td {
    background-color: #FAFAFA; /* Very light grey background for cells */
  }

  .custom-file-upload {
    background-color: #0D3165;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    display: inline-block;
  }

  input[type='text'], button {
    border-radius: 5px;
  }

  form {
    margin-top: 5px;
  }
</style>


<?php
// Start a session and include the database configuration
session_start();
include("config.php");
$id_profesor_depcie=$_GET['id_profesor_depcie'];
$id_specializare=$_GET['id_specializare'];

$sql="SELECT * FROM locuri 
    CROSS JOIN specializare ON specializare.id_specializare=locuri.id_specializare
    WHERE id_profesor_depcie=$id_profesor_depcie
    AND locuri.id_specializare=$id_specializare";
  $result = $db->query($sql);
?>


<div style="padding:20px;" class="container mt-5">
<?php
    if (isset($_GET['id_profesor_depcie']) && isset($_GET['id_specializare'])) {

        while ($details = mysqli_fetch_assoc($result)){
                echo "<div style='text-align: center;'><h2>Licenta</h2><br>"; // Subject name as a main header-like element
                echo "<span style='margin-right: 16px;'><strong>Specializare:</strong> " . htmlspecialchars($details['denumire']). "</span>" ;
                echo "<span style='margin-right: 16px;'><strong>Locuri disponibile:</strong> " . htmlspecialchars($details['locuri_disponibile']). "</span>";
                echo "<span style='margin-right: 16px;'><strong>Locuri ocupate:</strong> " . htmlspecialchars($details['locuri_ocupate']). "</span>" ;
                echo "</div>";
        }

           // Interogare pentru a prelua temele de licenta
           $sql_teme = "SELECT * FROM teme_licenta WHERE id_profesor_depcie =$id_profesor_depcie AND id_specializare=$id_specializare";
           $result_teme = $db->query($sql_teme); 
           echo "<table border='2' style='width:100%;'>";
           echo "<tr>";
           echo "<th style='width:70%;'>Tema</th>";
           echo "<th style='width:30%;'>Acțiuni</th>";
           echo "</tr>";
           while ($row = mysqli_fetch_assoc($result_teme)) {
               echo "<tr>";
               echo "<td style='padding: 10px;'>";
               echo "<form action='temeActions.php?action=edit' method='post' style='margin-bottom: 10px;'>";
               echo "<input type='text' name='tema_noua' value='" . htmlspecialchars($row['tema'], ENT_QUOTES) . "' style='width:100%;'>";
               echo "<td style='padding: 10px;'>";
               echo "<input type='hidden' name='id_tema' value='" . $row['id_tema'] . "'>";
               echo "<input type='hidden' name='id_profesor_depcie' value='" . $id_profesor_depcie . "'>";
               echo "<input type='hidden' name='id_specializare' value='" . $id_specializare . "'>";
               echo "<button type='submit' style='width: 100%;'>Editează</button>";
               echo "</form> ";
               echo "<form action='temeActions.php?action=delete' method='post'>";
               echo "<input type='hidden' name='id_tema' value='" . $row['id_tema'] . "'>";
               echo "<input type='hidden' name='id_profesor_depcie' value='" . $id_profesor_depcie . "'>";
               echo "<input type='hidden' name='id_specializare' value='" . $id_specializare . "'>";
               echo "<button type='submit' style='width: 100%;' onclick='return confirm(\"Ești sigur că vrei să ștergi această tema?\");'>Șterge</button>";
               echo "</form>";
               echo "</td>";
               echo "</tr>";
           }
               echo "<tr>";
               echo "<td style='padding: 10px;'>";
               echo "<form action='temeActions.php?action=add' method='post'>";
               echo "<input type='text' name='tema_noua' placeholder='Introdu o nouă tema'>";
               echo "<input type='hidden' name='id_profesor_depcie' value='" . $id_profesor_depcie . "'>";
               echo "<input type='hidden' name='id_specializare' value='" . $id_specializare . "'>";
               echo "<td><button type='submit'>Adaugă Tema</button></td>";
               echo "</form>";
               echo "</td>";
               echo "</tr>";
           
           echo "</table>";
    }
?>    


</div>
</body>
</html>