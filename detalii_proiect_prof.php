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
?>

<div style="padding:20px;" class="container mt-5">
    <?php
    if (isset($_GET['id_materie']) && isset($_GET['id_profesor'])) {
        $id_materie = $_GET['id_materie'];
        $id_profesor = $_GET['id_profesor'];
        $semigrupa = $_GET['semigrupa'];

        $parti = explode('/', $semigrupa); 
        $grupa = $parti[0];
        if($grupa=="211" || $grupa=="212" || $grupa=="213" || 
           $grupa=="221" || $grupa=="222" || $grupa=="223" ||
           $grupa=="231" || $grupa=="232" ||
           $grupa=="241" || $grupa=="242" )
        {
          $specializare="C";
        }
        else if($grupa=="214" || $grupa=="215" || $grupa=="224" || $grupa=="233" || $grupa=="243")
        {
          $specializare="TI";
        }
        else if($grupa=="216" || $grupa=="217" || $grupa=="225" || $grupa=="234" || $grupa=="244")
        {
          $specializare="ISM";
        }
        else if($grupa=="311" || $grupa=="321" || $grupa=="331" || $grupa=="341")
        {
          $specializare="EM";
        }
        else if($grupa=="312" || $grupa=="322" || $grupa=="332" || $grupa=="342")
        {
          $specializare="EA";
        }

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
                echo "<div style='text-align: center;'><h2>" . htmlspecialchars($details['materie']). "</h2><br>"; // Subject name as a main header-like element
                 // Opening div for containing details
                echo "<span style='margin-right: 16px;'><strong>Profesor:</strong> " . htmlspecialchars($details['nume']) . "</span><br>";
                 // Adding <br> to ensure each detail starts on a new line
                echo "<span style='margin-right: 16px;'><strong>An de studiu:</strong> " . htmlspecialchars($details['id_an']). "</span>" ;
                echo "<span style='margin-right: 16px;'><strong>Semestru:</strong> " . htmlspecialchars($details['sem']). "</span>";
                echo "<span style='margin-right: 16px;'><strong>Semigrupa:</strong> " . htmlspecialchars($details['nume_ns']). "</span>" ;
                echo "<span style='margin-right: 16px;'><strong>Specializare:</strong> " . htmlspecialchars($specializare) . "</span>";
                echo "<span style='margin-right: 16px;'><strong>Numar studenti:</strong> " . htmlspecialchars($numar_studenti);
                echo "</div>"; // Closing div for details



                 // Interogare pentru a prelua cerințele
              $sql_cerinte = "SELECT id_task, task FROM taskuri WHERE id_materie =$id_materie";
              $result_cerinte = $db->query($sql_cerinte); 
              echo "<table border='2' style='width:100%;'>";
              echo "<tr>";
              echo "<th style='width:70%;'>Cerință</th>";
              echo "<th style='width:30%;'>Acțiuni</th>";
              echo "</tr>";
              while ($row = mysqli_fetch_assoc($result_cerinte)) {
                  echo "<tr>";
                  echo "<td style='padding: 10px;'>";
                  echo "<form action='cerinteActions.php?action=edit' method='post' style='margin-bottom: 10px;'>";
                  echo "<input type='text' name='task_nou' value='" . htmlspecialchars($row['task'], ENT_QUOTES) . "' style='width:100%;'>";
                  echo "<td style='padding: 10px;'>";
                  echo "<input type='hidden' name='id_task' value='" . $row['id_task'] . "'>";
                  echo "<input type='hidden' name='id_materie' value='" . $id_materie . "'>";
                  echo "<input type='hidden' name='id_profesor' value='" . $id_profesor . "'>";
                  echo "<input type='hidden' name='semigrupa' value='" . $semigrupa . "'>";
                  echo "<button type='submit' style='width: 100%;'>Editează</button>";
                  echo "</form> ";
                  echo "<form action='cerinteActions.php?action=delete' method='post'>";
                  echo "<input type='hidden' name='id_task' value='" . $row['id_task'] . "'>";
                  echo "<input type='hidden' name='id_materie' value='" . $id_materie . "'>";
                  echo "<input type='hidden' name='id_profesor' value='" . $id_profesor . "'>";
                  echo "<input type='hidden' name='semigrupa' value='" . $semigrupa . "'>";
                  echo "<button type='submit' style='width: 100%;' onclick='return confirm(\"Ești sigur că vrei să ștergi această cerință?\");'>Șterge</button>";
                  echo "</form>";
                  echo "</td>";
                  echo "</tr>";
              }
                  echo "<tr>";
                  echo "<td style='padding: 10px;'>";
                  echo "<form action='cerinteActions.php?action=add' method='post'>";
                  echo "<input type='text' name='task_nou' placeholder='Introdu o nouă cerință'>";
                  echo "<input type='hidden' name='id_materie' value='" . $id_materie . "'>";
                  echo "<input type='hidden' name='id_profesor' value='" . $id_profesor . "'>";
                  echo "<input type='hidden' name='semigrupa' value='" . $semigrupa . "'>";
                  echo "<td><button type='submit'>Adaugă Cerință</button></td>";
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
            echo "<br>";
            echo "<b>Studenți din semigrupa " . htmlspecialchars($semigrupa) . "</b>";
            $sql_students = "SELECT s.id_student, s.nume, s.prenume, s.email, u.id_user, n.nota
                        FROM student s
                        LEFT JOIN users u ON s.email = u.email
                        LEFT JOIN note n ON s.id_student = n.id_student AND n.id_materie =$id_materie
                        WHERE s.grupa =$semigrupa";

              
            if ($stmt_students = $db->prepare($sql_students)) {
                $stmt_students;
                $stmt_students->execute();
                $result_students = $stmt_students->get_result();

              echo "<table border='2' style='width: 100%;'>";
              echo "<tr>";
              echo "<th style='width: 15%;'>Nume</th>";       // Set width to 15%
              echo "<th style='width: 15%;'>Prenume</th>";    // Set width to 15%
              echo "<th style='width: 20%;'>Email</th>";      // Set width to 20%
              echo "<th style='width: 20%;'>Nota</th>";       // Set width to 20%
              echo "<th style='width: 30%;'>Acțiuni</th>";    // Width already set to 30%
              echo "</tr>";
              while ($row_student = $result_students->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row_student['nume']) . "</td>";
                  echo "<td>" . htmlspecialchars($row_student['prenume']) . "</td>";
                  echo "<td><a href='mailto:" . htmlspecialchars($row_student['email']) . "'>" . htmlspecialchars($row_student['email']) . "</a></td>";
                  
                  // Adaugă coloana pentru nota, presupunând că există o variabilă disponibilă sau o logica suplimentară pentru a determina nota
                  if (isset($row_student['nota']) && !empty($row_student['nota'])) {
                          echo "<td style='text-align:center;'>" . htmlspecialchars($row_student['nota']);
                          echo "<form action='note_action.php' method='post'>";
                          echo "<input type='hidden' name='id_student' value='" . $row_student['id_student'] . "'>";
                          echo "<input type='hidden' name='id_materie' value='" . $id_materie . "'>";
                          echo "<input type='hidden' name='id_profesor' value='" . $id_profesor . "'>";
                          echo "<input type='hidden' name='semigrupa' value='" . $semigrupa . "'>";
                          echo "<input type='text' name='nota' placeholder='Introdu nota'>";
                          echo "<button type='submit' style='width: 95%;'>Noteaza</button>";
                          echo "</form></td>";
                  } else {
                      if (!empty($row_student['id_user'])) {
                          // Only show the grade form if the student is a registered user
                          echo "<td style='text-align:center;'><form action='note_action.php' method='post'>";
                          echo "<input type='hidden' name='id_student' value='" . $row_student['id_student'] . "'>";
                          echo "<input type='hidden' name='id_materie' value='" . $id_materie . "'>";
                          echo "<input type='hidden' name='id_profesor' value='" . $id_profesor . "'>";
                          echo "<input type='hidden' name='semigrupa' value='" . $semigrupa . "'>";
                          echo "<input type='text' name='nota' placeholder='Introdu nota'>";
                          echo "<button type='submit' style='width: 95%;'>Noteaza</button>";
                          echo "</form></td>";
                      } else {
                          // Display 'N/A' if the student is not a registered user
                          echo "<td style='text-align:center;'>N/A</td>";
                      }
                  }
                
                  // Coloana pentru butoane
                  echo "<td>";
                  if (!empty($row_student['id_user'])) {
                      // Dacă studentul este utilizator, arată butonul pentru arhive
                      echo "<form action='vizualizeazaArhive_prof.php' method='post' style='margin-bottom: 10px;'>";
                      echo "<input type='hidden' name='id_student' value='" . $row_student['id_student'] . "'>";
                      echo "<input type='hidden' name='id_materie' value='" . $id_materie . "'>";
                      echo "<button type='submit' style='width: 98%;'>Vezi Arhive</button>";
                      echo "</form>";
                  } else {
                      // Dacă nu este utilizator, afișează un chenar gri
                      echo "<span style='background-color: #ccc; padding: 5px; display: block; width: 100%; text-align: center;'>N/A</span>";
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