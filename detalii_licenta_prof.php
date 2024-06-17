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
    $currentPage = 'detalii_proiect_prof';
    require_once "./header_prof_lgd.php";
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

$sql2 = "SELECT *
         FROM cereri_teme
         CROSS JOIN specializare ON specializare.id_specializare = cereri_teme.id_specializare
         CROSS JOIN student ON student.id_student = cereri_teme.id_student
         CROSS JOIN teme_licenta ON teme_licenta.id_tema = cereri_teme.id_tema
         WHERE cereri_teme.id_specializare = $id_specializare
           AND teme_licenta.id_profesor_depcie=$id_profesor_depcie";
$result2 = $db->query($sql2);

// Fetch the current data_predare_licenta for the specialization
$sql_specializare = "SELECT data_predare_licenta FROM specializare WHERE id_specializare=$id_specializare";
$result_specializare = $db->query($sql_specializare);
$specializare_data = $result_specializare->fetch_assoc();
$data_predare_licenta = $specializare_data['data_predare_licenta'];

?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editLocuri'])) {
  $locuri = htmlspecialchars($_POST['locuri']);
  $id_profesor_depcie = htmlspecialchars($_POST['id_profesor_depcie']);
  $id_specializare = htmlspecialchars($_POST['id_specializare']);

  $sql = "UPDATE locuri SET locuri_disponibile = ? WHERE id_profesor_depcie = ? AND id_specializare = ?";
  if ($stmt = $db->prepare($sql)) {
      $stmt->bind_param("iii", $locuri, $id_profesor_depcie, $id_specializare);
      $stmt->execute();
      $stmt->close();
      header("Location: detalii_licenta_prof.php?id_profesor_depcie=$id_profesor_depcie&id_specializare=$id_specializare" );
  } 
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editDataPredare'])) {
  $data_predare_licenta = htmlspecialchars($_POST['data_predare_licenta']);
  $id_specializare = htmlspecialchars($_POST['id_specializare']);

  $sql = "UPDATE specializare SET data_predare_licenta = ? WHERE id_specializare = ?";
  if ($stmt = $db->prepare($sql)) {
      $stmt->bind_param("si", $data_predare_licenta, $id_specializare);
      $stmt->execute();
      $stmt->close();
      header("Location: detalii_licenta_prof.php?id_profesor_depcie=$id_profesor_depcie&id_specializare=$id_specializare" );
  } 
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accepta'])) {
  $db->begin_transaction();
  $id_specializare = htmlspecialchars($_POST['id_specializare']);
  $id_cerere=htmlspecialchars($_POST['id_cerere']);
  try {
      $updateCereri = $db->prepare("UPDATE cereri_teme SET acceptat = 2 WHERE id_cerere = ?");
      $updateCereri->bind_param("i", $id_cerere);
      $updateCereri->execute();
      $updateCereri->close();

      $updateLocuri = $db->prepare("UPDATE locuri SET locuri_disponibile = locuri_disponibile - 1, locuri_ocupate = locuri_ocupate + 1 WHERE id_specializare = ? AND id_profesor_depcie= ?");
      $updateLocuri->bind_param("ii", $id_specializare, $id_profesor_depcie);
      $updateLocuri->execute();
      $updateLocuri->close();

      $db->commit();
  } catch (Exception $e) {
      $db->rollback();
      echo "Eroare la procesare: " . $e->getMessage();
  }
  header("Location: detalii_licenta_prof.php?id_profesor_depcie=$id_profesor_depcie&id_specializare=$id_specializare" );
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['refuza'])) {
  $id_specializare = htmlspecialchars($_POST['id_specializare']);
  $id_cerere=htmlspecialchars($_POST['id_cerere']);
  $updateCereri = $db->prepare("UPDATE cereri_teme SET acceptat = 1 WHERE id_cerere = ?");
  $updateCereri->bind_param("i", $id_cerere);
  $updateCereri->execute();
  $updateCereri->close();

  header("Location: detalii_licenta_prof.php?id_profesor_depcie=$id_profesor_depcie&id_specializare=$id_specializare" );
}
?>

