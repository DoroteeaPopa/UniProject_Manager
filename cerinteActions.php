<?php
$action = $_GET['action'] ?? '';
$id_materie = $_POST['id_materie'] ?? 0;
$id_profesor = $_POST['id_profesor'] ?? 0;
$semigrupa = $_POST['semigrupa'] ?? 0;
$id_cerinte = $_POST['id_cerinte'] ?? 0;
$cerinta = $_POST['cerinta_noua'] ?? '';

function addCerinta($id_materie, $cerinta) {
    include("config.php");
    $sql = "INSERT INTO cerinte (id_materie, cerinta) VALUES (?, ?)";
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param("is", $id_materie, $cerinta);
        $stmt->execute();
        $stmt->close();
    }
    $db->close();
}

function editCerinta($id_cerinte, $cerinta) {
    include("config.php");
    $sql = "UPDATE cerinte SET cerinta = ? WHERE id_cerinte = ?";
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param("si", $cerinta, $id_cerinte);
        $stmt->execute();
        $stmt->close();
    }
    $db->close();
}

function deleteCerinta($id_cerinte) {
    include("config.php");
    $sql = "DELETE FROM cerinte WHERE id_cerinte = ?";
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param("i", $id_cerinte);
        $stmt->execute();
        $stmt->close();
    }
    $db->close();
}




switch ($action) {
    case 'add':
        addCerinta($id_materie, $cerinta);
        break;
    case 'edit':
        editCerinta($id_cerinte, $cerinta);
        break;
    case 'delete':
        deleteCerinta($id_cerinte);
        break;
}

header("Location: detalii_proiect_prof.php?id_materie=$id_materie&id_profesor=$id_profesor&semigrupa=$semigrupa"); // Redirect după operație
exit;

?>