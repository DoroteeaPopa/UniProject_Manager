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
include("config.php");
//$sql = "SELECT * FROM carti CROSS JOIN gen ON carti.IdGen=gen.IdGen ORDER BY Titlu";
$sql = "SELECT * FROM materi WHERE dep='1' OR dep='0'";
$result = $db->query($sql);

$sql2 = "SELECT* 
      FROM orar 
      CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
      CROSS JOIN materi ON orar.id_materie=materi.id_materie 
      CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
      WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' 
      ORDER BY materi.id_an, nume"; 
$result2 = $db->query($sql2);
$db->close();
?>

<body>

<?php
    $currentPage = 'proiecte';
    require_once "./header.php"
?>
  
<br>


</head>
<body>
    <div class="container">
        <?php
        $seen_materii = array(); // Array pentru a ține evidența materiilor deja afișate
        while ($developer = mysqli_fetch_assoc($result2)) { 
            // Verificăm dacă materia deja a fost afișată
            if (!in_array($developer['materie'], $seen_materii)) {
                // Dacă nu a fost afișată, o adăugăm în array
                $seen_materii[] = $developer['materie'];

                // Determinăm clasa CSS în funcție de anul cursului
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
                        $class = ''; // Pentru cazurile care nu corespund
                        break;
                }
        ?>
            <div class="card <?php echo $class; ?>" id="<?php echo $developer['id_orar']; ?>">
                <h3><?php echo $developer['materie']; ?></h3>
                <p><strong>Profesor:</strong> <?php echo $developer['nume']; ?></p>
                <p><strong>An:</strong> <?php echo $developer['id_an']; ?></p>
                <p><strong>Semestru:</strong> <?php echo $developer['sem']; ?></p>
            </div>
        <?php 
            }
        } 
        ?>
    </div>
</body>


</html>
