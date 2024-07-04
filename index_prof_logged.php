<?PHP
session_start();
$x = $_SESSION['email'];
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
.custom-table {
    border-collapse: separate; /* Asigură că `border-radius` funcționează corect */
    border-spacing: 0; /* Elimină spațiul între celule */
    width: 100%; /* Lățimea tabelului */
    border: 1px solid #ccc; /* Adaugă o bordură subtilă pentru a defini mai bine tabelul */
    border-radius: 10px; /* Rotunjirea colțurilor tabelului */
    overflow: hidden; /* Ascunde conținutul care depășește curba */
}

.custom-table th, .custom-table td {
    border: 1px solid #ccc; /* Bordură pentru celule */
    padding: 8px; /* Spațiu în interiorul celulelor */
    text-align: left; /* Alinează textul la stânga */
}

.custom-table thead {
    background-color: #0D3165 !important; /* Culoare de fundal pentru antetul tabelului */
    color: #ffffff !important; /* Culoarea textului în antet */
}

.custom-table tbody {
    background-color: #add8e6 !important; /* Culoare de fundal pentru corpul tabelului */
}

.table-spacing {
        margin-bottom: 30px; /* Spatiu intre tabele */
    }

  </style>

</head>

<body>

<?php
    $currentPage = 'index_prof_lgd';
    require_once "./header_prof_lgd.php"
?>


<?php
include("config.php");
$sql = "SELECT * FROM profesori_depcie CROSS JOIN profesori ON profesori_depcie.id_profesor=profesori.id_profesor WHERE profesori_depcie.email = '$x'";
$result = $db->query($sql);


$sql2 = "SELECT * FROM users WHERE users.email = '$x'";
$result2 = $db->query($sql2);

$developer = mysqli_fetch_assoc($result);
$nume_prof=$developer['nume'];



  $sql3 ="SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') 
          AND orar.id_tip='4' 
          AND profesori.nume='$nume_prof'
    ORDER BY nume";
  $result_profesor = $db->query($sql3);




?>


<style>
table {
    border-collapse: separate; /* Asigură că `border-radius` funcționează corect */
    border-spacing: 0; /* Elimină spațiul între celule */
    width: 100%; /* Lățimea tabelului */
    border: 1px solid #ccc; /* Adaugă o bordură subtilă pentru a defini mai bine tabelul */
    border-radius: 10px; /* Rotunjirea colțurilor tabelului */
    overflow: hidden; /* Ascunde conținutul care depășește curba */
}

th, td {
    border: 1px solid #ccc; /* Bordură pentru celule */
    padding: 8px; /* Spațiu în interiorul celulelor */
    text-align: left; /* Alinează textul la stânga */
}

thead {
    background-color: #f9f9f9; /* Culoare de fundal pentru antetul tabelului */
}

</style>

<div style="margin-top:30px; ">
  <table class="custom-table" style="width: 25%; float: left; ">
    <thead>
      <tr>
        <th>Username</th>
        <?php while( $developer = mysqli_fetch_assoc($result2)) { ?>
        <th><?php echo $developer['username']; ?></th>								
        <?php } ?>
      </tr>
    </thead>
      <tbody style="background-color:#add8e6; ">
      <?php mysqli_data_seek($result, 0); // repune cursorul la începutul rezultatelor ?>
      <?php while( $developer = mysqli_fetch_assoc($result)) { ?>
        <tr id="<?php echo $developer['id_profesor_depcie']; ?>"> 
            <td>Nume</td>
            <td><?php echo $developer['nume']; 
               $id_profesor_depcie = $developer['id_profesor_depcie']; ;?>
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $developer['email']; ?></td>
        </tr>
        <tr>
            <td>Coordonator</td>
            <td>
                <?php echo $developer['coordonator'] ? "da" : "nu";
                $coordonator = $developer['coordonator'];
                ?>
            </td>
        </tr>

      <?php } ?>
    </tbody>
  </table>
