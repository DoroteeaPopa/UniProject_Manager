<!DOCTYPE html>
<html lang="en">
<head>
  <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="proiecte.css">

</head>

<?php
session_start();
$x = $_SESSION['email'];
if (!(isset($_SESSION['login']))) {
    header("Location: index_prof_logged.php");
    exit; // Adaugă exit pentru a opri executarea scriptului după redirecționare
}
?>





<?php
    $currentPage = 'proiecte_profesor';
    require_once "./header_prof_lgd.php"
?>
  
<br>


<?php
include("config.php");
$sql = "SELECT * FROM profesori_depcie CROSS JOIN profesori ON profesori_depcie.id_profesor=profesori.id_profesor WHERE profesori_depcie.email = '$x'";
$result_profesori = $db->query($sql);

$developer = mysqli_fetch_assoc($result_profesori);
$nume_prof=$developer['nume'];
$id_profesor_depcie=$developer['id_profesor_depcie'];


$sql2 = "SELECT * FROM users WHERE users.email = '$x'";
$result_users = $db->query($sql2);

  $sql3 ="SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') 
          AND orar.id_tip='4' 
          AND profesori.nume='$nume_prof'
    ORDER BY nume_ns";
  $result_materii = $db->query($sql3);


  $sql4="SELECT * FROM locuri 
    CROSS JOIN specializare ON specializare.id_specializare=locuri.id_specializare
    WHERE id_profesor_depcie=$id_profesor_depcie";
  $result_licenta = $db->query($sql4);
$db->close();
?>

</head>
<body>






    <div class="container">
        <?php
        while ($developer = mysqli_fetch_assoc($result_materii)) { 
                $class = '';
                switch ($developer['id_an']) {
                    case 1:
                        $class = 'first-year';
                        break;
                    case 2:
                        $class = 'second-year';
                        break;
                    case 3:
                        $class = 'third-year';
                        break;
                    case 4:
                        $class = 'fourth-year';
                        break;
                    default:
                        $class = ''; 
                        break;
                }
        ?>
        
        <div class="card <?php echo $class; ?>" id="<?php echo $developer['id_orar']; ?>" onclick="window.location.href='detalii_proiect_prof.php?id_materie=<?php echo $developer['id_materie']; ?>&id_profesor=<?php echo $developer['id_profesor']; ?>&semigrupa=<?php echo $developer['nume_ns']; ?>'">
            <h3><?php echo $developer['materie']; ?></h3>
            <p><strong>Profesor:</strong> <?php echo $developer['nume']; ?></p>
            <p><strong>An:</strong> <?php echo $developer['id_an']; ?></p>
            <p><strong>Semestru:</strong> <?php echo $developer['sem']; ?></p>
            <p><strong>Semigrupa:</strong> <?php echo $developer['nume_ns']; ?></p>
        </div>

        <?php 
            
        } 
        ?>

        <?php
        while ($developer = mysqli_fetch_assoc($result_licenta)){?>
          <div class="card licenta" id="<?php echo $developer['id_locuri']; ?>" onclick="window.location.href='detalii_licenta_prof.php?id_profesor_depcie=<?php echo $developer['id_profesor_depcie']; ?>&id_specializare=<?php echo $developer['id_specializare']; ?>'">
            <h3>Licenta</h3>
            <p><strong>Profesor:</strong> <?php echo $nume_prof; ?></p>
            <p><strong>Specializare:</strong> <?php echo $developer['denumire']; ?></p>
            <p><strong>Locuri disponibile:</strong> <?php echo $developer['locuri_disponibile']; ?></p>
            <p><strong>Locuri ocupate:</strong> <?php echo $developer['locuri_ocupate']; ?></p>

          </div>

          <?php
        }

        ?>
    </div>



</body>


</html>
