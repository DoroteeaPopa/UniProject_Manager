<?php
include("config.php"); // Include configurația bazei de date

$action = $_GET['action'] ?? '';
$id_tema = $_POST['id_tema'];
$tema_noua = $_POST['tema_noua'];
$id_profesor_depcie = $_POST['id_profesor_depcie'];
$id_specializare = $_POST['id_specializare'];

switch ($action) {
    case 'add':
        // Adăugarea unei noi teme
        $tema_noua = $_POST['tema_noua'];
        $id_profesor_depcie = $_POST['id_profesor_depcie'];
        $id_specializare = $_POST['id_specializare'];
        $sql = "INSERT INTO teme_licenta (id_profesor_depcie, id_specializare, tema) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("iis", $id_profesor_depcie, $id_specializare, $tema_noua);
        $stmt->execute();
        break;

    case 'edit':
        // Editarea unei teme existente
        $sql = "UPDATE teme_licenta SET tema = ? WHERE id_tema = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("si", $tema_noua, $id_tema);
        $stmt->execute();
        break;

    case 'delete':
        // Ștergerea unei teme

        $sql = "DELETE FROM teme_licenta WHERE id_tema = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id_tema);
        $stmt->execute();
        break;
    default:
    $id_specializare=0;
}

// Redirecționare înapoi la pagina cu temele de licență (sau la oricare altă pagină relevată)
header("Location: detalii_licenta_prof.php?id_profesor_depcie=$id_profesor_depcie&id_specializare=$id_specializare");
exit();
?>
