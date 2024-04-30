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
    require_once "./header_lgd.php"
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
</style>

<?php
// Start a session and include the database configuration
session_start();
include("config.php");
?>

<div style="background-color:#add8e6; padding:20px;">
    <?php
    if (isset($_GET['id_materie']) && isset($_GET['id_profesor'])) {
        $id_materie = $_GET['id_materie'];
        $id_profesor = $_GET['id_profesor'];
        $semigrupa = $_GET['semigrupa'];

        $sql = "SELECT* 
        FROM orar 
        CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
        CROSS JOIN materi ON orar.id_materie=materi.id_materie 
        CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
        WHERE (profesori.dep='0' OR profesori.dep='1') 
            AND orar.id_tip='4'
            AND materi.id_materie = ? ";
        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param("i", $id_materie);
            $stmt->execute();
            $result = $stmt->get_result();
            $details = $result->fetch_assoc();
            

            if ($details) {
                // Display the details if available
                echo "<h2>" . htmlspecialchars($details['materie']) . "</h2>";
                //echo "<p><strong>Cerinte:</strong> " . htmlspecialchars($details['cerinte']) . "</p>";
                echo "<p><strong>An de studiu:</strong> " . htmlspecialchars($details['id_an']) . "</p>";
                echo "<p><strong>Semestru:</strong> " . htmlspecialchars($details['sem']) . "</p>";
                echo "<p><strong>Semigrupa:</strong> " . htmlspecialchars($details['nume_ns']) . "</p>";
            ?>
            <?php
            }
            else {
                echo "<p>Nu s-au găsit detalii pentru materia specificată.</p>";
            }
            $stmt->close();
        }
    } else {
        echo "<p>ID materie nepecificat.</p>";
    }

    // Close the database connection
    $db->close();
    ?>

</div>

</body>
</html>