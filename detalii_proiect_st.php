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
    $currentPage = 'proiecte_student';
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

function updateTasks($tasks) {
    global $db; // Folosim conexiunea la baza de date definită global
    foreach ($tasks as $task_id) {
        $sql_update = "UPDATE cerinte SET indeplinire = 1 WHERE id_cerinte = ?";   
        if ($stmt_update = $db->prepare($sql_update)) {
            $stmt_update->bind_param("i", $task_id);
            $stmt_update->execute();
            $stmt_update->close();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task'])) {
    updateTasks($_POST['task']);
}

?>




<div style="background-color:#add8e6; padding:20px;">
    <?php
    if (isset($_GET['id_materie']) && isset($_GET['id_student'])) {
        $id_materie = $_GET['id_materie'];
        $id_student = $_GET['id_student'];

        // Prepare and execute a query to retrieve details for the specified 'id_materie'
        $sql = "SELECT* 
        FROM orar 
        CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
        CROSS JOIN materi ON orar.id_materie=materi.id_materie 
        CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
        WHERE (profesori.dep='0' OR profesori.dep='1') 
            AND orar.id_tip='4'
            AND materi.id_materie = ? ";

        $sql_cerinte = "SELECT * FROM cerinte WHERE id_materie =$id_materie AND id_student=$id_student"; 
        $result_cerinte = $db->query($sql_cerinte);   
        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param("i", $id_materie);
            $stmt->execute();
            $result = $stmt->get_result();
            $details = $result->fetch_assoc();
            

            if ($details) {
                // Display the details if available
                echo "<h2>" . htmlspecialchars($details['materie']) . "</h2>";
                echo "<p><strong>Profesor:</strong> " . htmlspecialchars($details['nume']) . "</p>";
                echo "<p><strong>An de studiu:</strong> " . htmlspecialchars($details['id_an']) . "</p>";
                echo "<p><strong>Semestru:</strong> " . htmlspecialchars($details['sem']) . "</p>";
             // Afișare cerințe cu checkbox
             echo "<form action='' method='post'>";
             while ($row = mysqli_fetch_assoc($result_cerinte)) {
                 $checked = $row['indeplinire'] == 1 ? 'checked' : '';
                 echo "<div><input type='checkbox' name='task[]' value='" . $row['id_cerinte'] . "' $checked> " . htmlspecialchars($row['cerinta']) . "</div>";
             }
             echo "<button type='submit' name='updateTasks'>Actualizează Progres</button>";
             echo "</form>";
?>             
            
                <form action="incarcaFisier_action.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_student" value="<?php echo htmlspecialchars($id_student); ?>">
                    <input type="hidden" name="materie" value="<?php echo htmlspecialchars($id_materie); ?>">
                    <input type="file" name="uploadedFile" accept=".zip,.rar,.7z" id="fileInput" style="display: none;" onchange="this.form.submit()">
                    <label for="fileInput" class="custom-file-upload">Selectează și încarcă fișierul</label>
                </form>
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