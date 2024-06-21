<?php
session_start();
$x = $_SESSION['email'];
if (!(isset($_SESSION['login']))) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
.custom-table {
    border-collapse: separate; /* Asigură că `border-radius` funcționează corect */
    border-spacing: 0; /* Elimină spațiul între celule */
    width: 100%; /* Lățimea tabelului */
    border: 1px solid #ccc; /* Adaugă o bordură subtilă pentru a defini mai bine tabelul */
    border-radius: 10px; /* Rotunjirea colțurilor tabelului */
    overflow: hidden; /* Ascunde conținutul care depășește curba */
}

.custom-table th, .custom-table td {
    border: 1px solid #ccc; /* Bordură pentru celule */
    padding: 8px; /* Spațiu în interiorul celulelor */
    text-align: left; /* Alinează textul la stânga */
}

.custom-table thead {
    background-color: #0D3165 !important; /* Culoare de fundal pentru antetul tabelului */
    color: #ffffff !important; /* Culoarea textului în antet */
}

.custom-table tbody {
    background-color: #add8e6 !important; /* Culoare de fundal pentru corpul tabelului */
}

  </style>
</head>
<body>

<?php
include("config.php");
$sql = "SELECT * FROM student CROSS JOIN specializare ON student.specializare=specializare.id_specializare WHERE student.email = '$x'";
$result = $db->query($sql);

$sql2 = "SELECT * FROM users WHERE users.email = '$x'";
$result2 = $db->query($sql2);

$developer = mysqli_fetch_assoc($result);
$specializare = $developer['denumire'];

if ($specializare == 'Tehnologia Informatiei') {
    $sql3 = "SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') 
          AND orar.id_tip='4' 
          AND (nivele_seri.nume_ns='214/1' OR nivele_seri.nume_ns='224/1' OR nivele_seri.nume_ns='233/1' OR nivele_seri.nume_ns='243/1')
    ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
} elseif ($specializare == 'ISM') {
    $sql3 = "SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') 
          AND orar.id_tip='4' 
          AND (nivele_seri.nume_ns='216/1' OR nivele_seri.nume_ns='225/1' OR nivele_seri.nume_ns='234/1' OR nivele_seri.nume_ns='244/1')
    ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
} elseif ($specializare == 'C') {
    $sql3 = "SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') 
          AND orar.id_tip='4' 
          AND (nivele_seri.nume_ns='211/1' OR nivele_seri.nume_ns='221/1' OR nivele_seri.nume_ns='231/1' OR nivele_seri.nume_ns='241/1')
    ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
} elseif ($specializare == 'EM') {
    $sql3 = "SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') 
          AND orar.id_tip='4' 
          AND (nivele_seri.nume_ns='311/1' OR nivele_seri.nume_ns='321/1' OR nivele_seri.nume_ns='331/1' OR nivele_seri.nume_ns='341/1')
    ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
} elseif ($specializare == 'EA') {
    $sql3 = "SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') 
          AND orar.id_tip='4' 
          AND (nivele_seri.nume_ns='312/1' OR nivele_seri.nume_ns='322/1' OR nivele_seri.nume_ns='332/1' OR nivele_seri.nume_ns='342/1')
    ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
} elseif ($specializare == 'mACS') {
    $sql3 = "SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' AND nivele_seri.nume_ns='An_I_mACS'   
    ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
} elseif ($specializare == 'mES') {
    $sql3 = "SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' AND nivele_seri.nume_ns='An_I_mES'   
    ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
} elseif ($specializare == 'mICAI') {
    $sql3 = "SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' AND (nivele_seri.nume_ns='An_I_mICAI' OR nivele_seri.nume_ns='An_II_mICAI')
    ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
} elseif ($specializare == 'mAAIE') {
    $sql3 = "SELECT* 
    FROM orar 
    CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
    CROSS JOIN materi ON orar.id_materie=materi.id_materie 
    CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
    WHERE (profesori.dep='0' OR profesori.dep='1') AND orar.id_tip='4' AND nivele_seri.nume_ns='An_I_mAAIE'   
    ORDER BY materi.id_an, nume";
    $result3 = $db->query($sql3);
}
?>

<body>

<?php
    $currentPage = 'index_lgd';
    require_once "./header_lgd.php"
?>

<div style="margin-top:30px; ">
  <table class="custom-table" style="width: 25%; float: left;">
    <thead>
      <tr>
        <th>Username</th>
        <?php while ($developer = mysqli_fetch_assoc($result2)) { ?>
          <th><?php echo $developer['username']; ?></th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php mysqli_data_seek($result, 0); // repune cursorul la începutul rezultatelor ?>
      <?php while ($developer = mysqli_fetch_assoc($result)) { 
        $id_student = $developer['id_student']; ?>
        <tr id="<?php echo $developer['id_student']; ?>">   
          <td>Specializare</td>
          <td><?php echo $developer['denumire']; ?></td>
        </tr>
        <tr>
          <td>Nume</td>
          <td><?php echo $developer['nume']; ?></td>
        </tr>
        <tr>
          <td>Prenume</td>
          <td><?php echo $developer['prenume']; ?></td>
        </tr>
        <tr>
          <td>Email</td>
          <td><?php echo $developer['email']; ?></td>
        </tr>
        <tr>
          <td>An</td>
          <td><?php echo $developer['an']; ?></td>
        </tr>
        <tr>
          <td>Semigrupa</td>
          <td><?php echo $developer['grupa']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<div style="float: right; width: 70%;">
  <table class="custom-table">
    <thead>
      <tr>
        <th>Profesor</th>
        <th>Materie</th>
        <th>An</th>
        <th>Semestru</th>
        <th>Nota</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($developer = mysqli_fetch_assoc($result3)) { 
        $id_materie = $developer['id_materie'];
        $sql_note = "SELECT nota FROM note WHERE id_student = $id_student AND id_materie = $id_materie";
        $stmt_note = $db->prepare($sql_note);
        
        if ($stmt_note) {
            $stmt_note->execute();
            $result_note = $stmt_note->get_result();

            // Fetch the result
            $nota = mysqli_fetch_assoc($result_note);
            $grade = ($nota && $nota['nota'] != 0) ? $nota['nota'] : 'N/A';   // Check if nota exists and set a default value if not

            ?>
            <tr id="<?php echo htmlspecialchars($developer['id_orar']); ?>">   
                <td><?php echo htmlspecialchars($developer['nume']); ?></td>
                <td><?php echo htmlspecialchars($developer['materie']); ?></td>
                <td><?php echo htmlspecialchars($developer['id_an']); ?></td>
                <td><?php echo htmlspecialchars($developer['sem']); ?></td>
                <td><?php echo htmlspecialchars($grade); ?></td>
            </tr>
            <?php 
            // Close the prepared statement
            $stmt_note->close();
        } else {
            echo "Failed to prepare the SQL statement.";
        } 
      } 
      $db->close();
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
