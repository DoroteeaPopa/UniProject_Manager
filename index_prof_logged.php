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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">

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
  $result3 = $db->query($sql3);




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
  <table class="table" style="width: 25%; float: left; ">
    <thead style="background-color:#0D3165; color: #ffffff;  " >
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
            <td><?php echo $developer['nume']; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $developer['email']; ?></td>
        </tr>
        <tr>
            <td>Coordonator</td>
            <td>
                <?php echo $developer['coordonator'] ? "da" : "nu"; ?>
            </td>
        </tr>

      <?php } ?>
    </tbody>
  </table>
</div>

  <div style="float: right; width: 70%;">
        <table class="table" style="width: 100%;">
            <thead style="background-color:#0D3165; color: #ffffff;">
              <th>Materie</th>
              <th>An</th>
              <th>Semestru</th>
              <th>Semigrupa</th>
              <th>Nr. studenti</th>
            </thead>
            <tbody style="background-color:#add8e6;">
                <?php
                while ($developer = mysqli_fetch_assoc($result3)) {
                  $semigrupa=$developer['nume_ns'];
                  $sql_count = "SELECT COUNT(*) AS numar_studenti FROM student WHERE grupa=$semigrupa";
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
                
                    }
                    $db->close();
                
                ?>
            </tbody>
        </table>
    </div>



</body>
</html>