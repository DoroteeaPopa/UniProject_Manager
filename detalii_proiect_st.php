<!DOCTYPE html>
<html lang="en">
<head>
  <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="proiecte.css">

</head>
<body>

<?php
    $currentPage = 'detalii_proiect_st';
    require_once "./header_lgd.php"
?>


<style>
        #archiveInput {
            display: none;  /* Ascunde input-ul original */
        }

        .centered-container {
            margin: 0 auto;
            width: 70%;
            padding: 20px;
            background-color: #ececec;
            border-radius: 8px;
            box-shadow: 0 6px 10px rgba(0,0,0,0.1);
        }

        .custom-file-upload {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            display: inline-block;
            margin-top: 10px;
        }

        .custom-file-upload:hover {
            background-color: #0056b3;
        }

        .btn-custom-gray {
        background-color: #6c757d; /* A standard gray color */
        color: white; /* White text color */
        border: 1px solid #6c757d; /* Gray border */
        }

        .btn-custom-gray:hover, .btn-custom-gray:focus {
            background-color: #5a6268; /* A darker shade of gray for hover state */
            border-color: #545b62; /* Darker border on hover */
        }
    
        h2 {
        color: #0D3165; /* Deep blue for headings */
        border-bottom: 2px solid #f8f8f8; /* Subtle underline */
        padding-bottom: 10px;
        }

</style>
<?PHP
session_start();
include("config.php");
$x = $_SESSION['email'];
if (!(isset($_SESSION['login']))) {
header ("Location: index.php");
}
//pt cazul de else la detalii proiect
$sql = "SELECT * FROM student CROSS JOIN specializare ON student.specializare=specializare.id_specializare WHERE student.email = '$x'";
$result = $db->query($sql);
$developer = mysqli_fetch_assoc($result);
$specializare=$developer['denumire'];
$id_specializare=$developer['id_specializare'];
$id_student=$developer['id_student'];
$an_curent=$developer['an'];


if($specializare=='Tehnologia Informatiei'){
  $sql3 ="SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') 
          AND orar.id_tip='4' 
          AND (nivele_seri.nume_ns='214/1' OR nivele_seri.nume_ns='224/1' OR nivele_seri.nume_ns='233/1' OR nivele_seri.nume_ns='243/1' OR nivele_seri.nume_ns='233')
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
  else if($specializare=='EM'){
    $sql3 ="SELECT* 
      FROM orar 
      CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
      CROSS JOIN materi ON orar.id_materie=materi.id_materie 
      CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
      WHERE (profesori.dep='0' OR profesori.dep='1') 
            AND orar.id_tip='4' 
            AND (nivele_seri.nume_ns='311/1' OR nivele_seri.nume_ns='321/1' OR nivele_seri.nume_ns='331/1' OR nivele_seri.nume_ns='341/1')
      ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
  
  }
  else if($specializare=='EA'){
    $sql3 ="SELECT* 
      FROM orar 
      CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
      CROSS JOIN materi ON orar.id_materie=materi.id_materie 
      CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
      WHERE (profesori.dep='0' OR profesori.dep='1') 
            AND orar.id_tip='4' 
            AND (nivele_seri.nume_ns='312/1' OR nivele_seri.nume_ns='322/1' OR nivele_seri.nume_ns='332/1' OR nivele_seri.nume_ns='342/1')
      ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
  
  }
  else if($specializare=='mACS'){
    $sql3 = "SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' AND nivele_seri.nume_ns='An_I_mACS'   
    ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
  }
  else if($specializare=='mES'){
    $sql3 = "SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' AND nivele_seri.nume_ns='An_I_mES'   
    ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
  }
  else if($specializare=='mICAI'){
    $sql3 = "SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' AND (nivele_seri.nume_ns='An_I_mICAI' OR nivele_seri.nume_ns='An_II_mICAI')
    ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
  }
  else if($specializare=='mAAIE'){
    $sql3 = "SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' AND nivele_seri.nume_ns='An_I_mAAIE'   
    ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
  }

$db->close();?>


<?php
include("config.php");
function fetchAllTaskIds() {
    global $db; 

    $task_ids = [];
    $sql = "SELECT id_cerinte FROM cerinte"; // Query to get all task IDs

    if ($result = $db->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $task_ids[] = $row['id_cerinte']; // Add each ID to the array
        }
        $result->close();
    }

    return $task_ids; // Return the array of task IDs
}


