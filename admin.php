<?php
include 'config.php';
$currentPage = 'admin_page';

// Handle form submissions for students, professors, and secretary
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'edit_student') {
            $id_student = $_POST['id_student'];
            $nume = $_POST['nume'];
            $prenume = $_POST['prenume'];
            $specializare = $_POST['specializare'];
            $an = $_POST['an'];
            $email = $_POST['email'];
            $grupa = $_POST['grupa'];

            $sql = "UPDATE student SET nume='$nume', prenume='$prenume', specializare='$specializare', an=$an, email='$email', grupa='$grupa' WHERE id_student=$id_student";
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

            $sql = "DELETE FROM profesori_depcie WHERE id_profesor=$id_profesor";
            $db->query($sql);
        } elseif ($_POST['action'] == 'change_year') {
            $sql_students = "SELECT id_student, grupa FROM student";
            $result_students = $db->query($sql_students);

            while ($row = $result_students->fetch_assoc()) {
                $id_student = $row['id_student'];
                $grupa = $row['grupa'];

                // Extract the numeric year from the grupa string (e.g., 211/1 -> 2)
                preg_match('/(\d)(\d)(\d\/\d)/', $grupa, $matches);

                if ($matches) {
                    $year = (int)$matches[2]; // Get the second digit as the year
                    if ($year < 4) {
                        $year++;
                        $new_grupa = $matches[1] . $year . $matches[3];

                        // Update the grupa in the database
                        $sql_update = "UPDATE student SET grupa='$new_grupa' WHERE id_student=$id_student";
                        $db->query($sql_update);
                    }
                }
            }
        } elseif ($_POST['action'] == 'edit_secretary') {
            $id_management = $_POST['id_management'];
            $nume = $_POST['nume'];
            $prenume = $_POST['prenume'];

            $sql = "UPDATE management SET nume='$nume', prenume='$prenume' WHERE id_management=$id_management";
            $db->query($sql);
        }
    }
}

// Fetch students and apply sorting if selected
$sort_field = isset($_POST['sort']) ? $_POST['sort'] : 'grupa';
$sql_students = "SELECT * FROM student LEFT JOIN specializare ON specializare.id_specializare=student.specializare ORDER BY $sort_field";
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

// Fetch secretary details
$sql_secretary = "SELECT * FROM management WHERE rol='secretara' LIMIT 1";
$result_secretary = $db->query($sql_secretary);
$secretary = $result_secretary->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>UniProject Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
    .btn-edit, .btn-delete, .btn-insert, .btn-change-year {
      margin: 2px;
    }
  </style>
</head>
<body>
<header>
  <nav>
    <ul>
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
  <h2>Student List</h2>
  <form method="POST" action="" class="form-inline">
    <button type="submit" name="action" value="change_year" class="btn btn-primary btn-change-year">Schimba Anul</button>
  </form>
  <br>
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
          <td><input type="text" name="specializare" value="<?php echo $row['denumire']; ?>" class="form-control"></td>
          <td><input type="text" name="an" value="<?php echo $row['an']; ?>" class="form-control"></td>
          <td><input type="text" name="email" value="<?php echo $row['email']; ?>" class="form-control"></td>
          <td><input type="text" name="grupa" value="<?php echo $row['grupa']; ?>" class="form-control"></td>
          <td>
            <input type="hidden" name="id_student" value="<?php echo $row['id_student']; ?>">
            <input type="hidden" name="action" value="edit_student">
            <button type="submit" class="btn btn-warning btn-edit">Editeaza</button>
          </td>
        </form>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <h2>Secretary Details</h2>
  <form method="POST" action="">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>nume</th>
          <th>prenume</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><input type="text" name="nume" value="<?php echo $secretary['nume']; ?>" class="form-control"></td>
          <td><input type="text" name="prenume" value="<?php echo $secretary['prenume']; ?>" class="form-control"></td>
          <td>
            <input type="hidden" name="id_management" value="<?php echo $secretary['id_management']; ?>">
            <input type="hidden" name="action" value="edit_secretary">
            <button type="submit" class="btn btn-warning btn-edit">Editeaza</button>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
</body>
</html>

<?php $db->close(); ?>
