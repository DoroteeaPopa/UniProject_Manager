<!DOCTYPE html>
<html lang="en">
<head>
  <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="header.css">


</head>


<body>

<?php
$currentPage ='licenta_secretariat';
?>

<header>
  <nav>
    
    <ul>
        
        <li class="<?php if($currentPage == 'index_secretara_lgd') { echo 'active'; } ?>"><a href="index_secretara_logged.php">Acasa</a></li>
        <li class="<?php if($currentPage =='licenta_secretariat'){echo 'active';}?>" ><a href="licenta_secretariat.php">Licenta</a></li>
        <li style="float:right">
            <form action="logout.php" method="post">
                 <button type="submit" style="width:auto;">Logout</button>
            </form>
        </li>
    </ul>
    
    <div class="header">
        <h1>UniProject Manager</h1>
        <img src="logoUlbs.jpg" alt="logo">
    </div>
    
  </nav>
</header>

<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  h2 {
    color: #0D3165;
    border-bottom: 2px solid #f8f8f8;
    padding-bottom: 10px;
  }

  table {
    width: 100%;
    background-color: #ffffff;
    border-collapse: collapse;
    margin-top: 20px;
  }

  th, td {
    border: 1px solid #dee2e6;
    padding: 8px;
    text-align: left;
  }

  th {
    background-color: #f8f8f8;
  }

  td {
    background-color: #FAFAFA;
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
session_start();
include("config.php");

$sql_accepted_students = "
    SELECT 
        student.nume AS student_nume, 
        student.prenume AS student_prenume, 
        student.email AS student_email, 
        specializare.denumire AS specializare_denumire, 
        teme_licenta.tema AS tema_licenta, 
        profesori.nume AS profesor_nume
    FROM cereri_teme
    JOIN student ON cereri_teme.id_student = student.id_student
    JOIN specializare ON cereri_teme.id_specializare = specializare.id_specializare
    JOIN teme_licenta ON cereri_teme.id_tema = teme_licenta.id_tema
    JOIN profesori_depcie ON teme_licenta.id_profesor_depcie = profesori_depcie.id_profesor_depcie
    JOIN profesori ON profesori_depcie.id_profesor = profesori.id_profesor
    WHERE cereri_teme.acceptat = 2
";
$result_accepted_students = $db->query($sql_accepted_students);
?>

<div class="container">
  <h2>Studenti Inscrisi si Temele lor de Licenta</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Nume Student</th>
        <th>Email Student</th>
        <th>Specializare</th>
        <th>Tema Licenta</th>
        <th>Nume Profesor</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result_accepted_students->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['student_nume'] . ' ' . htmlspecialchars($row['student_prenume'])); ?></td>
        <td><a href="mailto:<?php echo htmlspecialchars($row['student_email']); ?>"><?php echo htmlspecialchars($row['student_email']); ?></a></td>
        <td><?php echo htmlspecialchars($row['specializare_denumire']); ?></td>
        <td><?php echo htmlspecialchars($row['tema_licenta']); ?></td>
        <td><?php echo htmlspecialchars($row['profesor_nume']); ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>


</body>
</html>