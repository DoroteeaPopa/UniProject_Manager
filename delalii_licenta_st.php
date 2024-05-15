<!DOCTYPE html>
<html lang="en">
<head>
  <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
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
            background-color: #f8f9fa;
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

<?php
session_start();
include("config.php");
$id_specializare=$_GET['id_specializare'];
$id_student=$_GET['id_student'];

$sql="SELECT tl.*, p.nume
FROM teme_licenta tl
JOIN profesori_depcie pd ON tl.id_profesor_depcie = pd.id_profesor_depcie
JOIN profesori p ON pd.id_profesor = p.id_profesor
WHERE tl.id_specializare = $id_specializare";
$result_teme=$db->query($sql);





?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sendRequest'])) {
    $id_tema = $_POST['id_tema'];
    $id_specializare = $_POST['id_specializare'];
    $id_student = $_POST['id_student'];

    $sql = "INSERT INTO cereri_teme (id_tema, id_specializare, id_student) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("iii", $id_tema, $id_specializare, $id_student);
    $stmt->execute();
    $stmt->close();
    $id_specializare = $_POST['id_specializare'];
    header("Location: delalii_licenta_st.php?id_specializare=$id_specializare&id_student=$id_student");

}

?>

<div style="padding:20px;" class="container mt-5">
<?php

    $sql3="SELECT * FROM cereri_teme WHERE id_student=$id_student";
    $result_acceptare=$db->query($sql3);
    $acceptare = mysqli_fetch_assoc($result_acceptare);


    if (isset($_GET['id_student']) && isset($_GET['id_specializare'])) {
        if ($acceptare != null && $acceptare['acceptat'] != 1) {//daca am o cerere si e in asteptare sau e acceptata
            $id_tema = $acceptare['id_tema'];
            $sql_tema = "SELECT tema, id_profesor_depcie FROM teme_licenta WHERE id_tema = $id_tema";
            $result_tema = $db->query($sql_tema);
            $tema = mysqli_fetch_assoc($result_tema);

            // Obținerea detaliilor profesorului folosind id_profesor_depcie pentru a lega la tabelul profesor
            $id_profesor_depcie = $tema['id_profesor_depcie'];
            $sql_profesor = "SELECT * FROM profesori 
            JOIN profesori_depcie ON profesori_depcie.id_profesor=profesori.id_profesor
            WHERE profesori.id_profesor = (SELECT id_profesor FROM profesori_depcie WHERE profesori_depcie.id_profesor_depcie = $id_profesor_depcie)";
            $result_profesor = $db->query($sql_profesor);
            $profesor = mysqli_fetch_assoc($result_profesor);
            if($acceptare['acceptat']==0){     //in asteptare     
                echo "<div style='text-align: center;'><h2>Licenta</h2>";
                echo "<br><span style='margin-right: 16px;'><strong>Tema:</strong> " . htmlspecialchars($tema['tema']). "</span>" ;
                echo "<br><span style='margin-right: 16px;'><strong>Profesor:</strong> " . htmlspecialchars($profesor['nume']). "</span>";
                echo "<br><span style='margin-right: 16px;'><strong>Email profesor:</strong> " ;
                    echo " <a href='mailto:" . htmlspecialchars($profesor['email']) . "'>" . htmlspecialchars($profesor['email']) . "</a>";
                echo "<br><span style='margin-right: 16px;'><strong>Status:</strong> " . "In asteptare". "</span><br></br>" ;
                echo "</div>";
            }
            else{
                echo "<div style='text-align: center;'><h2>Licenta</h2>";
                echo "<br><span style='margin-right: 16px;'><strong>Tema:</strong> " . htmlspecialchars($tema['tema']). "</span>" ;
                echo "<br><span style='margin-right: 16px;'><strong>Profesor:</strong> " . htmlspecialchars($profesor['nume']). "</span>";
                echo "<br><span style='margin-right: 16px;'><strong>Email profesor:</strong> " ;
                echo " <a href='mailto:" . htmlspecialchars($profesor['email']) . "'>" . htmlspecialchars($profesor['email']) . "</a>";
                echo "<br><span style='margin-right: 16px;'><strong>Status:</strong> " . "Acceptata". "</span><br></br>" ;
                echo "<form action='incarcaFisier_action.php' method='post' enctype='multipart/form-data'>";
                echo "<input type='hidden' name='id_student' value='" . htmlspecialchars($id_student) . "'>";
                echo "<input type='hidden' name='id_tema' value='" . htmlspecialchars($id_tema) . "'>";
                echo "<input type='hidden' name='id_specializare' value='" . htmlspecialchars($id_specializare) . "'>";
                echo "<input type='file' name='uploadedFile' accept='.zip,.rar,.7z' id='fileInput' style='display: none;' onchange='this.form.submit()'>";
                echo "<label for='fileInput' class='custom-file-upload btn btn-custom-gray'>Selectează și încarcă fișierul</label>";
                echo "</form>";
                echo "</div>";

            $sql2 = "SELECT * FROM arhive WHERE id_student=$id_student AND id_materie=$id_tema AND licenta=1 ORDER BY data_incarcarii DESC";
            $result2 = $db->query($sql2);

            if ($result2) {
                echo "<table class='table table-striped'>"; 
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

                echo "<form method='post'>";
                foreach ($resultArray as $index => $row) {
                    if ($index === $firstIndex) {
                        echo "<tr style='background-color: #e8f5e9;'>"; // Stil pentru ultimul rând
                    } else {
                        echo "<tr>";
                    }
                    echo "<td>" . $row['data_incarcarii'] . "</td>";
                    echo "<td><img src='image.png' alt='poza_arhiva'><a href='" . htmlspecialchars($row['arhiva']) . "'>" . basename($row['arhiva']) . "</a></td>";
                    echo "<td></td>";
                    echo "</tr>";
                }
                echo "<input type='hidden' name='id_student' value='" . htmlspecialchars($id_student) . "'>";
                echo "<input type='hidden' name='id_specializare' value='" . htmlspecialchars($id_specializare) . "'>";
                echo "</form>"; 
                echo "</tbody>";
                echo "</table>";
        } else {
                echo "Eroare la selectare: " . $db->error;
        }
            }
        }
        else{//daca nu am cerere trimisa sau am cerere neacceptata
        echo "<div style='text-align: center;'><h2>Licenta</h2></div>";
        echo "<table border='2' style='width: 100%;'>";
        echo "<tr>";
        echo "<th style='width: 15%;'>Profesor</th>";      
        echo "<th style='width: 35%;'>Tema</th>";    
        echo "<th style='width: 10%;'>Locuri ocupate</th>";      
        echo "<th style='width: 10%;'>Locuri disponibile</th>";      
        echo "<th style='width: 30%;'>Acțiuni</th>";   
        echo "</tr>";
            while (($details = mysqli_fetch_assoc($result_teme))) {
                $id_profesor_depcie=$details['id_profesor_depcie'];
                $sql2="SELECT * FROM locuri WHERE id_specializare=$id_specializare AND id_profesor_depcie=$id_profesor_depcie";
                $result_locuri=$db->query($sql2);
                $locuri = mysqli_fetch_assoc($result_locuri);
                $locuri_ocupate=$locuri['locuri_ocupate'];
                $locuri_disponibile=$locuri['locuri_disponibile'];
                echo "<tr>";
                echo "<td>" . htmlspecialchars($details['nume']) . "</td>";
                echo "<td>" . htmlspecialchars($details['tema']) . "</td>";
                echo "<td>" . htmlspecialchars($locuri_ocupate) . "</td>";
                echo "<td>" . htmlspecialchars($locuri_disponibile) . "</td>";

                
                echo "<td style='padding: 10px;'>";// n am cerere sau e refuzata
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='id_tema' value='" . $details['id_tema'] . "'>";
                echo "<input type='hidden' name='id_specializare' value='" . $id_specializare . "'>";
                echo "<input type='hidden' name='id_student' value='" . $id_student . "'>";
                echo "<button type='submit' name='sendRequest'>Trimite cerere</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }        
                  
        }
        
    }

?>
</div>


</body>
</html>