function updateTasks($tasks, $all_task_ids) {
    global $db;
    foreach ($all_task_ids as $task_id) {
        $completion_status = isset($tasks[$task_id]) ? 1 : 0;  // Check if the checkbox was checked
        $sql_update = "UPDATE cerinte SET indeplinire = ? WHERE id_cerinte = ?";   
        if ($stmt_update = $db->prepare($sql_update)) {
            $stmt_update->bind_param("ii", $completion_status, $task_id);
            $stmt_update->execute();
            $stmt_update->close();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateTasks'])) {
    // Assuming you have a function to get all task IDs that could have been in the form
    $all_task_ids = fetchAllTaskIds();  // You need to implement this function
    updateTasks($_POST['task'] ?? [], $all_task_ids);
}


?>




<div style="padding:20px;">
    <?php
    if (isset($_GET['id_materie']) && isset($_GET['id_student'])) {//daca am selectat un proiect
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

        $sql_cerinte = "SELECT * FROM cerinte 
        CROSS JOIN taskuri ON cerinte.id_task = taskuri.id_task
        WHERE cerinte.id_materie = $id_materie AND cerinte.id_student = $id_student";
        $result_cerinte = $db->query($sql_cerinte);
  

        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param("i", $id_materie);
            $stmt->execute();
            $result = $stmt->get_result();
            $details = $result->fetch_assoc();
            

            if ($details) {
                // Display the details if available
                // After fetching professor details
                $id_profesor = $details['id_profesor'];
                $sql_emailprof = "SELECT email FROM profesori_depcie WHERE id_profesor =$id_profesor";
                if ($stmt_email = $db->prepare($sql_emailprof)) {
                    $stmt_email->execute();
                    $result_email = $stmt_email->get_result();
                    $email_prof = $result_email->fetch_assoc();

                    // Now display the details along with the email link
                    echo "<div style='text-align: center;'><h2>" . htmlspecialchars($details['materie']). "</h2><br>";
                    echo "<span style='margin-right: 16px;'><strong>Profesor:</strong> " . htmlspecialchars($details['nume']). "</span>";
                    echo "<span style='margin-right: 16px;'><strong>Email profesor:</strong> " ;
                    if ($email_prof && !empty($email_prof['email'])) {
                        echo " <a href='mailto:" . htmlspecialchars($email_prof['email']) . "'>" . htmlspecialchars($email_prof['email']) . "</a>";
                    }
                    echo "</span>";
                    echo "<span style='margin-right: 16px;'><strong>An de studiu:</strong> " . htmlspecialchars($details['id_an']) . "</span>";
                    echo "<span style='margin-right: 16px;'><strong>Semestru:</strong> " . htmlspecialchars($details['sem']) . "</span></div><br>";
                    
                    // Close statement
                    $stmt_email->close();
                } else {
                    echo "Failed to prepare the SQL statement to fetch professor's email.";
                }?>
            <div class="centered-container">
                <h4>Cerinte de proiect</h4>
                <form action="" method="post">
                    <?php
                    while ($row = mysqli_fetch_assoc($result_cerinte)) {
                        $checked = $row['indeplinire'] == 1 ? 'checked' : '';
                        echo "<div class='form-check'>";
                        echo "<input class='form-check-input' type='checkbox' name='task[" . $row['id_cerinte'] . "]' value='1' $checked>";
                        echo "<label class='form-check-label'>" . htmlspecialchars($row['task']) . "</label>";
                        echo "</div>";
                    }
                    ?>
                    <button type="submit" name="updateTasks" class="btn btn-primary" style="width:21%; background-color: green;">Actualizează Progres</button>
                </form>
            </div>
            <br>
            <div class="centered-container">
                <form action="incarcaFisier_action.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <h4 for="uploadedFile">Selectează fișier</h4>
                        <input type="file" class="form-control" id="uploadedFile" name="uploadedFile" required>
                    </div>
                    <div class="form-group">
                        <h4 for="description">Adaugă descriere</h4>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <input type="hidden" name="id_student" value="<?php echo htmlspecialchars($id_student); ?>">
                    <input type="hidden" name="materie" value="<?php echo htmlspecialchars($id_materie); ?>">
                    <button type="submit" class="btn btn-primary" style="width:21%; background-color: green;">Încarcă Fișier</button>
                </form>
            </div>
            <br><br>
            <?php
            }
            else {
                echo "<p>Nu s-au găsit detalii pentru materia specificată.</p>";
            }
            $stmt->close();
        }

        $sql2 = "SELECT * FROM arhive WHERE id_student=$id_student AND id_materie=$id_materie AND licenta=0 ORDER BY data_incarcarii DESC";
        $result2 = $db->query($sql2);

        if ($result2) {
            echo "<table class='table table-striped'>"; // Folosește clase Bootstrap pentru stilizare
            echo "<thead>";
            echo "<tr>";
            echo "<th>Data Încărcării</th>";
            echo "<th>Arhivă</th>";
            echo "<th>Descriere</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            $resultArray = $result2->fetch_all(MYSQLI_ASSOC); // Preia toate rândurile odată
            $firstIndex = 0; // Indexul ultimului element
        
            foreach ($resultArray as $index => $row) {
                if ($index === $firstIndex) {
                    echo "<tr style='background-color: #e8f5e9;'>"; // Stil pentru ultimul rând
                } else {
                    echo "<tr>";
                }
                echo "<td>" . $row['data_incarcarii'] . "</td>";
                echo "<td><img src='image.png' alt='poza_arhiva'><a href='" . htmlspecialchars($row['arhiva']) . "'>" . basename($row['arhiva']) . "</a></td>";
                echo "<td>" . $row['descriere'] . "</td>";
                echo "</tr>";
            }
            
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "Eroare la selectare: " . $db->error;
        }
    } else {// daca nu am selectat un proiect, le afiseaza cerintele la toate

  

        if ($result3 != null) {
            while ($details= mysqli_fetch_assoc($result3)) {
                echo "<div style='margin-bottom: 100px;'>";
                $id_materie=$details['id_materie'];
                $sql_cerinte = "SELECT * FROM cerinte 
                CROSS JOIN taskuri ON cerinte.id_task = taskuri.id_task
                WHERE cerinte.id_materie = $id_materie AND cerinte.id_student = 3";

            
                $result_cerinte = $db->query($sql_cerinte);

                $id_profesor = $details['id_profesor'];
                $sql_emailprof = "SELECT email FROM profesori_depcie WHERE id_profesor =$id_profesor";
                if ($stmt_email = $db->prepare($sql_emailprof)) {
                    $stmt_email->execute();
                    $result_email = $stmt_email->get_result();
                    $email_prof = $result_email->fetch_assoc();

                    // Now display the details along with the email link
                    echo "<div style='text-align: center;'><h2>" . htmlspecialchars($details['materie']). "</h2><br>";
                    echo "<span style='margin-right: 16px;'><strong>Profesor:</strong> " . htmlspecialchars($details['nume']). "</span>";
                    echo "<span style='margin-right: 16px;'><strong>Email profesor:</strong> " ;
                    if ($email_prof && !empty($email_prof['email'])) {
                        echo " <a href='mailto:" . htmlspecialchars($email_prof['email']) . "'>" . htmlspecialchars($email_prof['email']) . "</a>";
                    }
                    echo "</span>";
                    echo "<span style='margin-right: 16px;'><strong>An de studiu:</strong> " . htmlspecialchars($details['id_an']) . "</span>";
                    echo "<span style='margin-right: 16px;'><strong>Semestru:</strong> " . htmlspecialchars($details['sem']) . "</span></div><br>";
                    
                    // Close statement
                    $stmt_email->close();
                } else {
                    echo "Failed to prepare the SQL statement to fetch professor's email.";
                }?>
                <div class="centered-container">
                <h4 style="text-align: center;">Cerinte de proiect</h4>
                <form action="" method="post">
                    <?php
                    while ($row = mysqli_fetch_assoc($result_cerinte)) {
                        $checked = $row['indeplinire'] == 1 ? 'checked' : '';
                        echo "<div class='form-check'>";
                        echo "<input class='form-check-input' type='checkbox' name='task[" . $row['id_cerinte'] . "]' value='1' $checked>";
                        echo "<label class='form-check-label'>" . htmlspecialchars($row['task']) . "</label>";
                        echo "</div>";
                    }
                    ?>
                    <button type="submit" name="updateTasks" class="btn btn-primary" style="width:21%">Actualizează Progres</button>
                </form>
        
                </div>
            <?php
             echo "</div>";
            }

        }    
    }

    // Close the database connection
    $db->close();
    ?>
</div>

</body>
</html> 