<div style="padding:20px;" class="container mt-5">
<?php
    if (isset($_GET['id_profesor_depcie']) && isset($_GET['id_specializare'])) {
        while ($details = mysqli_fetch_assoc($result)){
                $locuri_disponibile=$details['locuri_disponibile'];
                echo "<div style='text-align: center;'><h2>Licenta</h2><br>"; // Subject name as a main header-like element
                echo "<span style='margin-right: 16px;'><strong>Specializare:</strong> " . htmlspecialchars($details['denumire']). "</span>" ;
                echo "<span style='margin-right: 16px;'><strong>Locuri disponibile:</strong> " . htmlspecialchars($details['locuri_disponibile']). "</span>";
                echo "<span style='margin-right: 16px;'><strong>Locuri ocupate:</strong> " . htmlspecialchars($details['locuri_ocupate']). "</span><br></br>" ;
                echo "</div>";
        }

        echo "<table border='2' style='width:100%;'>";
        echo "<tr>";
        echo "<th style='width:70%;'>Locuri disponibile</th>";
        echo "<th style='width:30%;'>Acțiuni</th>";
        echo "</tr>";
               echo "<tr>";
               echo "<form action='' method='post' style='margin-bottom: 10px;'>";
               echo "<td>";
               echo "<input type='text' name='locuri' value='" . htmlspecialchars($locuri_disponibile) . "' style='width:100%;'>";
               echo "<input type='hidden' name='id_profesor_depcie' value='" . $id_profesor_depcie . "'>";
               echo "<input type='hidden' name='id_specializare' value='" . $id_specializare . "'>";
               echo "</td>";
               echo "<td>";
               echo "<button type='submit' name='editLocuri' style='width: 100%;'>Editează</button>";
               echo "</td>";
               echo "</form> ";
               echo "</tr>";
               echo "</table>";

        // Form to edit data_predare_licenta
        echo "<table border='2' style='width:100%;'>";
        echo "<tr>";
        echo "<th style='width:70%;'>Data Predare Licenta</th>";
        echo "<th style='width:30%;'>Acțiuni</th>";
        echo "</tr>";
               echo "<tr>";
               echo "<form action='' method='post' style='margin-bottom: 10px;'>";
               echo "<td>";
               echo "<input type='text' name='data_predare_licenta' value='" . htmlspecialchars($data_predare_licenta) . "' style='width:100%;'>";
               echo "<input type='hidden' name='id_specializare' value='" . $id_specializare . "'>";
               echo "</td>";
               echo "<td>";
               echo "<button type='submit' name='editDataPredare' style='width: 100%;'>Setează</button>";
               echo "</td>";
               echo "</form> ";
               echo "</tr>";
               echo "</table>";

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

           echo "<table border='2' style='width:100%;'>";
           echo "<tr>";
           echo "<th style='width:40%;'>Tema</th>";
           echo "<th style='width:10%;'>Specializare</th>";
           echo "<th style='width:10%;'>Nume student</th>";
           echo "<th style='width:15%;'>Email student</th>";
           echo "<th style='width:15%;'>Actiune</th>";
           echo "</tr>";
           while ($cereri = mysqli_fetch_assoc($result2)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($cereri['tema']) . "</td>";
            echo "<td>" . htmlspecialchars($cereri['denumire']) . "</td>";
            echo "<td>" . htmlspecialchars($cereri['nume']) ." " . htmlspecialchars($cereri['prenume']) ."</td>";
            echo "<td><a href='mailto:" . htmlspecialchars($cereri['email']) . "'>" . htmlspecialchars($cereri['email']) . "</a></td>";

            echo "<td>";
            if($cereri['acceptat']==0){//in asteptare
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='id_cerere' value='" . $cereri['id_cerere'] . "'>";
            echo "<input type='hidden' name='id_specializare' value='" . $id_specializare . "'>";
            echo "<button type='submit' name='accepta' style='background-color: green;'>Acceptă</button>";
            echo "<button type='submit' name='refuza' style='background-color: red;'>Refuză</button>";
            echo "</form>";
            }
            else if($cereri['acceptat']==1){
            echo "Student respins!"; 
            }
            else{
              echo "Student inscris!"; 
              echo "<form action='vizualizeazaArhive_prof.php' method='post' style='margin-bottom: 10px;'>";
              echo "<input type='hidden' name='id_student' value='" . $cereri['id_student'] . "'>";
              echo "<input type='hidden' name='id_tema' value='" . $cereri['id_tema'] . "'>";
              echo "<button type='submit' style='width: 98%;'>Vezi Arhive</button>";
              echo "</form>";
            }
            echo "</td>";
            echo "</tr>";
        }     
    }
?>    
</div>
</body>
</html>
