<?php
session_start();
include("config.php");  // Make sure you include your database configuration file

// Check if the necessary POST data is available
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nota'], $_POST['id_student'], $_POST['id_materie'])) {
    $id_student = $_POST['id_student'];
    $id_materie = $_POST['id_materie'];
    $id_profesor = $_POST['id_profesor'] ?? null;
    $semigrupa = $_POST['semigrupa'];
    $nota = $_POST['nota'];

    // Check if an entry already exists
    $check_sql = "SELECT id_nota FROM note WHERE id_student = ? AND id_materie = ?";
    if ($check_stmt = $db->prepare($check_sql)) {
        $check_stmt->bind_param("ii", $id_student, $id_materie);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // Update existing record
            $update_sql = "UPDATE note SET nota = ? WHERE id_student = ? AND id_materie = ?";
            if ($update_stmt = $db->prepare($update_sql)) {
                $update_stmt->bind_param("dii", $nota, $id_student, $id_materie);
                $update_stmt->execute();
                $update_stmt->close();
                if($id_profesor){
                header("Location: detalii_proiect_prof.php?id_materie=$id_materie&id_profesor=$id_profesor&semigrupa=$semigrupa"); // Redirect după operație
                exit;
                }
                else{
                header("Location: detalii_proiect_prof.php");                }
            } else {
                echo "Error preparing update statement: " . $db->error;
            }
        } else {
            // Insert new record
            $insert_sql = "INSERT INTO note (id_student, id_materie, nota) VALUES (?, ?, ?)";
            if ($insert_stmt = $db->prepare($insert_sql)) {
                $insert_stmt->bind_param("iid", $id_student, $id_materie, $nota);
                $insert_stmt->execute();
                header("Location: detalii_proiect_prof.php?id_materie=$id_materie&id_profesor=$id_profesor&semigrupa=$semigrupa"); // Redirect după operație
                exit;
                $insert_stmt->close();
            } else {
                echo "Error preparing insert statement: " . $db->error;
            }
        }
        $check_stmt->close();
    } else {
        echo "Error preparing check statement: " . $db->error;
    }
    $db->close();
} else {
    echo "Required data not submitted.";
}
?>
