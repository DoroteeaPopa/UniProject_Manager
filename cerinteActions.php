<?php
$action = $_GET['action'] ?? '';
$id_materie = $_POST['id_materie'] ?? 0;
$id_profesor = $_POST['id_profesor'] ?? 0;
$semigrupa = $_POST['semigrupa'] ?? 0;
$id_task = $_POST['id_task'] ?? 0;
$task = $_POST['task_nou'] ?? 'n';

function insertCeriteStudent($id_task_nou, $id_materie){
    include("config.php");
    $sql = "SELECT * FROM student CROSS JOIN specializare ON student.specializare=specializare.id_specializare";
    $result = $db->query($sql);
    
    while($developer = mysqli_fetch_assoc($result)){//pt fiecare student
    $specializare=$developer['denumire'];
    $id_student=$developer['id_student'];
    
    
    if($specializare=='Tehnologia Informatiei'){
      $sql3 ="SELECT* 
        FROM orar 
        CROSS JOIN profesori ON orar.id_profesor=profesori.id_profesor 
        CROSS JOIN materi ON orar.id_materie=materi.id_materie 
        CROSS JOIN nivele_seri ON orar.id_nivel=nivele_seri.id_ns
        WHERE (profesori.dep='0' OR profesori.dep='1') 
              AND orar.id_tip='4' 
              AND (nivele_seri.nume_ns='214/1' OR nivele_seri.nume_ns='224/1' OR nivele_seri.nume_ns='233/1' OR nivele_seri.nume_ns='243/1')
        ORDER BY materi.id_an, nume";
      $result4 = $db->query($sql3);
    
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
      $result4 = $db->query($sql3);
    
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
      $result4 = $db->query($sql3);  
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
      $result4 = $db->query($sql3);
    
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
      $result4 = $db->query($sql3);
    
    }

    while ($course = mysqli_fetch_assoc($result4)) {//pt fiecare materie
        $id_course = $course['id_materie'];
        if($id_course==$id_materie){
            // Insert a new entry into the `cerinte` table
            $insert_cerinte_sql = "INSERT INTO cerinte (id_student, id_materie, id_task) VALUES ($id_student, $id_materie, $id_task_nou)";
            $db->query($insert_cerinte_sql);
            }
        }
    }
    
}


function deleteCeriteStudent($id_task){
    include("config.php");
    $sql = "DELETE FROM cerinte WHERE id_task = ?";
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param("i", $id_task);
        $stmt->execute();
        $stmt->close();
    }
}





function addCerinta($id_materie, $task) {
    include("config.php");
    $sql = "INSERT INTO taskuri (id_materie, task) VALUES (?, ?)";    
    if ($stmt = $db->prepare($sql)) {
        // Bind the new 'cerinta' value and 'id_cerinta' to the placeholders
        $stmt->bind_param("is", $id_materie, $task);
        $stmt->execute();
        $id_task_nou=$db->insert_id;
        $stmt->close();
    }
    insertCeriteStudent($id_task_nou, $id_materie);
    $db->close();
}

function editCerinta($id_task, $task) {
    include("config.php");
    $sql = "UPDATE taskuri SET task = ? WHERE id_task = ?";
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param("si", $task, $id_task);
        $stmt->execute();
        $stmt->close();
    }
    $db->close();
}

function deleteCerinta($id_task) {
    include("config.php");
    $sql = "DELETE FROM taskuri WHERE id_task = ?";
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param("i", $id_task);
        $stmt->execute();
        $stmt->close();
    }
    deleteCeriteStudent($id_task);
    $db->close();
}




switch ($action) {
    case 'add':
        addCerinta($id_materie, $task);
        break;
    case 'edit':
        editCerinta($id_task, $task);
        break;
    case 'delete':
        deleteCerinta($id_task);
        break;
}

header("Location: detalii_proiect_prof.php?id_materie=$id_materie&id_profesor=$id_profesor&semigrupa=$semigrupa"); // Redirect după operație
exit;

?>