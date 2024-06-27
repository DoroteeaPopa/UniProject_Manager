<?php
include 'config.php';
$currentPage ='index_secretara_logged';

// Handle form submissions for students and professors
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'insert_student') {
            $nume = $_POST['nume'];
            $prenume = $_POST['prenume'];
            $specializare = $_POST['specializare'];
            $an = $_POST['an'];
            $email = $_POST['email'];
            $grupa = $_POST['grupa'];

            $sql = "INSERT INTO student (nume, prenume, specializare, an, email, grupa) VALUES ('$nume', '$prenume', '$specializare', $an, '$email', '$grupa')";
            $db->query($sql);
        } elseif ($_POST['action'] == 'edit_student') {
            $id_student = $_POST['id_student'];
            $nume = $_POST['nume'];
            $prenume = $_POST['prenume'];
            $specializare = $_POST['specializare'];
            $an = $_POST['an'];
            $email = $_POST['email'];
            $grupa = $_POST['grupa'];

            $sql = "UPDATE student SET nume='$nume', prenume='$prenume', specializare='$specializare', an=$an, email='$email', grupa='$grupa' WHERE id_student=$id_student";
            $db->query($sql);
        } elseif ($_POST['action'] == 'delete_student') {
            $id_student = $_POST['id_student'];
            $sql_email="SELECT * FROM student WHERE id_student=$id_student LIMIT 1";
            $result_email = $db->query($sql_email);
            $email_var = mysqli_fetch_assoc($result_email);
            $email=$email_var['email'];
            $sql_users = "SELECT * FROM users WHERE users.email = '$email'";
            $result_idUser = $db->query($sql_users);
            $id_user_var = mysqli_fetch_assoc($result_idUser);
            $id_user=$id_user_var['id_user'];

            $sql2 = "DELETE FROM users WHERE id_user=$id_user";
            $db->query($sql2);
            
            $sql = "DELETE FROM student WHERE id_student=$id_student";
            $db->query($sql);
        } elseif ($_POST['action'] == 'insert_profesor') {
            $id_profesor = $_POST['id_profesor'];
            $email = $_POST['email'];
            $coordonator = $_POST['coordonator'];

            $sql = "INSERT INTO profesori_depcie (id_profesor, email, coordonator) VALUES ($id_profesor, '$email', '$coordonator')";
            $db->query($sql);
        } elseif ($_POST['action'] == 'edit_profesor') {
            $id_profesor = $_POST['id_profesor'];
            $email = $_POST['email'];
            $coordonator = $_POST['coordonator'];

            $sql = "UPDATE profesori_depcie SET email='$email', coordonator='$coordonator' WHERE id_profesor=$id_profesor";
            $db->query($sql);
        } elseif ($_POST['action'] == 'delete_profesor') {
            $id_profesor = $_POST['id_profesor'];
            $sql_email="SELECT * FROM profesori_depcie WHERE id_profesor=$id_profesor LIMIT 1";
            $result_email = $db->query($sql_email);
            $email_var = mysqli_fetch_assoc($result_email);
            $email=$email_var['email'];
            $sql_users = "SELECT * FROM users WHERE users.email = '$email'";
            $result_idUser = $db->query($sql_users);
            $id_user_var = mysqli_fetch_assoc($result_idUser);
            $id_user=$id_user_var['id_user'];

            $sql2 = "DELETE FROM users WHERE id_user=$id_user";
            $db->query($sql2);


            $sql = "DELETE FROM profesori_depcie WHERE id_profesor=$id_profesor";
            $db->query($sql);
        }
    }
}

// Fetch students and apply sorting if selected
$sort_field = isset($_POST['sort']) ? $_POST['sort'] : 'id_student';
$sql_students = "SELECT * FROM student ORDER BY $sort_field";
$result_students = $db->query($sql_students);

// Fetch professors from departments 0 and 1
$sql_profesori = "SELECT * FROM profesori WHERE dep IN (0, 1)";
$result_profesori = $db->query($sql_profesori);

// Fetch details from profesori_depcie
$profesori_details = [];
$sql_profesori_depcie = "SELECT * FROM profesori_depcie";
$result_profesori_depcie = $db->query($sql_profesori_depcie);
while ($row = $result_profesori_depcie->fetch_assoc()) {
    $profesori_details[$row['id_profesor']] = $row;
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
  <link rel="stylesheet" href="header.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #f2f2f2;
    }
    tr:hover {
      background-color: #f5f5f5;
    }
    .btn-edit, .btn-delete, .btn-insert {
      margin: 2px;
    }
  </style>