</div>

  <div style="float: right; width: 70%;">
          <?php $developer = mysqli_fetch_assoc($result_profesor);
            if($developer != null){?>
            <table class="custom-table table-spacing" style="width: 100%;">
            <thead>
              <th colspan="5" style="text-align:center;">Proiecte</th>
            </thead>
            <thead>
              <th>Materie</th>
              <th>An</th>
              <th>Semestru</th>
              <th>Semigrupa</th>
              <th>Nr. studenti</th>
            </thead>
            <tbody style="background-color:#add8e6;">
                <?php
                do{
                  $semigrupa=$developer['nume_ns'];
                  if($semigrupa==='An_I_mICAI'){
                  $sql_count = "SELECT COUNT(*) AS numar_studenti FROM student WHERE grupa='mICAI_I_sgr'";
                  }
                  else if($semigrupa==='An_II_mICAI'){
                    $sql_count = "SELECT COUNT(*) AS numar_studenti FROM student WHERE grupa='mICAI_II_sgr'";
                  }
                  else if($semigrupa==='An_I_mACS'){
                    $sql_count = "SELECT COUNT(*) AS numar_studenti FROM student WHERE grupa='mACS_I_sgr'";
                  }
                  else if($semigrupa==='An_II_mACS'){
                    $sql_count = "SELECT COUNT(*) AS numar_studenti FROM student WHERE grupa='mACS_II_sgr'";
                  }
                  else if($semigrupa==='An_I_mES'){
                    $sql_count = "SELECT COUNT(*) AS numar_studenti FROM student WHERE grupa='mES_I_sgr'";
                  }
                  else if($semigrupa==='An_II_mES'){
                    $sql_count = "SELECT COUNT(*) AS numar_studenti FROM student WHERE grupa='mES_II_sgr'";
                  }
                  else if($semigrupa==='An_I_mAAIE'){
                    $sql_count = "SELECT COUNT(*) AS numar_studenti FROM student WHERE grupa='mAAIE_I_sgr'";
                  }
                  else if($semigrupa==='An_II_mAAIE'){
                    $sql_count = "SELECT COUNT(*) AS numar_studenti FROM student WHERE grupa='mAAIE_II_sgr'";
                  }
                  else{
                    $sql_count = "SELECT COUNT(*) AS numar_studenti FROM student WHERE grupa=$semigrupa";
                  }

                  

                  $result4 = $db->query($sql_count);
                  $nrSudenti = mysqli_fetch_assoc($result4);
                  $numar_studenti=$nrSudenti['numar_studenti'];     
                ?>
                
                    <tr id="<?php echo $developer['id_orar']; ?>">   
                        <td><?php echo $developer['materie']; ?></td>
                        <td><?php echo $developer['id_an']; ?></td>
                        <td><?php echo $developer['sem']; ?></td>
                        <td><?php echo $developer['nume_ns']; ?></td>
                        <td><?php echo $numar_studenti; ?></td>
                        
                    </tr>
                    
                <?php 
                  } while($developer = mysqli_fetch_assoc($result_profesor));
            }
            if($coordonator==1){
              $sql_locuri = "SELECT locuri.id_specializare, specializare.denumire, locuri.locuri_disponibile, locuri.locuri_ocupate
              FROM locuri 
              JOIN specializare ON specializare.id_specializare = locuri.id_specializare
              WHERE locuri.id_profesor_depcie = $id_profesor_depcie";
              $result_locuri = $db->query($sql_locuri);
                  echo "<table class='custom-table' style='width: 100%;'>";
                  echo "<thead>";
                  echo "<th colspan='3' style='text-align:center;'>Licenta</th>";
                  echo "</thead><tbody style='background-color:#add8e6;'>";
                  echo "<thead>";
                  echo "<th>Specializare</th><th>Locuri Disponibile</th><th>Locuri Ocupate</th>";
                  echo "</thead><tbody style='background-color:#add8e6;'>";
                  while ($row = mysqli_fetch_assoc($result_locuri)) {
                      echo "<tr>";
                      echo "<td>" . htmlspecialchars($row['denumire']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['locuri_disponibile']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['locuri_ocupate']) . "</td>";
                      echo "</tr>";
                  }
                  echo "</tbody></table>";       
            }
            $db->close();
            ?>                 
            </tbody>
        </table>
    </div>



</body>
</html>