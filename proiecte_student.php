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

<?php
session_start();
$x = $_SESSION['email'];
if (!(isset($_SESSION['login']))) {
    header("Location: index_lgd.php");
    exit; // Adaugă exit pentru a opri executarea scriptului după redirecționare
}


?>



<?php
include("config.php");
$sql = "SELECT * FROM student CROSS JOIN specializare ON student.specializare=specializare.id_specializare WHERE student.email = '$x'";
$result = $db->query($sql);

$developer = mysqli_fetch_assoc($result);
$specializare=$developer['denumire'];
$id_student=$developer['id_student'];


if($specializare=='Tehnologia Informatiei'){
  $sql3 ="SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') 
          AND orar.id_tip='4' 
          AND (nivele_seri.nume_ns='214/1' OR nivele_seri.nume_ns='224/1' OR nivele_seri.nume_ns='233/1' OR nivele_seri.nume_ns='243/1')
    ORDER BY materi.id_an, nume";
  $result3 = $db->query($sql3);

}
else if($specializare=='ISM'){
    $sql3 ="SELECT* 
      FROM orar 
      CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
      CROSS JOIN materi ON orar.id_materie=materi.id_materie 
      CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
      WHERE (profesori.dep='0' OR profesori.dep='1') 
            AND orar.id_tip='4' 
            AND (nivele_seri.nume_ns='216/1' OR nivele_seri.nume_ns='225/1' OR nivele_seri.nume_ns='234/1' OR nivele_seri.nume_ns='244/1')
      ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
  
  }
  else if($specializare=='C'){
    $sql3 ="SELECT* 
      FROM orar 
      CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
      CROSS JOIN materi ON orar.id_materie=materi.id_materie 
      CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
      WHERE (profesori.dep='0' OR profesori.dep='1') 
            AND orar.id_tip='4' 
            AND (nivele_seri.nume_ns='211/1' OR nivele_seri.nume_ns='221/1' OR nivele_seri.nume_ns='231/1' OR nivele_seri.nume_ns='241/1')
      ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
  
  }

$db->close();
?>



<?php
    $currentPage = 'proiecte_student';
    require_once "./header_lgd.php"
?>
  
<br>


</head>
<body>





    <div class="container">
        <?php
        $seen_materii = array(); // Array pentru a ține evidența materiilor deja afișate
        while ($developer = mysqli_fetch_assoc($result3)) { 
            // Verificăm dacă materia deja a fost afișată
            if (!in_array($developer['materie'], $seen_materii)) {
                // Dacă nu a fost afișată, o adăugăm în array
                $seen_materii[] = $developer['materie'];

               
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
            }
        ?>
        
        <div class="card <?php echo $class; ?>" id="<?php echo $developer['id_orar']; ?>" onclick="window.location.href='detalii_proiect_st.php?id_materie=<?php echo $developer['id_materie']; ?>&id_student=<?php echo $id_student; ?>'">
            <h3><?php echo $developer['materie']; ?></h3>
            <p><strong>Profesor:</strong> <?php echo $developer['nume']; ?></p>
            <p><strong>An:</strong> <?php echo $developer['id_an']; ?></p>
            <p><strong>Semestru:</strong> <?php echo $developer['sem']; ?></p>
        </div>

        <?php 
           
            
        } 
        ?>
    </div>



</body>


</html>