</head>
<body>
<header>
  <nav>
    <ul>
      <li class="<?php if($currentPage =='index_secretara_logged'){echo 'active';}?>" ><a href="index_secretara_logged.php">Acasa</a></li>
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
<div class="container">
  <h2>Lista Studenților</h2>
  <form method="POST" action="" class="form-inline">
    <label for="sort">Sort by: </label>
    <select name="sort" id="sort" class="form-control form-control-inline">
      <option value="id_student" <?php if ($sort_field == 'id_student') echo 'selected'; ?>>ID</option>
      <option value="nume" <?php if ($sort_field == 'nume') echo 'selected'; ?>>Nume</option>
      <option value="specializare" <?php if ($sort_field == 'specializare') echo 'selected'; ?>>Specializare</option>
      <option value="an" <?php if ($sort_field == 'an') echo 'selected'; ?>>An</option>
      <option value="grupa" <?php if ($sort_field == 'grupa') echo 'selected'; ?>>Grupa</option>
    </select>
    <button type="submit" class="btn btn-primary">Sort</button>
  </form>
  <br>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>id_student</th>
        <th>nume</th>
        <th>prenume</th>
        <th>specializare</th>
        <th>an</th>
        <th>email</th>
        <th>grupa</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result_students->fetch_assoc()): ?>
      <tr>
        <form action="" method="post">
          <td><?php echo $row['id_student']; ?></td>
          <td><input type="text" name="nume" value="<?php echo $row['nume']; ?>" class="form-control"></td>
          <td><input type="text" name="prenume" value="<?php echo $row['prenume']; ?>" class="form-control"></td>
          <td><input type="text" name="specializare" value="<?php echo $row['specializare']; ?>" class="form-control"></td>
          <td><input type="text" name="an" value="<?php echo $row['an']; ?>" class="form-control"></td>
          <td><input type="text" name="email" value="<?php echo $row['email']; ?>" class="form-control"></td>
          <td><input type="text" name="grupa" value="<?php echo $row['grupa']; ?>" class="form-control"></td>
          <td>
            <input type="hidden" name="id_student" value="<?php echo $row['id_student']; ?>">
            <input type="hidden" name="action" value="edit_student">
            <button type="submit" class="btn btn-warning btn-edit">Editeaza</button>
          </td>
        </form>
        <form action="" method="post" style="display:inline;">
          <td>
            <input type="hidden" name="id_student" value="<?php echo $row['id_student']; ?>">
            <input type="hidden" name="action" value="delete_student">
            <button type="submit" class="btn btn-danger btn-delete" onclick="return confirm('Ești sigur că vrei să ștergi acest student?');">Sterge</button>
          </td>
        </form>
      </tr>
      <?php endwhile; ?>
      <tr>
        <form action="" method="post">
          <td></td>
          <td><input type="text" name="nume" class="form-control"></td>
          <td><input type="text" name="prenume" class="form-control"></td>
          <td><input type="text" name="specializare" class="form-control"></td>
          <td><input type="text" name="an" class="form-control"></td>
          <td><input type="text" name="email" class="form-control"></td>
          <td><input type="text" name="grupa" class="form-control"></td>
          <td>
            <input type="hidden" name="action" value="insert_student">
            <button type="submit" class="btn btn-primary btn-insert">Insereaza</button>
          </td>
        </form>
      </tr>
    </tbody>
  </table>
</div>

<div class="container">
  <h2>Lista Profesorilor</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>id_profesor</th>
        <th>nume</th>
        <th>dep</th>
        <th>email</th>
        <th>coordonator</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result_profesori->fetch_assoc()): ?>
      <tr>
        <form action="" method="post">
          <td><?php echo $row['id_profesor']; ?></td>
          <td><?php echo $row['nume']; ?></td>
          <td><?php echo $row['dep']; ?></td>
          <?php if (isset($profesori_details[$row['id_profesor']])): ?>
            <td><input type="text" name="email" value="<?php echo $profesori_details[$row['id_profesor']]['email']; ?>" class="form-control"></td>
            <td><input type="text" name="coordonator" value="<?php echo $profesori_details[$row['id_profesor']]['coordonator']; ?>" class="form-control"></td>
            <td>
              <input type="hidden" name="id_profesor" value="<?php echo $row['id_profesor']; ?>">
              <input type="hidden" name="action" value="edit_profesor">
              <button type="submit" class="btn btn-warning btn-edit">Editeaza</button>
            </td>
          <?php else: ?>
            <td><input type="text" name="email" class="form-control"></td>
            <td><input type="text" name="coordonator" class="form-control"></td>
            <td>
              <input type="hidden" name="id_profesor" value="<?php echo $row['id_profesor']; ?>">
              <input type="hidden" name="action" value="insert_profesor">
              <button type="submit" class="btn btn-primary btn-insert">Insereaza</button>
            </td>
          <?php endif; ?>
        </form>
        <form action="" method="post" style="display:inline;">
          <td>
            <input type="hidden" name="id_profesor" value="<?php echo $row['id_profesor']; ?>">
            <input type="hidden" name="action" value="delete_profesor">
            <button type="submit" class="btn btn-danger btn-delete" onclick="return confirm('Ești sigur că vrei să ștergi acest profesor?');">Sterge</button>
          </td>
        </form>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>

<?php $db->close(); ?>
