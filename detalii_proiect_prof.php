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
</style>

<?php
// Start a session and include the database configuration
session_start();
include("config.php");
?>

<div style="padding:20px;">
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

        $sql_count = "SELECT COUNT(*) AS numar_studenti FROM student WHERE grupa =$semigrupa";
        $result4 = $db->query($sql_count);
        $developer = mysqli_fetch_assoc($result4);
        $numar_studenti=$developer['numar_studenti'];  
        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param("i", $id_materie);
            $stmt->execute();
            $result = $stmt->get_result();
            $details = $result->fetch_assoc();
            

            if ($details) {
                // Display the details if available
                echo "<h2>" . htmlspecialchars($details['materie']) . "</h2>";
                echo "<p><strong>An de studiu:</strong> " . htmlspecialchars($details['id_an']) . "</p>";
                echo "<p><strong>Semestru:</strong> " . htmlspecialchars($details['sem']) . "</p>";
                echo "<p><strong>Semigrupa:</strong> " . htmlspecialchars($details['nume_ns']) . "</p>";
                echo "<p><strong>Numar studenti:</strong> " . htmlspecialchars($numar_studenti) . "</p>";


                 // Interogare pentru a prelua cerințele
              $sql_cerinte = "SELECT id_cerinte, cerinta FROM cerinte WHERE id_materie =$id_materie";
              $result_cerinte = $db->query($sql_cerinte); 
              echo "<table border='2' style='width:100%;'>";
              echo "<tr>";
              echo "<th style='width:70%;'>Cerință</th>";
              echo "<th style='width:30%;'>Acțiuni</th>";
              echo "</tr>";
              while ($row = mysqli_fetch_assoc($result_cerinte)) {
                  echo "<tr>";
                  echo "<td style='padding: 10px;'><input type='text' name='cerinta_noua' value='" . htmlspecialchars($row['cerinta'], ENT_QUOTES) . "' style='width:100%;'></td>";
                  echo "<td style='padding: 10px;'>";
                  echo "<form action='cerinteActions.php?action=edit' method='post' style='margin-bottom: 10px;'>";
                  echo "<input type='hidden' name='id_cerinte' value='" . $row['id_cerinte'] . "'>";
                  echo "<input type='hidden' name='id_materie' value='" . $id_materie . "'>";
                  echo "<input type='hidden' name='id_profesor' value='" . $id_profesor . "'>";
                  echo "<input type='hidden' name='semigrupa' value='" . $semigrupa . "'>";
                  echo "<button type='submit' style='width: 100%;'>Editează</button>";
                  echo "</form> ";
                  echo "<form action='cerinteActions.php?action=delete' method='post'>";
                  echo "<input type='hidden' name='id_cerinte' value='" . $row['id_cerinte'] . "'>";
                  echo "<input type='hidden' name='id_materie' value='" . $id_materie . "'>";
                  echo "<input type='hidden' name='id_profesor' value='" . $id_profesor . "'>";
                  echo "<input type='hidden' name='semigrupa' value='" . $semigrupa . "'>";
                  echo "<button type='submit' style='width: 100%;' onclick='return confirm(\"Ești sigur că vrei să ștergi această cerință?\");'>Șterge</button>";
                  echo "</form>";
                  echo "</td>";
                  echo "</tr>";
              }
                  echo "<tr>";
                  echo "<td style='padding: 10px;'><input type='text' name='cerinta_noua' placeholder='Introdu o nouă cerință'></td>";
                  echo "<td style='padding: 10px;'>";
                  echo "<form action='cerinteActions.php?action=add' method='post'>";
                  echo "<input type='hidden' name='id_materie' value='" . $id_materie . "'>";
                  echo "<input type='hidden' name='id_profesor' value='" . $id_profesor . "'>";
                  echo "<input type='hidden' name='semigrupa' value='" . $semigrupa . "'>";
                  echo "<button type='submit'>Adaugă Cerință</button>";
                  echo "</form>";
                  echo "</td>";
                  echo "</tr>";
              echo "</table>";
            
                  
            ?>
            <?php
            }
            else {
                echo "<p>Nu s-au găsit detalii pentru materia specificată.</p>";
            }
            $stmt->close();

                        // Continuare cu studentii
            echo "<h3>Studenți din semigrupa " . htmlspecialchars($semigrupa) . "</h3>";
            $sql_students = "SELECT s.id_student, s.nume, s.prenume, s.email, u.id_user 
                            FROM student s 
                            LEFT JOIN users u ON s.email = u.email 
                            WHERE s.grupa = ?";
              
            if ($stmt_students = $db->prepare($sql_students)) {
                $stmt_students->bind_param("s", $semigrupa);
                $stmt_students->execute();
                $result_students = $stmt_students->get_result();

                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>Nume</th><th>Prenume</th><th>Email</th><th>Acțiuni</th></tr>";
                while ($row_student = $result_students->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row_student['id_student']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_student['nume']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_student['prenume']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_student['email']) . "</td>";
                    echo "<td>";
                    if (!empty($row_student['id_user'])) {
                        // Dacă studentul este utilizator, arată butonul pentru arhive
                        echo "<form action='vizualizeazaArhive_prof.php' method='post'>";
                        echo "<input type='hidden' name='id_student' value='" . $row_student['id_student'] . "'>";
                        echo "<input type='hidden' name='id_materie' value='" . $id_materie . "'>";
                        echo "<button type='submit'>Vezi Arhive</button>";
                        echo "</form>";
                    } else {
                        // Dacă nu este utilizator, afișează un chenar gri
                        echo "<span style='background-color: #ccc; padding: 5px;'>N/A</span>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                $stmt_students->close();
            } else {
                echo "<p>Eroare la pregătirea interogării pentru studenți.</p>";
            }

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