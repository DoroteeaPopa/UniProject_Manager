<!DOCTYPE html>
<html lang="en">
<head>
  <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">



</head>

<?php
session_start();
$x = $_SESSION['email'];
if (!(isset($_SESSION['login']))) {
    header("Location: index_prof_lgd.php");
    exit; // Adaugă exit pentru a opri executarea scriptului după redirecționare
}

$idStudent = $_POST['id_student'];
$idMaterie = $_POST['id_materie'];

?>

<?php
    $currentPage = 'proiecte_profesor';
    require_once "./header_prof_lgd.php"
?>
  
<br>



<body>





<?php
 include("config.php");
            $sql2 = "SELECT * FROM arhive WHERE id_student=$idStudent AND id_materie=$idMaterie ORDER BY data_incarcarii DESC";
            $result2 = $db->query($sql2);

            if ($result2) {
                echo "<table class='table table-striped'>"; // Folosește clase Bootstrap pentru stilizare
                echo "<thead>";
                echo "<tr>";
                echo "<th>Data Încărcării</th>";
                echo "<th>Arhivă</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                
                $resultArray = $result2->fetch_all(MYSQLI_ASSOC); // Preia toate rândurile odată
                $firstIndex = 0; 
            
                foreach ($resultArray as $index => $row) {
                    if ($index === $firstIndex) {
                        echo "<tr style='background-color: #e8f5e9;'>"; // Stil pentru ultimul rând
                    } else {
                        echo "<tr>";
                    }
                    echo "<td>" . $row['data_incarcarii'] . "</td>";
                    echo "<td><img src='image.png' alt='poza_arhiva'><a href='" . htmlspecialchars($row['arhiva']) . "'>" . basename($row['arhiva']) . "</a></td>";
                    echo "<td><button onclick='viewFiles(\"" . htmlspecialchars($row['arhiva']) . "\")'>View Files</button></td>";
                    echo "</tr>";
                }
                
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "Eroare la selectare: " . $db->error;
            }
        
?>

</body>


</html>